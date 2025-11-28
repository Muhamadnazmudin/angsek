<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = 'Pengguna';
        $data['users'] = $this->User_model->get_all();
        $data['roles'] = $this->User_model->get_roles();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pengguna/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        $fullname = $this->input->post('fullname');
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $role_id = $this->input->post('role_id');

        $this->User_model->insert([
            'fullname' => $fullname,
            'username' => $username,
            'password' => $password,
            'role_id'  => $role_id,
            'email'    => $this->input->post('email')
        ]);

        redirect('pengguna');
    }

    public function edit($id) {
        $data['title'] = 'Edit Pengguna';
        $data['user'] = $this->User_model->get_by_id($id);
        $data['roles'] = $this->User_model->get_roles();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pengguna/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $data = [
            'fullname' => $this->input->post('fullname'),
            'username' => $this->input->post('username'),
            'email'    => $this->input->post('email'),
            'role_id'  => $this->input->post('role_id')
        ];

        if (!empty($this->input->post('password'))) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        $this->User_model->update($id, $data);
        redirect('pengguna');
    }

    public function delete($id) {
        $this->User_model->delete($id);
        redirect('pengguna');
    }
}
