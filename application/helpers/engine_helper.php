<?php 
	
	function checkbox($data, $parent = 0, $parent_id = 0, $Nilai='') {
		static $i = 1;
		$ieTab = str_repeat("&nbsp;&nbsp;&nbsp;", $i * 2);
		$tab = $i * 0 ;
		if (isset($data[$parent])) {
			$i++;
			$html ='';
			foreach ($data[$parent] as $v) {
				$child = checkbox($data, $v['idmenu'], $parent_id, $Nilai);
				//Edit Di Item
				
				$_arrNilai = explode(',', $Nilai);
				$_ck = (array_search($v['idmenu'], $_arrNilai) === false)? '' : 'checked';
				$html .= '<div class="custom-control custom-checkbox">';
				$html .= ''.$ieTab .'<input type=checkbox name="data[]" id="checkb'.$v['idmenu'].'" class="custom-control-input" value="'.$v['idmenu'].'" '.$_ck.'>&nbsp;<label for="checkb'.$v['idmenu'].'" class="custom-control-label">'.$v['nama_menu'].'</label>';
				$html .= "</div>";
				if ($child) { $i--; $html .= $child; }
			}
			return $html;
		}
	}
	function tags_bahan($id){
		$ci = & get_instance();
		$query=$ci->db->query("SELECT id_bahan FROM `produk` WHERE id='$id'");
		$TampungData = array();
		foreach ($query->result() as $data_tags){
			$tags = explode(',',strtolower(trim($data_tags->id_bahan)));
			if(empty($data_tags->id_bahan)){echo'';}else{
				foreach($tags as $val) {
					$TampungData[] = $val;
				}}}
				$jumlah_tag = array_count_values($TampungData);
				ksort($jumlah_tag);
				$output = array();
				foreach($jumlah_tag as $key=>$val) {
					$querys=$ci->db->query("SELECT * FROM `bahan` WHERE id='$key' AND kunci='0'");
					foreach ($querys->result() as $row){
						$output[] = '<option selected value="'.$row->id.'">'.$row->title.'</options>';
					}
				}
				
				$tags= implode(' ',$output);
				return $tags;
	}
	function cek_menu_akses(){
    	$ci = & get_instance();
        $session = $ci->session->ids;
		$link_menu = $ci->uri->uri_string();
		if(isset($session)){
			$menu = $ci->db->query("SELECT * FROM menuadmin WHERE link='$link_menu'")->row_array();
			$user = $ci->db->query("SELECT * FROM tb_users WHERE sesi_login='$session'")->row_array();
			$people = explode(",",$user['idmenu']);
			if (!in_array($menu['idmenu'], $people)){
				redirect(base_url().'my404');
			}
			}else{
			redirect(base_url());
		}
	}
	
    function template(){
        $ci = & get_instance();
        $query = $ci->db->query("SELECT * FROM `themes` where pub='0'");
        if ($query->num_rows()>=1){
			$tmp = $query->row_array();
            return $tmp['folder'];
			}else{
            return 'errors';
		}
	}
    function title(){
        $ci = & get_instance();
        $title = $ci->db->query("SELECT title FROM info")->row_array();
        return $title['title'];
	}
	
    function description(){
        $ci = & get_instance();
        $title = $ci->db->query("SELECT deskripsi FROM info")->row_array();
        return $title['deskripsi'];
	}
	
    function keywords(){
        $ci = & get_instance();
        $title = $ci->db->query("SELECT keywords FROM info")->row_array();
        return $title['meta_keyword'];
	}
	
    function pilih($tbl,$where,$id){
        $ci = & get_instance();
        $info = $ci->db->query("SELECT * FROM `$tbl` where $where='$id'")->row_array();
        return $info;
	}
	
	
	function info(){
        $ci = & get_instance();
        $info = $ci->db->query("SELECT * FROM info")->row_array();
        return $info;
	}
	function logo(){
        $ci = & get_instance();
        $fav = $ci->db->query("SELECT logo FROM info")->row_array();
        return $fav['logo'];
	}
	
	
	function favicon(){
        $ci = & get_instance();
        $fav = $ci->db->query("SELECT favicon FROM info")->row_array();
        return $fav['favicon'];
	}
	
	
	
	function bayar($id){
        $ci = & get_instance();
		$ci->db->select('SUM(`bayar_invoice_detail`.`jml_bayar`) AS `Totalbayar`');
		$ci->db->from('bayar_invoice_detail');
		$ci->db->where('`bayar_invoice_detail`.id_invoice',$id);
		$ci->db->group_by("`bayar_invoice_detail`.`id_invoice`");
		return $ci->db->get()->row_array();
	}
	function trx_now(){
        $ci = & get_instance();
		$ci->db->where('tgl_trx=CURDATE()');
		$ci->db->where('oto=1');
		return $ci->db->count_all_results('invoice');
	}
	function c_acc(){
        $ci = & get_instance();
		$ci->db->where('oto=1');
		return $ci->db->count_all_results('invoice');
	}
	function c_pending(){
        $ci = & get_instance();
		$ci->db->where('oto=0');
		return $ci->db->count_all_results('invoice');
	}
	
    function cek_session_admin(){
        $ci = & get_instance();
        $session = $ci->session->userdata('level');
        if ($session != 'admin'){
            redirect(base_url());
		}
	}
    function cek_session_login(){
        $ci = & get_instance();
		$session = $ci->session->level;
        if (!isset($session)){
            redirect(base_url());
		}
	}
	function cekSessiLogin(){
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
		if ($ci->session->level==''){
			echo 'logout';
			// exit;
		} 
	}
	function autoNumbers($awalan,$digit)
	{ 
		//%06s
		$ci = & get_instance();
		$ci->db->select_max('id_member','max_id');
		$query = $ci->db->get('konsumen');
		if($query->num_rows()>0){
			$data=$query->row();
			$maxid = $data->max_id;
			$count_awalan = strlen($awalan);
			$potong_awalan = str_replace($awalan,"",$maxid);
			$count_potong_awalan = strlen($potong_awalan);
			$noUrut = (int) substr($maxid, $count_awalan, $count_potong_awalan);
			$noUrut++;
			$kode_baru = $awalan.sprintf($digit, $noUrut);
			}else{
			$kode_baru = $awalan.sprintf($digit, 1);
		}
		return $kode_baru;
	}	
	function get_Umasuk($id,$and){
		$qry = "SELECT 
		`bayar_invoice_detail`.`id_invoice`,
		`konsumen`.`nama`,
		`invoice`.`tgl_invoice`,
		`bayar_invoice_detail`.`tgl_bayar`,
		`bayar_invoice_detail`.`tgl_jam_bayar`,
		`bayar_invoice_detail`.`jml_bayar`,
		`cara_bayar`.`cara_bayar`,
		`bayar_invoice_detail`.`id`,
		`bayar_invoice_detail`.`id_byr`
		FROM
		`invoice`
		RIGHT OUTER JOIN `bayar_invoice_detail` ON (`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`)
		INNER JOIN `cara_bayar` ON (`bayar_invoice_detail`.`id_byr` = `cara_bayar`.`id_byr`)
		INNER JOIN `konsumen` ON (`invoice`.`id_konsumen` = `konsumen`.`id_konsumen`)
		WHERE  `bayar_invoice_detail`.id_byr='$id' $and
		ORDER BY
		`bayar_invoice_detail`.`id`";
		$query = $this->db->query($qry);
		// if($query->num_rows() > 0){
		return $query->result_array();
		// }
	}		