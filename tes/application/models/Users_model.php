<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_log = 'log_user';
    }

    function get_users($id_user = null)
    {
        $this->db->select('a.*, b.role_name, b.role_surat');
        $this->db->join('users_role as b', 'a.role_id = b.role_id');
        if ($id_user != null) {
            $this->db->where('a.id_pegawai', $id_user);
            return $this->db->get('pegawai as a')->row_array();
        } else {
            $this->db->where(['a.role_id !=' => '1']);
            return $this->db->get('pegawai as a')->result_array();
        }
    }
}
