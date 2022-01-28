<?php

function is_logged_in()
{
	$ci = get_instance();
	if (!$ci->session->userdata('username')) {
		redirect(site_url());
	} else {
		if ($ci->session->userdata('apps') == "aplikasibpfk") {
			$timeout = $ci->session->userdata('timeout');
			if (time() < $timeout) {
				$ci->session->set_userdata('timeout', time() + 9000);
				$user_id = $ci->session->userdata('user_id');
				$role_admin = $ci->session->userdata('role_admin');
				$data = [
					"user" => $user_id,
					"role" => $role_admin
				];
				return $data;
			} else {
				redirect(site_url());
			}
		} else {
			redirect(site_url());
		}
	}
}

function cek_akses_user()
{
	$ci = get_instance();
	$role_admin = $ci->session->userdata('role_admin');

	$menu = $ci->uri->segment(1);
	$queryMenu = $ci->db->get_where('users_menu', ['menu_link' => $menu])->row_array();
	$menu_id = $queryMenu['menu_id'];

	$userAccess = $ci->db->get_where('users_access', ['role_id' => $role_admin, 'menu_id' => $menu_id]);
	if ($userAccess->num_rows() == 0) {
		redirect(site_url('blocked'));
	} else {
		return $userAccess->row_array();
	}
}


function detail_user()
{
	$ci = get_instance();
	$ci->db->select('a.username, a.foto, b.role_name');
	$ci->db->join('users_role as b', 'a.role_id=b.role_id');
	$ci->db->where('username', $ci->session->userdata('username'));
	$users = $ci->db->get('pegawai as a')->row_array();

	$params = [
		'username' => $users['username'],
		'role' => $users['role_name'],
		'foto' => $users['foto']
	];
	return $params;
}

function encrypt_url($string)
{
	$output = false;
	$security       = parse_ini_file("security.ini");
	$secret_key     = $security["encryption_key"];
	$secret_iv      = $security["iv"];
	$encrypt_method = $security["encryption_mechanism"];
	$key    = hash("sha256", $secret_key);
	$iv     = substr(hash("sha256", $secret_iv), 0, 16);
	$result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	$output = base64_encode($result);
	return $output;
}

function decrypt_url($string)
{
	$output = false;
	$security       = parse_ini_file("security.ini");
	$secret_key     = $security["encryption_key"];
	$secret_iv      = $security["iv"];
	$encrypt_method = $security["encryption_mechanism"];
	$key    = hash("sha256", $secret_key);
	$iv = substr(hash("sha256", $secret_iv), 0, 16);
	$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	if (($output == "") or ($output == false) or ($output == null)) {
		return "error";
	} else {
		return $output;
	}
}
