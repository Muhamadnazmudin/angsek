<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Jurusan_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Users';
        $data['users'] = $this->User_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah User';
        $data['roles'] = $this->User_model->get_roles();
        $data['jurusan'] = $this->Jurusan_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('users/add', $data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $username = $this->input->post('username');

        // Cek username sudah dipakai
        if ($this->User_model->get_by_username($username)) {
            $this->session->set_flashdata('error', 'Username sudah digunakan!');
            redirect('users/add');
        }

        $role_id = $this->input->post('role_id');

        $data = [
            'fullname'   => $this->input->post('fullname'),
            'username'   => $username,
            'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id'    => $role_id,
            'jurusan_id' => ($role_id == 3) ? $this->input->post('jurusan_id') : null,
            'email'      => $this->input->post('email'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->User_model->insert($data);
        $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        redirect('users');
    }

    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['user'] = $this->User_model->get_by_id($id);
        $data['roles'] = $this->User_model->get_roles();
        $data['jurusan'] = $this->Jurusan_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('users/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $role_id = $this->input->post('role_id');

        $data = [
            'fullname'   => $this->input->post('fullname'),
            'username'   => $this->input->post('username'),
            'role_id'    => $role_id,
            'jurusan_id' => ($role_id == 3) ? $this->input->post('jurusan_id') : null,
            'email'      => $this->input->post('email')
        ];

        // Jika password diisi → update
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->User_model->update($id, $data);
        $this->session->set_flashdata('success', 'User berhasil diperbarui!');
        redirect('users');
    }

    public function delete($id) {
        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('users');
    }
    
}
