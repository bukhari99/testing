<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Instansi_model', 'instansi');
        $this->load->model('Detail_model', 'detail');
        $this->user = is_logged_in();
        $this->akses = cek_akses_user();
    }

    public function index()
    {
        if ($this->akses['akses'] == 'Y') {
            $data = [
                "menu_active" => "instansi",
                "submenu_active" => null
            ];
            $this->load->view('instansi/data/view', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    public function load()
    {
        if ($this->akses['akses'] == 'Y') {
            $result = $this->instansi->get_instansi();
            $data = [];
            $no = 0;
            foreach ($result as $r) {
                $no++;
                $edit = action_edit(encrypt_url($r['id_instansi']));
                $delete = action_delete(encrypt_url($r['id_instansi']));
                $nama_instansi = "<a href=" . base_url("instansi/detail/" . $r['id_instansi']) . ">" . $r['nama_instansi'] . "</a>";

                $row = [
                    'no' => $no,
                    'nama_instansi' => $nama_instansi,
                    'alamat' => $r['alamat'],
                    'penanggung_jawab' => $r['penanggung_jawab'],
                    'kontak_penanggung_jawab' => $r['no_telp_penanggung_jawab'],
                    'opsi' => $edit . ' ' . $delete
                ];
                $data[] = $row;
            }
            $output['data'] = $data;
            echo json_encode($output);
        } else {
            redirect(site_url('blocked'));
        }
    }

    private function _rule_form()
    {
        $this->form_validation->set_rules('nama_instansi', 'Nama instansi', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat instansi', 'required|trim');
        $this->form_validation->set_rules('penanggung_jawab', 'Penanggung jawab', 'required|trim');
        $this->form_validation->set_rules('no_penanggung_jawab', 'Nomor kontak', 'required|trim');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required|trim');
        $this->form_validation->set_message('required', '%s tidak boleh kosong');
    }

    private function _send_error()
    {
        $errors = [
            'nama_instansi' => form_error('nama_instansi'),
            'alamat' => form_error('alamat'),
            'penanggung_jawab' => form_error('penanggung_jawab'),
            'no_penanggung_jawab' => form_error('no_penanggung_jawab'),
            'provinsi' => form_error('provinsi'),
            'kabupaten' => form_error('kabupaten')
        ];
        $data = ['status' => FALSE, 'errors' => $errors, 'pesan' => 'Data Gagal Disimpan'];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function form_add()
    {
        if ($this->akses['tambah'] == 'Y') {
            $data = [
                'result_provinsi' => $this->mquery->select_data('provinsi', "id_provinsi ASC")
            ];
            $this->load->view('instansi/data/form_add', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    function add()
    {
        if ($this->akses['tambah'] == 'Y') {
            $this->_rule_form();
            if ($this->form_validation->run() == false) {
                $this->_send_error();
            } else {
                $post = $this->input->post(null, TRUE);
                $cek_kode = $this->instansi->jumlah_instansi();
                if ($cek_kode > 0) {
                    $this->db->select('MAX(RIGHT(id_instansi, 4)) as kode');
                    $last_code = $this->db->get('instansi')->row_array();
                    $kode = ((int)$last_code['kode']) + 1;
                    $no_urut = sprintf("%05s", $kode);
                } else {
                    $no_urut = '00001';
                }
                $kode_instansi = 'IN' . $no_urut;
                $instansi =  [
                    'id_instansi' => $kode_instansi,
                    'nama_instansi' => htmlspecialchars($post['nama_instansi']),
                    'tgl_input' => date('Y-m-d H:i:s'),
                    'user_input' => $this->user['user']
                ];

                $instansi_alamat = [
                    'id_instansi' => $kode_instansi,
                    'alamat' => htmlspecialchars($post['alamat']),
                    'id_kelurahan' => '',
                    'id_kecamatan' => '',
                    'id_kabupaten' => htmlspecialchars($post['kabupaten']),
                    'id_provinsi' => htmlspecialchars($post['provinsi'])
                ];

                $instansi_kontak = [
                    'id_instansi' => $kode_instansi,
                    'no_telpon' => "",
                    'no_rekening' => "",
                    'email' => "",
                    'penanggung_jawab' => htmlspecialchars($post['penanggung_jawab']),
                    'no_telp_penanggung_jawab' => htmlspecialchars($post['no_penanggung_jawab'])
                ];

                $string = [
                    'instansi' => $instansi,
                    'instansi_alamat' => $instansi_alamat,
                    'instansi_kontak' => $instansi_kontak
                ];
                $log = simpan_log("insert instansi", json_encode($string));
                $res = $this->instansi->insert_instansi($instansi, $instansi_alamat, $instansi_kontak, $log);
                $data = ['status' => TRUE, 'notif' => $res];
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        } else {
            kirim_pesan("blocked");
        }
    }

    public function form_edit()
    {
        if ($this->akses['ubah'] == 'Y') {
            $id = htmlspecialchars($this->input->post('id', TRUE));
            $id_instansi = decrypt_url($id);
            $instansi = $this->instansi->get_instansi_id($id_instansi);
            $data = [
                'instansi' => $instansi,
                'result_provinsi' => $this->mquery->select_data('provinsi', "id_provinsi ASC"),
                'result_kabupaten' => $this->mquery->select_by('kabupaten', ['id_provinsi' => $instansi['id_provinsi']], 'nama_kabupaten ASC')
            ];
            $this->load->view('instansi/data/form_edit', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    function edit()
    {
        if ($this->akses['ubah'] == 'Y') {
            $this->_rule_form();
            if ($this->form_validation->run() == false) {
                $this->_send_error();
            } else {
                $post = $this->input->post(null, TRUE);
                $id = htmlspecialchars($post['id_instansi']);
                $id_instansi = decrypt_url($id);
                if ($id_instansi == "error") {
                    kirim_pesan("access");
                } else {
                    $temp = $this->instansi->get_instansi_id($id_instansi);
                    $instansi =  [
                        'nama_instansi' => htmlspecialchars($post['nama_instansi']),
                        'tgl_update' => date('Y-m-d H:i:s'),
                        'user_update' => $this->user['user']
                    ];

                    $instansi_alamat = [
                        'alamat' => htmlspecialchars($post['alamat']),
                        'id_kelurahan' => '',
                        'id_kecamatan' => '',
                        'id_kabupaten' => htmlspecialchars($post['kabupaten']),
                        'id_provinsi' => htmlspecialchars($post['provinsi'])
                    ];

                    $instansi_kontak = [
                        'no_telpon' => "",
                        'no_rekening' => "",
                        'email' => "",
                        'penanggung_jawab' => htmlspecialchars($post['penanggung_jawab']),
                        'no_telp_penanggung_jawab' => htmlspecialchars($post['no_penanggung_jawab'])
                    ];

                    $string = [
                        'old' => $temp,
                        'instansi' => $instansi,
                        'instansi_alamat' => $instansi_alamat,
                        'instansi_kontak' => $instansi_kontak
                    ];
                    $log = simpan_log("update instansi", json_encode($string));
                    $res = $this->instansi->update_instansi($id_instansi, $instansi, $instansi_alamat, $instansi_kontak, $log);
                    $data = ['status' => TRUE, 'notif' => $res];
                    $this->output->set_content_type('application/json')->set_output(json_encode($data));
                }
            }
        } else {
            kirim_pesan("blocked");
        }
    }

    function delete()
    {
        if ($this->akses['hapus'] == 'Y') {
            $id = htmlspecialchars($this->input->post('id', TRUE));
            $id_instansi = decrypt_url($id);
            if ($id_instansi == "error") {
                kirim_pesan("access");
            } else {
                $temp = $this->instansi->get_instansi_id($id_instansi);
                $string = ['instansi' => $temp];
                $log = simpan_log("delete instansi", json_encode($string));
                $res = $this->instansi->delete_instansi($id_instansi, $log);
                $data = ['notif' => $res];
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            }
        } else {
            kirim_pesan("blocked");
        }
    }

    public function detail($id_instansi)
    {
        $instansi = $this->instansi->get_instansi_id($id_instansi);
        $data = [
            "menu_active" => "instansi",
            "submenu_active" => null,
            "instansi" => $instansi,
            "jlh_surat" => $this->mquery->count_data('surat_masuk', ['id_pengirim' => $instansi['id_instansi']]),
            "jlh_dosismeter" => $this->mquery->count_data('dosismeter', ['id_instansi' => $instansi['id_instansi']]),
            "jlh_pengguna" => $this->mquery->count_data('data_pengguna', ['id_instansi' => $instansi['id_instansi']])
        ];
        $this->load->view('instansi/data/view_detail', $data);
    }
}
