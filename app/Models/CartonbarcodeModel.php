<?php

namespace App\Models;

use CodeIgniter\Model;

class CartonBarcodeModel extends Model
{
    protected $table            = 'tblcartonbarcode';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'packinglist_carton_id',
        'carton_number_by_system',
        'carton_number_by_input',
        'barcode',
    ];


    public function update_barcode($data_array)
    {
        // dd($data_array);
        
        // $additionalUpdateField = ['updated_at' => new RawSql('CURRENT_TIMESTAMP')];
        $builder = $this->db->table('tblcartonbarcode');
        // $builder->updateFields($additionalUpdateField, true);
        $builder->insertBatch($data_array);
        // $builder->updateBatch($data_array, ['packinglist_carton_id','carton_number_by_system']);
    }

    public function update_barcode_v2($data_array)
    {
        dd($data_array);
    }
}

