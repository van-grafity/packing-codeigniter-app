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
                'product_colour_id'    => $this->request->getVar('product_colour_id'),
                'product_size_id'    => $this->request->getVar('product_size_id'),
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
            'product_colour_id'    => $this->request->getVar('product_colour_id'),
            'product_size_id'    => $this->request->getVar('product_size_id'),
            'product_name'        => $this->request->getVar('product_name'),
            'product_price'       => $this->request->getVar('product_price'),
        );
        // dd($id);
        $this->ProductModel->updateProduct($data, $id);
        session()->setFlashdata('pesan', 'Data Updated');
        return redirect()->to('product');
    }

    public function delete()
    {

        $id = $this->request->getVar('product_id');
        // dd($id);
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

            $is_valid = $this->is_valid_header($worksheet);
            if (!$is_valid) {
                return redirect()->to('product')->with('error', 'Incorrect header format');
            }

            $excel_to_array = $this->parseExceltoArray($worksheet);
            $data_to_update = $excel_to_array['data'];
            
            $adjusted_array = $this->adjustArrayToInsert($data_to_update);
            dd($adjusted_array);
            


            array_walk($data_to_update, function (&$item, $key) use ($packinglist_id) {
                $item['packinglist_id'] = $packinglist_id;
                $item['carton_number_by_system'] = $item['carton_number'];
                unset($item['carton_number']);
            });

            $this->CartonBarcodeModel->transException(true)->transStart();

            $updateCartonBarcode = $this->CartonBarcodeModel->updateCartonBarcode($data_to_update);

            $this->CartonBarcodeModel->transComplete();
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->to('product');
    }

    private function is_valid_header($worksheet)
    {
        // ## get first row in worksheet and check valid name
        $header_from_excel = $worksheet->toArray()[0];;
        $header_list = ['upc', 'product_name','style','style_description','colour','size','product_type','price','product_asin'];
        // $header_list = ['carton_number', 'barcode'];
        foreach ($header_list as $key => $header) {
            if ($header != $header_from_excel[$key]) return false;
        }
        return true;
    }

    private function parseExceltoArray($worksheet)
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

    private function adjustArrayToInsert($data_array_from_excel)
    {
        // [
        //     'product_code'        => $this->request->getVar('product_code'),
        //     'product_asin_id'     => $this->request->getVar('product_asin_id'),
        //     *'product_colour_id'    => $this->request->getVar('product_colour_id'),
        //     *'product_style_id'    => $this->request->getVar('product_style_id'),
        //     *'product_size_id'    => $this->request->getVar('product_size_id'),
        //     *'product_category_id' => $this->request->getVar('product_category'),
        //     'product_name'        => $this->request->getVar('product_name'),
        //     'product_price'       => $this->request->getVar('product_price')
        // ]


        $data_return = [];
        
        $header_and_model = [
            // [
            //     'name' => 'colour',
            //     'model' => $this->ColourModel,
            // ],
            [
                'name' => 'style',
                'model' => $this->StyleModel,
                'column_to_insert' => ['style','style_description']
            ],
            // [
            //     'name' => 'size',
            //     'model' => $this->SizeModel,
            // ],
            // [
            //     'name' => 'product_type',
            //     'model' => $this->CategoryModel,
            // ],
        ];
        $statusCreate = $this->createMasterDataIfNotExists($data_array_from_excel, $header_and_model);
        dd($statusCreate);
        
        dd("harusnya ga sampe sini");
        
        return $data_return;
    }


    private function createMasterDataIfNotExists(Array $data_array_from_excel, Array $header_and_model)
    {
        try {
            $this->db->transException(true)->transStart();
            foreach ($header_and_model as $key => $header) {

                $filtered_unique_data_by_key = $this->filterUniqueValueByKey($data_array_from_excel, $header['name']);
                $filtered_data_to_insert = $this->filterArrayByKeys($filtered_unique_data_by_key, $header['column_to_insert']);
                
                dd(($filtered_data_to_insert));
                
                foreach ($unique_value_from_this_header as $value) {
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

}
