<?php
class Kodering_model extends CI_Model {

    private $table = 'kodering';

    public function get_all() {
        $this->db->select('kodering.*, kategori_kodering.nama AS kategori_nama');
        $this->db->from($this->table);
        $this->db->join('kategori_kodering', 'kategori_kodering.id = kodering.kategori_id', 'left');
        $this->db->order_by('kodering.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id'=>$id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id',$id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id'=>$id]);
    }

    public function get_kategori() {
        return $this->db->get('kategori_kodering')->result();
    }
    public function get_all_with_kategori()
{
    $this->db->select('kodering.*, kategori_kodering.nama as kategori_nama');
    $this->db->from('kodering');
    $this->db->join('kategori_kodering', 'kategori_kodering.id = kodering.kategori_id', 'left');
    return $this->db->get()->result();
}


}
