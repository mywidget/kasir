<?php	
	defined('BASEPATH') or exit('No direct script access allowed');	
	
	class Pembukuan extends CI_Controller	
	{		
		public function __construct()		
		{			
			parent::__construct();			
			cek_session_login();
			$this->load->helper('date');			
			$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");			
			$this->perPage = 10; 			
		}		
		
		public function omset(){		
			cek_menu_akses();
			$data['title'] = 'Uang masuk';			
			$data['tgl'] = date('d/m/Y');			
			$data['pilihan'] = $this->model_app->view('tb_users');			
			$data['jenis'] = $this->model_app->view('jenis_cetakan');			
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan', array('kunci' =>0))->result_array();			
			$this->template->load('main/themes','pembukuan/omset',$data);			
		}		
		public function harian(){			
			$info= $this->db->escape_str($this->input->post('info'));			
			$user= $this->db->escape_str($this->input->post('user'));			
			$jenis= $this->db->escape_str($this->input->post('jenis'));			
			$dari = date_sl($_POST['dari']);			
			$sampai = date_sl($_POST['sampai']);			
			$exp = explode('-',$dari);			
			$tahun = $exp[0];			
			$bulan = $exp[1];			
			// $data['tgl'] = date('d/m/Y');			
			if($info=='harian'){				
				$proses = "invoice.tgl_trx BETWEEN CAST('$dari' AS DATE) AND CAST('$sampai' AS DATE)";				
				}else{				
				$proses = "MONTH(invoice.tgl_trx)='$bulan' AND YEAR(invoice.tgl_trx)='$tahun'";				
			}			
			if ($user=='0'){				
				$where = "WHERE invoice.status='simpan' AND $proses";				
				}else{				
				$where = "WHERE `invoice`.`id_user` = '$user'  AND `invoice`.`status`='simpan' AND `invoice`.`pos`='Y' AND $proses";				
			}			
			$data['result'] = $this->model_data->get_harian($where);			
			$this->load->view('pembukuan/data_omset', $data); 			
		}		
		
		public function bulanan(){			
			$this->load->view('pembukuan/load_modal', $data, false); 			
		}		
		public function load_modal(){			
			$info= $this->db->escape_str($this->input->post('info'));			
			$id= $this->db->escape_str($this->input->post('id'));			
			$iduser= $this->db->escape_str($this->input->post('user'));			
			$format = "%Y-%m-%d";			
			$mdate = mdate($format);			
			if($iduser==0){				
				$search=$this->model_app->edit('pengeluaran',array('id_pengeluaran'=>$id));				
				$rows =$search->row();				
				$data['loadp'] =$rows;				
				$data['loadd'] = $this->model_app->pengeluaran_detail(array('pengeluaran_detail.id_pengeluaran' => $rows->id_pengeluaran))->result_array();				
				$cek_user=$this->model_app->edit('tb_users',array('id_user'=>$rows->id_user))->row();				
				$data['nama'] =$cek_user->nama_lengkap;				
				$data['id_user'] =$cek_user->id_user;				
				$this->load->view('pembukuan/load_modal', $data, false); 				
				
				}else{				
				$cek_user=$this->model_app->edit('tb_users',array('id_user'=>$iduser))->row();				
				$data['nama'] =$cek_user->nama_lengkap;				
				$data['id_user'] =$iduser;				
				
				//tambah				
				if($info=='tambah'){					
					if(isset($this->session->cartp)){						
						$cek=$this->model_app->edit('pengeluaran',array('id_pengeluaran'=>$this->session->cartp,'id_user'=>$iduser));						
						$rows =$cek->row();						
						$data['loadp'] =$rows;						
						$data['loadd'] = $this->model_app->pengeluaran_detail(array('pengeluaran_detail.id_pengeluaran' => $rows->id_pengeluaran))->result_array();						
						$this->load->view('pembukuan/load_modal', $data, false); 						
						}else{						
						$array = array('tgl_pengeluaran'=>$mdate,'id_user'=>$iduser);						
						$this->model_app->insert('pengeluaran',$array);						
						$last_id = $this->db->insert_id();						
						$this->session->set_userdata(array('cartp'=>$last_id));						
						$this->model_app->insert('pengeluaran_detail',array('id_pengeluaran'=>$last_id,'id_biaya'=>1));						
						$data['loadp'] = $this->model_app->view_where('pengeluaran', array('id_pengeluaran' => $last_id))->row();						
						$data['loadd'] = $this->model_app->pengeluaran_detail(array('pengeluaran_detail.id_pengeluaran' => $last_id))->result_array();						
						$this->model_app->update('tb_users',array('last_idp'=>$last_id),array('id_user'=>$iduser));						
						$this->load->view('pembukuan/load_modal', $data, false); 						
					}					
					//edit					
					}elseif($info=='edit'){					
					$search=$this->model_app->edit('pengeluaran',array('id_pengeluaran'=>$id));					
					$rows =$search->row();					
					if($rows->rekap=='Y'){						
						echo "error";						
						}else{						
						$data['loadp'] =$rows;						
						$data['loadd'] = $this->model_app->pengeluaran_detail(array('pengeluaran_detail.id_pengeluaran' => $rows->id_pengeluaran))->result_array();						
						$this->load->view('pembukuan/load_modal', $data, false); 						
					}					
				}				
				
			}			
		}		
		public function save_pengeluaran(){			
			$id = $this->input->post('id');			
			$id_user = $this->input->post('pencatat');			
			
			$tgl = date_sl($this->input->post('tgl'));			
			$data = array('total_bayar' =>$this->input->post('total'), 			
			'pos' =>'Y','tgl_pengeluaran'=>$tgl);			
			$where = array('id_pengeluaran'=>$id,'id_user'=>$id_user);			
			$res= $this->model_app->update('pengeluaran', $data, $where);			
			if($res===true){				
				$data = array("ok"=>"ok","id"=>$id);				
				$this->model_app->update('tb_users',array('last_idp'=>0),array('id_user'=>$id_user));				
				$this->session->unset_userdata('cartp');				
				}else{				
				$data = array('error');				
			}			
			$this->output			
			->set_content_type('application/json')			
			->set_output(json_encode($data));			
		}		
		public function save_rekap_pengeluaran(){			
			$id = $this->input->post('id');			
			$user = $this->input->post('user');			
			$data = array();			
			if(empty($this->input->post('tgl'))){				
				$tgl = date('Y-m-d');				
				}else{				
				$tgl = date_sl($this->input->post('tgl'));				
			}			
			
			$search = $this->model_app->view_where('pengeluaran', array('rekap'=>'Y', 'id_pengeluaran'=>$id));			
			if($search->num_rows()>0){				
				$data = array('error');				
				echo json_encode($data);				
				exit;				
			}			
			$select = 'SUM(jumlah * harga) AS `total`';			
			$where = array('id_pengeluaran'=>$id);			
			$search_d= $this->model_app->cek_total('pengeluaran_detail',$select,$where);			
			$total = 0;			
			if($search_d->total >0){				
				$total = $search_d->total;				
			}			
			$res = $this->model_app->insert('data_rekap',array('kredit'=>$total,'tgl_rekap'=>$tgl,'id_kasir'=>$user));			
			if($res==true){				
				$this->model_app->update('pengeluaran',array('rekap'=>'Y','tgl_rekap'=>$tgl), $where);				
				$data = array("ok"=>"ok");				
				}else{				
				$data = array('error');				
			}			
			echo json_encode($data);			
		}		
		public function rekap_uang_masuk(){			
			$iduser = $this->input->post('iduser');			
			$user = $this->input->post('user');			
			$total = $this->input->post('total');			
			$tgl = date_sl($this->input->post('tgl'));			
			$hari_ini = date('Y-m-d');			
			if($user==0){				
				$data = array('error','msg'=>"Kasir belum dipilih");				
				}else{				
				$res = $this->model_app->insert('data_rekap',array('id_kasir'=>$user,'debet'=>$total,'tgl_rekap'=>$tgl));				
				if($res==true){					
					$this->model_app->update('bayar_invoice_detail',array('rekap'=>'Y'), array('id_user'=>$user,'tgl_bayar'=>$tgl));					
					$data = array("ok"=>"ok",'msg'=>$tgl);					
					}else{					
					$data = array('error');					
				}				
				
			}			
			echo json_encode($data);			
		}		
		public function save_detail(){			
			$id = $this->input->post('id');			
			$data = array('keterangan' =>$this->input->post('ket'), 			
			'id_biaya' =>$this->input->post('jenis'), 			
			'jumlah' =>$this->input->post('jum'), 			
			'harga' =>$this->input->post('harga'), 			
			'satuan' =>$this->input->post('satuan'));			
			$where = array('no'=>$id);			
			$res= $this->model_app->update('pengeluaran_detail', $data, $where);			
			if($res==true){				
				$data = array("ok"=>"ok","id"=>$id);				
				}else{				
				$data = array('error');				
			}			
			echo json_encode($data);			
		}		
		public function hapus_detail(){			
			$idx = $this->input->post('id');			
			$id = array('no' => $idx);			
			$res=$this->model_app->delete('pengeluaran_detail',$id);			
			if($res==true){				
				$data = array('ok'=>'ok','msg'=>'Data berhasil dihapus');				
				}else{				
				$data = array('ok'=>'err','msg'=>'Data gagal dihapus');				
			}			
			$this->output			
			->set_content_type('application/json')			
			->set_output(json_encode($data));			
		}		
		
		public function add_detail(){			
			$id = $this->db->escape_str($this->input->post('id'));			
			$res = $this->db->insert('pengeluaran_detail', array('id_pengeluaran' => $id,'id_biaya'=>1)); 			
			$last_id = $this->db->insert_id();			
			if($res==true){				
				$data = array('ok'=>'ok','idr'=>$last_id,'jenis'=>1);				
				}else{				
				$data = array('ok'=>'no','idr'=>0,'jenis'=>1);				
			}			
			echo json_encode($data);			
		}		
		public function load_pengeluaran(){			
			$info= $this->db->escape_str($this->input->post('info'));			
			$user= $this->db->escape_str($this->input->post('user'));			
			$dari = date_sl($_POST['dari']);			
			$sampai = date_sl($_POST['sampai']);			
			$exp = explode('-',$dari);			
			$tahun = $exp[0];			
			$bulan = $exp[1];			
			// $data['tgl'] = date('d/m/Y');			
			if($info=='harian'){				
				$proses = "pengeluaran.tgl_pengeluaran BETWEEN CAST('$dari' AS DATE) AND CAST('$sampai' AS DATE)";				
				}else{				
				$proses = "MONTH(pengeluaran.tgl_pengeluaran)='$bulan' AND YEAR(pengeluaran.tgl_pengeluaran)='$tahun'";				
			}			
			if ($user=='0'){				
				$where = "WHERE pengeluaran.pos='Y' AND $proses";				
				}else{				
				$where = "WHERE pengeluaran.pos='Y' AND $proses";				
			}			
			$data['result'] = $this->model_data->get_Satu($where);			
			$this->load->view('pembukuan/data_pengeluaran', $data); 			
			
		}		
		public function uang_masuk(){	
			cek_menu_akses();
			$data['title'] = 'Rekap';			
			$data['tgl'] = date('d/m/Y');			
			$data['pilihan'] = $this->model_app->view('tb_users');			
			$this->template->load('main/themes','pembukuan/uang_masuk',$data);			
		}		
		public function data_uang_masuk(){			
			$info= $this->db->escape_str($this->input->post('info'));			
			$user= $this->db->escape_str($this->input->post('user'));			
			$dari ='';			
			$sampai ='';			
			if(!empty($_POST['dari'])){				
				$dari = date_sl($_POST['dari']);				
				// $exp = explode('-',$dari);				
			}			
			
			if ($user=='0' AND $dari==''){				
				// echo 1;				
				$where = "WHERE `bayar_invoice_detail`.rekap='N'";				
				// $AND="AND `bayar_invoice_detail`.setor='N'";				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='N' AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
				}elseif ($user=='0' AND $dari!=''){				
				// echo 2;				
				$where = "WHERE `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='N'";				
				// $AND="AND `bayar_invoice_detail`.setor='N'";				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='N' AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
				}else{				
				// echo 2;				
				$where = "WHERE `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='N' AND `bayar_invoice_detail`.id_user = '$user'";				
				// $AND="AND `bayar_invoice_detail`.setor='N' AND `bayar_invoice_detail`.id_user = '$user'";				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='N' AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
			}			
			$data['dari'] = $dari;			
			$data['sampai'] = $sampai;			
			$data['user'] = $user;			
			$data['and'] = $AND;			
			$data['result'] = $this->model_data->carabayar($where);			
			$this->load->view('pembukuan/data_uang_masuk', $data); 			
		}		
		public function list_uang_masuk(){			
			$info= $this->db->escape_str($this->input->post('info'));			
			$user= $this->db->escape_str($this->input->post('user'));			
			$dari ='';			
			$sampai ='';			
			if(!empty($_POST['dari'])){				
				$dari = date_sl($_POST['dari']);				
				// $exp = explode('-',$dari);				
			}			
			
			if ($user=='0' AND $dari==''){				
				// echo 1;				
				$where = "WHERE `bayar_invoice_detail`.rekap='Y'";				
				// $AND="AND `bayar_invoice_detail`.setor='N'";				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='Y' AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
				}elseif ($user=='0' AND $dari!=''){				
				// echo 2;				
				$where = "WHERE `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='Y'";				
				// $AND="AND `bayar_invoice_detail`.setor='N'";				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='Y' AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
				}else{				
				// echo 2;				
				$where = "WHERE `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='Y' AND `bayar_invoice_detail`.id_user = '$user'";				
				// $AND="AND `bayar_invoice_detail`.setor='N' AND `bayar_invoice_detail`.id_user = '$user'";				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari' AND `bayar_invoice_detail`.rekap='Y' AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
			}			
			$data['dari'] = $dari;			
			$data['sampai'] = $sampai;			
			$data['user'] = $user;			
			$data['and'] = $AND;			
			$data['result'] = $this->model_data->carabayar($where);			
			$this->load->view('pembukuan/list_uang_masuk', $data); 			
		}		
		public function pengeluaran(){
			cek_menu_akses();
			$format = "%Y-%m-%d";			
			$harian = mdate($format);			
			$data['title'] = 'Pengeluaran';			
			$data['tgl'] = date('d/m/Y');			
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan',array('kunci'=>0,'pub'=>'Y'))->result_array();			
			$data['pilihan'] = $this->model_app->view('tb_users');			
			$conditions['returnType'] = 'count'; 			
			$conditions['where'] = array(			
			'tgl_pengeluaran' => $harian			
			);			
			$totalRec = $this->model_data->getPengeluaran($conditions); 			
			
			// Pagination configuration 			
			$config['target']      = '#dataList'; 			
			$config['base_url']    = base_url('ajak/ajaxPengeluaran'); 			
			$config['total_rows']  = $totalRec; 			
			$config['per_page']    = $this->perPage; 			
			
			// Initialize pagination library 			
			$this->ajax_pagination->initialize($config); 			
			
			// Get records 			
			$conditions = array( 			
			'limit' => $this->perPage 			
			); 			
			$conditions['where'] = array(			
			'tgl_pengeluaran' => $harian			
			);			
			$data['result'] = $this->model_data->getPengeluaran($conditions); 			
			
			$this->template->load('main/themes','pembukuan/pengeluaran',$data);			
		}		
		public function rekap(){			
			cek_menu_akses();			
			$format = "%Y-%m-%d";			
			$harian = mdate($format);			
			$data['title'] = 'Rekap';			
			$data['tgl'] = date('d/m/Y');			
			
			$conditions['returnType'] = 'count'; 			
			
			$totalRec = $this->model_data->getRekap($conditions); 			
			
			// Pagination configuration 			
			$config['target']      = '#dataList'; 			
			$config['base_url']    = base_url('ajak/ajaxRekap'); 			
			$config['total_rows']  = $totalRec; 			
			$config['per_page']    = $this->perPage; 			
			$config['link_func']   = 'searchRekap'; 			
			
			// Initialize pagination library 			
			$this->ajax_pagination->initialize($config); 			
			
			// Get records 			
			$conditions = array( 			
			'limit' => $this->perPage 			
			); 			
			$conditions['where'] = array(			
			'tgl_rekap' => $harian			
			);			
			$data['pilihan'] = $this->model_app->view('tb_users');			
			$data['result'] = $this->model_data->getRekap($conditions); 			
			
			$this->template->load('main/themes','pembukuan/rekapan',$data);			
		}		
		public function piutang(){	
			cek_menu_akses();
			$data['title'] = 'Piutang';			
			$data['bulan'] = date('m');			
			$data['tahun'] = date('Y');			
			$data['pilihan'] = $this->model_app->view('tb_users');			
			$this->template->load('main/themes','pembukuan/piutang',$data);			
		}		
		public function cari_piutang(){			
			$info= $this->db->escape_str($this->input->post('info'));			
			$iduser= $this->db->escape_str($this->input->post('user'));			
			$bulan= $this->db->escape_str($this->input->post('bulan'));			
			$tahun= $this->db->escape_str($this->input->post('tahun'));			
			$keywords= $this->db->escape_str($this->input->post('keywords'));			
			
			if ($bulan=="" AND $tahun=="" ){				
				$waktu = ""; 				
				}elseif ($bulan=="" AND $tahun > 0){				
				$waktu = "YEAR(tgl_trx) ='$tahun' AND ";				
				//echo $waktu;				
				}elseif ($tahun=="" AND $bulan > 0){				
				$waktu = "month(tgl_trx) ='$bulan' AND ";				
				}else{				
				$waktu = "month(tgl_trx) ='$bulan' AND YEAR(tgl_trx) ='$tahun' AND";				
				// echo 3;				
			}			
			// echo $waktu;			
			
			if ( substr($keywords,0,1 )== '0' )			
			{				
				// echo 1;				
				$whereSQL = "AND konsumen.no_hp LIKE '%$keywords%'";				
				}elseif(is_numeric($keywords)){				
				// echo 2;				
				$whereSQL = "AND invoice.id_invoice =".$keywords;				
				}else{				
				// echo 3;				
				$whereSQL = "";				
			}			
			
			if ($iduser=='0' AND $keywords==''){				
				// echo "a";				
				$where = "WHERE $waktu `invoice`.`status` = 'simpan'";				
				}elseif ($iduser=='0' AND $keywords!=''){				
				// echo "b";				
				$where = "WHERE $waktu  $whereSQL  AND `invoice`.`status` = 'simpan'";				
				}else{				
				// echo "c";				
				$where = "WHERE $waktu `invoice`.`id_user` = '$iduser' $whereSQL  AND `invoice`.`status` = 'simpan'" ;				
			}						
			
			// $data['result'] = $this->model_data->piutang($where);			
			$data['result'] = $this->model_data->piutang($where);			
			$this->load->view('pembukuan/cari_piutang', $data); 			
		}		
		public function cetak_pengeluaran($noid){			
			$id = array('id_pengeluaran' => $noid);			
			
			$search = $this->model_app->view_where('pengeluaran', $id);			
			$data['logo'] = FCPATH.'uploads/'.info()['logo'];			
			// $data['logo'] = base_url().'uploads/logo_pelita.png';			
			if($search->num_rows()>0){				
				$this->session->unset_userdata('cartp');				
				$row = $search->row_array();				
				$data['cetak'] = $row;				
				$data['info'] = info();				
				$data['detail'] = $this->model_app->view_where('pengeluaran_detail', array('id_pengeluaran' => $noid))->result_array();				
				$data['user'] = $this->model_app->view_where('tb_users', array('id_user' => $row['id_user']))->row_array();				
				$this->load->library('pdf');				
				$this->pdf->setPaper('A5', 'landscape');				
				$this->pdf->filename = "pengeluaran_".$noid."_".$row['tgl_pengeluaran'];				
				$this->pdf->load_view('pembukuan/cetak_pengeluaran', $data);				
				// $this->load->view('pembukuan/cetak_pengeluaran',$data);				
				}else{				
				$data['heading'] = 'Halaman error';				
				$data['message'] = 'Data tidak ditemukan';				
				$this->load->view('errors/html/error_404',$data);				
			}			
		}		
		public function cetak_rekap(){			
			if(isset($_POST['cetak'])){				
				$data['info'] = info();				
				$data['logo'] = FCPATH.'uploads/'.info()['logo'];				
				$id_user= $this->db->escape_str($this->input->post('id_user'));				
				$dari= $this->db->escape_str(date_sl($this->input->post('tgl_dari')));				
				$sampai= $this->db->escape_str(date_sl($this->input->post('tgl_sampai')));				
				$this->load->library('pdf');				
				$this->pdf->setPaper('A5', 'landscape');				
				$this->pdf->filename = "rekapan_".$dari."_".$sampai;				
				$where = "WHERE tgl_rekap BETWEEN CAST('$dari' AS DATE) AND CAST('$sampai' AS DATE) AND id_kasir='$id_user'";				
				
				$data['tgl'] = $dari;				
				$data['user'] = $this->model_app->view_where('tb_users', array('id_user' => $id_user))->row_array();				
				$data['detail'] = $this->model_data->cetakRekap($where);				
				$this->pdf->load_view('pembukuan/cetak_rekapan', $data);				
				// $this->load->view('pembukuan/cetak_rekapan',$data);				
				}else{				
				$data['heading'] = 'Halaman error';				
				$data['message'] = 'Data tidak ditemukan';				
				$this->load->view('errors/html/error_404',$data);				
			}			
		}		
		public function reset_table(){			
			$this->db->truncate('bayar_invoice_detail'); 			
			$this->db->truncate('data_rekap'); 			
			$this->db->truncate('invoice'); 			
			$this->db->truncate('invoice_detail'); 			
			$this->db->truncate('pengeluaran'); 			
			$this->db->truncate('pengeluaran_detail'); 			
		}		
		public function omset_produk(){			
			cek_menu_akses();
			$data['title'] = 'Omset per produk';			
			$data['tgl'] = date('d/m/Y');			
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan',array('kunci'=>0,'status'=>0,'pub'=>'Y'))->result_array();			
			$this->template->load('main/themes','pembukuan/omset_produk',$data);			
		}		
		public function cetak_uang_masuk(){			
			if(isset($_POST['id_user'])){			
				$user= $this->db->escape_str($this->input->post('id_user'));				
				$dari = date_sl($_POST['dari']);				
				
				$where = "WHERE `bayar_invoice_detail`.`tgl_bayar`='$dari'  AND `bayar_invoice_detail`.id_user = '$user'";				
				
				$AND = "AND `bayar_invoice_detail`.`tgl_bayar`='$dari'  AND `bayar_invoice_detail`.id_user = '$user' AND `invoice`.`oto` != 'baru' AND `invoice`.`oto` != 'pending' AND `invoice`.`oto` != 'batal'";				
				
				$data['dari'] = $dari;				
				$data['user'] = $user;				
				$data['and'] = $AND;				
				$data['logo'] = FCPATH.'uploads/'.info()['logo'];				
				$data['info'] = info();				
				$data['user'] = $this->model_app->view_where('tb_users', array('id_user' => $user))->row_array();				
				$data['detail'] = $this->model_data->carabayar($where);				
				$this->load->library('pdf');				
				$this->pdf->setPaper('A5', 'landscape');				
				$this->pdf->filename = "rekap_uang_masuk_".$user."_".$dari;				
				$this->pdf->load_view('pembukuan/cetak_uang_masuk', $data);				
				}else{				
				$data['heading'] = 'Halaman error';								
				$data['message'] = 'Data tidak ditemukan';								
				$this->load->view('errors/html/error_404',$data);			
			}			
		}		
			
		public function perjenis(){			
			$jenis= $this->db->escape_str($this->input->post('jenis'));			
			$info= $this->db->escape_str($this->input->post('info'));			
			$dari = date_sl($_POST['dari']);			
			$sampai = date_sl($_POST['sampai']);			
			$exp = explode('-',$dari);			
			$tahun = $exp[0];			
			$bulan = $exp[1];			
			if($jenis > 0){				
				$omset = "SELECT 				
				`jenis_cetakan`.`jenis_cetakan`,				
				`invoice_detail`.`id_produk`,				
				`invoice_detail`.`jenis_cetakan`,				
				`invoice_detail`.`keterangan`,				
				`invoice_detail`.`jumlah`,				
				`invoice_detail`.`harga`,				
				`invoice_detail`.`diskon`,				
				`invoice_detail`.`satuan`,				
				`invoice_detail`.`ukuran`,				
				`invoice_detail`.`id_bahan`,				
				`invoice`.`total_bayar`,				
				`invoice`.`pajak`,				
				`invoice`.`tgl_trx`,				
				`invoice`.`id_invoice`,				
				`invoice`.`id_konsumen`,				
				`invoice`.`id_marketing`,				
				`tb_users`.`nama_lengkap`,				
				`konsumen`.`nama`				
				FROM				
				`invoice_detail`				
				INNER JOIN `jenis_cetakan` ON (`invoice_detail`.`jenis_cetakan` = `jenis_cetakan`.`id_jenis`)				
				INNER JOIN `invoice` ON (`invoice_detail`.`id_invoice` = `invoice`.`id_invoice`)				
				INNER JOIN `tb_users` ON (`invoice`.`id_marketing` = `tb_users`.`id_user`)				
				INNER JOIN `konsumen` ON (`invoice`.`id_konsumen` = `konsumen`.`id`)				
				WHERE `invoice`.`tgl_trx` BETWEEN CAST('$dari' AS DATE) AND CAST('$sampai' AS DATE) AND invoice.status='simpan' AND `invoice_detail`.`jenis_cetakan` = '$jenis' group by `invoice_detail`.`id_invoice`";				
				}else{				
				$omset = "SELECT 				
				`konsumen`.`nama`,				
				`konsumen`.`id`,				
				`invoice`.`id_invoice`,				
				`invoice`.`total_bayar`,				
				`invoice`.`tgl_trx`,				
				`tb_users`.`id_user`,				
				`tb_users`.`nama_lengkap`,				
				`invoice`.`pajak`				
				FROM				
				`konsumen`				
				INNER JOIN `invoice` ON (`konsumen`.`id` = `invoice`.`id_konsumen`)				
				INNER JOIN `tb_users` ON (`invoice`.`id_marketing` = `tb_users`.`id_user`)				
				WHERE				
				`invoice`.`tgl_trx` BETWEEN CAST('$dari' AS DATE) AND CAST('$sampai' AS DATE) AND invoice.status='simpan'";				
			}			
			$data['result'] = $this->db->query($omset)->result_array();			
			
			$data['jenis'] = $jenis;			
			$data['dari'] = $dari;			
			$data['sampai'] = $sampai;			
			
			$this->load->view('pembukuan/omset_perjenis', $data); 			
		}		
		public function dummy(){			
		}		
	}																																											