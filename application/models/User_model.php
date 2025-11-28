<?php
class User_model extends CI_Model {

    private $table = 'users';

    public function get_all() {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function get_roles() {
        return $this->db->get('roles')->result();
    }
    public function get_by_username($username)
{
    return $this->db->get_where('users', ['username' => $username])->row();
}

}
