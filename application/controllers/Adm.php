<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adm extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('string');
		// $this->load->library('session');
	}
	function index(){
		if (isset($_POST['submit'])){
				$email_user = $this->input->post('email_user');
				$password = $this->input->post('pass_user');
				$cek = $this->model_app->cek_user($email_user);
				$total = $cek->num_rows();
				if ($total > 0){
					$sid_baru = session_id();
					$row = $cek->row_array();
					$hash = $row['password'];
					if (password_verify($password, $hash)) {
					$this->session->set_userdata(array('idu'=>$row['id_user'],'emailu'=>$row['email'],'nama'=>$row['nama_lengkap'],'level'=>$row['level'],'id_session'=>$row['id_session'],'ids'=>$sid_baru));
					$this->model_app->update('tb_users', array("sesi_login"=>$sid_baru),array('id_user'=>$this->session->idu));
					redirect('main');
					}else{
						
							
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username atau Password Salah!!</center></div>');
				$data['title'] = 'Username atau Password salah!';
				$this->load->view('element/login', $data);
					}
				}else{
				echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username atau Password Salah!!</center></div>');
				$data['title'] = 'username salah atau akun anda sedang diblokir';
				$data['username'] = $password;
				// $this->load->view('_layout/auth-header', $data);
				$this->load->view('element/login', $data);
				// $this->load->view('_layout/auth-footers', $data);
				}
		}else{
            if ($this->session->level!=''){
              redirect('main');
            }else{
    			$data['title'] = 'Administrator &rsaquo; Log In';
				// $this->load->view('_layout/auth-header', $data);
				$this->load->view('element/login', $data);
				// $this->load->view('_layout/auth-footers', $data);
            }
		}
	}
}
?>