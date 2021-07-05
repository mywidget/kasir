<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Dokumentasi extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function index()
		{
			$data['title'] = 'Dokumentasi';
			$this->load->view('dokumentasi/dokumentasi', $data);
		}
		public function page()
		{
			$data['title'] = 'Dokumentasi';
			$this->load->view('dokumentasi/docs-page', $data);
		}
		
	}		