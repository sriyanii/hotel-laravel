<?php
namespace App\Controllers;

use App\Models\DataModel;

class DataController extends BaseController {
    protected $dataModel;

    public function __construct() {
        $this->dataModel = new DataModel();
    }

    public function saveData() {
        $post = $this->request->getPost();

        $result = $this->dataModel->save($post);

        if ($result) {
            $this->setNotification('Data berhasil disimpan!', 'success');
        } else {
            $this->setNotification('Gagal menyimpan data!', 'danger');
        }

        return redirect()->to('/data');
    }

    public function updateData($id) {
        $post = $this->request->getPost();

        $result = $this->dataModel->update($id, $post);

        if ($result) {
            $this->setNotification('Data berhasil diperbarui!', 'success');
        } else {
            $this->setNotification('Gagal memperbarui data!', 'danger');
        }

        return redirect()->to('/data');
    }

    public function deleteData($id) {
        $result = $this->dataModel->delete($id);

        if ($result) {
            $this->setNotification('Data berhasil dihapus!', 'success');
        } else {
            $this->setNotification('Gagal menghapus data!', 'danger');
        }

        return redirect()->to('/data');
    }

    public function index() {
        $data['allData'] = $this->dataModel->findAll();

        // Panggil view dan kirim data
        echo view('data_view', $data);
    }
}
