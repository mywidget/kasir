<?php if(! defined('BASEPATH')) exit ('no direct access allowed');
    
    class Backup extends CI_controller{
        
        public function __construct()
		{
			parent::__construct();
			cek_session_login();
            $this->load->helper('directory');
            $this->load->helper("file");
            $this->load->helper('date');
        }
		
        public function index()
		{
			// cek_menu_akses();
			$data['title'] = 'Backup db';
			$this->template->load('main/themes','backup',$data);
        }
        public function list_data()
		{
            
            $fetch_data = directory_map('./backup/', FALSE, TRUE); 
            $data = array();  
            $no=1;
            foreach($fetch_data as $row)  
            {  
                $dname = explode(".", $row);
                $ext = end($dname);
                $exp = explode('_',$row);
                if($ext=='sql'){
                $resto = '';
                $archive ='<button type="button" class="btn btn-primary btn-sm restoredb" data-toggle="tooltip" title="Restore DB" data-file="'.$row.'"><i class="fa fa-retweet"></i></button>';
                }else{
                $resto = "";
                $archive = '<button type="button" class="btn btn-danger btn-sm unzipdb" data-toggle="tooltip" title="Unzip DB" data-file="'.$row.'"><i class="fa fa-archive "></i></button>';
                }
                if($exp[1]==date('Y-m-d')){
                    $btn = '<a href="'.base_url().'backup/'.$row.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="Download"><i class="fa fa-download"></i></a> '.$archive;
                    }else{
                    $btn = '<a href="backup/'.$row.'" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download"><i class="fa fa-download"></i></a> '.$archive;
                }
                
                $tgl = tgl_indo($exp[1],false);
                $sub_array = array();
                $sub_array[] = $row;   
                $sub_array[] = $tgl;  
                $sub_array[] = $btn;   
                $sub_array[] = '<button type="button" class="btn btn-danger btn-sm hapus" data-toggle="tooltip" title="Hapus DB" data-file="'.$row.'"><i class="fa fa-trash"></i></button>';  
                $data[] = $sub_array;  
            }  
            $output = array(   
            "data" => $data  
            );  
            echo json_encode($output);  
			
        }
        public  function hapusdb(){
            $file = $this->input->post('file');
            $path = "./backup/".$file;
            if (is_readable($path) && unlink($path)) {
                $data = array('ok'=>'ok','file'=>$file);
                } else {
                $data = array('ok'=>'error','file'=>$file);
            }
            echo json_encode($data);  
        }
        public  function backupdb(){
            // Load Clas Utilitas Database
            $this->load->dbutil();
            
            // nyiapin aturan untuk file backup
            $aturan = array(    
            'format'      => 'zip',            
            'filename'    => 'backup-on_'. date("Y-m-d_H-i-s") .'.sql'
            );
            
            // $backup =& $this->dbutil->backup($aturan);
            $backup = $this->dbutil->backup($aturan);
            
            $nama_database = 'backup-on_'. date("Y-m-d_H-i-s") .'.zip';
            $simpan = 'backup/'.$nama_database;
            
            $this->load->helper('file');
            write_file($simpan, $backup);
            
            if (is_readable($simpan)) {
                echo "ok";
                } else {
                echo "error";
            }
            
            // $this->load->helper('download');
            // force_download($nama_database, $backup);
        }
        function unzipdb(){
            $file = $this->input->post('file');
            ## Extract the zip file ---- start
            $zip = new ZipArchive;
            $res = $zip->open("backup/".$file);
            if ($res === TRUE) {
                
                // Unzip path
                $extractpath = "backup/";
                
                // Extract file
                $zip->extractTo($extractpath);
                $zip->close();
                $data = array('ok'=>'ok','msg'=>'Extract successfully.');
                
                } else {
                $data = array('ok'=>'error','msg'=>'Failed to extract.');
                
            }
            echo json_encode($data);  
            ## ---- end
        }
        function restoredb()
        {
            $file = $this->input->post('file');
            $isi_file = file_get_contents('./backup/'.$file);
            $string_query = rtrim( $isi_file, "\n;");
            $array_query = explode(";", $string_query);
            // print_r($array_query);
            foreach($array_query as $query)
            {
                $res = $this->db->query($query);
            }
            if ($res) {
                $data = array('ok'=>'ok','msg'=>'Database Restore successfully.');
                }else{
                $data = array('ok'=>'ok','msg'=>'Failed to Restore.');
            }
            echo json_encode($data);  
        }
    }                        