<?php 
	class Model_app extends CI_model{
		public function view($table){
			$query = $this->db->get($table);
			if($query->num_rows() > 0){
				return $query->result_array(); 
			}
		}
		public function views($table){
			return $this->db->get($table);
		}
		
		public function insert($table,$data){
			return $this->db->insert($table, $data);
		}
		public function edits($table, $data){
			$query = $this->db->get_where($table, $data);
			if($query->num_rows() > 0){
				return $query->row_array(); 
			}
		}
		public function edit($table, $data){
			return $this->db->get_where($table, $data);
		}
		
		public function update($table, $data, $where){
			return $this->db->update($table, $data, $where); 
		}
		
		public function delete($table, $where){
			return $this->db->delete($table, $where);
		}
		public function hapus($table, $id){
			$this->db->where(str_replace('tbl_', '', $table).'_id', $id);
			return $this->db->delete($table);
		}
		
		public function view_wherein($data){
			$this->db->where_in($data);
			return $this->db->get('bahan');
		}
		public function view_where($table,$data){
			$this->db->where($data);
			return $this->db->get($table);
		}
		public function view_where_in($table,$baris,$data){
			
			$this->db->where_in($baris,$data);
			return $this->db->get($table);
		}
		public function view_like($table,$data){
			$this->db->like($data);
			return $this->db->get($table);
		}
		
		public function view_ordering_limit($table,$order,$ordering,$baris,$dari){
			$this->db->select('*');
			$this->db->order_by($order,$ordering);
			$this->db->limit($dari, $baris);
			return $this->db->get($table);
		}
		public function view_where_ordering_limit($table,$data,$order,$ordering,$baris){
			$this->db->where($data);
			$this->db->order_by($order,$ordering);
			$this->db->limit($baris);
			// return $this->db->get($table)->result_array();
			return $this->db->get($table);
		}
		public function view_ordering($table,$order,$ordering){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->order_by($order,$ordering);
			return $this->db->get()->result_array();
		}
		
		public function view_where_ordering($table,$data,$order,$ordering){
			$this->db->where($data);
			$this->db->order_by($order,$ordering);
			$query = $this->db->get($table);
			return $query->result_array();
		}
		
		public function view_join_one($table1,$table2,$field,$order,$ordering){
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
			$this->db->order_by($order,$ordering);
			return $this->db->get()->result_array();
		}
		
		public function view_join_where($table1,$table2,$field,$where,$order,$ordering){
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
			$this->db->where($where);
			$this->db->order_by($order,$ordering);
			return $this->db->get()->result_array();
		}
		public function pilih_1($table,$where){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($where);
			return $this->db->get()->result_array();
			// return $this->db->query("SELECT * FROM `$tbl` where $where='$id'")->row_array();
		}
		public function diskon($table,$where){
			$this->db->select('SUM(`bayar_invoice_detail`.`jml_bayar`) AS `totbayar`,`bayar_invoice_detail`.`jdiskon`');
			// $this->db->from($table);
			$this->db->where($where);
			$this->db->group_by('`bayar_invoice_detail`.`jdiskon`');
			return $this->db->get($table);
			// return $this->db->get()->result_array();
		}
		public function total_bayar($where){
			$this->db->select('SUM(`bayar_invoice_detail`.`jml_bayar`) AS `total`');
			$this->db->where($where);
			return $this->db->get('bayar_invoice_detail');	
		}
		public function cara_bayar($where){
			$this->db->select('`cara_bayar`.`cara_bayar`,
			`cara_bayar`.`kode`,
			`cara_bayar`.`no_rek`,
			`cara_bayar`.`pemilik`,`invoice`.`cetak`');
			$this->db->from('cara_bayar');
			$this->db->join('bayar_invoice_detail', '`cara_bayar`.`id_byr` = `bayar_invoice_detail`.`id_byr`');
			$this->db->join('invoice', '`bayar_invoice_detail`.`id_invoice` = `invoice`.`id_invoice`');
			$this->db->where($where);
			return $this->db->get()->row();
		}
		/*SELECT 
			`bayar_invoice_detail`.`tgl_bayar`,
			`bayar_invoice_detail`.`jml_bayar`,
			`invoice`.`oto`
			FROM
			`invoice`
			INNER JOIN `bayar_invoice_detail` ON (`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`)
			WHERE
		`bayar_invoice_detail`.`id_invoice` = 5*/
		public function list_bayar($where){
			$this->db->select('`bayar_invoice_detail`.`tgl_bayar`,
			`bayar_invoice_detail`.`jml_bayar`,
			`invoice`.`oto`');
			$this->db->from('invoice');
			$this->db->join('bayar_invoice_detail', '`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`');
			$this->db->where($where);
			return $this->db->get()->row();
		}
		public function cek_total_invoice($where){
			$this->db->select('total_bayar');
			$this->db->where($where);
			return $this->db->get('invoice');
		}
		public function cek_total_detail($select,$where){
			$this->db->select('SUM(jumlah * harga) AS `total`');
			$this->db->where($where);
			return $this->db->get('invoice_detail');
		}
		public function cek_total($table,$select,$where){
			$this->db->select($select);
			$this->db->from($table);
			$this->db->where($where);
			// return $this->db->get($table)->row();
			return $this->db->get()->row();
		}
		// public function cek_count($table,$select,$where){
			// $this->db->select($select);
			// $this->db->from($table);
			// $this->db->where($where);
			// // return $this->db->get($table)->row();
			// return $this->db->get()->row();
		// }
		public function produk(){
			$this->db->select('`jenis_cetakan`.`jenis_cetakan`,
			`produk`.`id` AS idp,
			`produk`.`title` AS nproduk,
			`produk`.`harga_dasar`,
			`produk`.`pub`');
			$this->db->from('produk');
			$this->db->join('jenis_cetakan', '`produk`.`id_jenis` = `jenis_cetakan`.`id_jenis`');
			$this->db->where('produk.kunci=0');
			$this->db->order_by('`produk`.`id`','DESC');
			return $this->db->get()->result_array();
		}
		public function produk_cart($where){
			$this->db->select('`jenis_cetakan`.`id_jenis`,
			`bahan`.`id` AS idbahan,
			`bahan`.`title` AS nbahan,
			`jenis_cetakan`.`jenis_cetakan` AS jenis,
			`produk`.`title`,
			`produk`.`harga_dasar`,
			`produk`.`id_jenis`,
			`produk`.`id_bahan`,
			`produk`.`id`,
			`invoice`.`total_bayar`,
			`invoice`.`tgl_trx`,
			`invoice`.`tgl_ambil`,
			`invoice`.`id_user`,
			`invoice`.`id_marketing`,
			`invoice`.`status`,
			`invoice`.`oto`,
			`invoice_detail`.`id_rincianinvoice`,
			`invoice_detail`.`jumlah`,
			`invoice_detail`.`keterangan`,
			`invoice_detail`.`harga`,
			`invoice_detail`.`diskon`,
			`invoice_detail`.`satuan`,
			`invoice_detail`.`ukuran`,
			`invoice_detail`.`tot_ukuran`,
			`invoice_detail`.`uk_real`,
			`invoice_detail`.`catatan`');
			$this->db->from('invoice');
			$this->db->join('invoice_detail', '`invoice`.`id_invoice` = `invoice_detail`.`id_invoice`');
			$this->db->join('produk', '`invoice_detail`.`id_produk` = `produk`.`id`');
			$this->db->join('jenis_cetakan', '`invoice_detail`.`jenis_cetakan` = `jenis_cetakan`.`id_jenis`');
			$this->db->join('bahan', '`invoice_detail`.`id_bahan` = `bahan`.`id`');
			$this->db->where($where);
			$this->db->order_by('`invoice_detail`.`id_rincianinvoice`','ASC');
			return $this->db->get()->result_array();
		}
		public function pengeluaran_detail($where){
			$this->db->select('`jenis_cetakan`.`jenis_cetakan`,
  `pengeluaran_detail`.`no`,
  `pengeluaran_detail`.`id_pengeluaran`,
  `pengeluaran_detail`.`id_biaya`,
  `pengeluaran_detail`.`id_supplier`,
  `pengeluaran_detail`.`no_invo`,
  `pengeluaran_detail`.`keterangan`,
  `pengeluaran_detail`.`jumlah`,
  `pengeluaran_detail`.`harga`,
  `pengeluaran_detail`.`satuan`,
  `pengeluaran_detail`.`id_pemesan`,
  `pengeluaran_detail`.`no_order`,
  `jenis_cetakan`.`id_jenis`');
			$this->db->from('jenis_cetakan');
			$this->db->join('pengeluaran_detail', '`jenis_cetakan`.`id_jenis` = `pengeluaran_detail`.`id_biaya`');
			$this->db->where($where);
			return $this->db->get();
			// return $this->db->get()->result_array();
		}
		public function cek_login($username,$password,$table){
			return $this->db->query("SELECT * FROM $table where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."' AND aktif='Y'");
		}
		
		public function cek_user($username){
			return $this->db->query("SELECT * FROM tb_users where email='".$this->db->escape_str($username)."' AND aktif='Y'");
		}
	
		public function counter($table,$params=array()){
			if(array_key_exists("where", $params)){ 
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			}
			$result = $this->db->count_all_results($table);
			return $result; 
			
		}
	}		