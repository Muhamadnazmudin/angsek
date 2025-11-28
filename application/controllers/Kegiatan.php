<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kegiatan_model');
        $this->load->library('session');
    }

    public function index() {

        $data['title'] = 'Kegiatan';
        $data['kegiatan'] = $this->Kegiatan_model->get_all();
        $data['jurusan'] = $this->Kegiatan_model->get_jurusan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('kegiatan/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {

        $data = [
            'jurusan_id' => $this->input->post('jurusan_id'),
            'nama'       => $this->input->post('nama'),
            'deskripsi'  => $this->input->post('deskripsi')
        ];

        $this->Kegiatan_model->insert($data);
        redirect('kegiatan');
    }

    public function edit($id) {

        $data['title']    = 'Edit Kegiatan';
        $data['kegiatan'] = $this->Kegiatan_model->get_by_id($id);
        $data['jurusan']  = $this->Kegiatan_model->get_jurusan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('kegiatan/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {

        $data = [
            'jurusan_id' => $this->input->post('jurusan_id'),
            'nama'       => $this->input->post('nama'),
            'deskripsi'  => $this->input->post('deskripsi')
        ];

        $this->Kegiatan_model->update($id, $data);

        redirect('kegiatan');
    }

    public function delete($id) {
        $this->Kegiatan_model->delete($id);
        redirect('kegiatan');
    }
}
