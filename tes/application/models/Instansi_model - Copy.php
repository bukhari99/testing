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

    function get_srp_mahasiswa($nim_session)
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        $this->db->where('a.nim', $nim_session);
        return $this->db->get('tbl_skripsi_rancangan_publik as a')->result_array();
    }

    function get_instansi_id($id_instansi)
    {
        $this->db->select('a.*, b.alamat, b.id_provinsi, b.id_kabupaten, c.penanggung_jawab, c.no_telp_penanggung_jawab, d.nama_provinsi, e.nama_kabupaten');
        $this->db->join('instansi_alamat as b', 'a.id_instansi = b.id_instansi');
        $this->db->join('instansi_kontak as c', 'a.id_instansi = c.id_instansi');
        $this->db->join('provinsi as d', 'b.id_provinsi = d.id_provinsi', 'LEFT');
        $this->db->join('kabupaten as e', 'b.id_kabupaten = e.id_kabupaten', 'LEFT');
        $this->db->where('a.id_instansi', $id_instansi);
        return $this->db->get('instansi as a')->row_array();
    }

    function jumlah_instansi()
    {
        return $this->db->get('instansi')->num_rows();
    }

    function insert_instansi($instansi, $instansi_alamat, $instansi_kontak, $log)
    {
        $this->db->trans_start();
        $this->db->insert('instansi', $instansi);
        $this->db->insert('instansi_alamat', $instansi_alamat);
        $this->db->insert('instansi_kontak', $instansi_kontak);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function update_instansi($id_instansi, $instansi, $instansi_alamat, $instansi_kontak, $log)
    {
        $this->db->trans_start();
        $this->db->update('instansi', $instansi, ['id_instansi' => $id_instansi]);
        $this->db->update('instansi_alamat', $instansi_alamat, ['id_instansi' => $id_instansi]);
        $this->db->update('instansi_kontak', $instansi_kontak, ['id_instansi' => $id_instansi]);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
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

    function get_dosismeter_instansi($id_instansi)
    {
        $this->db->select('a.*, b.nama');
        $this->db->join('data_pengguna as b', 'a.id_pengguna=b.id_pengguna', 'LEFT');
        $this->db->where('a.id_instansi', $id_instansi);
        return $this->db->get('dosismeter as a')->result_array();
    }

    // Proses Data tbl_skripsi_rancangan_publik ------------------------------------------------------------------------
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

    function update_srp_verifikator($id_srp,$tbl_skripsi_rancangan_publik, $log)
    {
        $this->db->trans_start();
        $this->db->update('tbl_skripsi_rancangan_publik', $tbl_skripsi_rancangan_publik, ['id_srp' => $id_srp]);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Tabel Penelitian --------------------------------------------------------------------------
    
    function get_penelitian_mahasiswa($username)
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        $this->db->where('a.username', $username);
        return $this->db->get('tbl_penelitian as a')->result_array();
    }

    function get_penelitian_mahasiswa_all()
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        return $this->db->get('tbl_penelitian as a')->result_array();
    }

    function insert_penelitian($tbl_penelitian, $log)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_penelitian', $tbl_penelitian);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function get_penelitian($id_srp)
    {
        $this->db->select('a.*');
       $this->db->where('a.id_srp', $id_srp);
        return $this->db->get('tbl_penelitian a')->row_array();
    }

    // Tabel Kerja Praktek --------------------------------------------------------------------------
    
    function get_kerja_praktek_all()
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        return $this->db->get('tbl_kerja_praktek as a')->result_array();
    }

    function get_kerja_praktek_mahasiswa($username)
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        $this->db->where('a.username', $username)->where("(status='VERIFIKASI' OR status='PERBAIKAN' OR status='PROSES ADMIN' OR status='PRINT' )");;
        //$this->db->where('a.status', 'SELESAI');
        return $this->db->get('tbl_kerja_praktek as a')->result_array();
    }

    function get_kerja_praktek_mahasiswa_selesai($username)
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        $this->db->where('a.username', $username)->where("(status='SELESAI')");
        return $this->db->get('tbl_kerja_praktek as a')->result_array();
    }

    function insert_kerja_praktek($tbl_kerja_praktek, $log)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_kerja_praktek', $tbl_kerja_praktek);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function get_kerja_praktek_detail($id_srp)
    {
        $this->db->select('a.*');
       $this->db->where('a.id_srp', $id_srp);
        return $this->db->get('tbl_kerja_praktek a')->row_array();
    }

    // Tabel Skripsi Penelitian
    function get_skripsi_penelitian()
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        return $this->db->get('tbl_skripsi_penelitian as a')->result_array();
    }

    function get_skripsipenelitian_mahasiswa($nim_session)
    {
        $this->db->select('a.*,a.nama as nama_mahasiswa');
        $this->db->order_by('a.created_time ASC');
        $this->db->where('a.nim', $nim_session);
        return $this->db->get('tbl_skripsi_penelitian as a')->result_array();
    }

    function insert_skripsi_penelitian($tbl_skripsi_penelitian, $log)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_skripsi_penelitian', $tbl_skripsi_penelitian);
        $this->db->insert($this->table_log, $log);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function get_skripsi_penelitian_edit($id_srp)
    {
        $this->db->select('a.*');
       $this->db->where('a.id_srp', $id_srp);
        return $this->db->get('tbl_skripsi_penelitian a')->row_array();
    }

    function get_skripsi_penelitian_laporan($id_srp)
    {
        $this->db->select('a.*');
       $this->db->where('a.id_srp', $id_srp);
        return $this->db->get('tbl_skripsi_penelitian a')->row_array();
    }

}
