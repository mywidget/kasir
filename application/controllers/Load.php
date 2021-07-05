<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Load extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
		}
		
		public function load_bayar()
		{
			$idorder = $this->input->post('idorder'); 
			$idorder = $this->input->post('idorder'); 
			$data['load']  = $this->model_app->view_where('bayar_invoice_detail',array('id_invoice'=>$idorder));
			
			$this->load->view('produk/load',$data);
		}
		
	}	