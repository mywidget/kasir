<?php
	class Core {
		function checkEmpty($data)
		{
			if(!empty($data['hostname']) && !empty($data['username']) && !empty($data['database']) && !empty($data['url']) && !empty($data['template'])){
				return true;
				}else{
				return false;
			}
		}
		
		function show_message($type,$message) {
			return $message;
		}
		
		function getAllData($data) {
			return $data;
		}
		
		function write_db_config($data) {
			
			if($data['template'] == 2){
				$template_path 	= 'includes/templatevtwo.php';
				}else if($data['template'] == 3){
				$template_path 	= 'includes/templatevthree.php';
			}
			
			
			$output_path 	= '../application/config/database.php';
			
			$database_file = file_get_contents($template_path);
			
			$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
			$new  = str_replace("%USERNAME%",$data['username'],$new);
			$new  = str_replace("%PASSWORD%",$data['password'],$new);
			$new  = str_replace("%DATABASE%",$data['database'],$new);
			
			$handle = fopen($output_path,'w+');
			@chmod($output_path,0777);
			
			if(is_writable(dirname($output_path))) {
				
				if(fwrite($handle,$new)) {
					return true;
					} else {
					return false;
				}
				} else {
				return false;
			}
		}
		
		function write_config($data) {
			
			
			$template_path 	= 'includes/config.php';
			
			$output_path 	= '../application/config/config.php';
			
			$config_file = file_get_contents($template_path);
			
			$new  = str_replace("%BASE_URL%", $data['url'] ,$config_file);
			
			
			$handle = fopen($output_path,'w+');
			@chmod($output_path,0777);
			
			if(is_writable(dirname($output_path))) {
				
				if(fwrite($handle,$new)) {
					return true;
					} else {
					return false;
				}
				} else {
				return false;
			}
		}
		function write_routes() {
			$template_path 	= 'includes/routes.php';
			
			$output_path 	= '../application/config/routes.php';
			
			$config_file = file_get_contents($template_path);
			
			$new  = str_replace("%ROUTES%", 'dashboard' ,$config_file);
			
			
			$handle = fopen($output_path,'w+');
			@chmod($output_path,0777);
			
			if(is_writable(dirname($output_path))) {
				
				if(fwrite($handle,$new)) {
					return true;
					} else {
					return false;
				}
				} else {
				return false;
			}
		}
		
		function write_autoload() {
			$source 	= 'includes/autoload.php';
			$destination 	= '../application/config/autoload.php';
			if( !copy($source, $destination) ) {
				return false;
			} 
			else { 
				return true;
			} 
		}  
		function hapus_welcome(){
			$welcome = '../application/controllers/Welcome.php';
			if (file_exists($welcome))
			{
				if (!unlink($welcome)) { 
					return false;
				} 
				else { 
					return true;
				} 
				}else{
				return true;
			}
		}
		function rename_htacess(){
			$oldname = '../htaccess';
			$newname = '../.htaccess';
			
			if ( ! file_exists($newname))
			{
				if (rename($oldname, $newname)) {
					return true;
					} else {
					return false;
				}
				}else{
				return true;
			}
		}
		function checkFile(){
			$output_path = '../application/config/database.php';
			
			if (file_exists($output_path)) {
				return true;
			} 
			else{
				return false;
			}
		}
	}													