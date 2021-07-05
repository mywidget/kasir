<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Produk extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
		}
		
		public function index()
		{
			cek_menu_akses();
			$data['title'] ='Data Produk';
			$data['judul'] ='Data Produk';
			$data['record'] = $this->model_app->produk();
			$this->template->load('main/themes','produk/produk',$data);
		}
		
		public function cari_invoice_page(){
			
			$page = $this->input->post('page'); 
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			$limit = 10; 
			$keywords = $this->input->post('keywords'); 
			
			if(!empty($keywords)){ 
				$conditions['search']['keywords'] = $keywords; 
			} 
			
			// Get record count 
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getCari($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#hasil_cari'; 
			$config['base_url']    = base_url('produk/cari_invoice'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $limit; 
			$config['link_func']   = 'cariFilterIn'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $limit;
			unset($conditions['returnType']); 
			$data['posts'] = $this->model_data->getCari($conditions); 
			$data['pilihan'] = $this->model_app->view('tb_users');
			// Load the data list view 
			$this->load->view('produk/cari_invoice', $data, false); 
		}
		public function modal_popup()
		{
			$data['title'] ='Data Produk';
			$this->load->view('produk/modal_popup');
		}
		public function add_produk()
		{
			$data['title'] ='Data Produk';
			$where = array('kunci' => 0);
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan',$where)->result_array();
			$this->template->load('main/themes','produk/add_produk',$data);
		}
		public function edit_produk($noid)
		{
			$data['title'] ='Edit Produk';
			$where = array('id' => $noid);
			$record = $this->model_app->edit('produk',$where)->row_array();
			$data['record'] = $record;
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan',array('kunci' => 0))->result_array();
			$this->template->load('main/themes','produk/edit_produk',$data);
		}
		public function save_produk()
		{
			$id = $this->db->escape_str($this->input->post('id'));
			$bahan = $this->db->escape_str($this->input->post('bahan'));
			$jenis = $this->db->escape_str($this->input->post('jenis'));
			if(!empty($bahan)){
				$bahan=implode(',',array_unique($bahan));
				}else{
				$bahan ='';
			}
			// print_r($bahan);
			if($id >0){
				$data = array(
				'title'=>$this->db->escape_str($this->input->post('nama')),
				'id_jenis'=>$jenis,
				'id_bahan'=>$bahan,
				'harga_dasar'=>$this->db->escape_str($this->input->post('harga'))
				);
				$res = $this->model_app->update('produk', $data,array('id'=>$id));
				if($res==true){
					$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
					redirect('produk');
					}else{
					$this->session->set_flashdata('message', '<script>notif("Data gagal di simpan","success");</script>');
					redirect('produk');
				}
				}else{
				$data = array(
				'title'=>$this->db->escape_str($this->input->post('nama')),
				'id_jenis'=>$jenis,
				'id_bahan'=>$bahan,
				'harga_dasar'=>$this->db->escape_str($this->input->post('harga'))
				);
				$res= $this->model_app->insert('produk',$data);
				if($res==true){
					$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
					redirect('produk');
					}else{
					$this->session->set_flashdata('message', '<script>notif("Data gagal di simpan","success");</script>');
					redirect('produk');
				}	
			}
		}
		public function hapus_produk()
		{
			$data['title'] ='Data Produk';
			$data['record'] = $this->model_app->view_ordering('bahan','id','DESC');
			$this->template->load('main/themes','produk/bahan',$data);
		}
		public function satuan()
		{
			cek_menu_akses();
			$data['title'] ='Satuan Produk';
			$this->template->load('main/themes','produk/satuan',$data);
		}
		public function data_satuan()
		{
			$data['title'] ='Satuan Produk';
			$data['record'] = $this->model_app->view_ordering('satuan','id','DESC');
			$this->load->view('produk/data_satuan',$data);
		}
		public function edit_satuan(){
			$id= $this->db->escape_str($this->input->post('id'));
			if($id>0){
				$where = array('id' => $id);
				$row = $this->model_app->edit('satuan',$where)->row_array();
				$data = array('id'=>$id,'judul'=>$row['satuan'],'aktif'=>$row['pub']);
				}else{
				$data = array('id'=>0,'judul'=>"","aktif"=>"");
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function save_satuan()
		{
			$id= $this->db->escape_str($this->input->post('id'));
			$type= $this->db->escape_str($this->input->post('type'));
			$judul= $this->db->escape_str($this->input->post('judul'));
			$aktif= $this->db->escape_str($this->input->post('aktif'));
			$_data = array('satuan'=>$judul,'pub'=>$aktif);
			if($id ==0 AND $type=='add'){
				///data baru
				$res= $this->model_app->insert('satuan',$_data);
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil disimpan');
					}else{
					$data = array('ok'=>'err');
				}
				}else{
				///data update
				$res=  $this->model_app->update('satuan',$_data,array('id'=>$id));
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil update');
					}else{
					$data = array('ok'=>'err');
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function hapus_satuan()
		{
			$id= $this->db->escape_str($this->input->post('id'));
			$res=$this->model_app->delete('satuan',array('id' => $id));
			if($res==true){
				$data = array('ok'=>'ok','msg'=>'Data berhasil dihapus');
				}else{
				$data = array('ok'=>'err','msg'=>'Data gagal dihapus');
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cari_bahans(){
			$data[] = array("id"=>1,"name"=>'Flexi');
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cari_bahan(){
			// print_r($_POST);
			$name= $this->db->escape_str($this->input->post('name'));
			$result = $this->model_app->view_like('bahan',array('title'=>$name));
			$data = array();
			foreach ($result->result_array() as $row)
			{
				$data[] = array("id"=>$row['id'],"name"=>$row['title']);
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function bahan()
		{
			cek_menu_akses();
			$data['title'] ='Data Produk';
			$data['record'] = $this->model_app->view_where_ordering('bahan',array('kunci'=>0),'id','DESC');
			$this->template->load('main/themes','produk/bahan',$data);
		}
		public function data_bahan()
		{
			$data['record'] = $this->model_app->view_where_ordering('bahan',array('kunci'=>0),'id','DESC');
			$this->load->view('produk/data_bahan',$data);
		}
		public function edit_bahan(){
			$id= $this->db->escape_str($this->input->post('id'));
			if($id>0){
				$where = array('id' => $id);
				$row = $this->model_app->edit('bahan',$where)->row_array();
				$data = array('id'=>$id,'judul'=>$row['title'],'harga'=>$row['harga'],'aktif'=>$row['pub']);
				}else{
				$data = array('id'=>0,'judul'=>"",'harga'=>'',"aktif"=>"");
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function save_bahan()
		{
			$id= $this->db->escape_str($this->input->post('id'));
			$type= $this->db->escape_str($this->input->post('type'));
			$judul= $this->db->escape_str($this->input->post('judul'));
			$harga= $this->db->escape_str($this->input->post('harga'));
			$aktif= $this->db->escape_str($this->input->post('aktif'));
			$_data = array('title'=>$judul,'harga'=>$harga,'pub'=>$aktif);
			if($id ==0 AND $type=='add'){
				///data baru
				$res= $this->model_app->insert('bahan',$_data);
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil disimpan');
					}else{
					$data = array('ok'=>'err');
				}
				}else{
				///data update
				$res=  $this->model_app->update('bahan',$_data,array('id'=>$id));
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil update');
					}else{
					$data = array('ok'=>'err');
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function hapus_bahan($id)
		{
			
			$search=$this->model_app->view_where('invoice_detail',array('id_bahan'=>$id));
			if($search->num_rows()>0){
				$data = array('ok'=>'err','msg'=>'Bahan tidak bisa dihapus');
				}else{
				$res=$this->model_app->delete('bahan',array('id' => $id));
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil dihapus');
					}else{
					$data = array('ok'=>'err','msg'=>'Data gagal dihapus');
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function jenis()
		{
			cek_menu_akses();
			$data['title'] = 'Jenis Produk';
			$data['judul'] ='Jenis Produk';
			$data['record'] = $this->model_app->view_ordering('jenis_cetakan','id_jenis','DESC');
			$this->template->load('main/themes','produk/jenis_cetakan',$data);
		}
		
		public function data_jenis(){
			$data['record'] = $this->model_app->view_ordering('jenis_cetakan','id_jenis','DESC');
			$this->load->view('produk/data_jenis',$data);
		}
		public function edit_jenis(){
			$id= $this->db->escape_str($this->input->post('id'));
			if($id>0){
				$where = array('id_jenis' => $id);
				$row = $this->model_app->edit('jenis_cetakan',$where)->row_array();
				$data = array('id'=>$id,'judul'=>$row['jenis_cetakan'],'grup'=>$row['status'],'aktif'=>$row['pub']);
				}else{
				$data = array('id'=>0,'judul'=>"","grup"=>"","aktif"=>"");
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function save_jenis()
		{
			$id= $this->db->escape_str($this->input->post('id'));
			$type= $this->db->escape_str($this->input->post('type'));
			$judul= $this->db->escape_str($this->input->post('judul'));
			$grup= $this->db->escape_str($this->input->post('grup'));
			$aktif= $this->db->escape_str($this->input->post('aktif'));
			$_data = array('jenis_cetakan'=>$judul,'status'=>$grup,'pub'=>$aktif);
			if($id ==0 AND $type=='add'){
				///data baru
				$res= $this->model_app->insert('jenis_cetakan',$_data);
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil disimpan');
					}else{
					$data = array('ok'=>'err');
				}
				}else{
				///data update
				$res=  $this->model_app->update('jenis_cetakan',$_data,array('id_jenis'=>$id));
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil update');
					}else{
					$data = array('ok'=>'err');
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function hapus_jenis()
		{
			$id = $this->db->escape_str($this->input->post('id'));
			$search=$this->model_app->view_where('invoice_detail',array('jenis_cetakan'=>$id));
			if($search->num_rows()>0){
				$data = array('ok'=>'err','msg'=>'Jenis tidak bisa dihapus');
				}else{
				$where = array('id_jenis' => $id);
				$res=$this->model_app->delete('jenis_cetakan',$where);
				if($res==true){
					$data = array('ok'=>'ok','msg'=>'Data berhasil dihapus');
					}else{
					$data = array('ok'=>'err','msg'=>'Data gagal dihapus');
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function print_invoice($noid){
			$id = array('id_invoice' => $noid);
			
			$search = $this->model_app->view_where('invoice', $id);
			$data['logo_lunas'] = FCPATH.'uploads/'.info()['logo'];
			$data['logo_blunas'] = FCPATH.'uploads/'.info()['logo_bw'];
			$data['lunas'] = FCPATH.'uploads/'.info()['stamp_l'];
			$data['blunas'] = FCPATH.'uploads/'.info()['stamp_b'];
			$data['html'] = 'N';
			if($search->num_rows()>0){
				$this->session->unset_userdata('cart');
				$row = $search->row_array();
				$jml =$row['cetak']+1;
				$this->model_app->update('tb_users', array("last_invoice"=>0),array('id_user'=>$this->session->idu));
				$this->model_app->update('invoice',array('cetak'=>$jml,'status'=>'simpan','pos'=>'Y','oto'=>6),array('id_invoice'=>$noid));
				//cek sisa
				$_total = 'ROUND(SUM((`invoice_detail`.`jumlah` * harga) - (`invoice_detail`.`jumlah` * harga) * (`invoice_detail`.`diskon`/100))) AS sisa';
				$cari_total= $this->model_app->cek_total('invoice_detail',$_total,array('id_invoice'=>$noid));
				$data['sisanya'] = $cari_total->sisa;
				//
				$data['cetak'] = $row;
				$data['info'] = info();
				$konsumen = $this->model_app->view_where('konsumen', array('id' => $row['id_konsumen']))->row_array();
				if($konsumen['max_utang'] >0){
					$max_utang = $konsumen['max_utang'] - 1;
					$this->model_app->update('konsumen',array('max_utang'=>$max_utang),array('id'=>$row['id_konsumen']));
				}
				$data['konsumen'] = $konsumen;
				$data['marketing'] = $this->model_app->view_where('tb_users', array('id_user' => $row['id_marketing']))->row_array();
				$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
				$data['total'] =$this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice'=>$noid))->row();
				//total detail
				// $select = 'SUM(jumlah * harga) AS `total`';
				$select = 'pajak, total_bayar AS total';
				$where = array('id_invoice'=>$noid);
				$tdetail= $this->model_app->cek_total('invoice',$select,$where);
				$data['tdetail'] = $tdetail->total;
				// $data['tdetail'] = $tdetail->total - $cari_total->sisa;
				$data['pajak'] = $tdetail->pajak;
				// $pajak = ($subtotal * $cetak['pajak']) /100;
				//cek count 
				$_diskon = 'SUM(diskon) AS `disc`';
				$cdiskon= $this->model_app->cek_total('invoice_detail',$_diskon,$where);
				$data['cdiskon'] = $cdiskon->disc;
				$_select = 'COUNT(id) AS `jml`';
				$cdetail= $this->model_app->cek_total('bayar_invoice_detail',$_select,$where);
				$data['cdetail'] = $cdetail->jml;
				//bayar detail
				$data['bdetail'] = $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();
				///
				$data['cara'] = $this->model_app->cara_bayar(array('`bayar_invoice_detail`.`id_invoice`' => $noid));
				$data['bank'] = $this->model_app->view_where('cara_bayar', array('slug !=' => ""))->result_array();
				$this->load->library('pdf');
				$this->pdf->setPaper('A5', 'landscape');
				$this->pdf->filename = "invoice_".$noid."_".$row['tgl_trx'];
				$this->pdf->load_view('produk/print_invoice', $data);
				// $this->load->view('produk/print_invoice',$data);
				}else{
				$data['cetak'] = 'error';
				$this->load->view('produk/print_invoice_error',$data);
			}
		}
		public function print_invoice_html($noid){
			$id = array('id_invoice' => $noid);
			
			$search = $this->model_app->view_where('invoice', $id);
			$data['logo_lunas'] = base_url().'uploads/'.info()['logo'];
			$data['logo_blunas'] = base_url().'uploads/'.info()['logo_bw'];
			$data['lunas'] = base_url().'uploads/'.info()['stamp_l'];
			$data['blunas'] = base_url().'uploads/'.info()['stamp_b'];
			$data['html'] = 'Y';
			if($search->num_rows()>0){
				$this->session->unset_userdata('cart');
				$row = $search->row_array();
				$jml =$row['cetak']+1;
				$this->model_app->update('tb_users', array("last_invoice"=>0),array('id_user'=>$this->session->idu));
				$this->model_app->update('invoice',array('cetak'=>$jml,'status'=>'simpan','pos'=>'Y','oto'=>6),array('id_invoice'=>$noid));
				//cek sisa
				$_total = 'ROUND(SUM((`invoice_detail`.`jumlah` * harga) - (`invoice_detail`.`jumlah` * harga) * (`invoice_detail`.`diskon`/100))) AS sisa';
				$cari_total= $this->model_app->cek_total('invoice_detail',$_total,array('id_invoice'=>$noid));
				$data['sisanya'] = $cari_total->sisa;
				//
				$data['cetak'] = $row;
				$data['info'] = info();
				$konsumen = $this->model_app->view_where('konsumen', array('id' => $row['id_konsumen']))->row_array();
				if($konsumen['max_utang'] >0){
					$max_utang = $konsumen['max_utang'] - 1;
					$this->model_app->update('konsumen',array('max_utang'=>$max_utang),array('id'=>$row['id_konsumen']));
				}
				$data['konsumen'] = $konsumen;
				$data['marketing'] = $this->model_app->view_where('tb_users', array('id_user' => $row['id_marketing']))->row_array();
				$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
				$data['total'] =$this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice'=>$noid))->row();
				//total detail
				// $select = 'SUM(jumlah * harga) AS `total`';
				$select = 'pajak, total_bayar AS total';
				$where = array('id_invoice'=>$noid);
				$tdetail= $this->model_app->cek_total('invoice',$select,$where);
				$data['tdetail'] = $tdetail->total;
				// $data['tdetail'] = $tdetail->total - $cari_total->sisa;
				$data['pajak'] = $tdetail->pajak;
				// $pajak = ($subtotal * $cetak['pajak']) /100;
				//cek count 
				$_diskon = 'SUM(diskon) AS `disc`';
				$cdiskon= $this->model_app->cek_total('invoice_detail',$_diskon,$where);
				$data['cdiskon'] = $cdiskon->disc;
				$_select = 'COUNT(id) AS `jml`';
				$cdetail= $this->model_app->cek_total('bayar_invoice_detail',$_select,$where);
				$data['cdetail'] = $cdetail->jml;
				//bayar detail
				$data['bdetail'] = $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();
				///
				$data['cara'] = $this->model_app->cara_bayar(array('`bayar_invoice_detail`.`id_invoice`' => $noid));
				$data['bank'] = $this->model_app->view_where('cara_bayar', array('slug !=' => ""))->result_array();
				$this->load->view('produk/print_invoice',$data);
				}else{
				$data['cetak'] = 'error';
				$this->load->view('produk/print_invoice_error',$data);
			}
		}
		public function cara_bayar(){
			$result = $this->model_app->view_where('cara_bayar',array('publish'=>'Y'));
			$data = array();
			foreach ($result->result_array() as $row)
			{
				$data[] = array("id"=>$row['id_byr'],"name"=>$row['cara_bayar']);
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			// echo json_encode($data);
		}
		public function finishing(){
			$data['title'] ='Data Produk';
			$cari_finishing=$this->model_app->view_where('invoice_detail',array('id_rincianinvoice'=>$this->input->post('id')));
			$finishing ="";
			if($cari_finishing->num_rows()>0){
				$rows =$cari_finishing->row();
				$finishing = $rows->detail;
			}
			$data['detail'] = array(
			"invoice"=> $this->db->escape_str($this->input->post('invoice')),
			"idr"=> $this->db->escape_str($this->input->post('id')),
			"kode"=> $this->db->escape_str($this->input->post('kode')),
			"jenis"=> $this->db->escape_str($this->input->post('jenis')),
			"finishing"=> $finishing
			);
			$this->load->view('produk/detail',$data);
		}
		public function update_finishing(){
			// print_r($_POST);
			$kode_invoice = $this->db->escape_str($this->input->post('kode_invoice'));
			$kode = $this->db->escape_str($this->input->post('kode'));
			$finishing = $this->db->escape_str($this->input->post('finishing'));
			// echo $finishing;
			if(!empty($finishing)){
				$_data = array('detail'=>$finishing);
				$where = array('id_rincianinvoice'=>$kode);
				$res= $this->model_app->update('invoice_detail', $_data, $where);
				if($res===true){
					$data = array("ok"=>"ok");
					}else{
					$data = array("ok"=>"err");
				}
				echo json_encode($data);
			}
			
		}
		public function ajax()
		{
			$type= $this->db->escape_str($this->input->post('type'));
			if($type == 'jenis_table'){
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				$query = "SELECT * FROM jenis_cetakan where UPPER(jenis_cetakan) LIKE '%".strtoupper($name)."%' AND pub='Y' AND status='0'";
				$result = $this->db->query($query);
				$data = array();
				foreach ($result->result_array() as $row)
				{
					$name = $row['jenis_cetakan'].'|'.$row['id_jenis'].'|'.$row_num;
					array_push($data, $name);
				}
				echo json_encode($data);
			}
			if($type == 'jenis_tablep'){
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				$query = "SELECT * FROM jenis_cetakan where UPPER(jenis_cetakan) LIKE '%".strtoupper($name)."%' AND pub='Y'";
				$result = $this->db->query($query);
				$data = array();
				foreach ($result->result_array() as $row)
				{
					$name = $row['jenis_cetakan'].'|'.$row['id_jenis'].'|'.$row_num;
					array_push($data, $name);
				}
				echo json_encode($data);
			}
			if($type == 'bahan_table'){
				$idprod = $_POST['idprod'];
				$cek = "SELECT * FROM `produk` where id='$idprod'";
				$res = $this->db->query($cek);
				$rows = $res->row_array();
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				// $query = "SELECT * FROM bahan where UPPER(title) LIKE '%".strtoupper($name)."%'";
				$query = "SELECT * FROM bahan where id IN ($rows[id_bahan])";
				$result = $this->db->query($query);
				$data = array();
				foreach ($result->result_array() as $row)
				{
					$name = $row['title'].'|'.$row['id'].'|'.$row['harga'].'|'.$rows['id_bahan'];
					array_push($data, $name);
				}
				echo json_encode($data);	
			}
			if($type == 'satuan_table'){
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				$query = "SELECT * FROM satuan where UPPER(satuan) LIKE '%".strtoupper($name)."%'";
				$result = $this->db->query($query);
				$data = array();
				foreach ($result->result_array() as $row)
				{
					$name = $row['satuan'].'|'.$row_num;
					array_push($data, $name);
				}
				echo json_encode($data);
			}
			if($type == 'marketing_table'){
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				$query = "SELECT * FROM tb_users where UPPER(nama_lengkap) LIKE '%".strtoupper($name)."%'";
				$result = $this->db->query($query);
				$data = array();
				foreach ($result->result_array() as $row)
				{
					$name = $row['nama_lengkap'].'|'.$row['id_user'].'|'.$row_num;
					array_push($data, $name);
				}
				echo json_encode($data);
			}
			if($type == 'produk_table'){
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				$query = "SELECT 
				`produk`.`id`,
				`produk`.`id_jenis`,
				`produk`.`title`,
				`produk`.`harga_dasar`,
				`jenis_cetakan`.`id_jenis`,
				`jenis_cetakan`.`jenis_cetakan`,
				`bahan`.`id` AS idb,
				`bahan`.`title` AS nbahan,
				`bahan`.`harga`
				FROM
				`jenis_cetakan`
				INNER JOIN `produk` ON (`jenis_cetakan`.`id_jenis` = `produk`.`id_jenis`)
				INNER JOIN `bahan` ON (`produk`.`id_bahan` = `bahan`.`id`)
				where UPPER(`produk`.`title`) LIKE '%".strtoupper($name)."%' AND produk.pub='1'";
				$result = $this->db->query($query);
				$data = array();
				foreach ($result->result_array() as $row)
				{
					$name = $row['title'].'|'.rp($row['harga_dasar']).'|'.$row['id'].'|'.$row['jenis_cetakan'].'|'.$row['nbahan'].'|'.$row['id_jenis'].'|'.$row['idb'].'|'.$row_num;
					array_push($data, $name);
				}
				echo json_encode($data);
			}
		}
		public function cari_invoice(){
			$idorder = $this->db->escape_str($this->input->post('keywords'));
			$search = $this->model_app->view_where('invoice', array('id_invoice'=>$idorder));
			if($search->num_rows()>0){
				$data['posts'] = $idorder;
				$data['pilihan'] = $this->model_app->view('tb_users');
				$this->load->view('produk/cari_invoice', $data, false); 
				}else{
				echo "error";
			}
		}
		public function cari_nominal(){
			$idorder = $this->db->escape_str($this->input->post('idorder'));
			$idedit = $this->db->escape_str($this->input->post('idedit'));
			$idkasir = $this->db->escape_str($this->input->post('idkasir'));
			$jml = $this->db->escape_str($this->input->post('jml'));
			$search = $this->model_app->view_where('bayar_invoice_detail', array('jml_bayar'=>$jml,'id_invoice'=>$idorder));
			if($search->num_rows()>0){
				$row = $search->row_array();
				if($row['kunci']==1){
					$data = array('ok'=>'edit','idorder'=>$idorder,'idedit'=>$idedit,'idkasir'=>$idkasir,'jml'=>$jml);	
					}else{
					$data = array('ok'=>'ok','idorder'=>$idorder,'idedit'=>$idedit,'idkasir'=>$idkasir,'jml'=>$jml);	
				}
				}else{
				$data = array('ok'=>'error');	
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function save_cari_invoice(){
			$idorder = $this->db->escape_str($this->input->post('idorder'));
			$idkasir = $this->db->escape_str($this->input->post('idkasir'));
			$idedit = $this->db->escape_str($this->input->post('idedit'));
			$jml = $this->db->escape_str($this->input->post('jml'));
			$id = array('id_user'=>$this->session->idu);
			$typenya = array($idedit);
			
			$search = $this->model_app->view_where('tb_users', $id);
			if($search->num_rows()>0){
				$row = $search->row_array();
				// view_where_in($table,$baris,$data)
				$query = "SELECT * FROM tb_users where FIND_IN_SET('$idedit', CONCAT(type_akses, ',')) AND id_user=".$this->session->idu;
				$result = $this->db->query($query);
				if($result->num_rows()>0){
					if($idedit==1){
						$search = $this->model_app->view_where('invoice',array('lunas'=>1,'id_invoice'=>$idorder));
						if($search->num_rows()>0){
							$data = array('ok'=>'errl','msg'=>'Maaf Order Sudah Lunas');	
							}else{
							$res = $this->model_app->update('invoice', array('oto'=>$idedit),array('id_invoice'=>$idorder));
							if($res==true){
								$data = array('ok'=>'ok');	
								}else{
								$data = array('ok'=>'err');	
							}
						}
						}elseif($idedit==2){ //hapus pembayaran + edit
						$res = $this->model_app->update('bayar_invoice_detail', array('kunci'=>1),array('id_invoice'=>$idorder,'jml_bayar'=>$jml));
						$res = $this->model_app->update('invoice', array('oto'=>1),array('id_invoice'=>$idorder));
						if($res==true){
							$data = array('ok'=>'ok');	
							}else{
							$data = array('ok'=>'err');	
						}
						}elseif($idedit==3){ //edit lunas
						$search = $this->model_app->view_where('invoice',array('lunas'=>1,'id_invoice'=>$idorder));
						if($search->num_rows()>0){
							// $row = $search->row_array();
							$res = $this->model_app->update('invoice', array('oto'=>3),array('id_invoice'=>$idorder));
							$data = array('ok'=>'ok');	
							}else{
							$data = array('ok'=>'errb','msg'=>'Order belum Lunas');	
						}
						}elseif($idedit==4){ //pending
						$_select = 'SUM(jml_bayar) AS `jml`';
						$cdetail= $this->model_app->cek_total('bayar_invoice_detail',$_select,array('id_invoice'=>$idorder));
						if($cdetail->jml == 0){
							$res = $this->model_app->update('invoice', array('status'=>'pending','oto'=>1),array('id_invoice'=>$idorder));
							$data = array('ok'=>'ok');
							// $this->model_app->update('tb_users', array("last_invoice"=>0),array('id_user'=>idkasir));
							}else{
							$data = array('ok'=>'errp','msg'=>'Belum ada pembayaran dipending aj');	
						}
						
						}elseif($idedit==5){ //batal
						$_select = 'SUM(jml_bayar) AS `jml`';
						$cdetail= $this->model_app->cek_total('bayar_invoice_detail',$_select,array('id_invoice'=>$idorder));
						if($cdetail->jml > 0){
							$res = $this->model_app->update('invoice', array('oto'=>5),array('id_invoice'=>$idorder));
							$data = array('ok'=>'ok');	
							}else{
							$data = array('ok'=>'err_batal','msg'=>'Belum ada pembayaran dipending aj');	
						}
					}
					}else{
					$data = array('ok'=>'error');	
				}
				
				}else{
				$data = array('ok'=>'error');	
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			// echo json_encode($data);
		}
	}																					