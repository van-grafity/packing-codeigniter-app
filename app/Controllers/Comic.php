<?php

namespace App\Controllers;

use App\Models\ComicModel;

class Comic extends BaseController
{
    protected $comicModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->comicModel = new ComicModel();
    }

    public function index()
    {
        $comic = $this->comicModel->findAll();

        $data = [
            'title' => 'List of Comic',
            'comic' => $this->comicModel->getComic()
        ];

        return view('comic/index', $data);
    }

    public function detail($slug)
    {
        $comic = $this->comicModel->getComic($slug);
        // dd($comic);
        $data = [
            'title' => 'Comic Detail',
            'comic' => $this->comicModel->getComic($slug)
        ];

        // If comic is not in table
        if (empty($data['comic'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Comic Title ' . $slug . 'not found.');
        }
        return view('comic/detail', $data);
        //dd($comic);
        //dd($slug);
    }

    public function create()
    {
        // session();
        $data = [
            'title' => 'Add New Comic Form',
            //            'validation' => \Config\Services::validation()
        ];

        return view('comic/create', $data);
    }

    public function save()
    // untuk mengelola data yang dikirim dari CREATE untuk di-INSERT ke dalam Table
    {
        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} Comic must be filled in.',
                    'is_unique' =>  '{field} Comic exist on database.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // dd($validation); --> untuk mengecek apakah pesan Validate tertangkap oleh system.
            //return redirect()->to('/comic/create')->withInput()->with('validation', $validation);
            return redirect()->to('/comic/create')->withInput();
        };

        //dd($this->request->getVar());
        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->comicModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', ' Data berhasil ditambahkan');
        return redirect()->to('comic');
    }

    public function delete($id)
    {
        $this->comicModel->delete($id);
        session()->setFlashdata('pesan', ' Data berhasil dihapus');
        return redirect()->to('comic');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Edit Data Comic',
            'comic' => $this->comicModel->getComic($slug)
        ];
        return view('comic/edit', $data);
    }

    public function update($id)
    {
        // Cek Judul
        $oldComic = $this->comicModel->getComic($this->request->getVar('slug'));
        if ($oldComic['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        // dd($this->request->getVar());
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} cannot be empty.',
                    'is_unique' => '{field} comic exist on database.'
                ]
            ]
        ])) {
            return redirect()->to('comic/edit' . $this->request->getVar('slug'))->withInput();
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->comicModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        session()->setFlashdata('pesan', 'Data Updated');
        return redirect()->to('/comic');
    }
}
