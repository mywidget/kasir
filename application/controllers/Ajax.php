<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Ajax extends CI_Controller { 
     
    function __construct() { 
        parent::__construct(); 
      // $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->perPage = 10; 
    } 
  
    function ajaxPengeluaran(){
	// cek_session_login(); 
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
        $sortBy = $this->input->post('sortBy'); 
        $user = $this->input->post('user'); 
		// $conditions['search']['dari'] = date('Y-m-d'); 
		// $conditions['search']['sampai'] = date('Y-m-d'); 

        if(!empty($_POST['dari'])){
        $dari = date_sl($_POST['dari']);
		$conditions['search']['dari'] = $dari; 
        }
		if(!empty($_POST['sampai'])){ 
		$sampai = date_sl($_POST['sampai']);
		$conditions['search']['sampai'] = $sampai; 
        }
		if(!empty($user)){ 
            $conditions['search']['user'] = $user; 
        } 
        
        if(!empty($limits)){ 
            $conditions['search']['limits'] = $limits; 
        } 
		if(!empty($sortBy)){ 
            $conditions['search']['sortBy'] = $sortBy; 
        } 
		// echo $dari;
         
        // Get record count 
        $conditions['returnType'] = 'count'; 
        $totalRec = $this->model_data->getPengeluaran($conditions); 
         
        // Pagination configuration 
        $config['target']      = '#dataListPengeluaran'; 
        $config['base_url']    = base_url('ajax/ajaxPengeluaran'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $limit; 
        $config['link_func']   = 'FilterPengeluaran'; 
         
        // Initialize pagination library 
        $this->ajax_pagination->initialize($config); 
         
        // Get records 
        $conditions['start'] = $offset; 
        $conditions['limit'] = $limit;
        // print_r($conditions);
        $conditions['where'] = array('pos' => 'Y');
        unset($conditions['returnType']); 
        $data['result'] = $this->model_data->getPengeluaran($conditions); 
         
        // Load the data list view 
        $this->load->view('pembukuan/ajax-pengeluaran', $data); 
    }
    function ajaxPengeluaranProduk(){
	// cek_session_login(); 
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
        $sortBy = $this->input->post('sortBy'); 
        $user = $this->input->post('user'); 
        $jenis = $this->input->post('jenis'); 
         
		// $conditions['search']['dari'] = date('Y-m-d'); 
		// $conditions['search']['sampai'] = date('Y-m-d'); 

        if(!empty($_POST['dari'])){
        $dari = date_sl($_POST['dari']);
		$conditions['search']['dari'] = $dari; 
        }
		if(!empty($_POST['sampai'])){ 
		$sampai = date_sl($_POST['sampai']);
		$conditions['search']['sampai'] = $sampai; 
        }
		if(!empty($user)){ 
            $conditions['search']['user'] = $user; 
        } 
        
        if(!empty($limits)){ 
            $conditions['search']['limits'] = $limits; 
        } 
		if(!empty($sortBy)){ 
            $conditions['search']['sortBy'] = $sortBy; 
        } 
        if(!empty($jenis)){ 
            $conditions['search']['jenis'] = $jenis; 
        } 
		// echo $dari;
         
        // Get record count 
        $conditions['returnType'] = 'count'; 
        $totalRec = $this->model_data->getPengeluaranPerproduk($conditions); 
         
        // Pagination configuration 
        $config['target']      = '#dataListPengeluaran'; 
        $config['base_url']    = base_url('ajax/ajaxPengeluaranProduk'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $limit; 
        $config['link_func']   = 'FilterPengeluaran'; 
         
        // Initialize pagination library 
        $this->ajax_pagination->initialize($config); 
         
        // Get records 
        $conditions['start'] = $offset; 
        $conditions['limit'] = $limit;
        // print_r($conditions);
        $conditions['where'] = array('pos' => 'Y');
        unset($conditions['returnType']); 
        $data['jenis'] = $this->input->post('jenis');
        $data['result'] = $this->model_data->getPengeluaranPerproduk($conditions); 
         
        // Load the data list view 
        $this->load->view('pembukuan/ajax-pengeluaran-jenis', $data); 
    }
	function ajaxRekap(){
	cek_session_login(); 
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
        
		//$conditions['search']['dari'] = date('Y-m-d'); 
		$sortBy = $this->input->post('sortBy'); 
		$user = $this->input->post('id_kasir'); 
         if(!empty($user)){ 
            $conditions['search']['id_kasir'] = $user; 
        } 
        if(!empty($_POST['dari'])){
        $dari = date_sl($_POST['dari']);
		$conditions['search']['dari'] = $dari; 
        }
		if(!empty($_POST['sampai'])){ 
		$sampai = date_sl($_POST['sampai']);
		$conditions['search']['sampai'] = $sampai; 
        }
		
        if(!empty($limits)){ 
            $conditions['search']['limits'] = $limits; 
        } 
		if(!empty($sortBy)){ 
            $conditions['search']['sortBy'] = $sortBy; 
        } 
       
         
        // Get record count 
        $conditions['returnType'] = 'count'; 
        $totalRec = $this->model_data->getRekap($conditions); 
         
        // Pagination configuration 
        $config['target']      = '#dataList'; 
        $config['base_url']    = base_url('ajax/ajaxRekap'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $limit; 
        $config['link_func']   = 'searchRekap'; 
         
        // Initialize pagination library 
        $this->ajax_pagination->initialize($config); 
         
        // Get records 
        $conditions['start'] = $offset; 
        $conditions['limit'] = $limit;
        unset($conditions['returnType']); 
        $data['result'] = $this->model_data->getRekap($conditions); 
         
        // Load the data list view 
        $this->load->view('pembukuan/ajax-rekapan', $data, false); 
    }
}