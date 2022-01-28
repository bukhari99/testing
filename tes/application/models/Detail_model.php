<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_log = 'log_user';
    }

    public function get_dosismeter($id_dosismeter = null){
		$this->db->order_by('id_dosismeter', 'ASC');
		$this->db->select('*');
		$this->db->from('dosismeter');
		if($id_dosismeter != null){ $this->db->where('id_dosismeter', $id_dosismeter); }
		$query = $this->db->get();
		return $query;
	}

    public function get_dosismeter_instansi($id_instansi = null){
		$this->db->order_by('id_dosismeter', 'ASC');
		$this->db->select('*');
		$this->db->from('dosismeter');
		if($id_instansi != null){ $this->db->where('id_instansi', $id_instansi); }
		$query = $this->db->get();
		return $query;
	}

    public function get_datapengguna($id_pengguna = null){
		$this->db->order_by('id_pengguna', 'ASC');
		$this->db->select('*');
		$this->db->from('data_pengguna');
		if($id_pengguna != null){ $this->db->where('id_pengguna', $id_pengguna); }
		$query = $this->db->get();
		return $query;
	}

}
