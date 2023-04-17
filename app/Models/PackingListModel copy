<?php

namespace App\Models;

use CodeIgniter\Model;

class PackingListModel extends Model
{
    protected $table = 'tblpackinglist';
    protected $primaryKey = 'id';
    protected $allowedFields = ['packinglist_no', 'packinglist_date', 'packinglist_po_id', 'packinglist_qty', 'packinglist_amount', 'packinglist_created_at', 'packinglist_updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'packinglist_created_at';
    protected $updatedField = 'packinglist_updated_at';
    protected $returnType = 'App\Entities\PackingList';
    protected $useSoftDeletes = false;
    protected $skipValidation = false;
    protected $validationRules = [
        'packinglist_no' => 'required|alpha_numeric_space|min_length[3]|max_length[35]',
        'packinglist_date' => 'required|valid_date',
        'packinglist_po_id' => 'required|is_natural_no_zero',
        'packinglist_qty' => 'required|is_natural_no_zero',
        'packinglist_amount' => 'required|is_natural_no_zero',
    ];
    protected $validationMessages = [
        'packinglist_no' => [
            'required' => 'Nomor Packing List harus diisi.',
            'alpha_numeric_space' => 'Nomor Packing List hanya boleh diisi dengan huruf, angka, spasi, dan underscore.',
            'min_length' => 'Nomor Packing List minimal diisi dengan 3 karakter.',
            'max_length' => 'Nomor Packing List maksimal diisi dengan 35 karakter.',
        ],
        'packinglist_date' => [
            'required' => 'Tanggal Packing List harus diisi.',
            'valid_date' => 'Tanggal Packing List tidak valid.',
        ],
        'packinglist_po_id' => [
            'required' => 'ID Purchase Order harus diisi.',
            'is_natural_no_zero' => 'ID Purchase Order tidak valid.',
        ],
        'packinglist_qty' => [
            'required' => 'Jumlah harus diisi.',
            'is_natural_no_zero' => 'Jumlah tidak valid.',
        ],
        'packinglist_amount' => [
            'required' => 'Jumlah harus diisi.',
            'is_natural_no_zero' => 'Jumlah tidak valid.',
        ],
    ];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['packinglist_no'])) {
            $data['data']['packinglist_no'] = strtolower($data['data']['packinglist_no']);
        }

        return $data;
    }

    public function getPackingList($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }

    public function getPackingListByPoId($po_id = false)
    {
        if ($po_id === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['packinglist_po_id' => $po_id])
            ->findAll();
    }

    public function getPackingListByPackingListNo($packinglist_no = false)
    {
        if ($packinglist_no === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['packinglist_no' => $packinglist_no])
            ->first();
    }

    public function getPackingListByPackingListDate($packinglist_date = false)
    {
        if ($packinglist_date === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['packinglist_date' => $packinglist_date])
            ->findAll();
    }

    public function getPackingListByPackingListQty($packinglist_qty = false)
    {
        if ($packinglist_qty === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['packinglist_qty' => $packinglist_qty])
            ->findAll();
    }

    public function getPackingListByPackingListAmount($packinglist_amount = false)
    {
        if ($packinglist_amount === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['packinglist_amount' => $packinglist_amount])
            ->findAll();
    }
}
