<?php
class Anggaran_model extends CI_Model {

    private $table = 'item_anggaran';

    // =============================
    // GET ALL (list anggaran)
    // =============================
    public function get_all($jurusan_id = null)
    {
        $this->db->select("
            item_anggaran.*,

            jurusan.nama AS jurusan_nama,
            kodering.kode AS kode_nama,
            kategori_kodering.nama AS jenis_belanja_nama,

            ref_snp.snp,
            ref_snp.komponen,
            ref_snp.uraian_kegiatan
        ");
        $this->db->from('item_anggaran');

        $this->db->join('jurusan', 'jurusan.id = item_anggaran.jurusan_id', 'left');
        $this->db->join('kodering', 'kodering.id = item_anggaran.kodering_id', 'left');
        $this->db->join('kategori_kodering', 'kategori_kodering.id = kodering.kategori_id', 'left');

        // JOIN ref_snp (baru)
        $this->db->join('ref_snp', 'ref_snp.id = item_anggaran.ref_snp_id', 'left');

        if ($jurusan_id !== null) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }

        return $this->db->get()->result();
    }


    // =============================
    // GET BY ID (untuk edit)
    // =============================
    public function get_by_id($id)
    {
        $this->db->select("
            item_anggaran.*,
            jurusan.nama AS jurusan_nama,
            kodering.kode AS kode_nama,
            kategori_kodering.nama AS jenis_belanja_nama,
            ref_snp.snp,
            ref_snp.komponen,
            ref_snp.uraian_kegiatan
        ");

        $this->db->from('item_anggaran');
        $this->db->join('jurusan', 'jurusan.id = item_anggaran.jurusan_id', 'left');
        $this->db->join('kodering', 'kodering.id = item_anggaran.kodering_id', 'left');
        $this->db->join('kategori_kodering', 'kategori_kodering.id = kodering.kategori_id', 'left');
        $this->db->join('ref_snp', 'ref_snp.id = item_anggaran.ref_snp_id', 'left');

        $this->db->where('item_anggaran.id', $id);

        return $this->db->get()->row();
    }


    // =============================
    // CRUD
    // =============================
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id'=>$id]);
    }


    // =============================
    // RKAS FILTER (UPDATE → hilangkan kegiatan)
    // =============================
    public function get_rkas_filtered($jurusan_id = null, $kodering_id = null, $jenis_id = null)
    {
        $this->db->select("
            item_anggaran.*,
            jurusan.nama AS jurusan_nama,
            kodering.kode AS kode,
            kodering.nama AS kode_nama,
            kategori_kodering.nama AS jenis_belanja_nama,

            ref_snp.snp,
            ref_snp.komponen,
            ref_snp.uraian_kegiatan
        ");

        $this->db->from('item_anggaran');
        $this->db->join('jurusan','jurusan.id=item_anggaran.jurusan_id','left');
        $this->db->join('kodering','kodering.id=item_anggaran.kodering_id','left');
        $this->db->join('kategori_kodering','kategori_kodering.id=kodering.kategori_id','left');

        $this->db->join('ref_snp','ref_snp.id=item_anggaran.ref_snp_id','left');

        if (!empty($jurusan_id)) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }
        if (!empty($kodering_id)) {
            $this->db->where('item_anggaran.kodering_id', $kodering_id);
        }
        if (!empty($jenis_id)) {
            $this->db->where('kategori_kodering.id', $jenis_id);
        }

        return $this->db->get()->result();
    }


    // =============================
    // TOTAL ANGGARAN
    // =============================
    public function get_total_anggaran($jurusan_id = null)
    {
        if (!empty($jurusan_id)) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }

        $row = $this->db->select_sum('total')->get('item_anggaran')->row();
        return isset($row->total) ? $row->total : 0;
    }


    // =============================
    // TAHAP 1
    // =============================
    public function get_tahap1($jurusan_id = null)
    {
        $this->db->select("SUM(jan + feb + mar + apr + mei + jun) AS total", FALSE);

        if (!empty($jurusan_id)) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }

        $row = $this->db->get('item_anggaran')->row();
        return isset($row->total) ? $row->total : 0;
    }


    // =============================
    // TAHAP 2
    // =============================
    public function get_tahap2($jurusan_id = null)
    {
        $this->db->select("SUM(jul + agu + sep + okt + nov + des) AS total", FALSE);

        if (!empty($jurusan_id)) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }

        $row = $this->db->get('item_anggaran')->row();
        return isset($row->total) ? $row->total : 0;
    }


    // =============================
    // TRIWULAN
    // =============================
    public function get_triwulan($tw, $jurusan_id = null)
    {
        switch ($tw) {
            case 1: $cols = "jan + feb + mar"; break;
            case 2: $cols = "apr + mei + jun"; break;
            case 3: $cols = "jul + agu + sep"; break;
            case 4: $cols = "okt + nov + des"; break;
            default: $cols = "0"; break;
        }

        $this->db->select("SUM($cols) AS total", FALSE);

        if (!empty($jurusan_id)) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }

        $row = $this->db->get('item_anggaran')->row();
        return isset($row->total) ? $row->total : 0;
    }


    // =============================
    // TOTAL PER BULAN
    // =============================
    public function get_total_per_bulan($jurusan_id = null)
    {
        if (!empty($jurusan_id)) {
            $this->db->where('item_anggaran.jurusan_id', $jurusan_id);
        }

        $this->db->select("
            SUM(jan) AS jan,
            SUM(feb) AS feb,
            SUM(mar) AS mar,
            SUM(apr) AS apr,
            SUM(mei) AS mei,
            SUM(jun) AS jun,
            SUM(jul) AS jul,
            SUM(agu) AS agu,
            SUM(sep) AS sep,
            SUM(okt) AS okt,
            SUM(nov) AS nov,
            SUM(des) AS des
        ");

        $row = $this->db->get('item_anggaran')->row();

        if ($row) return $row;

        return (object)[
            'jan'=>0,'feb'=>0,'mar'=>0,'apr'=>0,'mei'=>0,'jun'=>0,
            'jul'=>0,'agu'=>0,'sep'=>0,'okt'=>0,'nov'=>0,'des'=>0
        ];
    }
    /**
 * Rekap per jurusan (untuk dashboard)
 * Jika $jurusan_id diberikan, hanya kembalikan rekap untuk jurusan itu.
 */
public function get_rekap_jurusan($jurusan_id = null)
{
    if (!empty($jurusan_id)) {

        return $this->db->query("
            SELECT 
                j.nama AS jurusan,
                COALESCE(SUM(a.jan + a.feb + a.mar + a.apr + a.mei + a.jun), 0) AS tahap1,
                COALESCE(SUM(a.jul + a.agu + a.sep + a.okt + a.nov + a.des), 0) AS tahap2
            FROM jurusan j
            LEFT JOIN item_anggaran a ON a.jurusan_id = j.id
            WHERE j.id = ".$this->db->escape($jurusan_id)."
            GROUP BY j.id
        ")->result();
    }

    return $this->db->query("
        SELECT 
            j.nama AS jurusan,
            COALESCE(SUM(a.jan + a.feb + a.mar + a.apr + a.mei + a.jun), 0) AS tahap1,
            COALESCE(SUM(a.jul + a.agu + a.sep + a.okt + a.nov + a.des), 0) AS tahap2
        FROM jurusan j
        LEFT JOIN item_anggaran a ON a.jurusan_id = j.id
        GROUP BY j.id
        ORDER BY j.nama ASC
    ")->result();
}

}
