<?php
class Ref_snp_model extends CI_Model {

    public function get_all() {
        return $this->db->order_by('id', 'ASC')->get('ref_snp')->result();
    }

    public function insert($data) {
        return $this->db->insert('ref_snp', $data);
    }

    public function insert_batch($data) {
        return $this->db->insert_batch('ref_snp', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('ref_snp', ['id' => $id])->row();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('ref_snp', $data);
    }

    public function delete($id) {
        return $this->db->delete('ref_snp', ['id' => $id]);
    }

    // new: ambil semua kode yang sudah ada dari array kode input
     public function get_existing_codes($kode_array = []) {
        if (empty($kode_array)) return [];

        $this->db->select('kode');
        $this->db->where_in('kode', $kode_array);
        $q = $this->db->get('ref_snp')->result();

        $result = [];
        foreach ($q as $r) {
            $result[] = $r->kode;
        }

        return $result;
    }
    public function get_paginated($limit, $offset)
{
    return $this->db
        ->order_by('id', 'DESC')
        ->get('ref_snp', $limit, $offset)
        ->result();
}

public function count_all()
{
    return $this->db->count_all('ref_snp');
}

}
