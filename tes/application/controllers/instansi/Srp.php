<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Srp extends CI_Controller
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
            $this->load->view('instansi/data/view_srp', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    public function laporan()
    {
        if ($this->akses['akses'] == 'Y') {
            //$id_srp = '49';
            $id_srp = $this->uri->segment(3);
            $data = [
                //"menu_active" => "instansi",
                //"submenu_active" => null
                //'srp' => $this->mquery->select_data('tbl_skripsi_rancangan_publik', "nama ASC")
                'srp' => $this->instansi->get_skripsi_rancangan_publik($id_srp)
            ];
            $this->load->library('pdfgenerator');
            //$this->load->view('instansi/data/view_srp_pdf', $data);

            $html = $this->load->view('instansi/data/view_srp_pdf', $data, true);
		    $filename = 'report_'.time();
		    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
        } else {
            redirect(site_url('blocked'));
        }
    }

    public function load()
    {
        function tanggal_indo($tanggal)
{
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}
        if ($this->akses['akses'] == 'Y') {
            $role_surat = $this->session->userdata('role_surat');
            $nim_session = $this->session->userdata('nim');
           if($role_surat=='admin')
            {
                $result = $this->instansi->get_srp();
            }
            
            $data = [];
            $no = 0;
            foreach ($result as $r) {
                $no++;
                $edit = action_edit(encrypt_url($r['id_srp']));
                $delete = action_delete(encrypt_url($r['id_srp']));
                //$nama_instansi = "<a href=" . base_url("instansi/detail_srp/" . $r['id_srp']) . ">" . $r['nim'] . "</a>";
                $file_krs = "<a href='#' onclick=\"window.open('./uploads/srp/$r[file_krs]', '_blank', 'toolbar=0,scrollbars=1,location=no,statusbar=0,menubar=0,resizable=0,width=950px,height=600,left=200,top=50,titlebar=yes')\"><i class=\"fas fa-clipboard-list\"></i></a>";

                $file_lpprp = "<a href='#' onclick=\"window.open('./uploads/srp/$r[lembar_pprp]', '_blank', 'toolbar=0,scrollbars=1,location=no,statusbar=0,menubar=0,resizable=0,width=950px,height=600,left=200,top=50,titlebar=yes')\"><i class=\"fas fa-clipboard-list\"></i></a> - ";

                //if($role_surat=='admin')
                //{
                    $result = $this->instansi->get_srp();
                    $preview_hasil = " <a href='#' onclick=\"window.open('./srp/laporan/$r[id_srp]', '_blank', 'toolbar=0,scrollbars=1,location=no,statusbar=0,menubar=0,resizable=0,width=950px,height=600,left=200,top=50,titlebar=yes')\" title='Preview Surat Keputusan Skripsi Rancangan Pabrik'><i class=\"fas fa-print\"></i></a>";
                    if($r['file_hasil']<>'')
                    {
                        $file_hasil = " <a href='#' onclick=\"window.open('./uploads/srp/$r[file_hasil]', '_blank', 'toolbar=0,scrollbars=1,location=no,statusbar=0,menubar=0,resizable=0,width=950px,height=600,left=200,top=50,titlebar=yes')\" title='Berkas telah ditanda tangani'><i class=\"fas fa-book\"></i></a>";
                    }
                    else
                    {
                        $file_hasil = "";
                    }
                //}
                //else
                //{
                    //$preview_hasil = "";
                //}

                $row = [
                    'no' => $no,
                    'nama' => $r['nama']."",
                    'usia' => $r['usia'],
                    'jenis_kelamin' => $r['jk'],
                    'gol_pangkat' => "Gol. $r[golongan]$r[tingkat_golongan] $r[pangkat]",
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
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        //$this->form_validation->set_rules('file_krs', 'File KRS', 'required|trim');
        //$this->form_validation->set_rules('lembar_pprp', 'Lembar Pengesahan Proposal Rancangan Publik', 'required|trim');
        $this->form_validation->set_message('required', '%s tidak boleh kosong');
    }

    private function _send_error()
    {
        $errors = [
            'nama' => form_error('nama'),
            'usia' => form_error('usia')
        ];
        $data = ['status' => FALSE, 'errors' => $errors, 'pesan' => 'Data Gagal Disimpan, Lengkapi Isian'];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function form_add()
    {
        if ($this->akses['tambah'] == 'Y') {
            $data = [
                'result_pegawai' => $this->mquery->select_by('pegawai', ['id_sub_unit' => 'DOSEN'], 'nama_pegawai ASC')
                //'result_provinsi' => $this->mquery->select_data('provinsi', "id_provinsi ASC")
            ];
            $this->load->view('instansi/data/form_add_srp', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    function add()
    {
        if ($this->akses['tambah'] == 'Y') {
            $this->_rule_form();
            if ($this->form_validation->run() == false) {
                //$this->_send_error();
                $this->_send_error("default");
            } else {
                $post = $this->input->post(null, TRUE);
               

                $nama = htmlspecialchars($this->input->post('nama', TRUE));
                $usia = htmlspecialchars($this->input->post('usia', TRUE));
                $jk = htmlspecialchars($this->input->post('jk', TRUE));
                $pg = htmlspecialchars($this->input->post('pg', TRUE));
                $split_pg = explode('-', $pg);

                $tbl_data_pegawai = [
                    'nama' => $nama,
                    'usia' => $usia,
                    'jk' => $jk,
                    'golongan' =>  $split_pg[0],
                    'tingkat_golongan' =>  $split_pg[1],
                    'pangkat' =>  $split_pg[2],
                    'created_time' => date('Y-m-d')." ".date("H:i:s")
                ];

                $string = [
                    'tbl_data_pegawai' => $tbl_data_pegawai
                ];
                $log = simpan_log("insert instansi", json_encode($string));
                //$res = $this->instansi->insert_instansi($instansi, $instansi_alamat, $instansi_kontak, $log);
                $res = $this->instansi->insert_srp($tbl_data_pegawai, $log);
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
            $id_srp = htmlspecialchars($this->input->post('id', TRUE));
            $id_srp = decrypt_url($id_srp);
            $data = [
                'result_pegawai' => $this->mquery->select_by('pegawai', ['id_sub_unit' => 'DOSEN'], 'nama_pegawai ASC'),
                'srp' => $this->instansi->get_srp_edit($id_srp)
            ];
            $this->load->view('instansi/data/form_edit_srp', $data);
        } else {
            redirect(site_url('blocked'));
        }
    }

    function edit()
    {
        if ($this->akses['ubah'] == 'Y') {

                $id_srp = htmlspecialchars($this->input->post('id_srp', TRUE));
                $nama = htmlspecialchars($this->input->post('nama', TRUE));
                $usia = htmlspecialchars($this->input->post('usia', TRUE));
                $jk = htmlspecialchars($this->input->post('jk', TRUE));
                $pg = htmlspecialchars($this->input->post('pg', TRUE));
                $split_pg = explode('-', $pg);

                    $array =  [
                        'nama' => $nama,
                        'usia' => $usia,
                        'jk' => $jk,
                        'golongan' =>  $split_pg[0],
                        'tingkat_golongan' =>  $split_pg[1],
                        'pangkat' =>  $split_pg[2],
                        'updated_time' => date('Y-m-d')." ".date("H:i:s"),
                    ];
               

                
                $string = ['tbl_data_pegawai' => $array];
                $log = simpan_log("update", json_encode($string));
                $res = $this->mquery->update_data('tbl_data_pegawai', $array, ['id_srp' => $id_srp], $log);
                
                $data = ['status' => TRUE, 'notif' => $res];
                $this->output->set_content_type('application/json')->set_output(json_encode($data));

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

   
}
