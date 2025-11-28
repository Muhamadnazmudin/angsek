<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_rkas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jurusan_model');
        $this->load->model('Kodering_model');
        $this->load->model('Kegiatan_model');
        $this->load->database();
    }

    public function index()
{
    $data['title'] = "Laporan RKAS";

    // Ambil role & jurusan user
    $role_id    = $this->session->userdata('role_id');
    $user_jurusan_id = $this->session->userdata('jurusan_id');

    // FILTER dari GET
    $jurusan_id    = $this->input->get('filter_jurusan');
    $kodering_id   = $this->input->get('filter_kodering');
    $kategori_id   = $this->input->get('filter_kategori');

    // *** FIX: Jika role JURUSAN → override filter_jurusan ***
    if ($role_id == 3) {
        $jurusan_id = $user_jurusan_id;
    }

    // List dropdown
    $data['jurusan']  = $this->db->order_by('nama', 'ASC')->get('jurusan')->result();
    $data['kategori'] = $this->db->order_by('nama', 'ASC')->get('kategori_kodering')->result();
    $data['kodering'] = $this->db->order_by('nama', 'ASC')->get('kodering')->result();

    // Query data RKAS
    $this->db->select("
        item_anggaran.*,
        jurusan.nama AS jurusan_nama,
        kegiatan.nama AS kegiatan_nama,
        kodering.kode AS kode_rka,
        kodering.nama AS nama_rka,
        kategori_kodering.nama AS jenis_belanja
    ");
    $this->db->from("item_anggaran");
    $this->db->join("jurusan", "jurusan.id=item_anggaran.jurusan_id", "left");
    $this->db->join("kegiatan", "kegiatan.id=item_anggaran.kegiatan_id", "left");
    $this->db->join("kodering", "kodering.id=item_anggaran.kodering_id", "left");
    $this->db->join("kategori_kodering", "kategori_kodering.id=kodering.kategori_id", "left");

    // ** FILTER BERDASARKAN ROLE **
    if (!empty($jurusan_id)) {
        $this->db->where("item_anggaran.jurusan_id", $jurusan_id);
    }

    if (!empty($kodering_id)) {
        $this->db->where("item_anggaran.kodering_id", $kodering_id);
    }

    if (!empty($kategori_id)) {
        $this->db->where("kodering.kategori_id", $kategori_id);
    }

    $this->db->order_by("jurusan.nama", "ASC");
    $this->db->order_by("kegiatan.nama", "ASC");
    $this->db->order_by("kodering.kode", "ASC");

    $data['rkas'] = $this->db->get()->result();

    // Load view
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('laporan/rkas_index', $data);
    $this->load->view('templates/footer');
}


    // ===================
    // EXPORT EXCEL
    // ===================
    public function export_excel()
{
    $this->load->library("Excel_lib");

    $role_id    = $this->session->userdata('role_id');
    $user_jurusan_id = $this->session->userdata('jurusan_id');

    // FILTER dari GET
    $jurusan_id    = $this->input->get('filter_jurusan');
    $kodering_id   = $this->input->get('filter_kodering');
    $kategori_id   = $this->input->get('filter_kategori');

    // FIX: Jurusan hanya boleh export datanya sendiri
    if ($role_id == 3) {
        $jurusan_id = $user_jurusan_id;
    }


        // Buat excel
        $excel = new PHPExcel();
        $sheet = $excel->setActiveSheetIndex(0);
        $sheet->setTitle('Laporan RKAS');

        // Header Excel
        $headers = [
            'A' => 'Jurusan',
            'B' => 'Kegiatan',
            'C' => 'Kode',
            'D' => 'Nama Kodering',
            'E' => 'Jenis Belanja',
            'F' => 'Uraian',
            'G' => 'Volume',
            'H' => 'Satuan',
            'I' => 'Harga Satuan',
            'J' => 'Total',
            'K' => 'Jan',
            'L' => 'Feb',
            'M' => 'Mar',
            'N' => 'Apr',
            'O' => 'Mei',
            'P' => 'Jun',
            'Q' => 'Jul',
            'R' => 'Agu',
            'S' => 'Sep',
            'T' => 'Okt',
            'U' => 'Nov',
            'V' => 'Des',
        ];

        foreach ($headers as $col => $text) {
            $sheet->setCellValue($col.'1', $text);
        }

        // Query data
        $this->db->select("
            item_anggaran.*,
            jurusan.nama AS jurusan_nama,
            kegiatan.nama AS kegiatan_nama,
            kodering.kode AS kode_rka,
            kodering.nama AS nama_rka,
            kategori_kodering.nama AS jenis_belanja
        ");
        $this->db->from("item_anggaran");
        $this->db->join("jurusan", "jurusan.id=item_anggaran.jurusan_id", "left");
        $this->db->join("kegiatan", "kegiatan.id=item_anggaran.kegiatan_id", "left");
        $this->db->join("kodering", "kodering.id=item_anggaran.kodering_id", "left");
        $this->db->join("kategori_kodering", "kategori_kodering.id=kodering.kategori_id", "left");

        if (!empty($jurusan_id))
            $this->db->where("item_anggaran.jurusan_id", $jurusan_id);

        if (!empty($kodering_id))
            $this->db->where("item_anggaran.kodering_id", $kodering_id);

        if (!empty($kategori_id))
            $this->db->where("kodering.kategori_id", $kategori_id);

        $this->db->order_by("jurusan.nama", "ASC");
        $this->db->order_by("kegiatan.nama", "ASC");
        $this->db->order_by("kodering.kode", "ASC");

        $rows = $this->db->get()->result();

        // Fill Excel
        $rowNum = 2;
        foreach ($rows as $r) {
            $sheet->setCellValue("A$rowNum", $r->jurusan_nama);
            $sheet->setCellValue("B$rowNum", $r->kegiatan_nama);
            $sheet->setCellValue("C$rowNum", $r->kode_rka);
            $sheet->setCellValue("D$rowNum", $r->nama_rka);
            $sheet->setCellValue("E$rowNum", $r->jenis_belanja);
            $sheet->setCellValue("F$rowNum", $r->uraian);
            $sheet->setCellValue("G$rowNum", $r->volume);
            $sheet->setCellValue("H$rowNum", $r->satuan);
            $sheet->setCellValue("I$rowNum", $r->harga_satuan);
            $sheet->setCellValue("J$rowNum", $r->volume * $r->harga_satuan);
            $sheet->setCellValue("K$rowNum", $r->jan);
            $sheet->setCellValue("L$rowNum", $r->feb);
            $sheet->setCellValue("M$rowNum", $r->mar);
            $sheet->setCellValue("N$rowNum", $r->apr);
            $sheet->setCellValue("O$rowNum", $r->mei);
            $sheet->setCellValue("P$rowNum", $r->jun);
            $sheet->setCellValue("Q$rowNum", $r->jul);
            $sheet->setCellValue("R$rowNum", $r->agu);
            $sheet->setCellValue("S$rowNum", $r->sep);
            $sheet->setCellValue("T$rowNum", $r->okt);
            $sheet->setCellValue("U$rowNum", $r->nov);
            $sheet->setCellValue("V$rowNum", $r->des);
            $rowNum++;
        }

        // Download
        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_RKAS.xlsx"');
        header('Cache-Control: max-age=0');

        PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
        exit;
    }
}
