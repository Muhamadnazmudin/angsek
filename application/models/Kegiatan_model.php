<?php
class Kegiatan_model extends CI_Model {

    private $table = 'kegiatan';

    public function get_all() {
        $this->db->select('kegiatan.*, jurusan.nama as jurusan_nama');
        $this->db->from($this->table);
        $this->db->join('jurusan', 'jurusan.id = kegiatan.jurusan_id', 'left');
        $this->db->order_by('kegiatan.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id'=>$id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id,$data) {
        return $this->db->where('id',$id)->update($this->table,$data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id'=>$id]);
    }

    public function get_jurusan() {
        return $this->db->get('jurusan')->result();
    }
}
