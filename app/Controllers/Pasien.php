<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PasienModel;

class Pasien extends BaseController
{
    protected $modelName = 'App\Models\PasienModel';
    protected $format    = 'json';
    protected PasienModel $model;

    public function __construct()
    {
        $this->model = new PasienModel();
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
                'message' => 'Pasien tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        $rules = [
            'nama' => 'required|max_length[100]',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[L,P]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 400,
                'message' => 'Gagal menyimpan data',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $this->model->insert($data);

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 201,
            'message' => 'Data pasien berhasil disimpan',
            'data' => $this->model->find($this->model->insertID())
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'message' => 'Pasien tidak ditemukan'
            ]);
        }

        $rules = [
            'nama' => 'max_length[100]',
            'alamat' => 'max_length[255]',
            'tanggal_lahir' => 'valid_date',
            'jenis_kelamin' => 'in_list[L,P]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 400,
                'message' => 'Gagal memperbarui data',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $this->model->update($id, $data);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Data pasien berhasil diperbarui',
            'data' => $this->model->find($id)
        ]);
    }

    public function delete($id = null)
    {
        $pasien = $this->model->find($id);
        if (!$pasien) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 404,
                'message' => 'Pasien tidak ditemukan'
            ]);
        }

        $this->model->delete($id);

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Data pasien berhasil dihapus',
            'data'    => $pasien
        ]);
    }
}
