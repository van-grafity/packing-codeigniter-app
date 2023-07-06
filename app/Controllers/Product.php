<?php

namespace App\Controllers;

use Config\Services;
use App\Models\CategoryModel;
use App\Models\ColourModel;
use App\Models\ProductModel;
use App\Models\SizeModel;
use App\Models\StyleModel;
use Faker\Extension\Helper;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Product extends BaseController
{
    protected $CategoryModel;
    protected $ColourModel;
    protected $ProductModel;
    protected $SizeModel;
    protected $StyleModel;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->CategoryModel = new CategoryModel();
        $this->ColourModel = new ColourModel();
        $this->ProductModel = new ProductModel();
        $this->SizeModel = new SizeModel();
        $this->StyleModel = new StyleModel();
        $this->session = Services::session();
    }

    public function index()
    {
        $data = [
            'title'     => 'Product List',
            'category'  => $this->CategoryModel->getCategory()->getResult(),
            'colour'    => $this->ColourModel->getColour()->getResult(),
            'product'   => $this->ProductModel->getProduct()->getResult(),
            'size'      => $this->SizeModel->getSize()->getResult(),
            'style'     => $this->StyleModel->getStyle()->getResult(),
        ];
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        return view('product/index', $data);
    }

    public function save()
    {
        $this->ProductModel->save(
            [
                'product_code'        => $this->request->getVar('product_code'),
                'product_asin_id'     => $this->request->getVar('product_asin_id'),
                'product_category_id' => $this->request->getVar('product_category'),
                'product_style_id'    => $this->request->getVar('product_style_id'),
                'product_colour_id'   => $this->request->getVar('product_colour_id'),
                'product_size_id'     => $this->request->getVar('product_size_id'),
                'product_name'        => $this->request->getVar('product_name'),
                'product_price'       => $this->request->getVar('product_price')
            ]
        );
        session()->setFlashdata('pesan', ' Data Added');
        return redirect()->to('/product');
    }

    public function update()
    {
        $id = $this->request->getVar('edit_product_id');
        $data = array(
            'product_code'        => $this->request->getVar('product_code'),
            'product_asin_id'     => $this->request->getVar('product_asin_id'),
            'product_category_id' => $this->request->getVar('product_category'),
            'product_style_id'    => $this->request->getVar('product_style_id'),
            'product_colour_id'   => $this->request->getVar('product_colour_id'),
            'product_size_id'     => $this->request->getVar('product_size_id'),
            'product_name'        => $this->request->getVar('product_name'),
            'product_price'       => $this->request->getVar('product_price'),
        );
        $this->ProductModel->updateProduct($data, $id);
        session()->setFlashdata('pesan', 'Data Updated');
        return redirect()->to('product');
    }

    public function delete()
    {
        $id = $this->request->getVar('product_id');
        $this->ProductModel->deleteProduct($id);
        return redirect()->to('/product');
    }

    public function importexcel()
    {
        try {
            $packinglist_id = $this->request->getPost('packinglist_id');
            $file = $this->request->getFile('file_excel');
            $rules = [
                'file_excel' => 'ext_in[file_excel,csv,xlsx,xls]',
            ];
            if (!$this->validate($rules)) {
                return redirect()->to('product/' . $packinglist_id)->with('error', 'Please upload on csv / xlsx / xls format');
            }

            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();

            $is_valid = $this->isValidHeader($worksheet);
            if (!$is_valid) {
                return redirect()->to('product')->with('error', 'Incorrect header format');
            }

            $excel_to_array = $this->parseExceltoArray($worksheet);
            $data_to_update = $excel_to_array['data'];


            // ## set required Column. cannot be empty / null on excel
            $required_column = ['upc', 'product_name','style_no','style_description','colour','size','product_type','price']; 
            $cleaned_data = $this->removeEmptyData($data_to_update, $required_column);


            $is_duplicate_on_excel = $this->isDuplicateProductCodeOnExcel($cleaned_data);
            if($is_duplicate_on_excel) { 
                return redirect()->to('product')->with('error', 'There is a duplicate UPC in your excel! Please double check the data you provide' );
            }

            $is_duplicate_on_system = $this->isDuplicateProductCodeOnSystem($cleaned_data);
            if($is_duplicate_on_system) { 
                return redirect()->to('product')->with('error', 'There is a UPC already registered in the system! Please double check the data you provide' );
            }
            
            $adjusted_array = $this->adjustArrayToInsert($cleaned_data);
            
            $this->ProductModel->transException(true)->transStart();
            $insertedProduct = $this->ProductModel->insertBatch($adjusted_array);
            $this->ProductModel->transComplete();
            
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->to('product')->with('success', 'Successfully Submitted ' . $insertedProduct . ' Products' );
    }

    private function isValidHeader($worksheet)
    {
        // ## get first row in worksheet and check valid name
        $header_from_excel = $worksheet->toArray()[0];
        
        $header_list = ['upc', 'product_name','style_no','style_description','colour','size','product_type','price','product_asin'];
        foreach ($header_list as $key => $header) {
            if ($header != $header_from_excel[$key]) return false;
        }
        return true;
    }

    private function parseExceltoArray($worksheet) : array
    {
        $data = [];
        $firstRow = true;
        $header = [];

        foreach ($worksheet->getRowIterator() as $row) {
            if ($firstRow) {
                foreach ($row->getCellIterator() as $cell) {
                    $header[$cell->getColumn()] = $cell->getValue();
                }
                $firstRow = false;
            } else {
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $columnIndex = $cell->getColumn();
                    $headerIndex = array_key_exists($columnIndex, $header);
                    if ($headerIndex !== false) {
                        $rowData[$header[$columnIndex]] = $cell->getValue();
                    }
                }
                if (!empty($rowData)) {
                    $data[] = $rowData;
                }
            }
        }

        $data_return = [
            'header' => $header,
            'data' => $data,
        ];

        return $data_return;
    }

    private function adjustArrayToInsert($data_array_from_excel) : array
    {
        $result = [];

        // ## set list of header and model to create master data
        $header_and_model = [
            [
                'name' => 'style_no',
                'model' => $this->StyleModel,
                'column_to_insert' => ['style_no','style_description']
            ],
            [
                'name' => 'colour',
                'model' => $this->ColourModel,
                'column_to_insert' => ['colour']
            ],
            [
                'name' => 'size',
                'model' => $this->SizeModel,
                'column_to_insert' => ['size']
            ],
            [
                'name' => 'product_type',
                'model' => $this->CategoryModel,
                'column_to_insert' => ['product_type']
            ],
        ];
        $statusCreate = $this->createMasterDataIfNotExists($data_array_from_excel, $header_and_model);
        if(!$statusCreate) { return false; }

        $result = $this->recreateArrayToUseID($data_array_from_excel);
        return $result;
    }

    private function removeEmptyData(Array $data_array_from_excel, Array $required_column) : array
    {
        $result = array();
        foreach ($data_array_from_excel as $key => $product) {
            $is_valid_data = true;
            foreach ($required_column as $column) {
                if(!$product[$column]){
                    $is_valid_data = false;
                    break;
                }
            }
            if($is_valid_data) {
                $result[] = $product; 
            }
        }

        foreach ($result as $key => $product) {
            $result[$key] = array_filter($product, fn($key_product) => $key_product !== '', ARRAY_FILTER_USE_KEY);  
        }
        return $result;
    }

    private function isDuplicateProductCodeOnExcel(Array $data_array_from_excel) : bool
    {
        $array_upc = array_column($data_array_from_excel,'upc');
        if(count(array_unique($array_upc))<count($array_upc)) { return true; }
        return false;
    }

    private function isDuplicateProductCodeOnSystem(Array $data_array_from_excel) : bool 
    {
        foreach ($data_array_from_excel as $key => $product) {
            $product = $this->ProductModel->where('product_code', $product['upc'])->first();
            if($product) { return true; }
        }
        return false;
    }

    private function createMasterDataIfNotExists(Array $data_array_from_excel, Array $header_and_model) : bool
    {
        try {
            $this->db->transException(true)->transStart();
            foreach ($header_and_model as $key => $header) {

                $filtered_unique_data_by_key = $this->filterUniqueValueByKey($data_array_from_excel, $header['name']);
                $filtered_data_to_insert = $this->filterArrayByKeys($filtered_unique_data_by_key, $header['column_to_insert']);
                
                foreach ($filtered_data_to_insert as $value) {
                    $model_data = $header['model']->getOrCreateDataByName($value);
                }
            }

            $this->db->transComplete();
            return $this->db->transStatus();
        } catch (DatabaseException $e) {
            exit($e->getMessage());
        }
    }


    private function filterUniqueValueByKey(array $data_array, String $key) : array
    {
        /*
         * filter array to get only unique values base on column name(key)
         * mengembalikan array yang memiliki nilai unik pada kolom yang sudah ditentukan
         * ------------------------------------------------------------------------------------------------
         * step: 
         * array mentah => $data_array
         * pilih kolom => $key
         * ambil seluruh nilai dari kolom $key menggunakan array_column()
         * ambil nilai unik dari kolom $key menggunakan array_unique()
         * ambil nilai untuk semua kolom di baris yang sama (1 baris full) pada array_unique yang sebelumnya, menggunakan array_intersect_key()
         * atur ulang keys atau index pada array, karena index masih mengikuti data_array yang belum di filter.
         */

        $result = array();
        $unique_values_by_key = array_unique(array_column($data_array, $key)); // only get unique values from 1 column
        $unique_row_by_key = (array_intersect_key($data_array, $unique_values_by_key)); // get 1 row by the unique values
        $result = array_values($unique_row_by_key); // reset index or keys of array
        return $result;
    }

    private function filterArrayByKeys(array $data_array, array $allowed_keys) : array
    {
        /*
         * filter array to get only allowed keys
         * mengembalikan array yang berisi kolom atau key tertentu saja => $allowed_keys
         * ------------------------------------------------------------------------------------------------
         * step: 
         * array mentah => $data_array
         * key yang diinginkan => $allowed_keys
         * array yang berisi allowed keys ($allowed_keys) ditukar antara keys dan value nya menggunakan array_flip()
         * tujuan ditukar agar dapat digunakan sebagai parameter dalam intersect key (proses selanjutnya)
         * perulangan pada $data_array
         * untuk setiap baris dicari yang cocok dengan $allowed_keys menggunakan array_intersect_key()
         * hasil pencocokan ditampung dalam $result
         */

        $result      = array();
        $allowed_keys = array_flip($allowed_keys); // switch keys and values. key as value and value as key
        
        foreach ($data_array as $key => $data_row) {
            // getting only those key value pairs, which matches $allowed_keys
            $result[$key] = array_intersect_key($data_row, $allowed_keys);
        }
        return $result;
    }

    private function recreateArrayToUseID($data_array_from_excel)
    {
        // ## Recreate array to use ID instead Name of the Master Data. Only for Master Data Column.
        $result = array();
        
        foreach ($data_array_from_excel as $key => $product) {
            $new_format = [
                'product_code' => $product['upc'],
                'product_asin_id' => $product['product_asin'],
                'product_colour_id' => $this->ColourModel->getIdByName($product['colour']),
                'product_style_id' => $this->StyleModel->getIdByName($product['style_no']),
                'product_size_id' => $this->SizeModel->getIdByName($product['size']),
                'product_category_id' => $this->CategoryModel->getIdByName($product['product_type']),
                'product_name' => $product['product_name'],
                'product_price' => $product['price'],
            ];
            $result[$key] = $new_format; 
        }
        return $result;
    }

}
