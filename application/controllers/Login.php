<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	
	public function cek_login(){
	$ci = & get_instance();
	$ip = gethostbyname(trim(exec("hostname")));
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$session = $ci->session->userdata('idu');
	$ids = $ci->session->userdata('ids');
	$rses = $ci->db->query("SELECT sesi_login FROM tb_users where id_user='$session'")->row_array();
	if ($rses['sesi_login'] != $ids) {
	session_destroy();
    echo 'logout';
	}
	if ($this->session->level==''){
    echo 'logout';
	// exit;
} 
	}
}
?>