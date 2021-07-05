<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Unduh {
		private $status; 
        private function exec_redirects($ch, &$redirects, $die=false) {
            $data = curl_exec($ch);
            
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == 301 || $http_code == 302) {
                list($header) = explode("\r\n\r\n", $data, 2);
                
                $matches = array();
                preg_match("/(Location:|URI:)[^(\n)]*/", $header, $matches);
                $url = trim(str_replace($matches[1], "", $matches[0]));
                
                $url_parsed = parse_url($url);
                if (isset($url_parsed)) {
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $redirects++;
                    return $this->exec_redirects($ch, $redirects, true);
				}
			}
            
            list(, $body) = explode("\r\n\r\n", $data, 2);
            return $body;
		}
        
        public function download($opts){
            extract($opts);
            
            $file = $saveAs;
            $endpoint ="https://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@raw.githubusercontent.com/{$user}/{$repo}/main/version/{$file_name}";
            
            $ch = curl_init($endpoint); 
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $data = $this->exec_redirects($ch, $out); 
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $h = fopen($file, "w+");
            fwrite($h, $data);
            fclose($h);
			
            if($statusCode == 200){
                $this->status = "ok";  
                } else{
                $this->status = "Status Code: " . $statusCode;
			}
		}
        function get_status() {
			return $this->status;
		}
	}	