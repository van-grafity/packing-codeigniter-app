<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Employee_model;

class Employee extends Controller
{
    public function index()
    {
        $model = new Employee_model;
        $data['title']     = 'Data Vaksin Karyawan';
        $data['getKaryawan'] = $model->getKaryawan();

        echo view('employee/header', $data);
        echo view('employee/view', $data);
        echo view('employee/footer', $data);
    }

    public function add()
    {
        $model = new Employee_model;
        $data = array(
            'nama_karyawan' => $this->request->getPost('nama_karyawan'),
            'usia'         => $this->request->getPost('usia'),
            'status_vaksin_1'  => $this->request->getPost('status_vaksin_1'),
            'status_vaksin_2'  => $this->request->getPost('status_vaksin_2')
        );
        $model->saveKaryawan($data);
        echo '<script>
                alert("Selamat! Berhasil Menambah Data Vaksinasi Karyawan");
                window.location="' . base_url('employee') . '"
            </script>';
    }
    public function edit($id)
    {
        $model = new Employee_model;
        $getKaryawan = $model->getKaryawan($id)->getRow();
        if (isset($getKaryawan)) {
            $data['employee'] = $getKaryawan;
            $data['title']  = 'Niagahoster Tutorial';

            echo view('employee/header', $data);
            echo view('employee/edit_view', $data);
            echo view('employee/footer', $data);
        } else {

            echo '<script>
                    alert("ID karyawan ' . $id . ' Tidak ditemukan");
                    window.location="' . base_url('employee') . '"
                </script>';
        }
    }

    public function update()
    {
        $model = new Employee_model;
        $id = $this->request->getPost('id');
        $data = array(
            'nama_karyawan' => $this->request->getPost('nama_karyawan'),
            'usia'         => $this->request->getPost('usia'),
            'status_vaksin_1'  => $this->request->getPost('status_vaksin_1'),
            'status_vaksin_2'  => $this->request->getPost('status_vaksin_2')
        );
        $model->editKaryawan($data, $id);
        echo '<script>
                alert("Selamat! Anda berhasil melakukan update data.");
                window.location="' . base_url('employee') . '"
            </script>';
    }

    public function hapus($id)
    {
        $model = new Employee_model;
        $getKaryawan = $model->getKaryawan($id)->getRow();
        if (isset($getKaryawan)) {
            $model->hapusKaryawan($id);
            echo '<script>
                    alert("Selamat! Data berhasil terhapus.");
                    window.location="' . base_url('employee') . '"
                </script>';
        } else {

            echo '<script>
                    alert("Gagal Menghapus !, ID karyawan ' . $id . ' Tidak ditemukan");
                    window.location="' . base_url('employee') . '"
                </script>';
        }
    }
}
