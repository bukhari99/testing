<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model', 'users');
        $this->akses = is_logged_in();
    }

    public function index()
    {
        $role_surat = $this->session->userdata('role_surat');
        $nim_session = $this->session->userdata('nim');
        $username = $this->session->userdata('username');
        if($role_surat=='pengguna')
        {
            $data = [
                "menu_active" => "dashboard",
                "submenu_active" => null,
                "pegawai" => $this->users->get_users($this->akses['user']),
                //"jumlah_instansi" => $this->mquery->count_data('instansi')
                "jumlah_kerja_praktek" => $this->mquery->count_data("tbl_kerja_praktek where username='$username'"),
                "jumlah_srp" => $this->mquery->count_data("tbl_data_pegawai where username='$username'"),
                "jumlah_penelitian" => $this->mquery->count_data("tbl_penelitian where username='$username'"),
                "jumlah_skripsi_penelitian" => $this->mquery->count_data("tbl_skripsi_penelitian where username='$username'")
            ];
        }
        else
        {
        $data = [
            "menu_active" => "dashboard",
            "submenu_active" => null,
            "pegawai" => $this->users->get_users($this->akses['user']),
            //"jumlah_instansi" => $this->mquery->count_data('instansi')
            "jumlah_gol_I" => $this->mquery->count_data("tbl_data_pegawai where golongan='I'"),
            "jumlah_gol_II" => $this->mquery->count_data("tbl_data_pegawai where golongan='II'"),
            "jumlah_gol_III" => $this->mquery->count_data("tbl_data_pegawai where golongan='III'"),
            "jumlah_gol_IV" => $this->mquery->count_data("tbl_data_pegawai where golongan='IV'"),
            "jumlah_pria" => $this->mquery->count_data("tbl_data_pegawai where jk='L'"),
            "jumlah_wanita" => $this->mquery->count_data("tbl_data_pegawai where jk='P'"),
            "jumlah_usia_kurang_30" => $this->mquery->count_data("tbl_data_pegawai  WHERE usia>'1' and usia<'30'"),
            "jumlah_usia_31_40" => $this->mquery->count_data("tbl_data_pegawai  WHERE usia>'30' and usia<'41'"),
            "jumlah_usia_41_50" => $this->mquery->count_data("tbl_data_pegawai  WHERE usia>'40' and usia<'51'"),
            "jumlah_usia_lebih_50" => $this->mquery->count_data("tbl_data_pegawai  WHERE usia>'50' and usia<'1001'"),
        ];
    }
        $this->load->view('dashboard', $data);
    }
}
