<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kodering extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kodering_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title']    = 'Kodering';
        $data['kodering'] = $this->Kodering_model->get_all();
        $data['kategori'] = $this->Kodering_model->get_kategori();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('kodering/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
    $kode = $this->input->post('kode');
    $nama = $this->input->post('nama');
    $kategori_id = $this->input->post('kategori_id');
    $deskripsi = $this->input->post('deskripsi');

    // Cek duplikat lebih dulu
    $cek = $this->db->get_where('kodering', ['kode' => $kode])->row();

    if ($cek) {
        $this->session->set_flashdata('error', 
            "Kode <b>$kode</b> sudah ada! Tidak bisa menambah data duplikat."
        );
        redirect('kodering');
        return;
    }

    // Insert jika aman
    $this->Kodering_model->insert([
        'kode' => $kode,
        'nama' => $nama,
        'kategori_id' => $kategori_id,
        'deskripsi'   => $deskripsi
    ]);

    $this->session->set_flashdata('success', "Data kodering berhasil ditambahkan!");
    redirect('kodering');
}


    public function edit($id) {

        $data['title']    = 'Edit Kodering';
        $data['kodering'] = $this->Kodering_model->get_by_id($id);
        $data['kategori'] = $this->Kodering_model->get_kategori();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('kodering/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
    $kode = $this->input->post('kode');
    $nama = $this->input->post('nama');
    $kategori_id = $this->input->post('kategori_id');
    $deskripsi = $this->input->post('deskripsi');

    // CEK jika kode berubah → baru cek duplikat
    $existing = $this->Kodering_model->get_by_id($id);

    if ($existing->kode != $kode) {
        $cek = $this->db->get_where('kodering', ['kode' => $kode])->row();
        if ($cek) {
            $this->session->set_flashdata('error', 
                "Kode <b>$kode</b> sudah dipakai! Tidak boleh duplikat."
            );
            redirect('kodering/edit/'.$id);
            return;
        }
    }

    // UPDATE aman
    $this->Kodering_model->update($id, [
        'kode'        => $kode,
        'nama'        => $nama,
        'kategori_id' => $kategori_id,
        'deskripsi'   => $deskripsi
    ]);

    $this->session->set_flashdata('success', "Data kodering berhasil diperbarui!");
    redirect('kodering');
}

    public function delete($id) {
        $this->Kodering_model->delete($id);
        redirect('kodering');
    }
    public function import()
{
    if (!empty($_FILES['file_excel']['name'])) {

        $this->load->library('excel_lib');
        $file = $_FILES['file_excel']['tmp_name'];

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        $numRow = 1;
        $inserted = 0;
        $skipped = 0;

        foreach ($sheet as $row) {

            if ($numRow == 1) { 
                $numRow++;
                continue; // skip header
            }

            $kode   = trim($row['A']);
            $nama   = trim($row['B']);
            $kategori_id = trim($row['C']);

            // Skip baris kosong
            if ($kode == "" || $nama == "") {
                $skipped++;
                continue;
            }

            // Validasi kategori ID ada di DB
            $cek_kat = $this->db->get_where('kategori_kodering', ['id' => $kategori_id])->row();
            if (!$cek_kat) {
                $skipped++;
                continue;
            }

            // CEK DUPLIKAT BERDASARKAN KODE
            $cek_duplikat = $this->db->get_where('kodering', ['kode' => $kode])->row();
            if ($cek_duplikat) {
                $skipped++; // jangan insert
                continue;
            }

            // Insert data
            $this->Kodering_model->insert([
                'kode'        => $kode,
                'nama'        => $nama,
                'kategori_id' => $kategori_id,
                'deskripsi'   => ''
            ]);

            $inserted++;
        }

        $this->session->set_flashdata('success', 
            "Import selesai: <br>
             • $inserted data berhasil masuk <br>
             • $skipped data dilewati (duplikat / invalid)"
        );
    } 
    else {
        $this->session->set_flashdata('error', 'File Excel belum dipilih!');
    }

    redirect('kodering');
}

public function download_template()
{
    // Load library PHPExcel
    $this->load->library('excel_lib');

    // Buat objek excel baru
    $excel = new PHPExcel();
    $sheet = $excel->setActiveSheetIndex(0);
    $sheet->setTitle('Template Kodering');

    // Header kolom
    $sheet->setCellValue('A1', 'Kode');
    $sheet->setCellValue('B1', 'Nama Kodering');
    $sheet->setCellValue('C1', 'Kategori ID (lihat sheet Kategori)');

    // Style header
    $style_header = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
        'borders' => [
            'allborders' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
        ],
        'fill' => [
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'D9E1F2']
        ]
    ];
    $sheet->getStyle('A1:C1')->applyFromArray($style_header);
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);

    // Tambahkan contoh data
    $sheet->setCellValue('A2', '5.1.02.01.01.0055');
    $sheet->setCellValue('B2', 'Belanja Makanan dan Minuman');
    $sheet->setCellValue('C2', '1');

    $sheet->setCellValue('A3', '5.2.05.01.01.0001');
    $sheet->setCellValue('B3', 'Belanja Modal Buku Umum');
    $sheet->setCellValue('C3', '2');

    $sheet->setCellValue('A4', '5.1.02.02.03.0012');
    $sheet->setCellValue('B4', 'Belanja Jasa Kebersihan');
    $sheet->setCellValue('C4', '3');

    // ========================================================
    // Sheet Referensi Kategori
    // ========================================================
    $refSheet = $excel->createSheet();
    $refSheet->setTitle('Kategori');

    $refSheet->setCellValue('A1', 'ID');
    $refSheet->setCellValue('B1', 'Nama Kategori');

    $kategori = $this->db->get('kategori_kodering')->result();

    $rowNum = 2;
    foreach ($kategori as $kat) {
        $refSheet->setCellValue('A'.$rowNum, $kat->id);
        $refSheet->setCellValue('B'.$rowNum, $kat->nama);
        $rowNum++;
    }

    // Style referensi header
    $refStyle = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
        'borders' => [
            'allborders' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
        ],
        'fill' => [
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => ['rgb' => 'E2EFDA']
        ]
    ];
    $refSheet->getStyle('A1:B1')->applyFromArray($refStyle);
    $refSheet->getColumnDimension('A')->setAutoSize(true);
    $refSheet->getColumnDimension('B')->setAutoSize(true);

    // ========================================================
    // BERSIHKAN OUTPUT BUFFER SEBELUM DOWNLOAD
    // ========================================================
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Header download file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Template_Kodering.xlsx"');
    header('Cache-Control: max-age=0');

    // Export
    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $writer->save('php://output');
    exit;
}

}
