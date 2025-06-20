<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ObatModel;

class Obat extends BaseController
{

    protected $modelName = 'App\Models\ObatModel';
    protected $format    = 'json';
    protected ObatModel $model;
    
    public function __construct()
    {
        $this->model = new ObatModel();
    }

    public function index()
    {
        $data = $this->model->findAll();
        return $this->response->setJSON($data);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'message' => 'Obat tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $data = $this->request->getJSON(true); 

        $rules = [
            'nama_obat'    => 'required|max_length[100]',
            'kategori'     => 'required|max_length[50]',
            'stok'      => 'required|integer',
            'harga'  => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'message' => 'Gagal menyimpan data',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $this->model->insert($data);
        $id = $this->model->getInsertID(); 

        return $this->response->setStatusCode(201)->setJSON([
            'status'  => 201,
            'message' => 'Data obat berhasil ditambahkan',
            'id'      => $id,
            'data'    => $data
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'message' => 'Obat tidak ditemukan'
            ]);
        }

        $rules = [
            'nama_obat'    => 'required|max_length[100]',
            'kategori'     => 'required|max_length[50]',
            'stok'      => 'required|integer',
            'harga'  => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'message' => 'Gagal memperbarui data',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, $data);

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data obat berhasil diperbarui',
            'data'    => $data
        ]);
    }

    public function delete($id = null)
    {
        $obat = $this->model->find($id);
        if (!$obat) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 404,
                'message' => 'Obat tidak ditemukan'
            ]);
        }

        $this->model->delete($id);

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data obat berhasil dihapus',
            'data'    => $obat
        ]);
    }

}
