<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jurusan_model');
        $this->load->model('User_model'); // << WAJIB
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Jurusan';
        $data['jurusan'] = $this->Jurusan_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('jurusan/index', $data);
        $this->load->view('templates/footer');
    }

    // ==========================
    // TAMBAH JURUSAN + AUTO USER
    // ==========================
    public function add() {

        // 1. Simpan jurusan dulu
        $dataJurusan = [
            'kode'       => $this->input->post('kode'),
            'nama'       => $this->input->post('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Jurusan_model->insert($dataJurusan);
        $jurusan_id = $this->db->insert_id();

        // 2. Generate username dari kode jurusan
        $username = strtolower(str_replace(' ', '', $this->input->post('kode')));

        // Cek apakah username sudah dipakai
        if ($this->User_model->get_by_username($username)) {
            $username = $username . rand(100, 999); // tambahkan angka supaya unik
        }

        // 3. Password default
        $passwordHash = password_hash('123456', PASSWORD_DEFAULT);

        // 4. Masukkan user baru
        $dataUser = [
            'role_id'    => 3, // role = jurusan
            'jurusan_id' => $jurusan_id,
            'username'   => $username,
            'password'   => $passwordHash,
            'fullname'   => $this->input->post('nama'),
            'email'      => null,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->User_model->insert($dataUser);

        $this->session->set_flashdata('success', 'Jurusan & User Jurusan berhasil dibuat.');
        redirect('jurusan');
    }

    public function edit($id) {
        $data['title'] = 'Edit Jurusan';
        $data['jurusan'] = $this->Jurusan_model->get_by_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('jurusan/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $data = [
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama')
        ];

        $this->Jurusan_model->update($id, $data);
        redirect('jurusan');
    }

    public function delete($id) {
        // Hapus user jurusan juga
        $this->db->delete('users', ['jurusan_id' => $id]);

        // Hapus jurusan
        $this->Jurusan_model->delete($id);

        redirect('jurusan');
    }
}
