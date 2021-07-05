<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Update extends CI_Controller {
		function __construct(){
			parent::__construct();
			$this->load->library('unduh');
			$this->load->helper('directory');
            $this->load->helper("file");
		}
		public function index()
		{
			// cek_menu_akses();
			$data['title'] = 'Download update';
			$arr = curl();
			$vupdate = $arr->update;
			if($vupdate!=0){
			$this->template->load('main/themes','update',$data);
			}else{
			$this->template->load('main/themes','update_error',$data);
			}
		}
		public function list_data()
		{
            
            $fetch_data = directory_map('./update/', FALSE, TRUE); 
            $data = array();  
            $no=1;
            foreach($fetch_data as $row)  
            {
                $dname = explode(".", $row);
                $ext = end($dname);
                $exp = explode('_',$row);
				
				$btn = '<a href="'.base_url().'update/'.$row.'" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download"><i class="fa fa-download"></i></a>';
                
                $sub_array = array();
                $sub_array[] = $no++;
                $sub_array[] = $row;
                $sub_array[] = $btn.' <button type="button" class="btn btn-danger btn-sm hapus" data-toggle="tooltip" title="Hapus" data-file="'.$row.'"><i class="fa fa-trash"></i></button>';  
                $data[] = $sub_array;  
			}  
            $output = array(   
            "data" => $data  
            );  
            echo json_encode($output);  
			
		}
		public function download(){
			$fileUrl ="https://".SITE_KEY."raw.githubusercontent.com/mywidget/app_kasir/main/version.json";
			$fileOffline = "version.json";
			if (!is_file($fileOffline)) {
				echo "File tidak ditemukan";
				die();
			}
			$result = file_get_contents($fileUrl);
			$data = json_decode($result);
			$versi = $data->aplikasi;
			$versi = $versi[0];
			$offline = file_get_contents($fileOffline);
			$data2 = json_decode($offline, true);
			$data2 = $data2['aplikasi'][0];
			if(empty($data2)){
				$data = array('ok'=>'error','msg'=>'Versi tidak ditemukan');
				echo json_encode($data);  
				die();
			}
			if(empty($data2['version'])){
				$data = array('ok'=>'error','msg'=>'Versi tidak ditemukan');
				echo json_encode($data);  
				die();
			}
			if($data2['version']==$versi->version){
				$data = array('ok'=>'ook','msg'=>'Sudah versi terbaru.');
				echo json_encode($data);  
				die();
			}
			if($data2['version'] > $versi->version){
				$data = array('ok'=>'error','msg'=>'Versi tidak sesuai');
				echo json_encode($data);  
				die();
			}
			$folder = 'update/';
			$this->unduh->download(array(
			'appid'   => $site_key,
			'user'   => 'mywidget',
			'repo'   => 'app_kasir',
			'file_name' => $versi->file_download,
			'saveAs' => $folder.$versi->file_download
			));
			if ($this->unduh->get_status()=='ok') {
				$data = array('ok'=>'ok','msg'=>'Download berhasil.');
				} else {
				$data = array('ok'=>'error','msg'=>'Download gagal.');
			}
			echo json_encode($data);  
		}
		public function cek_notif(){
			$cek_notif = $this->input->post('tipe');
			if(isset($cek_notif)){
				// echo SITE_KEY;
				$fileUrl ="https://".SITE_KEY."raw.githubusercontent.com/mywidget/app_kasir/main/version.json";
				$fileOffline = "version.json";
				
				$result = file_get_contents($fileUrl);
				// print_r($result);
				$data = json_decode($result);
				$versi = $data->aplikasi;
				$versi = $versi[0];
				$offline = file_get_contents($fileOffline);
				$data2 = json_decode($offline, true);
				$data2 = $data2['aplikasi'][0];
				$html="";
				if($data2['version']==$versi->version){
					$html .= '<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-bell fa-fw"></i>
					<span class="badge badge-danger badge-counter">0</span>
					</a>';
					}elseif($versi->version > $data2['version']){
					$html .= '<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-bell fa-fw"></i>
					<span class="badge badge-danger badge-counter">1</span>
					</a>
					<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in "
					aria-labelledby="alertsDropdown">
					<h6 class="dropdown-header">
					Versi '.$versi->version .' tersedia
					</h6>
					<a class="dropdown-item d-flex align-items-center" href="#">
					<div class="mr-3">
					<div class="icon-circle bg-primary">
					<i class="fas fa-file-alt text-white"></i>
					</div>
					</div>
					<div>
					<div class="small text-gray-500">'.dtime($versi->updateDate).'</div>
					<span class="font-weight-bold">'.$versi->caption.'</span>
					</div>
					</a>
					<a class="dropdown-item text-center small text-gray-500" href="'.base_url().'update">Klik untuk update</a>
					</div>';
					}else{
					$html .="";
				}
				
				echo $html; 
				}
		}
		public function cek(){
			$fileUrl ="https://".SITE_KEY."raw.githubusercontent.com/mywidget/app_kasir/main/version.json";
			$fileOffline = "version.json";
			
			$result = file_get_contents($fileUrl);
			// print_r($result);
			$data = json_decode($result);
			$versi = $data->aplikasi;
			$versi = $versi[0];
			$offline = file_get_contents($fileOffline);
			$data2 = json_decode($offline, true);
			$data2 = $data2['aplikasi'][0];
			if($data2['version']==$versi->version){
				$_data = array('ok'=>'ok','msg'=>'Versi sesuai');
				}elseif($versi->version > $data2['version']){
				$_data = array('ok'=>'new','msg'=>'Versi Terbaru '.$versi->version);
				}else{
				$_data = array('ok'=>'error','msg'=>'Gagal cek');
			}
			echo json_encode($_data);  
		}
		public function unzipup(){
			$fileUrl ="https://".SITE_KEY."raw.githubusercontent.com/mywidget/app_kasir/main/version.json";
			$fileOffline = "version.json";
			if (!is_file($fileOffline)) {
				echo "File tidak ditemukan";
				die();
			}
			$result = file_get_contents($fileUrl);
			$data = json_decode($result);
			$versi = $data->aplikasi;
			$versi = $versi[0];
			$offline = file_get_contents($fileOffline);
			$data2 = json_decode($offline, true);
			$data2 = $data2['aplikasi'][0];
			if(empty($data2)){
				$data = array('ok'=>'error','msg'=>'Versi tidak ditemukan');
				echo json_encode($data);  
				die();
			}
			if(empty($data2['version'])){
				$data = array('ok'=>'error','msg'=>'Versi tidak ditemukan');
				echo json_encode($data);  
				die();
			}
			if($data2['version']==$versi->version){
				$data = array('ok'=>'ook','msg'=>'Sudah versi terbaru.');
				echo json_encode($data);  
				die();
			}
			if($data2['version'] > $versi->version){
				$data = array('ok'=>'error','msg'=>'Versi tidak sesuai');
				echo json_encode($data);  
				die();
			}
			$folder = 'tmp';
			if (is_file($folder)) {
				unlink($folder);
			}
			if (!is_dir('./'.$folder)) {
				mkdir('./'.$folder, 0777, TRUE);
			}
			
			
			$file = './'.$folder.'/'.$versi->file_update;
			$dest = './'.$folder;
			
			$this->unduh->download(array(
			'appid'   => $site_key,
			'user'   => 'mywidget',
			'repo'   => 'app_kasir',
			'file_name' => $versi->file_update,
			'saveAs' => $file
			));
			
			/* Do not edit below this line unless you know what you're doing! */
			
			$zip = new ZipArchive;
			if ($zip->open('./'.$file) === TRUE) {
				// $zip->extractTo('./latest'.$versi->version.'/');
				$zip->extractTo('./');
				$zip->close();
				// unlink($file);
				
				$files = scandir('./');
				$src = './'.$files[2];
				
				recursiveChmod($src, 0777, 0777);
				recursiveDelete($dest);
				moveFiles($src, $dest);
				recursiveDelete($src);
				recursiveChmod($dest, 0777, 0777);
				if (is_file($folder)) {
					unlink($folder);
				}
				if ($this->unduh->get_status()=='ok') {
					$data = array('ok'=>'ok','msg'=>'Update berhasil.');
					file_put_contents('version.json', $result);
					} else {
					$data = array('ok'=>'error','msg'=>'Update gagal.');
				}
				echo json_encode($data);  
			}
		}
		public function unzip(){
			$file = $this->input->post('file');
            ## Extract the zip file ---- start
            $zip = new ZipArchive;
            $res = $zip->open("update/".$file);
            if ($res === TRUE) {
                
                // Unzip path
                $extractpath = "./";
                
                // Extract file
                $zip->extractTo($extractpath);
                $zip->close();
                $data = array('ok'=>'ok','msg'=>'Upload & Extract successfully.');
                
                } else {
                $data = array('ok'=>'error','msg'=>'Failed to extract.');
                
			}
            echo json_encode($data);  
		}
		public  function hapus(){
            $file = $this->input->post('file');
            $path = "./update/".$file;
            if (is_readable($path) && unlink($path)) {
                $data = array('ok'=>'ok','file'=>$file);
                } else {
                $data = array('ok'=>'error','file'=>$file);
			}
            echo json_encode($data);  
		}
		}
	?>	