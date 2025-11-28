<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kategori_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Kategori Kodering';
        $data['kategori'] = $this->Kategori_model->get_all();

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('kategori/index',$data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $this->Kategori_model->insert([
            'nama'      => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi')
        ]);

        redirect('kategori');
    }

    public function edit($id) {
        $data['title'] = 'Edit Kategori Kodering';
        $data['kategori'] = $this->Kategori_model->get_by_id($id);

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('kategori/edit',$data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->Kategori_model->update($id, [
            'nama'      => $this->input->post('nama'),
            'deskripsi' => $this->input->post('deskripsi'),
        ]);

        redirect('kategori');
    }

    public function delete($id) {
        $this->Kategori_model->delete($id);
        redirect('kategori');
    }
}
