<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Anggaran_model');
        $this->load->model('Jurusan_model'); // tidak apa meski tidak ada count_all
    }

    public function index()
{
    $role = $this->session->userdata('role_id');
    $jurusan_id = $this->session->userdata('jurusan_id');

    // ===== JIKA JURUSAN, FILTER SEMUA DATA =====
    if ($role == 3) {

        // Total anggaran jurusan ini
        $data['total_anggaran'] = $this->Anggaran_model->get_total_anggaran($jurusan_id);

        // Tahap
        $data['tahap1'] = $this->Anggaran_model->get_tahap1($jurusan_id);
        $data['tahap2'] = $this->Anggaran_model->get_tahap2($jurusan_id);

        // Triwulan
        $data['tw1'] = $this->Anggaran_model->get_triwulan(1, $jurusan_id);
        $data['tw2'] = $this->Anggaran_model->get_triwulan(2, $jurusan_id);
        $data['tw3'] = $this->Anggaran_model->get_triwulan(3, $jurusan_id);
        $data['tw4'] = $this->Anggaran_model->get_triwulan(4, $jurusan_id);

        // Total per bulan
        $data['bulan'] = $this->Anggaran_model->get_total_per_bulan($jurusan_id);

        // hitung total rencana
        $data['total_rencana'] =
            $data['bulan']->jan + $data['bulan']->feb + $data['bulan']->mar +
            $data['bulan']->apr + $data['bulan']->mei + $data['bulan']->jun +
            $data['bulan']->jul + $data['bulan']->agu + $data['bulan']->sep +
            $data['bulan']->okt + $data['bulan']->nov + $data['bulan']->des;

        // Rekap jurusan → hanya jurusan ini
        $data['rekap_jurusan'] = $this->Anggaran_model->get_rekap_jurusan($jurusan_id);

        // Jurusan tidak butuh total jurusan sekolah
        $data['total_jurusan'] = 1;

    } else {
        // ===== ADMIN / OPERATOR → TANPA FILTER =====
        $data['total_jurusan'] = $this->db->count_all('jurusan');

        $data['total_anggaran'] = $this->Anggaran_model->get_total_anggaran();

        $data['tahap1'] = $this->Anggaran_model->get_tahap1();
        $data['tahap2'] = $this->Anggaran_model->get_tahap2();

        $data['tw1'] = $this->Anggaran_model->get_triwulan(1);
        $data['tw2'] = $this->Anggaran_model->get_triwulan(2);
        $data['tw3'] = $this->Anggaran_model->get_triwulan(3);
        $data['tw4'] = $this->Anggaran_model->get_triwulan(4);

        $data['bulan'] = $this->Anggaran_model->get_total_per_bulan();

        $data['total_rencana'] =
            $data['bulan']->jan + $data['bulan']->feb + $data['bulan']->mar +
            $data['bulan']->apr + $data['bulan']->mei + $data['bulan']->jun +
            $data['bulan']->jul + $data['bulan']->agu + $data['bulan']->sep +
            $data['bulan']->okt + $data['bulan']->nov + $data['bulan']->des;

        $data['rekap_jurusan'] = $this->Anggaran_model->get_rekap_jurusan();
    }

    // Load view
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('dashboard', $data);
    $this->load->view('templates/footer');
}

}
