<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cek extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Cek_model', 'cek');
        $this->akses = is_logged_in();
    }

    function kabupaten()
    {
        $id_provinsi = $this->input->post('id_provinsi', TRUE);
        $id_kabupaten = $this->input->post('id_kabupaten', TRUE);
        if ($id_provinsi != "") {
            $result = $this->mquery->select_by('kabupaten', ['id_provinsi' => $id_provinsi], 'nama_kabupaten ASC');
            echo "<option value=''>Pilih Kabupaten/Kota</option>";
            foreach ($result as $r) {
                if ($r['id_kabupaten'] == $id_kabupaten) {
                    echo "<option value='" . $r['id_kabupaten'] . "' selected>" . ucwords(strtolower($r['nama_kabupaten'])) . "</option>";
                } else {
                    echo "<option value='" . $r['id_kabupaten'] . "'>" . ucwords(strtolower($r['nama_kabupaten'])) . "</option>";
                }
            }
        }
    }

    function kecamatan()
    {
        $id_kabupaten = $this->input->post('id_kabupaten', TRUE);
        $id_kecamatan = $this->input->post('id_kecamatam', TRUE);
        if ($id_kabupaten != "") {
            $result = $this->mquery->select_by('kecamatan', ['id_kabupaten' => $id_kabupaten], 'nama_kecamatan ASC');
            echo "<option value=''>Pilih Kecamatan</option>";
            foreach ($result as $r) {
                if ($r['id_kecamatan'] == $id_kecamatan) {
                    echo "<option value='" . $r['id_kecamatan'] . "' selected>" . ucwords(strtolower($r['nama_kecamatan'])) . "</option>";
                } else {
                    echo "<option value='" . $r['id_kecamatan'] . "'>" . ucwords(strtolower($r['nama_kecamatan'])) . "</option>";
                }
            }
        }
    }

    function subklasifikasi()
    {
        $id_klasifikasi = $this->input->post('id_klasifikasi', TRUE);
        $id_sub_klasifikasi = $this->input->post('id_sub_klasifikasi', TRUE);
        if ($id_klasifikasi != "") {
            $result = $this->mquery->select_by('sub_klasifikasi', ['id_klasifikasi' => $id_klasifikasi], 'nama_sub_klasifikasi ASC');
            foreach ($result as $r) {
                if ($r['id_sub_klasifikasi'] == $id_sub_klasifikasi) {
                    echo "<option value='" . $r['id_sub_klasifikasi'] . "' selected>" . $r['nama_sub_klasifikasi'] . "</option>";
                } else {
                    echo "<option value='" . $r['id_sub_klasifikasi'] . "'>" . $r['nama_sub_klasifikasi'] . "</option>";
                }
            }
        }
    }

    function username()
    {
        $id = $this->input->post('id_pegawai', TRUE);
        $id_pegawai = decrypt_url($id);
        if ($id_pegawai != "error") {
            $result = $this->mquery->select_id('pegawai', ['id_pegawai' => $id_pegawai]);
            $data = [
                "nip" => $result['nip'],
                "username" => $result['username']
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
}
