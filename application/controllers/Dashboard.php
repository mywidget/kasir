<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function index()
		{
			if (isset($_POST['submit'])){
				$email_user = $this->input->post('email_user');
				$password = $this->input->post('pass_user');
				$cek = $this->model_app->cek_user($email_user);
				$total = $cek->num_rows();
				if ($total > 0){
					$row = $cek->row_array();
					$hash = $row['password'];
					if (password_verify($password, $hash)) {
						$this->session->set_userdata(array('idu'=>$row['id_user'],'emailu'=>$row['email'],'nama'=>$row['nama_lengkap'],'level'=>$row['level'],'id_session'=>$row['id_session']));
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
					$this->load->view('element/login', $data);
				}
				}else{
				if ($this->session->level!=''){
					redirect('main');
					}else{
					$data['title'] = 'Administrator &rsaquo; Log In';
					$this->load->view('element/login', $data);
				}
			}
		}
		
	}		