<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Penjualan extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
			$this->perPage = 10; 
			$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		}
		
		public function cart()
		{
			$id = $this->input->post('id');
			$edit = $this->input->post('edit');
			$iduser = $this->session->idu;
			// $data['id_member'] = autoNumbers('P','%06s');
			$_select = 'SUM(jumlah * harga) AS `jml`';
			if($id>0){
				//0
				$data['echo'] =0;
				$data['type'] = $edit;
				$data['diskon'] =$this->model_app->diskon('bayar_invoice_detail',array('bayar_invoice_detail.id_invoice'=>$id));
				$data['id'] =$id;
				$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $id));
				$data['proses'] = $this->model_app->edit('invoice', array('id_invoice' => $id))->row_array();
				//sum detail
				$cdetail= $this->model_app->cek_total('invoice_detail',$_select,array('id_invoice'=>$id));
				$data['cdetail'] = $cdetail->jml;
				//end
				$iddel = array('id_produk' => 0,'id_invoice'=>$id);
				$res = $this->model_app->delete('invoice_detail',$iddel);
				}else{
				$cari_last_invoice=$this->model_app->view_where('tb_users',array('last_invoice >'=>0,'id_user'=>$iduser));
				if($cari_last_invoice->num_rows()>0){
					//1
					$data['echo'] =1;
					$rows =$cari_last_invoice->row();
					$data['type'] = 'baru';
					$data['diskon'] =$this->model_app->diskon('bayar_invoice_detail',array('bayar_invoice_detail.id_invoice'=>$rows->last_invoice));
					$data['id'] =$rows->last_invoice;
					$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $rows->last_invoice));
					$data['proses'] = $this->model_app->edit('invoice', array('id_invoice' => $rows->last_invoice))->row_array();
					//sum detail
					$cdetail= $this->model_app->cek_total('invoice_detail',$_select,array('id_invoice'=>$rows->last_invoice));
					$data['cdetail'] = $cdetail->jml;
					//end
					$iddel = array('id_produk' => 0,'id_invoice'=>$rows->last_invoice);
					
					$res = $this->model_app->delete('invoice_detail',$iddel);
					}else{
					//2
					$data['echo'] =2;
					$data_arr = array(
					'id_konsumen' => '1' ,
					'id_user' => $iduser,
					'id_marketing' => $iduser,
					'tgl_trx' => date('Y-m-d'),
					'tgl_ambil' => date('Y-m-d H:i:s'),
					'status' => 'baru',
					'sesi_cart' => session_id()
					);
					$search=$this->model_app->view_where('invoice',array('id_invoice'=>$this->session->cart));
					if($search->num_rows()>0){
						//3
						$data['echo'] =3;
						$rows =$search->row();
						$data['type'] = 'baru';
						$data['diskon'] =$this->model_app->diskon('bayar_invoice_detail',array('bayar_invoice_detail.id_invoice'=>$rows->id_invoice));
						$data['id'] =$rows->id_invoice;
						$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $rows->id_invoice));
						$data['proses'] = $this->model_app->edit('invoice', array('id_invoice' => $rows->id_invoice))->row_array();
						//sum detail
						$cdetail= $this->model_app->cek_total('invoice_detail',$_select,array('id_invoice'=>$rows->id_invoice));
						$data['cdetail'] = $cdetail->jml;
						//end
						$iddel = array('id_produk' => 0,'id_invoice'=>$rows->id_invoice);
						$res = $this->model_app->delete('invoice_detail',$iddel);
						}else{
						$search=$this->model_app->view_where_ordering_limit('invoice',array('id_konsumen'=>1),'id_invoice','DESC',1);
						if($search->num_rows()>0){
							//4 edit
							$rows =$search->row();
							$data['echo'] =4;
							$data['type'] = 'baru';
							$data['diskon'] =$this->model_app->diskon('bayar_invoice_detail',array('bayar_invoice_detail.id_invoice'=>$rows->id_invoice));
							$data['id'] =$rows->id_invoice;
							$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $rows->id_invoice));
							$data['proses'] = $this->model_app->edit('invoice', array('id_invoice' => $rows->id_invoice))->row_array();
							//sum detail
							$cdetail= $this->model_app->cek_total('invoice_detail',$_select,array('id_invoice'=>$rows->id_invoice));
							$data['cdetail'] = $cdetail->jml;
							//end
							$iddel = array('id_produk' => 0,'id_invoice'=>$rows->id_invoice);
							$res = $this->model_app->delete('invoice_detail',$iddel);
							}else{
							//5 input
							$data['echo'] =5;
							$data['type'] = 'baru';
							$this->db->insert('invoice', $data_arr); 
							$last_id = $this->db->insert_id();
							$datain = array('id_invoice' => $last_id,
							"id_produk"=>1,"id_bahan"=>1,"jenis_cetakan"=>1,"jumlah"=>1);
							$this->db->insert('invoice_detail', $datain); 
							$data['diskon'] =$this->model_app->diskon('bayar_invoice_detail',array('bayar_invoice_detail.id_invoice'=>$last_id));
							$data['detail'] = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $last_id));
							$data['id'] =$last_id;
							$data['proses'] = $this->model_app->edit('invoice', array('id_invoice' => $last_id))->row_array();
							//sum detail
							$cdetail= $this->model_app->cek_total('invoice_detail',$_select,array('id_invoice'=>$last_id));
							$data['cdetail'] = $cdetail->jml;
							//end
							$this->session->set_userdata(array('cart'=> $last_id));
						}
					}
				}
			}
			$data['idsesi'] =$iduser;
			$this->load->view('penjualan/index',$data);
		}
		public function del_bayar(){
			$idbyr = $this->db->escape_str($this->input->post('id'));
			$noin = $this->db->escape_str($this->input->post('noin'));
			$kunci = $this->db->escape_str($this->input->post('kunci'));
			$jml = $this->db->escape_str($this->input->post('jml'));
			if ($this->session->level=='admin' OR $this->session->level=='owner'){
				$where = array('id' => $idbyr,'id_invoice'=>$noin);
				}else{
				$where = array('id' => $idbyr,'id_invoice'=>$noin,'kunci'=>$kunci);
			}
			$res = $this->model_app->delete('bayar_invoice_detail',$where);
			if($res==true){
				$data = array('ok'=>'ok','uang'=>$jml);
				}else{
				$data = array('ok'=>'no','uang'=>0);
			}
			echo json_encode($data);
		}
		public function list_bayar(){
			$data['title'] = 'List';
			$noin = $this->db->escape_str($this->input->post('id'));
			$data['bayar']=$this->model_app->view_where('bayar_invoice_detail',array('id_invoice'=>$noin));
			$this->load->view('penjualan/bayar',$data);
		}
		public function save_bayar(){
			$type = $this->db->escape_str($this->input->post('type'));
			$noin = $this->db->escape_str($this->input->post('noin'));
			$iduser = $this->db->escape_str($this->input->post('uid'));
			$id_byr = $this->db->escape_str($this->input->post('id_byr'));
			$jml_bayar = $this->db->escape_str($this->input->post('uang'));
			$sisabayar = $this->db->escape_str($this->input->post('sisabayar'));
			$nourut = $this->db->escape_str($this->input->post('nourut'));
			$pajak = $this->db->escape_str($this->input->post('pajak'));
			if($type=='simpan_bayar'){
				$cek_disc = $this->model_app->cek_total('invoice','pajak',array('id_invoice'=>$noin));
				if($cek_disc->pajak !=$pajak ){
					$alert = array('ok'=>'no','id'=>0,'uang'=>0,'total'=>0);
					echo json_encode($alert);
					exit;
				}
				$data = array('id_invoice'=>$noin,
				'tgl_bayar'=>date('Y-m-d'),
				'jml_bayar'=>$jml_bayar,
				'id_byr'=>$id_byr,
				'urutan'=>$nourut,
				'id_user'=>$iduser);
				$alert = array('ok'=>'no');
				if($noin!=null AND $jml_bayar > 0) {
					$res= $this->model_app->insert('bayar_invoice_detail',$data);
					if($res==true){
						$this->model_app->update('invoice', array("pos"=>'Y','id_user'=>$iduser),array('id_invoice' => $noin));
						//cek jml bayar
						$select = 'SUM(jml_bayar) AS `total`';
						$where = array('id_invoice'=>$noin);
						$search= $this->model_app->cek_total('bayar_invoice_detail`',$select,$where);
						//total di invoice
						$invoice = 'total_bayar AS total';
						$searchin = $this->model_app->cek_total('invoice',$invoice,$where);
						if($searchin->total == $search->total){
							$this->model_app->update('invoice', array("lunas"=>1),array('id_invoice' => $noin));
							$alert = array('ok'=>'ok','id'=>$noin,'uang'=>$jml_bayar,'total'=>$search->total);
							}else{
							$alert = array('ok'=>'ok','id'=>$noin,'uang'=>$jml_bayar,'total'=>$searchin->total);
						}
						}else{
						$alert = array('ok'=>'no','id'=>0,'uang'=>0,'total'=>0);
					}
				}
			}
			echo json_encode($alert);
		}
		public function add_detail(){
			$id = $this->db->escape_str($this->input->post('id'));
			$res = $this->db->insert('invoice_detail', array('id_invoice' => $id)); 
			$last_id = $this->db->insert_id();
			if($res==true){
				$data = array('ok'=>'ok','idr'=>$last_id);
				}else{
				$data = array('ok'=>'no','idr'=>0);
			}
			echo json_encode($data);
		}
		public function hapus_detail(){
			$id = array('id_rincianinvoice' => $this->db->escape_str($this->input->post('idr')));
			$res = $this->model_app->delete('invoice_detail',$id);
			if($res==true){
				$data = array('ok'=>'ok');
				}else{
				$data = array('ok'=>'no');
			}
			echo json_encode($data);
		}
		public function cari_konsumen(){
			$data['title'] ='';
			$data['id'] = $this->input->post('id');
			$this->load->view('penjualan/cari_konsumen',$data);
		}
		public function ajax_cari(){
			if($_POST['type']=='konsumen_cari'){
				
				$row_num = $_POST['row_num'];
				$name = $_POST['name_startsWith'];
				$query = "SELECT * FROM konsumen where UPPER(nama) LIKE '%".strtoupper($name)."%' or no_hp LIKE '%".strtoupper($name)."%'";
				$result = $this->db->query($query);
				// $rowcount=$result->num_rows();
				$data = array();
				// if($rowcount >0){
				foreach ($result->result_array() as $row)
				{
					$name = $row['nama'].' - '.$row['no_hp'].'|'.$row['id'].'|'.$row['nama'].'|'.$row['alamat'].'|'.$row['perusahaan'].'|'.$row['id_member'].'|'.$row_num;
					array_push($data, $name);
				}
				// }
				echo json_encode($data);
				}else{
				array_push($data, 'Pelanggan tidak ditemukan');
				echo json_encode($data);
			}	
		}
		public function input_konsumen(){
			// print_r($_POST);
			$config = array(
			array(
			'field' => 'namaadd',
			'label' => 'Nama',
			'rules' => 'required',
			'errors' => array(
			'required' => '%s. Harus diisi',
			),
			),
			array(
			'field' => 'teleponadd',
			'label' => 'No. HP',
			'rules' => 'required',
			'errors' => array(
			'required' => '%s. Harus diisi',
			),
			),
			array(
			'field' => 'alamatadd',
			'label' => 'Alamat',
			'rules' => 'required',
			'errors' => array(
			'required' => '%s. Harus diisi',
			),
			),
			array(
			'field' => 'perusahaanadd',
			'label' => 'Perusahaan',
			'rules' => 'required',
			'errors' => array(
			'required' => '%s. Harus diisi',
			),
			),
			array(
			'field' => 'via',
			'label' => 'Referal',
			'rules' => 'required',
			'errors' => array(
			'required' => '%s. Harus diisi',
			),
			)
			);
			$data = array('hasil'=>'error');
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() != FALSE){
				$search=$this->model_app->view_where('konsumen',array('no_hp'=>$this->input->post('teleponadd')));
				$data = array('hasil'=>'');
				if($search->num_rows()>0){
					$data = array('hasil'=>'ada','telp'=>'No. HP Sudah ada');
					}else{
					$id_nya = $this->input->post('id_nya');
					$where = array('id_invoice' => $id_nya);
					// $idmember = autoNumbers('P','id','konsumen');
					$idmember = autoNumbers('P','%06s');
					$unik = strtoupper(random_string('alnum',5));
					$data_arr = array(
					'id_member' => $idmember,
					'kode_unik' => $unik,
					'panggilan' =>  $this->input->post('panggilan'),
					'nama' =>  ucwords($this->input->post('namaadd')),
					'no_hp' => hp_3($this->input->post('teleponadd')),
					'tgl_daftar' => date('Y-m-d'),
					'referal' => $this->input->post('via'),
					'alamat' => $this->input->post('alamatadd'),
					'perusahaan' => $this->input->post('perusahaanadd')
					);
					$result = $this->db->insert('konsumen', $data_arr); 
					$lastid = $this->db->insert_id();
					if($result==true){
						$this->model_app->update('invoice', array("id_konsumen"=>$lastid), $where);
						$data = array(
						'idk' => $lastid,
						'id_member' => $idmember,
						'panggilan' =>  $this->input->post('panggilan'),
						'nama' =>  ucwords($this->input->post('namaadd')),
						'telp' => $this->input->post('teleponadd'),
						'referal' => $this->input->post('via'),
						'alamat' => $this->input->post('alamatadd'),
						'perusahaan' => $this->input->post('perusahaanadd'),
						'hasil' => 'sukses'
						);
						}else{
						$data = array('hasil'=>'error');
					}
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			
		}
		
		public function cari_update(){
			$id = clean($this->input->post('id'));//id invoice
			$telepon = clean($this->input->post('telp'));
			$search = $this->model_app->view_where('konsumen', array('no_hp' => $telepon));
			if($search->num_rows()>0){
				$row =$search->row_array();
				$unik = strtoupper(random_string('alnum',5));
				$where = array('id_invoice' => $id);
				$res= $this->model_app->update('invoice', array("id_konsumen"=>$row['id']), $where);
				if($res==true){
					$this->model_app->update('konsumen', array("kode_unik"=>$unik), array('no_hp' => $telepon));
					$data = array('idnya' => $id,
					"idk"=> $row['id'],
					"id_member"=> $row['id_member'],
					"nama"=> $row['nama'],
					"telp"=> $row['no_hp'],
					"alamat"=> $row['alamat'],
					"perusahaan"=> $row['perusahaan'],
					"hasil"=> 'sukses'
					);	
				}
				}else{
				$data = array(0 => 'error');	
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cek_telp(){
			$telepon = clean($this->input->post('telp'));
			$search = $this->model_app->view_where('konsumen', array('no_hp' => $telepon));
			if($search->num_rows()>0){
				$rows =$search->row_array();
				$data = array(0 => 'ada', 'idnya' => $rows['id'],'no_hp'=>$rows['no_hp'],'panggilan'=>$rows['panggilan'],'nama'=>$rows['nama'],'perusahaan'=>$rows['perusahaan'],'alamat'=>$rows['alamat'],'reff'=>$rows['referal'],'kodeunik'=>$rows['kode_unik']);
				}else{
				$data = array(0 => 'error '. $telepon);	
			}
			echo json_encode($data);
		}
		public function update_konsumen(){
			// print_r($_POST);
			$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
			$id_invoicecari = $_POST['id_invoicecari'];
			$id_konsumencari = $_POST['id_konsumencari'];
			$id_member = $_POST['id_member'];
			$nama = $_POST['nama_cari'];
			$telp = $_POST['caritlp'];
			$alamat = $_POST['alamat_cari'];
			$perusahaan = $_POST['perusahaan_cari'];
			$exp = explode('-',$telp);
			$wh = "WHERE `konsumen`.`id`='".$id_konsumencari."'";
			$piutang_sql = $this->db->query("SELECT 
			`invoice_detail`.`id_invoice`,
			`invoice`.`id_invoice`, 
			`invoice`.`tgl_trx`, 
			`konsumen`.`id`,
			`konsumen`.`nama` AS namakon,
			`konsumen`.`status`,
			`konsumen`.`no_hp`,
			`konsumen`.`perusahaan`,
			`konsumen`.`max_utang`,
			IFNULL(`tb_users`.`nama_lengkap`,`invoice`.`id_user`)  as fo, 
			IFNULL(`tb_users1`.`nama_lengkap`, `invoice`.`id_marketing`) as `marketing`,  
			
			SUM(`invoice_detail`.`jumlah` * `invoice_detail`.`harga`) AS `totalbeli`,
			IFNULL(A.totalbayar,0) AS `totalbayar`,
			SUM(`invoice_detail`.`jumlah` * `invoice_detail`.`harga`) -  IFNULL(A.totalbayar,0) AS sisa
			
			FROM
			`invoice_detail`
			LEFT OUTER JOIN (SELECT `bayar_invoice_detail`.`id_invoice`, SUM(`bayar_invoice_detail`.`jml_bayar`) AS `totalbayar`
			FROM `bayar_invoice_detail` GROUP BY  `bayar_invoice_detail`.`id_invoice`) A   
			ON (`invoice_detail`.`id_invoice` = A.`id_invoice`)
			
			LEFT OUTER JOIN  
			`invoice` ON 
			(`invoice`.`id_invoice` = `invoice_detail`.`id_invoice`)
			
			LEFT OUTER JOIN  
			`konsumen` ON 
			(`konsumen`.`id` = `invoice`.`id_konsumen`)
			
			LEFT OUTER JOIN  
			`tb_users` ON 
			(`tb_users`.`id_user` = `invoice`.`id_user`)
			
			LEFT OUTER JOIN  
			`tb_users` `tb_users1` ON 
			(`tb_users1`.`id_user` = `invoice`.`id_marketing`)
			".$wh." GROUP BY
			`invoice_detail`.`id_invoice`
			HAVING sisa > 0 ORDER by  `konsumen`.`nama` ASC");
			$no=1;  
			$totomset = 0;
			$totpiutang = 0;
			$totbyr = 0;
			$konsumensama = "";
			$piu=0;
			$tampil='N';
			
			if($piutang_sql->num_rows() >0){
				$row=$piutang_sql->row_array();
				if($row['status']==1 OR $row['max_utang'] >0){
					goto boleh;
					}else{
					$tgl = tgl_indo($row['tgl_trx'],false);
					$namakon = $row['namakon'];
					$piutang = $row['sisa'];
					$id_invoice = $row['id_invoice'];
					$totpiutang = $totpiutang + $piutang;
					$data = array(
					'id' => $id_konsumencari,
					'totalp' => rp($totpiutang),
					'nama' => $namakon,
					'tgl' => $tgl,
					'hasil' => 'ada',
					'error' => $namakon.' Masih ada piutang');	
					echo json_encode($data);
				}
				}else{
				boleh:
				///
				$data = array(
				'id' => $id_invoicecari,
				'id_member' => $id_member,
				'idk' => $id_konsumencari,
				'nama' => $nama,
				'telp' => 'Telp: '.$exp[1],
				'alamat' => $alamat,
				'perusahaan' => $perusahaan,
				'hasil' => 'sukses',
				'error' => 'Data berhasil di input'
				);	
				$update = $this->db->query("UPDATE `invoice` set `id_konsumen` = '$id_konsumencari' WHERE `id_invoice` = '$id_invoicecari'");
				if($update){
					echo json_encode($data);
					}else{
					$data = array(
					'id' => '',
					'id_member' => '',
					'nama' => '',
					'telp' => '',
					'alamat' => '',
					'perusahaan' => '',
					'hasil' => 'gagal',
					'error' => 'Data gagal di input'
					);	
					
					echo json_encode($data);
				}
			}
		}
		function totaltrx(){
			$conditions = array(); 
			$data = $this->model_app->counter('invoice',$conditions);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			// echo json_encode($data);
		}
		function hari_ini(){
			$conditions['where'] = array(
            'tgl_trx' => date('Y-m-d'),
            'status' => 'simpan'
			);
			$data = $this->model_app->counter('invoice',$conditions);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		function baru(){
			$conditions['where'] = array(
            'status' => 'baru'
			); 
			$data = $this->model_app->counter('invoice',$conditions);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function pending(){
			$conditions['where'] = array(
            'status' => 'pending'
			); 
			$data = $this->model_app->counter('invoice',$conditions);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function batal(){
			$conditions['where'] = array(
            'status' => 'batal'
			); 
			$data = $this->model_app->counter('invoice',$conditions);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function konsumen(){
			$conditions['where'] = array(
            'kunci' => '0'
			); 
			$data = $this->model_app->counter('konsumen',$conditions);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			// echo json_encode($data);
		}
		
		public function cari(){
			$search=  $this->input->post('search');
			$query = $this->model_data->getdata($search);
			echo json_encode ($query);
		}
		public function auto_save_invoice()
		{
			$id		= $this->db->escape_str($this->input->post('id'));
			$tgli		= $this->db->escape_str($this->input->post('tglin'));
			$tgla		= $this->db->escape_str($this->input->post('tgla'));
			$jam		= $this->db->escape_str($this->input->post('jam'));
			$marketing	= $this->db->escape_str($this->input->post('marketing'));
			$data = array('tgl_trx'=>$tgli,'tgl_ambil'=>$tgla.' '.$jam,'id_marketing'=>$marketing);
			$where = array('id_invoice'=>$id);
			$res= $this->model_app->update('invoice', $data, $where);
			if($res==true){
				$data = array("ok"=>"ok");
				}else{
				$data = array("ok"=>"err");
			}
		}
		public function auto_save_invoice_detail()
		{
			$idorder	= $this->db->escape_str($this->input->post('noin'));
			$jml		= $this->db->escape_str($this->input->post('jml'));
			$uangmuka	= $this->db->escape_str($this->input->post('uangmuka'));
			$id			= $this->db->escape_str($this->input->post('id_rincianinvoice'));
			$harga		= $this->db->escape_str($this->input->post('harga'));
			$jumlah		= $this->db->escape_str($this->input->post('jumlah'));
			$id_produk	= $this->db->escape_str($this->input->post('id_produk'));
			$ket		= $this->db->escape_str($this->input->post('ket'));
			$ukuran		= $this->db->escape_str($this->input->post('ukuran'));
			$satuan		= $this->db->escape_str($this->input->post('satuan'));
			$id_bahan	= $this->db->escape_str($this->input->post('id_bahan'));
			$jenis		= $this->db->escape_str($this->input->post('jenis'));
			$totukuran	= $this->db->escape_str($this->input->post('totukuran'));
			$diskon		= $this->db->escape_str($this->input->post('diskon'));
			if(empty($totukuran)){
				$totukuran = 0;
			}
			// $sisa = 'SUM(`bayar_invoice_detail`.`jml_bayar`) AS total';
			// $total= $this->model_app->cek_total('bayar_invoice_detail',$sisa,array('id_invoice'=>$idorder));
			$where = array('id_rincianinvoice'=>$id);
			$_reload = $this->model_app->view_where('invoice_detail',$where)->row_array();
			if($jml < $uangmuka){
				$data = array("ok"=>"error","jml"=>$_reload['jumlah'],'harga' => $_reload['harga'],'diskon' => $_reload['diskon'],'ukuran' => $_reload['ukuran']);
				}else{
				$data = array('id_produk'=> $id_produk, 'jumlah' =>$jumlah, 'harga' => $harga, 'ukuran' =>$ukuran, 'satuan' =>$satuan, 'keterangan' =>$ket, 'id_bahan' => $id_bahan,'jenis_cetakan' => $jenis, 'tot_ukuran' =>$totukuran, 'diskon' =>$diskon,'kunci'=>0);
				
				$res= $this->model_app->update('invoice_detail', $data, $where);
				if($res==true){
					$data = array("ok"=>"ok");
					}else{
					$data = array("ok"=>$id_bahanin);
				}
			}
			echo json_encode($data);
		}
		public function simpan_pajak(){
			$id = $this->db->escape_str($this->input->post('id'));
			$pajak = $this->db->escape_str($this->input->post('pajak'));
			$where = array('id_invoice'=>$id);
			$data = array('pajak'=>$pajak);
			$res= $this->model_app->update('invoice', $data, $where);
			if($res==true){
				$data = array("ok"=>'ok','pajak'=>$pajak);
				}else{
				$data = array("ok"=>'err','pajak'=>0);
			}
			echo json_encode($data);
		}
		public function bayar_detail(){
			$id = $this->input->post('id');
			$select = 'SUM(jml_bayar) AS `total`';
			$where = array('id_invoice'=>$id);
			$search= $this->model_app->cek_total('bayar_invoice_detail` ',$select,$where);
			// print_r($search);
			if(!empty($search->total)){
				$data = $search->total;
				}else{
				$data = 0;
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cek_jml_bayar(){
			$id = $this->input->post('id');
			$select = 'total_bayar AS total';
			$where = array('id_invoice'=>$id);
			$search= $this->model_app->cek_total('invoice',$select,$where);
			if(!empty($search->total)){
				$data = $search->total;
				}else{
				$data = 0;
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cek_total_detail(){
			$id = $this->input->post('id');
			$select = 'SUM(jumlah * harga) AS `total`';
			$where = array('id_invoice'=>$id);
			$search= $this->model_app->cek_total('invoice_detail',$select,$where);
			if(!empty($search->total)){
				$data = $search->total;
				}else{
				$data = 0;
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cek_data_total(){
			$id = $this->input->post('id');
			$iduser = $this->input->post('iduser');
			$pajak = $this->input->post('pajak');
			$where = array('id_invoice'=>$id);
			$invoice = 'total_bayar AS total';
			$searchin = $this->model_app->cek_total('invoice',$invoice,$where);
			//diskon
			$sisa = 'ROUND(SUM((`invoice_detail`.`jumlah`) * (`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS sisa';
			$cari_sisa= $this->model_app->cek_total('invoice_detail',$sisa,$where);
			////
			$select = 'SUM(jumlah * harga) AS `total`';
			$search= $this->model_app->cek_total('invoice_detail',$select,$where);
			$total_detail = $search->total - $cari_sisa->sisa;
			$kurangpajak = $searchin->total - $total_detail;
			$total_bayar = $searchin->total - $kurangpajak;
			if($total_detail == $total_bayar AND $pajak>0){
				$data = array('ok'=>'ok','id'=>$id,'iduser'=>$iduser,'total'=>$total_detail);
				}elseif($total_detail == $searchin->total AND $pajak==0){
				$data = array('ok'=>'ok','id'=>$id,'iduser'=>$iduser,'total'=>$total_detail);
				}else{
				$data = array('ok'=>'err','id'=>$id,'iduser'=>$iduser,'total'=>0);
			}
			echo json_encode($data);
			// $this->output
			// ->set_content_type('application/json')
			// ->set_output(json_encode($data));
		}
		public function cek_di_invoice(){
			$id = $this->input->post('id');
			$total = $this->input->post('total');
			$pajak = $this->input->post('pajak');
			$where = array('id_invoice'=>$id);
			// $invoice = 'total_bayar AS total';
			$invoice = 'SUM(total_bayar) AS `total`';
			//cek total invoice
			$searchin = $this->model_app->cek_total('invoice',$invoice,$where);
			//cek pajak di invoice
			
			
			//diskon`/100
			$sisa = 'ROUND(SUM((`invoice_detail`.`jumlah` * `invoice_detail`.`harga`) - (`invoice_detail`.`jumlah` * `invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS sisa';
			$cari_sisa= $this->model_app->cek_total('invoice_detail',$sisa,$where);
			//invoice_detail
			$select = 'SUM(jumlah * harga) AS `total`';
			$search= $this->model_app->cek_total('invoice_detail',$select,$where);
			$total_detail = $cari_sisa->sisa;
			if($pajak >0){
				$pajak = $pajak;
				$total_detail = $total_detail + $total_detail * $pajak/100;
			}
			if($total_detail == $searchin->total AND $pajak==0){
				$data = array('ok'=>'ok','id'=>$id,'total'=>$search->total);
				}elseif($total_detail == $searchin->total AND $pajak>0){
				$data = array('ok'=>'ok','id'=>$id,'total'=>$search->total);
				}else{
				$data = array('ok'=>'err','id'=>$id,'total_1'=>$searchin->total,'total_2'=>$search->total,'sisa'=>$cari_sisa->sisa,'total'=>$total_detail);
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function update_data(){
			$id = $this->input->post('id');
			$iduser = $this->input->post('iduser');
			$idlunas = $this->input->post('idlunas');
			$total = $this->input->post('total');
			$data = array('total_bayar'=>$total);
			$where = array('id_invoice' => $id);
			$search= $this->model_app->update('invoice', $data, $where);
			//sum detail
			$cdetail= $this->model_app->cek_total('invoice_detail','SUM(jumlah * harga) AS `jml`',array('id_invoice'=>$id));
			if($idlunas == 1 AND $cdetail->jml != $total){
				$this->model_app->update('invoice', array('lunas'=>0), $where);
			}
			//end
			if($search==true){
				$this->model_app->update('tb_users', array("last_invoice"=>$id),array('id_user'=> $iduser));
				$data = array('ok'=>'ok');
				}else{
				$data = array('ok'=>'err');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function update_lunas(){
			$noin = $this->input->post('id');
			$iduser = $this->input->post('iduser');
			$total = $this->input->post('total');
			if($noin!=null AND $total > 0) {
				//cek jml bayar
				$select = 'SUM(jml_bayar) AS `total`';
				$where = array('id_invoice'=>$noin);
				$search= $this->model_app->cek_total('bayar_invoice_detail`',$select,$where);
				//total di invoice
				$invoice = 'total_bayar AS total';
				$searchin = $this->model_app->cek_total('invoice',$invoice,$where);
				if($searchin->total == $search->total){
					$this->model_app->update('invoice', array("lunas"=>1),array('id_invoice' => $noin));
					$data = array('ok'=>'ok','id'=>$noin,'iduser'=>$iduser,'total'=>$search->total);
					}else{
					$data = array('ok'=>'ok','id'=>$noin,'iduser'=>$iduser,'total'=>$searchin->total);
				}
				
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function trx($id)
		{
			$data['id'] =$id;
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getRows($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataList'; 
			$config['base_url']    = base_url('penjualan/ajaxPaginationData'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			$data['posts'] = $this->model_data->getRows($conditions); 
			
			$this->load->view('penjualan/trx',$data);
		}
		public function order()
		{
			cek_menu_akses();
			$data['title'] ='Data order';
			$data['id'] ='';
			$data['tgl'] ='';
			$data['select'] = array(0=>'semua',1=>'Lunas','baru'=>'Baru','pending'=>'Pending','edit'=>'Edit','batal'=>'Batal');
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getRows($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataList'; 
			$config['base_url']    = base_url('penjualan/ajaxPaginationData'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			$data['posts'] = $this->model_data->getRows($conditions); 
			$this->template->load('main/themes','penjualan/order',$data);
		}
		function ajaxPaginationData(){ 
			
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
			$trx = $this->input->post('trx'); 
			$tgl = $this->input->post('tgl'); 
			if(!empty($trx)){ 
				$conditions['search']['trx'] = $trx; 
			} 
			if(!empty($keywords)){ 
				$conditions['search']['keywords'] = $keywords; 
			} 
			if(!empty($sortBy)){ 
				$conditions['search']['sortBy'] = $sortBy; 
			} 
			if(!empty($limits)){ 
				$conditions['search']['limits'] = $limits; 
			}
			if(!empty($tgl)){ 
				$conditions['search']['tgl'] = $tgl; 
			} 
			
			
			// Get record count 
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getRows($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataList'; 
			$config['base_url']    = base_url('penjualan/ajaxPaginationData'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $limit; 
			$config['link_func']   = 'searchFilter'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $limit;
			unset($conditions['returnType']); 
			$data['posts'] = $this->model_data->getRows($conditions); 
			
			// Load the data list view 
			$this->load->view('penjualan/ajax-trx', $data, false); 
		}
		public function pending_data(){
			$noin = $this->input->post('id');
			$iduser = $this->session->idu;
			$cari_pending=$this->model_app->view_where('invoice',array('status'=>'pending','id_invoice'=>$noin));
			if($cari_pending->num_rows()>0){
				$data = array('ok'=>'pending');
				}else{
				$res = $this->model_app->update('invoice', array("pos"=>'N','status'=>'pending','id_user'=>$iduser),array('id_invoice' => $noin));
				if($res){
					$this->model_app->update('tb_users', array("last_invoice"=>0),array('id_user'=>$iduser));
					$this->session->unset_userdata('cart');
					$data = array('ok'=>'ok');
					}else{
					$data = array('ok'=>'err');
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function konsumen_data($id=null)
		{
			cek_menu_akses();
			if(empty($id))
			{
				$data['title'] ="Data Konsumen";
				//$data['id'] =$id;
				$conditions['returnType'] = 'count'; 
				$totalRec = $this->model_data->getKonsumen($conditions); 
				
				// Pagination configuration 
				$config['target']      = '#dataListKonsumen'; 
				$config['base_url']    = base_url('penjualan/ajaxKonsumen'); 
				$config['total_rows']  = $totalRec; 
				$config['per_page']    = $this->perPage; 
				
				// Initialize pagination library 
				$this->ajax_pagination->initialize($config); 
				
				// Get records 
				$conditions = array( 
				'limit' => $this->perPage 
				); 
				$data['posts'] = $this->model_data->getKonsumen($conditions); 
				//$data['links'] = $this->ajax_pagination->create_links(); 
				// $this->load->view('penjualan/konsumen',$data);
				$this->template->load('main/themes','penjualan/konsumen_data',$data);
				}else{
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
		}
		public function data_konsumen($id)
		{
			$data['id'] =$id;
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getKonsumen($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataListKonsumen'; 
			$config['base_url']    = base_url('penjualan/ajaxKonsumen'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
			'limit' => $this->perPage 
			); 
			$data['posts'] = $this->model_data->getKonsumen($conditions); 
			
			$this->load->view('penjualan/konsumen',$data);
		}
		function ajaxKonsumen(){
			
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
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getKonsumen($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataListKonsumen'; 
			$config['base_url']    = base_url('penjualan/ajaxKonsumen'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $limit; 
			$config['link_func']   = 'searchFilterKonsumen'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $limit;
			unset($conditions['returnType']); 
			$data['posts'] = $this->model_data->getKonsumen($conditions); 
			
			// Load the data list view 
			$this->load->view('penjualan/ajax-konsumen', $data, false); 
		}
		
	}											