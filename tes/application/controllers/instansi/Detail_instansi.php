<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_instansi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Instansi_model', 'instansi');
        $this->load->model('Detail_model', 'detail');
        $this->user = is_logged_in();
        $this->akses = cek_akses_user();
    }

    public function load_surat()
    {
        $id_instansi = $this->input->post('id');
        $role_surat = $this->session->userdata('role_surat');
        if($role_surat=='unit' or $role_surat=='sub_unit')
        {
            $result = $this->mquery->select_by("surat_masuk", ['id_pengirim' => $id_instansi, 'posisi_surat' => 'UNIT']);
        }
        else
        {
            $result = $this->mquery->select_by("surat_masuk", ['id_pengirim' => $id_instansi]);
        }
        $data = [];
        $no = 0;
        foreach ($result as $r) {
            $no++;
            $edit = action_edit(encrypt_url($r['id_surat_masuk']));
            $delete = action_delete(encrypt_url($r['id_surat_masuk']));
            $row = [
                'no' => $no,
                'no_surat' => $r['no_surat'],
                'tgl_surat' => format_tanggal($r['tgl_surat']),
                'perihal' => $r['perihal'],
                'opsi' => '-' //$edit . ' ' . $delete
            ];
            $data[] = $row;
        }
        $output['data'] = $data;
        echo json_encode($output);
    }

    public function load_dosismeter()
    {
        $id_instansi = $this->input->post('id');
        $result = $this->instansi->get_dosismeter_instansi($id_instansi);
        $data = [];
        $no = 0;
        foreach ($result as $r) {
            $no++;
            $edit = "<button id='tombol-ubah-dosismeter' data-id='" . encrypt_url($r['id_dosismeter']) . "' data-toggle='modal' data-target='#modal-form-dosismeter' class='btn btn-icon btn-round btn-success btn-sm' title='UBAH'><i class='fa fa-edit'></i> </button>";
            $delete = "<button id='tombol-hapus-dosismeter' data-id='" . encrypt_url($r['id_dosismeter']) . "' class='btn btn-icon btn-round btn-danger btn-sm' title='HAPUS'><i class='fa fa-trash'></i></button>";
            ($r['status'] == 0) ? $ket = "Person" : $ket = "Kontrol";
            $row = [
                'no' => $no,
                'id_dosismeter' => $r['id_dosismeter'],
                'id_pengguna' => $r['nama'],
                'status' => $ket,
                'opsi' => $edit . ' ' . $delete
            ];
            $data[] = $row;
        }
        $output['data'] = $data;
        echo json_encode($output);
    }

    public function load_pengguna()
    {
        $id_instansi = $this->input->post('id');
        $result = $this->mquery->select_by("data_pengguna", ['id_instansi' => $id_instansi]);
        $data = [];
        $no = 0;
        foreach ($result as $r) {
            $no++;
            $edit = "<button id='tombol-ubah-pengguna' data-id='" . encrypt_url($r['id_pengguna']) . "' data-toggle='modal' data-target='#modal-form-pengguna' class='btn btn-icon btn-round btn-success btn-sm' title='UBAH'><i class='fa fa-edit'></i> </button>";
            $delete = "<button id='tombol-hapus-pengguna' data-id='" . encrypt_url($r['id_pengguna']) . "' class='btn btn-icon btn-round btn-danger btn-sm' title='HAPUS'><i class='fa fa-trash'></i></button>";

            if (empty($r['jenkel']) or $r['jenkel'] == '') {
                $jenkel = "";
            } else {
                ($r['jenkel'] == 'L') ? $jenkel = "Laki-Laki" : $jenkel = "Perempuan";
            }

            if ($r['tanggal_lahir'] == '0000-00-00' or $r['tanggal_lahir'] == '1970-01-01') {
                $tanggal_lahir = "";
            } else {
                $tanggal_lahir = '/' . format_tanggal($r['tanggal_lahir']);
            }
            $row = [
                'no' => $no,
                'nik' => $r['nik'],
                'nama' => $r['nama'],
                'jenkel' => $jenkel,
                'ttl' => $r['tempat_lahir'] .  $tanggal_lahir,
                'opsi' => $edit . ' ' . $delete
            ];
            $data[] = $row;
        }
        $output['data'] = $data;
        echo json_encode($output);
    }
}
