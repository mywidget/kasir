<?php 
	class Model_data extends CI_model{
		function __construct() { 
			// Set table name 
			$this->table = 'tb_users'; 
		} 
		function get_harian($where){
			$qry = "SELECT invoice.id_invoice,
			invoice.tgl_trx,
			invoice.total_bayar,
			invoice.oto,
			invoice.pajak,
			invoice_detail.id_rincianinvoice,
			invoice_detail.diskon AS disc,
			
			sum(invoice_detail.jumlah * invoice_detail.harga) AS Tot,
			SUM((`invoice_detail`.`jumlah`)*(`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100)) AS sisa,
			round(SUM(`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100)) AS diskon,
			konsumen.nama,
			tb_users.nama_lengkap AS kasir
			FROM
			invoice
			INNER JOIN invoice_detail ON (invoice.id_invoice = invoice_detail.id_invoice)
			LEFT OUTER JOIN konsumen ON (invoice.id_konsumen = konsumen.id)
			LEFT OUTER JOIN tb_users ON (invoice.id_user = tb_users.id_user)
			" .$where. " 
			GROUP BY 
			invoice.id_invoice,
			konsumen.nama,
			tb_users.nama_lengkap ORDER BY invoice.id_invoice DESC";
			$query = $this->db->query($qry);
			// if($query->num_rows() > 0){
			return $query->result_array();
			// }
		}
		function piutang($where){
			$qry = "SELECT 
			`invoice_detail`.`id_invoice`,
			`invoice_detail`.`harga`,
			`invoice_detail`.`jumlah`,
			`invoice_detail`.`diskon`,
			`invoice`.`tgl_trx`, 
			`konsumen`.`nama` AS namak,
			`konsumen`.`no_hp`,
			`konsumen`.`perusahaan`, 
			IFNULL(`tb_users`.`nama_lengkap`,`invoice`.`id_user`)  as fo, 
			IFNULL(`tb_users1`.`nama_lengkap`, `invoice`.`id_user`) as `marketing`,  
			
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
			(`tb_users1`.`id_user` = `invoice`.`id_user`)
			$where GROUP BY
			`invoice_detail`.`id_invoice`
			HAVING sisa > 0 ORDER by  `konsumen`.`nama` ASC";
			$query = $this->db->query($qry);
			return $query->result_array();
		}
		function carabayar($where){
			$qry = "SELECT 
			`cara_bayar`.`cara_bayar`,
			`cara_bayar`.`id_byr`
			FROM
			`cara_bayar`
			RIGHT OUTER JOIN `bayar_invoice_detail` ON (`cara_bayar`.`id_byr` = `bayar_invoice_detail`.`id_byr`)
			$where
			GROUP BY `cara_bayar`.`id_byr`,
			`cara_bayar`.`cara_bayar`";
			$query = $this->db->query($qry);
			return $query->result_array();
		}
		
		function rekap_debit($where){
			$qry = "SELECT 
			SUM(`bayar_invoice_detail`.`jml_bayar`) AS `total`,
			`bayar_invoice_detail`.`tgl_bayar`
			FROM
			`invoice`
			INNER JOIN `bayar_invoice_detail` ON (`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`)
			" .$where. "
			GROUP BY
			`bayar_invoice_detail`.`tgl_bayar`";
			$query = $this->db->query($qry);
			if($query->num_rows() > 0){
				return $query->row();
			}
		}
		function rekap_kredit($where){
			$qry = "SELECT 
			SUM(`pengeluaran_detail`.`jumlah` * `pengeluaran_detail`.`harga`) AS `total`,
			`pengeluaran`.`tgl_pengeluaran`
			FROM
			`pengeluaran`
			RIGHT OUTER JOIN `pengeluaran_detail` ON (`pengeluaran`.`id_pengeluaran` = `pengeluaran_detail`.`id_pengeluaran`)
			" .$where. "
			GROUP BY
			`pengeluaran`.`tgl_pengeluaran`";
			$query = $this->db->query($qry);
			if($query->num_rows() > 0){
				return $query->row();
			}
		}
		//pengeluaran_detail`
		function getPengeluaran($params = array()){
			// print_r($params);
			$this->db->select('*');
			$this->db->from('pengeluaran');
			
			if(array_key_exists("where", $params)){
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			}  
			
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['dari'])){ 
					
					$this->db->where('tgl_pengeluaran >=', $params['search']['dari']);
				} 
				if(!empty($params['search']['sampai'])){ 
					$this->db->where('tgl_pengeluaran <=', $params['search']['sampai']);
				} 
				if(!empty($params['search']['user'])){ 
					$this->db->like('id_user', $params['search']['user']); 
				} 
			} 
			
			// Sort data by ascending or desceding order 
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('id_pengeluaran', $params['search']['sortBy']); 
			}
			
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$this->db->where('pos', 'Y'); 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('id_pengeluaran', $params['id']); 
					} 
					$this->db->where('pos', 'Y'); 
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
					}else{
					$this->db->where('pos', 'Y'); 
					$this->db->order_by('id_pengeluaran', 'ASC'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit']); 
					}
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		}
		function getPengeluaranPerproduk($params = array()){
			// print_r($params);
			$this->db->select('*');
			$this->db->from('pengeluaran');
			$this->db->join('tb_users', '`pengeluaran`.`id_user` = `tb_users`.`id_user`');
			if(array_key_exists("where", $params)){
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			}  
			
			if(array_key_exists("search", $params))
			{ 
				if(!empty($params['search']['dari']) AND !empty($params['search']['sampai'])){ 
					$this->db->where('tgl_pengeluaran BETWEEN "'. date('Y-m-d', strtotime($params['search']['dari'])). '" and "'. date('Y-m-d', strtotime($params['search']['sampai'])).'"');
				}
				if(!empty($params['search']['dari']) AND empty($params['search']['sampai'])){
					$this->db->where('tgl_pengeluaran', $params['search']['dari']);
					
				}
				// if(!empty($params['search']['jenis'])){ 
					// $this->db->where('`jenis_cetakan`.`id_jenis`', $params['search']['jenis']); 
				// }
				if(!empty($params['search']['user'])){ 
					$this->db->like('pengeluaran.id_user', $params['search']['user']); 
				} 
				
			} 
			
			// Sort data by ascending or desceding order 
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('pengeluaran.id_pengeluaran', $params['search']['sortBy']); 
			}
			
			
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$this->db->where('pos', 'Y'); 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					// if(!empty($params['id'])){ 
					// $this->db->where('id_pengeluaran', $params['id']); 
					// } 
					$this->db->where('pos', 'Y'); 
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
					}else{
					$this->db->where('pos', 'Y'); 
					$this->db->order_by('pengeluaran.id_pengeluaran', 'ASC'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit']); 
					}
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		}

		//rekapan
		function cetakRekap($where){
			$qry = "SELECT * FROM `data_rekap`  $where";
			$query = $this->db->query($qry);
			return $query->result_array();
			
		}
		function getRekap($params = array()){
			//print_r($params);
			$this->db->select('*');
			$this->db->from('data_rekap');
			
			if(array_key_exists("where", $params)){
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			}  
			
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['id_kasir'])){ 
					$this->db->where('id_kasir', $params['search']['id_kasir']);
				} 
				if(!empty($params['search']['dari'])){ 
					
					$this->db->where('tgl_rekap >=', $params['search']['dari']);
				} 
				if(!empty($params['search']['sampai'])){ 
					$this->db->where('tgl_rekap <=', $params['search']['sampai']);
				} 
				
			} 
			
			// Sort data by ascending or desceding order 
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('id', $params['search']['sortBy']); 
			}
			
			
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				// $this->db->where('pos', 'Y'); 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('id', $params['id']); 
						// $this->db->where('pos', 'Y'); 
					} 
					$query = $this->db->get(); 
					$result = $query->row_array(); 
					}else{
					// $this->db->where('pos', 'Y'); 
					$this->db->order_by('id', 'ASC'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit']); 
					}
					
					$query = $this->db->get(); 
					// $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
					$result = $query->result_array();
				} 
			} 
			
			// Return fetched data 
			return $result; 
		}
		function get_Satu($where){
			$qry = "SELECT 
			`pengeluaran`.`id_pengeluaran`,
			`pengeluaran`.`id_user`,
			`pengeluaran`.`tgl_pengeluaran`
			FROM `pengeluaran` $where
			ORDER BY `pengeluaran`.`tgl_pengeluaran` DESC";
			return $this->db->query($qry);
			// if($query->num_rows() > 0){
			// return $query->result_array();
			// }
		}
		function get_pengeluaran($where){
			$qry = "SELECT 
			`pengeluaran_detail`.`jumlah`,
			`pengeluaran_detail`.`harga`,
			`pengeluaran_detail`.`satuan`,
			`pengeluaran_detail`.`keterangan`,
			`pengeluaran`.`tgl_pengeluaran`,
			`pengeluaran`.`pos`,
			SUM(`pengeluaran_detail`.`jumlah` * `pengeluaran_detail`.`harga`) AS `total`,
			`pengeluaran`.`id_pengeluaran`
			FROM
			`pengeluaran`
			INNER JOIN `pengeluaran_detail` ON (`pengeluaran`.`id_pengeluaran` = `pengeluaran_detail`.`id_pengeluaran`)
			" .$where. " 
			GROUP BY
			`pengeluaran_detail`.`satuan`,
			`pengeluaran`.`tgl_pengeluaran`,
			`pengeluaran`.`pos`,
			`pengeluaran`.`id_pengeluaran`";
			$query = $this->db->query($qry);
			if($query->num_rows() > 0){
				return $query->result_array();
			}
		}
		function get_chart(){
			$qry = sprintf("select count(id) as jum, month(tgl_input) as bulan, year(tgl_input) as tahun from data_app GROUP BY tgl_input ORDER BY tgl_input ASC");
			$query = $this->db->query($qry);
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$hasil[]=array(
					'jum'=>$row->jum,
					'bulan'=>getBulan($row->bulan)
					);	
				}
				return $hasil;
			}
		}
		function getRows($params = array()){ 
			$this->db->select('`invoice`.`tgl_trx`,
			`invoice`.`id_konsumen`,
			`invoice`.`id_invoice`,
			`invoice`.`total_bayar`,
			`invoice`.`status`,
			`invoice`.`oto`,
			`invoice`.`lunas`,
			`invoice`.`cetak`,
			`konsumen`.`id`,
			`konsumen`.`nama`,
			`konsumen`.`no_hp`,
			`tb_users`.`nama_lengkap`'); 
			$this->db->from($this->table); 
			$this->db->join('invoice', '`tb_users`.`id_user` = `invoice`.`id_marketing`');
			$this->db->join('konsumen', '`invoice`.`id_konsumen` = `konsumen`.`id`');
			
			if(array_key_exists("where", $params)){ 
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			} 
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['keywords'])){ 
					$this->db->like('`invoice`.`id_invoice`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`nama`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`no_hp`', $params['search']['keywords']); 
					$this->db->or_like('`tb_users`.`nama_lengkap`', $params['search']['keywords']); 
					
				} 
				if(!empty($params['search']['trx'])){
					if($params['search']['trx']==1){ 
						$this->db->like('`invoice`.`lunas`', $params['search']['trx']); 
						}else{
						$this->db->like('`invoice`.`status`', $params['search']['trx']); 
					}
				} 
				if(!empty($params['search']['tgl'])){ 
					$this->db->where('tgl_trx', $params['search']['tgl']);
				} 
			}
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('`invoice`.`id_invoice`', $params['search']['sortBy']); 
			}
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('invoice.id_invoice', $params['id']); 
					} 
					$query = $this->db->get(); 
					$result = $query->row_array(); 
					}else{ 
					$this->db->order_by('invoice.id_invoice', 'desc'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit']); 
					} 
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		}
		
		function getKonsumen($params = array()){ 
			$this->db->select('*'); 
			$this->db->from('konsumen'); 
			$this->db->where('konsumen.id >', 1); 
			
			if(array_key_exists("where", $params)){ 
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			} 
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['keywords'])){ 
					$this->db->like('`konsumen`.`nama`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`no_hp`', $params['search']['keywords']); 
				} 
			}
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('`konsumen`.`id`', $params['search']['sortBy']); 
			}
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
				// $this->db->group_by(array("`konsumen`.`nama`", "`konsumen`.`no_hp`", "`konsumen`.`tgl_daftar`")); 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('konsumen.id', $params['id']); 
						// print_r($params);
					} 
					$query = $this->db->get(); 
					$result = $query->row_array(); 
					}else{ 
					// $this->db->group_by(array("`konsumen`.`nama`", "`konsumen`.`no_hp`", "`konsumen`.`tgl_daftar`")); 
					$this->db->order_by('konsumen.id', 'desc'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit']); 
					} 
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
					
				} 
			} 
			return $result; 
		}
		function getDetail($params = array()){
			// print_r($params);
			$this->db->select('`konsumen`.`nama`,
			`konsumen`.`no_hp`,
			`invoice`.`id_invoice`,
			`invoice`.`total_bayar`,
			`invoice`.`pajak`,
			`invoice`.`tgl_trx`,
			`tb_users`.`nama_lengkap`'); 
			$this->db->from('konsumen'); 
			$this->db->join('invoice', '`konsumen`.`id` = `invoice`.`id_konsumen`');
			$this->db->join('tb_users', '`invoice`.`id_marketing` = `tb_users`.`id_user`');
			if(array_key_exists("where", $params)){ 
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			} 
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['keywords'])){ 
					$this->db->like('`invoice`.`id_invoice`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`nama`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`no_hp`', $params['search']['keywords']); 
					$this->db->or_like('`tb_users`.`nama_lengkap`', $params['search']['keywords']); 
				} 
				
			}
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('`invoice`.`id_invoice`', $params['search']['sortBy']); 
			}
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
				$this->db->where('konsumen.id', $params['id']); 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('konsumen.id', $params['id']); 
					} 
					$query = $this->db->get(); 
					$result = $query->result_array(); 
					}else{ 
					$this->db->order_by('invoice.id_invoice', 'ASC'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit']); 
					} 
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		} 
		function getCari($params = array()){
			$this->db->select('`invoice`.`tgl_trx`,
			`invoice`.`id_invoice`,
			`invoice`.`total_bayar`,
			`invoice`.`status`,
			`invoice`.`oto`,
			`invoice`.`lunas`,
			`invoice`.`cetak`,
			`konsumen`.`id`,
			`konsumen`.`nama`,
			`konsumen`.`no_hp`,
			`tb_users`.`nama_lengkap`'); 
			$this->db->from($this->table); 
			$this->db->join('invoice', '`tb_users`.`id_user` = `invoice`.`id_marketing`');
			$this->db->join('konsumen', '`invoice`.`id_konsumen` = `konsumen`.`id`');
			
			if(array_key_exists("where", $params)){ 
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			} 
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['keywords'])){ 
					$this->db->like('`invoice`.`id_invoice`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`nama`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`no_hp`', $params['search']['keywords']); 
					$this->db->or_like('`tb_users`.`nama_lengkap`', $params['search']['keywords']); 
					
				} 
				
			}
			
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('konsumen.id', $params['id']); 
					} 
					$query = $this->db->get(); 
					$result = $query->row_array(); 
					}else{ 
					$this->db->order_by('invoice.id_invoice', 'desc'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit']); 
					} 
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->row_array():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		} 
		function getRowsHarian($params = array()){
			$this->db->select('`invoice`.`tgl_trx`,
			`invoice`.`id_invoice`,
			`invoice`.`total_bayar`,
			`invoice`.`status`,
			`invoice`.`oto`,
			`invoice`.`lunas`,
			`invoice`.`cetak`,
			`konsumen`.`id`,
			`konsumen`.`nama`,
			`konsumen`.`no_hp`,
			`tb_users`.`nama_lengkap`'); 
			$this->db->from($this->table); 
			$this->db->join('invoice', '`tb_users`.`id_user` = `invoice`.`id_marketing`');
			$this->db->join('konsumen', '`invoice`.`id_konsumen` = `konsumen`.`id`');
			
			if(array_key_exists("where", $params)){ 
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			} 
			if(array_key_exists("search", $params)){ 
				if(!empty($params['search']['keywords'])){ 
					$this->db->like('`invoice`.`id_invoice`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`nama`', $params['search']['keywords']); 
					$this->db->or_like('`konsumen`.`no_hp`', $params['search']['keywords']); 
					$this->db->or_like('`tb_users`.`nama_lengkap`', $params['search']['keywords']); 
					
				} 
				if(!empty($params['search']['trx'])){
					if($params['search']['trx']==1){ 
						$this->db->like('`invoice`.`lunas`', $params['search']['trx']); 
						}else{
						$this->db->like('`invoice`.`status`', $params['search']['trx']); 
					}
				} 
				if(!empty($params['search']['dari'])){ 
					$this->db->where('tgl_trx', $params['search']['dari']);
				} 
			}
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('`invoice`.`id_invoice`', $params['search']['sortBy']); 
			}
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					if(!empty($params['id'])){ 
						$this->db->where('invoice.id_invoice', $params['id']); 
					} 
					$query = $this->db->get(); 
					$result = $query->row_array(); 
					}else{ 
					$this->db->order_by('invoice.id_invoice', 'desc'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						$this->db->limit($params['limit']); 
					} 
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		} 
	}															