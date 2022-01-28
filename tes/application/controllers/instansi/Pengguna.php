<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Instansi_model', 'instansi');
        $this->load->model('Detail_model', 'detail');
        $this->user = is_logged_in();
        $this->akses = cek_akses_user();
    }

    public function form_add()
    {
        $id = htmlspecialchars($this->input->post('id', TRUE));
        $id_instansi = decrypt_url($id);
        $data = [
            'id_instansi' => $id_instansi
        ];
        $this->load->view('instansi/pengguna/form_add', $data);
    }

    public function form_edit()
    {
        $id = htmlspecialchars($this->input->post('id', TRUE));
        $id_pengguna = decrypt_url($id);
        $data = [
            'pengguna' => $this->mquery->select_id("data_pengguna", ['id_pengguna' => $id_pengguna])
        ];
        $this->load->view('instansi/pengguna/form_edit', $data);
    }

    private function _rule_form()
    {
        $this->form_validation->set_rules('id_instansi', 'Instansi', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[16]|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis kelamin', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat lahir', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal lahir', 'required|trim');
        $this->form_validation->set_message('required', '%s tidak boleh kosong');
        $this->form_validation->set_message('min_length', 'Format %s salah');
    }

    private function _send_error()
    {
        $errors = [
            'instansi' => form_error('instansi'),
            'nik' => form_error('nik'),
            'nama' => form_error('nama'),
            'jenis_kelamin' => form_error('jenis_kelamin'),
            'tempat_lahir' => form_error('tempat_lahir'),
            'tgl_lahir' => form_error('tgl_lahir')
        ];
        $data = ['status' => FALSE, 'errors' => $errors, 'pesan' => 'Data Gagal Disimpan'];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function add()
    {
        $this->_rule_form();
        if ($this->form_validation->run() == false) {
            $this->_send_error();
        } else {
            $post = $this->input->post(null, TRUE);
            $id_instansi = decrypt_url($post['id_instansi']);
            if ($id_instansi == "error") {
                kirim_pesan("access");
            } else {
                $array =  [
                    'nik' => htmlentities($post['nik']),
                    'nama' => htmlspecialchars($post['nama']),
                    'jenkel' => $post['jenis_kelamin'],
                    'tempat_lahir' => htmlspecialchars($post['tempat_lahir']),
                    'tanggal_lahir' => tanggal_database($post['tgl_lahir']),
                    'id_instansi' => $id_instansi
                ];
                $string = ['data_pengguna' => $array];
                $log = simpan_log("insert data pengguna", json_encode($string));
                $res = $this->mquery->insert_data("data_pengguna", $array, $log);
                $data = ['status' => TRUE, 'notif' => $res];
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

    function edit()
    {
        $this->_rule_form();
        if ($this->form_validation->run() == false) {
            $this->_send_error();
        } else {
            $post = $this->input->post(null, TRUE);
            $id = htmlspecialchars($post['id_pengguna']);
            $id_pengguna = decrypt_url($id);
            if ($id_pengguna == "error") {
                kirim_pesan("access");
            } else {
                $temp = $this->mquery->select_id('data_pengguna', ['id_pengguna' => $id_pengguna]);
                $array =  [
                    'nik' => htmlentities($post['nik']),
                    'nama' => htmlspecialchars($post['nama']),
                    'jenkel' => $post['jenis_kelamin'],
                    'tempat_lahir' => htmlspecialchars($post['tempat_lahir']),
                    'tanggal_lahir' => tanggal_database($post['tgl_lahir'])
                ];

                $string = ['data_pengguna' => ['old' => $temp, 'new' => $array]];
                $log = simpan_log("update data pengguna", json_encode($string));
                $res = $this->mquery->update_data('data_pengguna', $array, ['id_pengguna' => $id_pengguna], $log);
                $data = ['status' => TRUE, 'notif' => $res];
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        }
    }

    function delete()
    {
        $id = htmlspecialchars($this->input->post('id', TRUE));
        $id_pengguna = decrypt_url($id);
        if ($id_pengguna == "error") {
            kirim_pesan("access");
        } else {
            $temp = $this->mquery->select_id('data_pengguna', ['id_pengguna' => $id_pengguna]);
            $string = ['data_pengguna' => $temp];
            $log = simpan_log("delete data pengguna", json_encode($string));
            $res = $this->mquery->delete_data('data_pengguna', ['id_pengguna' => $id_pengguna], $log);
            $data = ['notif' => $res];
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
}
