<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Main extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
			
			$this->perPage = 10; 
		}
		
		public function index()
		{
			$data['title'] = 'Dashboard';
			$this->template->load('main/themes','main/index',$data);
		}
		public function ambildata(){
			// if ($this->input->is_ajax_request()){
			$data['record'] = $this->model_app->view_ordering('tb_users','username','DESC');
			$arr = $this->load->view('main/user/ambildata',$data);
			$msg = array('hasil'=>$arr);
			echo json_encode($msg);
		}
		public function logout(){
			$this->session->sess_destroy();
			redirect('adm');
		}
		
		
		public function profil()
		{
			$data['title'] = 'Edit Data';
			$id = $this->uri->segment(3);
			if (isset($_POST['submit'])){
				$pid = $this->input->post('id');
				if($pid !=''){
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
					$where = array('sesi_login' => $this->input->post('id'));
					$res= $this->model_app->update('tb_users', $data, $where);
					if($res==true){
						$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
						redirect('main/profil/'.$pid);
						}else{
						$this->session->set_flashdata('message', '<script>notif("Data gagal simpan","danger");</script>');
						redirect('main/profil/'.$pid);
					}
					}else{
					redirect('main/');
				}
				
				exit;
				}else{
				if($id !=""){
					$data['judul'] = 'Form edit';
					$proses = $this->model_app->edit('tb_users', array('sesi_login' => $id))->row_array();
					$data['rows'] = $proses;
					$this->template->load('main/themes','main/user/edit_profil',$data);
					}else{
					redirect('main');
				}
			}
		}
		
		
		public function menuadmin()
		{
			// echo $this->uri->segment(1);
			cek_menu_akses();
			$data['title'] = 'Menu Admin';
			$this->template->load('main/themes','main/menuadmin',$data);
		}
		public function info(){
			cek_menu_akses();
			$data['title'] = 'Pengaturan Aplikasi';
			$data['rows'] = $this->model_app->views('info')->row_array();
			
			$arr = curl();
			$data['update'] = $arr->update;
			$this->template->load('main/themes','main/website/index',$data);
		}
		public function info_save(){
			if (isset($_POST['submit'])){
				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = 'gif|jpg|png|ico|svg';
				$config['max_size'] = '1000'; // kb
				$this->load->library('upload', $config);
				
				$search=$this->model_app->view_where('info',array('id'=>1));
				if($search->num_rows()>0){
					$datas=$search->row();
					$nama_logo=$datas->logo;
					$nama_logo_bw=$datas->logo_bw;
					$nama_icon=$datas->favicon;
					$lunas=$datas->stamp_l;
					$blunas=$datas->stamp_b;
				}
				// print_r($search);
				// echo $nama_logo;
				if(!empty($_FILES["logo"]["name"])){
					$_logo=FCPATH."uploads/".$nama_logo;
					unlink($_logo);
					if(!$this->upload->do_upload('logo'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$nama_logo = $data["file_name"];
					}  
				}
				
				if(!empty($_FILES["logo_bw"]["name"])){
					$_logo=FCPATH."uploads/".$nama_logo_bw;
					unlink($_logo);
					if(!$this->upload->do_upload('logo_bw'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$nama_logo_bw = $data["file_name"];
					}  
				}
				if(!empty($_FILES["icon"]["name"])){
					$favicon=FCPATH."uploads/".$nama_icon;
					unlink($favicon);
					if(!$this->upload->do_upload('icon'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$nama_icon = $data["file_name"];
					}  
				}
				if(!empty($_FILES["lunas"]["name"])){
					$favicon=FCPATH."uploads/".$lunas;
					unlink($favicon);
					if(!$this->upload->do_upload('lunas'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$lunas = $data["file_name"];
					}  
				}
				if(!empty($_FILES["blunas"]["name"])){
					$favicon=FCPATH."uploads/".$blunas;
					unlink($favicon);
					if(!$this->upload->do_upload('blunas'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$blunas = $data["file_name"];
					}  
				}
				$data = array('title'=>$this->input->post('title')
				,'deskripsi'=>$this->input->post('deskripsi')
				,'ket'=>$this->input->post('ket')
				,'email'=>$this->input->post('email')
				,'phone'=>$this->input->post('phone')
				,'fb'=>$this->input->post('fb')
				,'ig'=>$this->input->post('ig')
				,'logo'=>$nama_logo
				,'logo_bw'=>$nama_logo_bw
				,'stamp_l'=>$lunas
				,'stamp_b'=>$blunas
				,'warna_lunas'=>$this->input->post('warna_lunas')
				,'warna_blunas'=>$this->input->post('warna_blunas')
				,'tema'=>$this->input->post('tema')
				,'favicon'=>$nama_icon);	
				$where = array('id' => 1);
				$res= $this->model_app->update('info', $data, $where);
				if($res==true){
					$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
					redirect('main/info');
					}else{
					$this->session->set_flashdata('message', '<script>notif("Data gagal di simpan","danger");</script>');
					redirect('main/info');
				}
			}
		}
		
		public function json_chart(){
			$data=$this->model_data->get_chart();
			print json_encode($data);
		}
		public function crud(){
			cek_session_login();	
			$type = $this->input->get('type', TRUE);
			$gdata = $this->input->get('data', TRUE);
			$id = $this->input->get('id', TRUE);('id');
			$label = $this->input->get('label', TRUE);
			$link = $this->input->get('link', TRUE);
			$eclass = $this->input->get('eclass', TRUE);
			$treeview = $this->input->get('parentc', TRUE);
			$aktif = $this->input->get('aktif', TRUE);
			$submenu = $this->input->get('submenu', TRUE);
			if($type=='get'){
				$data = array();
				$return = $this->db->query("SELECT * FROM menuadmin WHERE idmenu='".$id."'")->row_array();	
				$data = array(
				'id' => $return['idmenu'],
				'label' => $return['nama_menu'],
				'link' => $return['link'],
				'eclass' => $return['icon'],
				'parentc' => $return['treeview'],
				'aktif' => $return['aktif'],
				'level' => $return['id_level'],
				'submenu' => $return['link_on']
				);	
				echo json_encode($data);
				}elseif($type=='simpan'){
				$data = json_decode($this->input->get('data', TRUE));
				function parseJsonArray($jsonArray, $parentID = 0) {
					$return = array();
					foreach ($jsonArray as $subArray) {
						$returnSubSubArray = array();
						if (isset($subArray->children)) {
							$returnSubSubArray = parseJsonArray($subArray->children, $subArray->id);
						}
						$return[] = array('id' => $subArray->id, 'parentID' => $parentID);
						$return = array_merge($return, $returnSubSubArray);
					}
					return $return;
				}
				
				$readbleArray = parseJsonArray($data);
				
				$i=0;
				foreach($readbleArray as $row){
					$qry = $this->db->query("update menuadmin set idparent = '".$row['parentID']."', urutan='$i' where idmenu = '".$row['id']."' ");
					$i++;
				}
				}elseif($type=='hapus'){
				function recursiveDelete($id) {
					$ci = & get_instance();
					$data = array('hapus'=>'hapus');
					$query = $ci->db->query("select * from menuadmin where idparent = '".$id."' ");
					if ($query->num_rows >0) {
						foreach ($query->result_array() as $current){
							recursiveDelete($current['idmenu']);
						}
					}
					$qry = $ci->db->query("delete from menuadmin where idmenu = '".$id."' ");
					if($qry){
						$data = array(0=>'ok');;
						}else{
						$data = array(0=>'error');;
					}
					echo json_encode($data);
				}
				recursiveDelete($id);
			}
		}
		public function save_menu(){
			cek_session_login();	
			$type = $this->input->get('type', TRUE);
			$id = $this->input->get('id', TRUE);('id');
			$label = $this->input->get('label', TRUE);
			$link = $this->input->get('link', TRUE);
			$eclass = $this->input->get('eclass', TRUE);
			$treeview = $this->input->get('parentc', TRUE);
			$aktif = $this->input->get('aktif', TRUE);
			$submenu = $this->input->get('submenu', TRUE);
			$level = $this->input->get('level', TRUE);
			///
			if($type=='simpan'){
				if($id != ''){
					$this->db->query("update menuadmin set nama_menu = '".$label."', link  = '".$link."', icon  = '".$eclass."', treeview  = '".$treeview."', aktif  = '".$aktif."', link_on  = '".$submenu."', id_level  = '".$level."' where idmenu = '".$id."' ");
					
					$arr['type']  = 'edit';
					$arr['label'] = $label;
					$arr['link']  = $link;
					$arr['eclass']  = $eclass;
					$arr['parentc']  = $treeview;
					$arr['aktif']  = $aktif;
					$arr['submenu']  = $submenu;
					$arr['level']  = $level;
					$arr['id']    = $id;
					} else {
					$row = $this->db->query("SELECT max(urutan)+1 as urutan FROM menuadmin")->row_array();
					$qry = $this->db->query("insert into menuadmin (nama_menu,link,icon,id_level,treeview,aktif,link_on,urutan) values ('".$label."', '".$link."', '".$eclass."', '".$level."', '".$treeview."', '".$aktif."','".$submenu."','".$row['urutan']."')");
					if($qry){
						$arr['ok'] = 'ok';
						$lastid = $this->db->insert_id();
						$resultz = $this->db->query("SELECT idmenu FROM menuadmin");
						foreach ($resultz->result_array() as $rowz){
							$ids_array[] = $rowz['idmenu'];
						}
						$data = implode(",",$ids_array);
						$this->db->query("update tb_users set idmenu = '".$data."'");
						$arr['menu'] = '<li class="dd-item dd3-item" data-id="'.$lastid.'" >
	                    <div class="dd-handle dd3-handle"></div>
	                    <div class="ns-row">
						<div class="ns-title" id="label_show'.$lastid.'">'.$label.'</div>
						<div class="ns-url" id="link_show'.$lastid.'">'.$link.'</div> 
						<div class="ns-class" id="eclass_show'.$lastid.'">'.$eclass.'</div>
						<div class="ns-actions">
						<a class="edit-button" id="'.$lastid.'" label="'.$label.'" link="'.$link.'" eclass="'.$eclass.'" parentc="'.$treeview.'"><i class="fa fa-pencil"></i></a>
						<a href="#" class="confirm-delete" data-id="'.$lastid.'" id="'.$lastid.'"><i class="fa fa-trash"></i></a>
						</div> 
	                    </div>
						<script>
						$(".confirm-delete").on("click", function(e) {
						e.preventDefault();
						var id = $(this).data("id");
						$("#myModalDel").data("id", id).modal("show");
						});
						</script>';
						}else{
						$arr['type'] = 'error';
					}
					$arr['type'] = 'add';
				}
			}
			
			echo json_encode($arr);
		}
		public function cek_konsumen()
		{
			cek_session_login();
			$id = $this->db->escape_str($this->input->post('id'));
			$search=$this->model_app->view_where('konsumen',array('id'=>$id));
			if($search->num_rows()>0){
				$row =$search->row();
				$data = array(
				'id'=>$row->id,
				'nama'=>$row->nama,
				'panggilan'=>$row->panggilan,
				'nohp'=>$row->no_hp,
				'perusahaan'=>$row->perusahaan,
				'alamat'=>$row->alamat,
				'via'=>$row->referal,
				'status'=>$row->status,
				'max'=>$row->max_utang
				);
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function update_konsumen()
		{
			cek_session_login();
			// print_r($_POST);
			$id = $this->db->escape_str($this->input->post('id_edit'));
			$nama_edit = $this->db->escape_str($this->input->post('nama_edit'));
			$panggilan_edit = $this->db->escape_str($this->input->post('panggilan_edit'));
			$telepon_edit = $this->db->escape_str($this->input->post('telepon_edit'));
			$perusahaan_edit = $this->db->escape_str($this->input->post('perusahaan_edit'));
			$alamat_edit = $this->db->escape_str($this->input->post('alamat_edit'));
			$via_edit = $this->db->escape_str($this->input->post('via_edit'));
			$status = $this->db->escape_str($this->input->post('status'));
			$max_u = $this->db->escape_str($this->input->post('max_u'));
			
			$_data = array(
			'nama'=>$nama_edit,
			'panggilan'=>$panggilan_edit,
			'no_hp'=>$telepon_edit,
			'perusahaan'=>$perusahaan_edit,
			'alamat'=>$alamat_edit,
			'referal'=>$via_edit,
			'status'=>$status,
			'max_utang'=>$max_u,
			'tgl_edit'=>date('Y-m-d H:i:s')
			);
			///panggil
			$search=$this->model_app->view_where('konsumen',array('id'=>$id));
			$row =$search->row();
			$catat = json_encode($_data);
			if($row->history==''){
				$catat = $catat;
				}else{
				$catat = $row->history.','.$catat;
			}
			
			$data = array(
			'nama'=>$nama_edit,
			'panggilan'=>$panggilan_edit,
			'no_hp'=>$telepon_edit,
			'perusahaan'=>$perusahaan_edit,
			'alamat'=>$alamat_edit,
			'referal'=>$via_edit,
			'status'=>$status,
			'max_utang'=>$max_u,
			'history'=>$catat
			);
			
			
			$res = $this->model_app->update('konsumen', $data, array("id"=>$id));
			if($res===TRUE){
				$json = array('ok'=>'ok','msg'=>'Data berhasil diupdate');
				}else{
				$json = array('ok'=>'err','msg'=>'Data gagal diupdate');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($json));
		}
		public function detail_konsumen($id='')
		{
			// cek_session_login();
            cek_menu_akses();
			if(empty($id)){
				redirect('penjualan/konsumen_data/');
			}
			$data['title'] = 'Detail konsumen';
			$data['id'] = $id;
			
			// Get record count 
			$conditions['id'] = $id;
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getDetail($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#detailKonsumen'; 
			$config['base_url']    = base_url('main/ajaxDKonsumen'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			$conditions['where'] = array(
            'konsumen.id' => $id
			);
			$data['result'] = $this->model_data->getDetail($conditions); 
			$this->template->load('main/themes','main/detail_konsumen',$data);
		}
		function ajaxDKonsumen(){
			cek_session_login();
			// cek_menu_akses();
			$idkon = $this->input->post('idkon'); 
			$page = $this->input->post('page'); 
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			$limits = $this->input->post('limits'); 
			if(!empty($limits)){ 
				$limit = $limits; 
				}else{ 
				$limit = $this->perPage; 
			} 
			// Set conditions for search and filter 
			$keywords = $this->input->post('keywords'); 
			$sortBy = $this->input->post('sortBy'); 
			
			if(!empty($keywords)){ 
				$conditions['search']['keywords'] = $keywords; 
			} 
			if(!empty($sortBy)){ 
				$conditions['search']['sortBy'] = $sortBy; 
			} 
			if(!empty($limits)){ 
				$conditions['search']['limits'] = $limits; 
			}
			
			
			// Get record count 
			$conditions['id'] = $idkon;
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getDetail($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#detailKonsumen'; 
			$config['base_url']    = base_url('main/ajaxDKonsumen'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $limit; 
			$config['link_func']   = 'FilterKonsumen'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $limit;
			$conditions['where'] = array(
            'konsumen.id' => $idkon
			);
			unset($conditions['returnType']); 
			
			$data['posts'] = $this->model_data->getDetail($conditions); 
			
			// Load the data list view 
			$this->load->view('main/ajax-konsumen', $data, false); 
		}
	}														