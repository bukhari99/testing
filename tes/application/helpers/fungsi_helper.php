<?php
function cek_query($res, $notifikasi)
{
    $ci = get_instance();
    if ($res > 0) {
        return $ci->session->set_flashdata('flash', 'success-Berhasil-Data Berhasil Di' . $notifikasi);
    } else {
        return $ci->session->set_flashdata('flash', 'error-Gagal-Data Gagal Di' . $notifikasi);
    }
}

function simpan_log($aksi, $keterangan)
{
    $ci = get_instance();
    $tgl_sekarang = date('Y-m-d');
    $tgl_kode = date('y-m-d');
    $cek_kode = $ci->db->get_where('log_user', ['date(waktu_akses)' => $tgl_sekarang])->num_rows();
    if ($cek_kode > 0) {
        $ci->db->select('log_id');
        $ci->db->from('log_user');
        $ci->db->where('date(waktu_akses)', $tgl_sekarang);
        $ci->db->order_by("log_id DESC");
        $ci->db->limit(1, 0);
        $last_kode = $ci->db->get()->row_array();
        $no_urut = substr($last_kode['log_id'], 6, 4);
        $v_kode = (int)($no_urut);
        $id_log = $v_kode + 1;
    } else {
        $id_log = 1;
    }
    $kode_log = str_replace('-', '', $tgl_kode) . str_pad($id_log, 4, "0",  STR_PAD_LEFT);

    $browser = [
        'browser' => $ci->agent->browser(),
        'version' => $ci->agent->version(),
        'os' => $ci->agent->platform(),
        'ip' => $ci->input->ip_address()
    ];
    $string = [
        'log_id'    => $kode_log,
        'username'     => $ci->session->userdata('username'),
        'aktivitas'    => $aksi,
        'aktivitas_detail' => $keterangan,
        'browser'     => json_encode($browser),
        'waktu_akses' => date('Y-m-d H:i:s')
    ];
    return $string;
}

function format_tanggal($tanggal)
{
    return date('d-m-Y', strtotime($tanggal));
}

function tanggal_database($tanggal)
{
    return date('Y-m-d', strtotime($tanggal));
}

function cek_file($path)
{
    if (file_exists(FCPATH . $path)) {
        return base_url($path);
    } else {
        return base_url("uploads/no-image.png");
    }
}

function hapus_file($path)
{
    if (file_exists(FCPATH . $path)) {
        unlink(FCPATH . $path);
    }
}

function kode_kabupaten($string)
{
    $provinsi = substr($string, 0, 2);
    $kabupaten = substr($string, 2, 2);
    return $provinsi . '.' . $kabupaten;
}

function kode_kecamatan($string)
{
    $provinsi = substr($string, 0, 2);
    $kabupaten = substr($string, 2, 2);
    $kecamatan = substr($string, 4, 2);
    return $provinsi . '.' . $kabupaten . '.' . $kecamatan;
}

function kode_kelurahan($string)
{
    $provinsi = substr($string, 0, 2);
    $kabupaten = substr($string, 2, 2);
    $kecamatan = substr($string, 4, 2);
    $kelurahan = substr($string, 6, 4);
    return $provinsi . '.' . $kabupaten . '.' . $kecamatan . '.' . $kelurahan;
}

function kode_acak($panjang_karakter)
{
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for ($i = 0; $i < $panjang_karakter; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

function format_nama($gelar_depan, $nama_pegawai, $gelar_belakang)
{
    if ($gelar_depan == '') {
        if ($gelar_belakang == '') {
            $nama = "$nama_pegawai";
        } else {
            $nama = "$nama_pegawai, $gelar_belakang";
        }
    } else {
        if ($gelar_belakang == '') {
            $nama = "$gelar_depan $nama_pegawai";
        } else {
            $nama = "$gelar_depan $nama_pegawai, $gelar_belakang";
        }
    }

    return $nama;
}

function status_permohonan($status)
{
    if ($status == 0) {
        return "Lengkapi Berkas";
    } elseif ($status == 1) {
        return "Menunggu Verifikasi BKD";
    } elseif ($status == 2) {
        return "Berkas sudah di verifikasi";
    }
}


function action_edit($id)
{
    return "<button id='tombol-ubah' data-id='" . $id . "' data-toggle='modal' data-target='#modal-form-action' class='btn btn-icon btn-round btn-success btn-sm' title='UBAH'><i class='fa fa-edit'></i> </button>";
}

function action_delete($id)
{
    return "<button id='tombol-hapus' data-id='" . $id . "' class='btn btn-icon btn-round btn-danger btn-sm' title='HAPUS'><i class='fa fa-trash'></i></button>";
}

function  kirim_pesan($tipe)
{
    $ci = get_instance();
    if ($tipe == "blocked") {
        $data = ['status' => FALSE, 'pesan' => 'Blocked...!!!'];
        $ci->output->set_content_type('application/json')->set_output(json_encode($data));
    } else {
        $data = ['status' => FALSE, 'pesan' => "Access Denied...!!!"];
        $ci->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
