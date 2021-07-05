<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class User extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
		}
		
		public function index()
		{
			cek_menu_akses();
			$data['title'] = 'Data pengguna';
			$data['record'] = $this->model_app->view_ordering('tb_users','username','DESC');
			$this->template->load('main/themes','main/user/user',$data);
		}
		
		public function add_user(){
			$data['judul'] = 'Data pengguna';
			$this->template->load('main/themes','main/user/form_add',$data);
		}
		public function edit_user()
		{
			$data['title'] = 'Edit Data';
			$id = $this->uri->segment(3);
			if (isset($_POST['submit'])){
				$pid = $this->input->post('id');
				if($pid >0){
					$data_cat = $this->input->post('data');
					$input_data=implode(',',$data_cat);
					$level = $this->input->post('level');
					$level=explode(',',$level);
					if($this->input->post('password') ==''){
						$data = array('idmenu'=>$input_data,
						'nama_lengkap'=>$this->db->escape_str($this->input->post('nama')),
						'email'=>$this->db->escape_str($this->input->post('email')),
						'id_level'=>$level[0],
						'level'=>$level[1],
						'aktif'=>$this->input->post('aktif'));
						}else{
						$data = array('idmenu'=>$input_data,
						'nama_lengkap'=>$this->db->escape_str($this->input->post('nama')),
						'email'=>$this->db->escape_str($this->input->post('email')),
						'password'=>password_hash($this->input->post('password'), PASSWORD_DEFAULT),
						'id_level'=>$level[0],
						'level'=>$level[1],
						'aktif'=>$this->input->post('aktif'));
					}
					$where = array('id_user' => $this->input->post('id'));
					$res= $this->model_app->update('tb_users', $data, $where);
					if($res==true){
						$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
						redirect('user');
						}else{
						$this->session->set_flashdata('message', '<script>notif("Data gagal simpan","danger");</script>');
						redirect('user');
					}
					}else{
					$input_data = $this->input->post('data');
					if(!empty($input_data)){
						$input_data=implode(',',$input_data);
					}
					$level = $this->input->post('level');
					$level=explode(',',$level);
					$data = array('idmenu'=>$input_data,
					'nama_lengkap'=>$this->db->escape_str($this->input->post('nama')),
					'email'=>$this->db->escape_str($this->input->post('email')),
					'password'=>password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'tgl_daftar'=>date('Y-m-d H:i:s'),
					'id_level'=>$level[0],
					'level'=>$level[1],
					'aktif'=>$this->input->post('aktif'));
					$res= $this->model_app->insert('tb_users',$data);
					if($res==true){
						$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
						redirect('user');
						}else{
						$this->session->set_flashdata('message', '<script>notif("Data gagal simpan","danger");</script>');
						redirect('user');
					}
				}
				
				exit;
			}
			if($id >0){
				$data['judul'] = 'Form edit';
				$proses = $this->model_app->edit('tb_users', array('id_user' => $id))->row_array();
				$data['rows'] = $proses;
				$this->template->load('main/themes','main/user/form_edit',$data);
				}else{
				$data['judul'] ='Form Add';
				$data['id'] =0;
				$this->template->load('main/themes','main/user/form_add',$data);
			}
		}
		function hapus_user(){
			cek_session_login();
			cek_session_admin();
			$id = $this->db->escape_str($this->input->post('id'));
			$where = array('id_user' => $id);
			$search = $this->model_app->edit('tb_users', $where);
			if($search->num_rows()>0){
				$row = $search->row_array();
				if($row['level']=='admin'){
					$data = array('ok'=>'erradm','msg'=>'Admin tidak boleh dihapus');
					}else{
					$res = $this->model_app->delete('tb_users',$where);
					if($res==true){
						$data = array('ok'=>'ok','msg'=>'Data berhasil dihapus');
						}else{
						$data = array('ok'=>'err','msg'=>'Data gagal dihapus');
					}
				}
				}else{
				$data = array('ok'=>'err','msg'=>'Data gagal dihapus');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
	}			