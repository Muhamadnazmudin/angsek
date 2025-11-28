<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login() {

    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->User_model->get_by_username($username);

    if ($user && password_verify($password, $user->password)) {

        // simpan role + jurusan_id ke session
        $session = [
            'user_id'    => $user->id,
            'fullname'   => $user->fullname,
            'username'   => $user->username,
            'role_id'    => $user->role_id,
            'jurusan_id' => $user->jurusan_id, // << WAJIB UNTUK AKSES FILTER
            'logged_in'  => TRUE
        ];

        $this->session->set_userdata($session);

        redirect('dashboard');
    }

    $this->session->set_flashdata('error', 'Username atau password salah!');
    redirect('auth');
}

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
