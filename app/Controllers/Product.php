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

            $excel_to_array = $this->parse_excel_to_array($worksheet);
            $data_to_update = $excel_to_array['data'];
            
            $adjusted_array = $this->adjust_array_to_insert($data_to_update);
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

    private function parse_excel_to_array($worksheet)
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

    private function adjust_array_to_insert($data_array_from_excel)
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
        // dd($data_array_from_excel);
        $colour_list = $this->getDistictValueByKey($data_array_from_excel, 'colour');
        $style_list = $this->getDistictValueByKey($data_array_from_excel, 'style');
        $size_list = $this->getDistictValueByKey($data_array_from_excel, 'size');
        $product_type_list = $this->getDistictValueByKey($data_array_from_excel, 'product_type');
        dd($product_type_list);
        
        foreach ($data_array_from_excel as $key => $product) {
            $colourModel = $this->ColourModel->getOrCreateColourByName($product['colour']);
            // $colourModel->transRollback();
            dd("stop");
            
        }
        

        return $data_return;
    }

    private function getDistictValueByKey(Array $data_array_from_excel, String $array_key) : array
    {
        return array_unique(array_column($data_array_from_excel,$array_key));
    }

}
