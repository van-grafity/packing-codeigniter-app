<?php

namespace App\Controllers;

use Config\Services;
use App\Models\BuyerModel;
use App\Models\GlModel;
use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderDetailModel;
use App\Models\SyncPurchaseOrderModel;
use App\Models\ProductModel;
use App\Models\SizeModel;
use App\Models\StyleModel;
use App\Models\ColourModel;
use App\Models\CategoryModel;

use App\Controllers\SyncPurchaseOrder;

use PhpOffice\PhpSpreadsheet\IOFactory;
use \Hermawan\DataTables\DataTable;


class PurchaseOrder extends BaseController
{
    protected $BuyerModel;
    protected $GlModel;
    protected $PurchaseOrderModel;
    protected $PurchaseOrderDetailModel;
    protected $SyncPurchaseOrderModel;
    protected $ProductModel;
    protected $SizeModel;
    protected $StyleModel;
    protected $ColourModel;
    protected $CategoryModel;
    protected $session;
    protected $SyncPurchaseOrderController;
    

    public function __construct()
    {
        $this->db = db_connect();
        $this->BuyerModel = new BuyerModel();
        $this->GlModel = new GlModel();
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->PurchaseOrderDetailModel = new PurchaseOrderDetailModel();
        $this->SyncPurchaseOrderModel = new SyncPurchaseOrderModel();
        $this->ProductModel = new ProductModel();
        $this->SizeModel = new SizeModel();
        $this->StyleModel = new StyleModel();
        $this->ColourModel = new ColourModel();
        $this->CategoryModel = new CategoryModel();
        $this->session = Services::session();

        $this->SyncPurchaseOrderController = new SyncPurchaseOrder();
    }

    public function index()
    {
        if (in_array(session()->get('role'), ['superadmin', 'admin','merchandiser'])) {
            $action_field_class = '';
        } else {
            $action_field_class = 'd-none';
        }

        $data = [
            'title'     => 'Purchase Order',
            'GL'        => $this->GlModel->getGL()->getResult(),
            'Product'   => $this->ProductModel->getProduct()->getResult(),
            'action_field_class' => $action_field_class,
            // 'purchase_order_list' => $this->PurchaseOrderModel->getPurchaseOrder(),
        ];

        // return view('purchaseorder/index', $data);
        return view('purchaseorder/index_dt', $data);
    }

    public function index_dt()
    {
        $po_list = $this->PurchaseOrderModel->getDatatable();
        return DataTable::of($po_list)
            ->addNumbering('DT_RowIndex')
            ->add('action', function($row){
                $action_button = '
                    <a class="btn btn-danger btn-sm btn-delete" onclick="delete_po(this)" data-id="'.$row->id.'" data-po-number="'.$row->po_no.'">Delete</a>
                ';
                return $action_button;
            })->add('po_no', function($row){
                $po_number_link = '<a href="'. base_url('purchaseorder/').$row->id.'">'.$row->po_no .'</a>';
                return $po_number_link;
            })->postQuery(function ($po_list) {
                $po_list->orderBy('po.created_at','desc');
            })->toJson(true);
    }

    public function savePO()
    {
        $data_po = array(
            'po_no'        => $this->request->getVar('po_no'),
            'shipdate'     => $this->request->getVar('shipdate'),
            'po_qty'       => $this->request->getVar('total_order_qty'),
            'po_amount'    => $this->request->getVar('total_amount'),
        );

        try {
            $this->PurchaseOrderModel->transException(true)->transStart();

            $po_id = $this->PurchaseOrderModel->insert($data_po);
            
            if (!$po_id) {
                $this->PurchaseOrderModel->transRollback();
            }
            $gl_id_list = $this->request->getVar('gl_no');
            foreach ($gl_id_list as $key => $gl_id) {
                $data_gl_po = [
                    'po_id' => $po_id,
                    'gl_id' => $gl_id,
                ];
                $insert_gl_po = $this->GlModel->insertGL_PO($data_gl_po);
                if(!$insert_gl_po) { 
                    $this->PurchaseOrderModel->transRollback();
                    throw new Exception("Error Insert GL PO", 1);
                }
            }

            // ## insert PO Detail
            $product_codes = $this->request->getPost('product_code');
            foreach ($product_codes as $key => $value) {
                $data_po_detail = [
                    'order_id' => $po_id,
                    'product_id' => $this->request->getPost('product_code')[$key],
                    'qty' => $this->request->getPost('order_qty')[$key],
                ];
                $po_detail = $this->PurchaseOrderDetailModel->insert($data_po_detail);
                if (!$po_detail) {
                    $this->PurchaseOrderModel->transRollback();
                }
            }
            $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_id);

            $this->PurchaseOrderModel->transComplete();

            $result = $this->SyncPurchaseOrderController->sync_po_gl($po_id);
            
        } catch (DatabaseException $e) {
            throw $e;
            // Automatically rolled back already.
        }

        return redirect()->to('/purchaseorder');
    }

    public function detail($id = null)
    {
        $data = [
            'title'     => 'Purchase Order Detail',
            'purchase_order'   => $this->PurchaseOrderModel->getPurchaseOrder($id),
            'purchase_order_details'   => $this->PurchaseOrderModel->getPODetails($id),
            'products'   => $this->ProductModel->getProduct()->getResult(),
        ];
        return view('purchaseorder/detail', $data);
    }

    public function delete()
    {
        try {
            $id = $this->request->getVar('po_id');

            $is_used_on_packinglist = $this->PurchaseOrderModel->is_used_on_packinglist($id);

            if($is_used_on_packinglist){
                return redirect()->to('purchaseorder')->with('error', 'This PO has been used on packinglist. Please delete the packinglist First');
            }
            
            $this->PurchaseOrderModel->transException(true)->transStart();
            
            $this->PurchaseOrderDetailModel->transException(true)->transStart();
            $this->PurchaseOrderDetailModel->where('order_id',$id)->delete();
            $this->PurchaseOrderDetailModel->transComplete();

            $this->SyncPurchaseOrderModel->transException(true)->transStart();
            $this->SyncPurchaseOrderModel->where('purchase_order_id',$id)->delete();
            $this->SyncPurchaseOrderModel->transComplete();
            
            $delete = $this->PurchaseOrderModel->delete($id);
            $this->PurchaseOrderModel->transComplete();
            
            return redirect()->to('purchaseorder');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function adddetail()
    {
        $po_id = $this->request->getVar('order_id');
        $data_po_detail = array(
            'order_id'        => $this->request->getVar('order_id'),
            'product_id'        => $this->request->getVar('product'),
            'qty'        => $this->request->getVar('order_qty'),
        );
        $this->PurchaseOrderDetailModel->insert($data_po_detail);

        $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_id);

        return redirect()->to('purchaseorder/' . $po_id);
    }

    public function updatedetail()
    {
        $po_id = $this->request->getVar('order_id');

        $id = $this->request->getVar('edit_po_detail_id');
        $data_po_detail = array(
            'order_id'        => $this->request->getVar('order_id'),
            'product_id'        => $this->request->getVar('product'),
            'qty'        => $this->request->getVar('order_qty'),
        );
        $this->PurchaseOrderDetailModel->update($id, $data_po_detail);

        $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_id);

        return redirect()->to('purchaseorder/' . $po_id);
    }

    public function deletedetail()
    {
        $po_id = $this->request->getVar('order_id');

        $po_detail_id = $this->request->getPost('po_detail_id');
        $delete = $this->PurchaseOrderDetailModel->delete($po_detail_id);

        $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_id);
        return redirect()->to('purchaseorder/' . $po_id);
    }

    public function importexcel()
    {
        try {
            $file = $this->request->getFile('file_excel');
            $rules = [
                'file_excel' => 'ext_in[file_excel,csv,xlsx,xls]',
            ];
            if (!$this->validate($rules)) {
                return redirect()->to('purchaseorder')->with('error', 'Please upload on csv / xlsx / xls format');
            }

            $spreadsheet = IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            
            $is_valid = $this->isValidHeader($worksheet);
            if (!$is_valid) {
                return redirect()->to('purchaseorder')->with('error', 'Incorrect header format');
            }

            $excel_to_array = $this->parseExceltoArray($worksheet);
            $data_to_update = $excel_to_array['data'];

            // ## set required Column. cannot be empty / null on excel
            $required_column = ['gl_number','po_number','shipdate','upc','style_no','style_description','colour','size','product_type','price','order_qty'];
            $cleaned_data = $this->removeEmptyData($data_to_update, $required_column);
            $cleaned_data = $this->removeWhitespace($cleaned_data);

            $gl_available = $this->isGlNumberAvailable($cleaned_data);
            
            if(!$gl_available) { 
                return redirect()->to('purchaseorder')->with('error', 'There is a GL Number has not registered in the system! Please create GL Master Data first' );
            }
            
            $adjusted_array_product = $this->adjustArrayProductToInsert($cleaned_data);
            
            $this->db->transException(true)->transStart();
            
            foreach ($adjusted_array_product as $key => $product) {
                /* 
                 * check apakah product sudah ada di Master Data. check product by their UPC / Product Code
                 * kalau belum tambahkan product.
                 * kalau sudah ada, tidak perlu menambahkan data baru. 
                */
                $product_ids[] = $this->ProductModel->getOrCreateProduct($product);
            }
            
            $add_products_to_purchase_order = $this->addProductToPurchaseOrder($cleaned_data);
            
            $this->db->transComplete();
            return redirect()->to('purchaseorder')->with('success', 'Successfully Submitted ' . count($add_products_to_purchase_order['data']) . ' Product Orders' );

        } catch (\Throwable $th) {
            throw $th;
            return redirect()->to('purchaseorder')->with('error', 'Something Wrong!' );
        }
    }

    private function isValidHeader($worksheet)
    {
        // ## get first row in worksheet and check valid name
        $header_from_excel = $worksheet->toArray()[0];
        $header_list = ['gl_number','po_number','shipdate','upc','style_no','style_description','colour','size','product_type','price','order_qty','product_asin','product_name'];

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

    private function adjustArrayProductToInsert(Array $data_array_from_excel) : array
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
                if(!$product[$column]  && $product[$column] !== "0"){
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

    private function isGlNumberAvailable(Array $data_array_from_excel) : bool
    {
        $array_gl_number = array_column($data_array_from_excel,'gl_number');
        foreach ($array_gl_number as $key => $gl_number) {
            $gl = $this->GlModel->where('gl_number', $gl_number)->first();
            if(!$gl) { return false; }
        }
        return true;
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
                
                foreach ($filtered_data_to_insert as $key_data => $value) {
                    $model_data = $header['model']->getOrCreateDataByName($value);
                }
            }

            $this->db->transComplete();
            return $this->db->transStatus();;
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
            if($product['product_name']){
                $product_name = $product['product_name'];
            } else {
                $product_name = $product['style_description'] . ' - ' . $product['colour'] . ' - ' . $product['size'];
            }
            $new_format = [
                'product_code' => $product['upc'],
                'product_asin_id' => $product['product_asin'],
                'product_colour_id' => $this->ColourModel->getIdByName($product['colour']),
                'product_style_id' => $this->StyleModel->getIdByName($product['style_no']),
                'product_size_id' => $this->SizeModel->getIdByName($product['size']),
                'product_category_id' => $this->CategoryModel->getIdByName($product['product_type']),
                'product_name' => $product_name,
                'product_price' => $product['price'],
            ];
            $result[$key] = $new_format; 
        }
        return $result;
    }

    private function addProductToPurchaseOrder(Array $data_array_from_excel) : array
    {
        /*
         * =================================================================
         * Step :
         * Perulangan untuk setiap data (product on PO)
         * check apakah sudah ada PO
         * ** kalau belum ada, buat PO berdasarkan nomor PO
         * ** field po => ['po_no','gl_id','shipdate']
         * insert data po detail
         * ** field po detail => ['order_id','product_id','qty']
         * =================================================================
         */
        $result = array();
        $inserted_products = array();
        $po_id_list = array();

        try {
            $this->db->transException(true)->transStart();

            foreach ($data_array_from_excel as $key => $product) {
                $data_po = [
                    'po_no' => $product['po_number'],
                    'gl_id' => $this->GlModel->where('gl_number',$product['gl_number'])->first()['id'],
                    'shipdate' => $product['shipdate'],
                ];
                $po_id = $this->PurchaseOrderModel->getOrCreateDataByName($data_po);
                $po_id_list[] = $po_id;
                
                $data_po_detail = [
                    'order_id' => $po_id,
                    'product_id' => $this->ProductModel->where('product_code', $product['upc'])->first()['id'],
                    'qty' => $product['order_qty'],
                ];

                $insert_po_detail = $this->PurchaseOrderDetailModel->insert($data_po_detail);
                $inserted_products[] = $insert_po_detail;
            }
            
            // ## Tamabahan untuk sync GL dan PO menjadi 1 baris di table tblsyncpurchaseorder
            // ## dibuat di sini agar mengurangi jumlah sync nya. kalau di taruh di looping atas akan berulang sebanyak product. kalau di taruh di bawha ini akan berulang sesuai jumlah PO yang unique

            $po_id_list = array_unique($po_id_list);
            foreach ($po_id_list as $key => $po_id) {
                $sync_po_gl = $this->SyncPurchaseOrderController->sync_po_gl($po_id);
                $sync_po = $this->PurchaseOrderModel->syncPurchaseOrderDetails($po_id);
            }


            $this->db->transComplete();
            $result = [
                'status' => $this->db->transStatus(),
                'data' => $inserted_products,
            ];
            return $result; 
        } catch (\DatabaseException $e) {
            exit($e->getMessage());
            
            $result = [
                'status' => $this->db->transStatus(),
                'message' => $e->getMessage(),
            ];
            return $result; 
        }        
    }

    private function removeWhitespace($product_array) : array
    {
        // ## Cleaning data. remove whitespace from beginning and end of string
        foreach ($product_array as $key => $product) {
            foreach ($product as $prop => $value) {
                $product_array[$key][$prop] = trim($value);
            }
        }
        return $product_array;
    }
}
