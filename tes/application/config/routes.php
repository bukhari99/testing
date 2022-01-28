<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['logout'] = 'auth/logout';
$route['blocked'] = 'auth/blocked';

$route['dashboard'] = 'dashboard';

// ========================= Module untuk wilayah ============================
$route['provinsi'] = 'master/provinsi';
$route['provinsi/load'] = 'master/provinsi/load';
$route['kabupaten'] = 'master/kabupaten';
$route['kabupaten/load'] = 'master/kabupaten/load';
$route['kecamatan'] = 'master/kecamatan';
$route['kecamatan/load'] = 'master/kecamatan/load';
$route['kelurahan'] = 'master/kelurahan';
$route['kelurahan/load'] = 'master/kelurahan/load';

// ========================= Module untuk instansi ============================
$route['instansi'] = 'instansi/instansi';
$route['instansi/load'] = 'instansi/instansi/load';
$route['instansi/form-add'] = 'instansi/instansi/form_add';
$route['instansi/add'] = 'instansi/instansi/add';
$route['instansi/form-edit'] = 'instansi/instansi/form_edit';
$route['instansi/edit'] = 'instansi/instansi/edit';
$route['instansi/delete'] = 'instansi/instansi/delete';

$route['instansi/detail/([0-9a-zA-Z=-_]+)'] = 'instansi/instansi/detail/$1';
$route['instansi/surat-masuk/load'] = 'instansi/detail_instansi/load_surat';
$route['instansi/dosismeter/load'] = 'instansi/detail_instansi/load_dosismeter';
$route['instansi/pengguna/load'] = 'instansi/detail_instansi/load_pengguna';

// Skripsi Rancangan Publik -----------------------------------------------------------------
$route['srp'] = 'instansi/srp';
$route['srp/load'] = 'instansi/srp/load';
$route['srp/form-add'] = 'instansi/srp/form_add';
$route['srp/add'] = 'instansi/srp/add';
$route['srp/form-edit'] = 'instansi/srp/form_edit';
$route['srp/edit'] = 'instansi/srp/edit';
$route['srp/edit2'] = 'instansi/srp/edit2';
$route['srp/edit3'] = 'instansi/srp/edit3';
$route['srp/laporan/([0-9a-zA-Z=-_]+)'] = 'instansi/srp/laporan/$1';
$route['srp/delete'] = 'instansi/srp/delete';

// Penelitian -----------------------------------------------------------------
$route['penelitian'] = 'instansi/penelitian';
$route['penelitian/load'] = 'instansi/penelitian/load';
$route['penelitian/form-add'] = 'instansi/penelitian/form_add';
$route['penelitian/add'] = 'instansi/penelitian/add';
$route['penelitian/form-edit'] = 'instansi/penelitian/form_edit';
$route['penelitian/edit'] = 'instansi/penelitian/edit';
$route['penelitian/edit2'] = 'instansi/penelitian/edit2';
$route['penelitian/edit3'] = 'instansi/penelitian/edit3';
$route['penelitian/laporan/([0-9a-zA-Z=-_]+)'] = 'instansi/penelitian/laporan/$1';
//$route['srp/delete'] = 'instansi/srp/delete';

// Kerja Praktek -----------------------------------------------------------------
$route['kerjapraktek'] = 'instansi/kerjapraktek';
$route['kerjapraktek/load'] = 'instansi/kerjapraktek/load';
$route['kerjapraktek/form-add'] = 'instansi/kerjapraktek/form_add';
$route['kerjapraktek/add'] = 'instansi/kerjapraktek/add';
$route['kerjapraktek/form-edit'] = 'instansi/kerjapraktek/form_edit';
$route['kerjapraktek/edit'] = 'instansi/kerjapraktek/edit';
$route['kerjapraktek/edit2'] = 'instansi/kerjapraktek/edit2';
$route['kerjapraktek/edit3'] = 'instansi/kerjapraktek/edit3';
$route['kerjapraktek/laporan/([0-9a-zA-Z=-_]+)'] = 'instansi/kerjapraktek/laporan/$1';

$route['kerjapraktekselesai'] = 'instansi/kerjapraktekselesai';
$route['kerjapraktekselesai/load'] = 'instansi/kerjapraktekselesai/load';
//$route['srp/delete'] = 'instansi/srp/delete';

// Skripsi Penelitian -----------------------------------------------------------------
$route['skripsipenelitian'] = 'instansi/skripsipenelitian';
$route['skripsipenelitian/load'] = 'instansi/skripsipenelitian/load';
$route['skripsipenelitian/form-add'] = 'instansi/skripsipenelitian/form_add';
$route['skripsipenelitian/add'] = 'instansi/skripsipenelitian/add';
$route['skripsipenelitian/form-edit'] = 'instansi/skripsipenelitian/form_edit';
$route['skripsipenelitian/edit'] = 'instansi/skripsipenelitian/edit';
$route['skripsipenelitian/edit2'] = 'instansi/skripsipenelitian/edit2';
$route['skripsipenelitian/edit3'] = 'instansi/skripsipenelitian/edit3';
$route['skripsipenelitian/laporan/([0-9a-zA-Z=-_]+)'] = 'instansi/skripsipenelitian/laporan/$1';
$route['skripsipenelitian/laporan2/([0-9a-zA-Z=-_]+)'] = 'instansi/skripsipenelitian/laporan2/$1';
$route['srp/delete'] = 'instansi/srp/delete';



// ========================= Module untuk users ===============================
$route['users'] = 'setting/users';
$route['users/load'] = 'setting/users/load';
$route['users/form-add'] = 'setting/users/form_add';
$route['users/add'] = 'setting/users/add';
$route['users/form-edit'] = 'setting/users/form_edit';
$route['users/edit'] = 'setting/users/edit';
$route['users/delete'] = 'setting/users/delete';
$route['profile'] = 'setting/profile';
$route['profile/load'] = 'setting/profile/load';
$route['profile/form-foto'] = 'setting/profile/form_foto';
$route['profile/foto'] = 'setting/profile/foto';
$route['profile/form-password'] = 'setting/profile/form_password';
$route['profile/password'] = 'setting/profile/password';

// ========================= Module untuk list menu ===========================
$route['list-menu'] = 'konfigurasi/menu';
$route['list-menu/load'] = 'konfigurasi/menu/load';
$route['list-menu/form-add'] = 'konfigurasi/menu/form_add';
$route['list-menu/add'] = 'konfigurasi/menu/add';
$route['list-menu/form-edit'] = 'konfigurasi/menu/form_edit';
$route['list-menu/edit'] = 'konfigurasi/menu/edit';
$route['list-menu/delete'] = 'konfigurasi/menu/delete';
// ========================= Module untuk akses menu ===========================
$route['akses-menu'] = 'konfigurasi/akses';
$route['akses-menu/form-edit'] = 'konfigurasi/akses/form_edit';
$route['akses-menu/edit'] = 'konfigurasi/akses/edit';

// ========================== Modul untuk surat masuk ==============================
$route['surat-masuk'] = 'surat_masuk/surat';
$route['surat-masuk/load'] = 'surat_masuk/surat/load';
$route['surat-masuk/form-add'] = 'surat_masuk/surat/form_add';
$route['surat-masuk/add'] = 'surat_masuk/surat/add';
$route['surat-masuk/form-edit'] = 'surat_masuk/surat/form_edit';
$route['surat-masuk/edit'] = 'surat_masuk/surat/edit';
$route['surat-masuk/delete'] = 'surat_masuk/surat/delete';

// ========================== Modul untuk disposisi ===============================
$route['surat-masuk/disposisi'] = 'surat_masuk/disposisi/form';
$route['surat-masuk/add-disposisi'] = 'surat_masuk/disposisi/add';

// ===================== Modul untuk lampiran surat masuk =========================
$route['surat-masuk-detail/load'] = 'surat_masuk_detail/load';
$route['surat-masuk-detail/add'] = 'surat_masuk_detail/add';
$route['surat-masuk-detail/delete'] = 'surat_masuk_detail/delete';
$route['surat-masuk-detail/([0-9a-zA-Z=-_]+)'] = 'surat_masuk_detail/index/$1';





$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
