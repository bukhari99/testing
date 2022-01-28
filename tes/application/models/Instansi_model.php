<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_log = 'log_user';
    }

    function get_instansi()
    {
        $this->db->select('a.*, b.alamat, c.penanggung_jawab, c.no_telp_penanggung_jawab');
        $this->db->join('instansi_alamat as b', 'a.id_instansi = b.id_instansi');
        $this->db->join('instansi_kontak as c', 'a.id_instansi = c.id_instansi');
        $this->db->order_by('b.id_provinsi ASC, b.id_kabupaten ASC, a.nama_instansi ASC');
        return $this->db->get('instansi as a')->result_array();
    }

    function get_srp()
    {
        $this->db->select('a.*,a.nama as nama_pegawai');
        $this->db->order_by('a.golongan DESC, a.usia ASC');
        return $this->db->get('tbl_data_pegawai as a')->result_array();
    }

    

    function delete_instansi($id_instansi, $log)
    {
        $this->db->trans_start();
        $this->db->delete('instansi', ['id_instansi' => $id_instansi]);
        $this->db->delete('instansi_alamat', ['id_instansi' => $id_instansi]);
        $this->db->delete('instansi_kontak', ['id_instansi' => $id_instansi]);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

   

    // Proses Inpu Data ------------------------------------------------------------------------
    function insert_srp($tbl_data_pegawai, $log)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_data_pegawai', $tbl_data_pegawai);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function get_srp_edit($id_srp)
    {
        $this->db->select('a.*');
       $this->db->where('a.id_srp', $id_srp);
        return $this->db->get('tbl_data_pegawai a')->row_array();
    }

    

}
