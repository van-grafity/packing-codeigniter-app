<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

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
        
        $additionalUpdateField = ['updated_at' => new RawSql('CURRENT_TIMESTAMP')];
        $builder = $this->db->table('tblcartonbarcode');
        $builder->updateFields($additionalUpdateField, true);
        $builder->updateBatch($data_array, ['packinglist_carton_id','carton_number_by_system']);
        // $builder->insertBatch($data_array);
    }

    public function update_barcode_v2($data_array)
    {
        foreach ($data_array as $key => $value) {
            $builder = $this->db->table('tblcartonbarcode');
            $builder->where('packinglist_carton_id', $value['packinglist_carton_id']);
            $builder->update($value);
        }
    }
}

