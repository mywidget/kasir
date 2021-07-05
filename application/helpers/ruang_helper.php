<?php 
    function curl(){
   $siteaddr = base_url()."assets/setting.json";
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $siteaddr);
        // Execute
        $output = curl_exec($ch);
        $output = json_decode($output);
        curl_close($ch);
        return $output;
    }
    function curl2($url){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch); 
        curl_close($ch);      
        return $output;
    }
    function hp_1($handphone) {
        $jumlah_digit_handphone = strlen(substr($handphone, 3));
        // nomor handphone yang ditampilkan jika berjumlah 9 digit
        if ($jumlah_digit_handphone == 9) {
            $tampil_handphone = "+62 " . substr($handphone, 3, 3) . "-" . substr($handphone, 6, 3) . "-" . substr($handphone, 9, 3);
        }
        // nomor handphone yang ditampilkan jika berjumlah 10 digit
        if ($jumlah_digit_handphone == 10) {
            $tampil_handphone = "+62 " . substr($handphone, 3, 3) . "-" . substr($handphone, 6, 4) . "-" . substr($handphone, 10, 3);
        }
        // nomor handphone yang ditampilkan jika berjumlah 11 digit
        if ($jumlah_digit_handphone == 11) {
            $tampil_handphone = "+62 " . substr($handphone, 3, 3) . "-" . substr($handphone, 6, 4) . "-" . substr($handphone, 10, 4);
        }
        // nomor handphone yang ditampilkan jika berjumlah 12 digit
        if ($jumlah_digit_handphone == 12) {
            $tampil_handphone = "+62 " . substr($handphone, 3, 3) . "-" . substr($handphone, 6, 4) . "-" . substr($handphone, 10, 5);
        }
        return $tampil_handphone;
    }
    function hp_2($nohp) {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ","",$nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(","",$nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")","",$nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".","",$nohp);
        $nohp = str_replace("-","",$nohp);
        
        // cek apakah no hp mengandung karakter + dan 0-9
        if(!preg_match('/[^+0-9]/',trim($nohp))){
            // cek apakah no hp karakter 1-3 adalah +62
            if(substr(trim($nohp), 0, 3)=='+62'){
                $nohp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif(substr(trim($nohp), 0, 1)=='0'){
                $nohp = '+62'.substr(trim($nohp), 1);
            }
        }
        return $nohp;
    }
    function hp_3($nohp) {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ","",$nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(","",$nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")","",$nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".","",$nohp);
        // kadang ada penulisan no hp 0811-239-345
        $nohp = str_replace("-","",$nohp);
        $nohp = str_replace("+","",$nohp);
        
        // cek apakah no hp mengandung karakter + dan 0-9
        if(!preg_match('/[^+0-9]/',trim($nohp))){
            // cek apakah no hp karakter 1-3 adalah +62
            if(substr(trim($nohp), 0, 2)=='62'){
                // $hp = trim($nohp);
                $hp = substr_replace($nohp,'0',0,2);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif(substr(trim($nohp), 0, 1)=='0'){
                $hp = '0'.substr(trim($nohp), 1);
            }
        }
        return $hp;
    }
    function clean($text){
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($text)));
        return $text;
    }
    
    function kata($string, $limit, $break=" ", $pad="...") {
        // return with no change if string is shorter than $limit 
        if(strlen($string) <= $limit) 
        return $string; 
        $string = substr($string, 0, $limit); 
        if(false !== ($breakpoint = strrpos($string, $break))) { 
        $string = substr($string, 0, $breakpoint); } 
        return $string . $pad; 
    }
    function cetak($str){
        return strip_tags(htmlentities($str, ENT_QUOTES, 'UTF-8'));
    }
    
    function cetak_meta($str,$mulai,$selesai){
        return strip_tags(html_entity_decode(substr(str_replace('"','',$str),$mulai,$selesai), ENT_COMPAT, 'UTF-8'));
    }
    
    function sensor($teks){
        $ci = & get_instance();
        $query = $ci->db->query("SELECT * FROM katajelek");
        foreach ($query->result_array() as $r) {
            $teks = str_replace($r['kata'], $r['ganti'], $teks);       
        }
        return $teks;
    }  
    
    function getSearchTermToBold($text, $words){
        preg_match_all('~[A-Za-z0-9_äöüÄÖÜ]+~', $words, $m);
        if (!$m)
        return $text;
        $re = '~(' . implode('|', $m[0]) . ')~i';
        return preg_replace($re, '<b style="color:red">$0</b>', $text);
    }
    
    function tgl_indo($tgl){
        $tanggal = substr($tgl,8,2);
        $bulan = getBulan(substr($tgl,5,2));
        $tahun = substr($tgl,0,4);
        return $tanggal.' '.$bulan.' '.$tahun;       
    } 
    
    function tgl_simpan($tgl){
        $tanggal = substr($tgl,0,2);
        $bulan = substr($tgl,3,2);
        $tahun = substr($tgl,6,4);
        return $tahun.'-'.$bulan.'-'.$tanggal;       
    }
	function tgl_ambil_1($tglp){
        $tgl_post = date('Y-m-d',strtotime($tglp));
        return $tgl_post;		 
    }
	function tgl_ambil($tglp){
        $tgl_post = date('d/m/Y',strtotime($tglp));
        return $tgl_post;		 
    }
    function tgl_view($tgl){
        $tanggal = substr($tgl,8,2);
        $bulan = substr($tgl,5,2);
        $tahun = substr($tgl,0,4);
        return $tanggal.'-'.$bulan.'-'.$tahun;       
    }
    
    function tgl_grafik($tgl){
        $tanggal = substr($tgl,8,2);
        $bulan = getBulan(substr($tgl,5,2));
        $tahun = substr($tgl,0,4);
        return $tanggal.'_'.$bulan;       
    }   
    
    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    } 
    
    function seo_title($s) {
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
        $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
        return $s;
    }
    
    function date_sl($date){
        $date = DateTime::createFromFormat('d/m/Y', $date);
        $date = $date->format('Y-m-d');
        return $date;
    }
    function date_sll($date){
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('d/m/Y');
        return $date;
    }
    function hari_ini($w){
        $seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $hari_ini = $seminggu[$w];
        return $hari_ini;
    }
    function xhari($tgl){
        $tanggal 	= strtotime($tgl);
		$hari_arr 	= Array ('0'=>'Minggu',
        '1'=>'Senin',
        '2'=>'Selasa',
        '3'=>'Rabu',
        '4'=>'Kamis',
        '5'=>'Jum`at',
        '6'=>'Sabtu'
        );
		$hari 	= @$hari_arr[date('w',$tanggal)];
        return $hari;	
    }
    function dtimes($tgl,$Jam=true,$Wib=true){
        $tanggal 	= strtotime($tgl);
        $hari_arr 	= Array (	'0'=>'Minggu',
        '1'=>'Senin',
        '2'=>'Selasa',
        '3'=>'Rabu',
        '4'=>'Kamis',
        '5'=>'Jum`at',
        '6'=>'Sabtu'
        );
		$hari 	= @$hari_arr[date('w',$tanggal)];
		$tggl 	= date('j',$tanggal);
		$bln 	= date('m',$tanggal);
		$thn 	= date('Y',$tanggal);
		$jam 	= $Jam ? date ('H:i',$tanggal) : '';
		$wib	= $Wib ? 'WIB' :'';
		return "$hari, $tggl/$bln/$thn $jam $wib";	
        
    }
    function dtime($tgl){
        $tanggal 	= strtotime($tgl);
        $hari_arr 	= Array (	'0'=>'Minggu',
        '1'=>'Senin',
        '2'=>'Selasa',
        '3'=>'Rabu',
        '4'=>'Kamis',
        '5'=>'Jum`at',
        '6'=>'Sabtu'
        );
		$hari 	= @$hari_arr[date('w',$tanggal)];
		$tggl 	= date('j',$tanggal);
		$bln 	= date('m',$tanggal);
		$thn 	= date('Y',$tanggal);
		return "$hari, $tggl/$bln/$thn";	
        
    }
	function jam_ambil($jam){
        $jam_post = date('H:i',strtotime($jam));
        return $jam_post;		 
    }
	
    function getBulan($bln){
        switch ($bln){
            case 1: 
            return "Januari";
            break;
            case 2:
            return "Februari";
            break;
            case 3:
            return "Maret";
            break;
            case 4:
            return "April";
            break;
            case 5:
            return "Mei";
            break;
            case 6:
            return "Juni";
            break;
            case 7:
            return "Juli";
            break;
            case 8:
            return "Agustus";
            break;
            case 9:
            return "September";
            break;
            case 10:
            return "Oktober";
            break;
            case 11:
            return "November";
            break;
            case 12:
            return "Desember";
            break;
        }
    } 
    function getBlnAgenda($bln){
        switch ($bln){
            case 1: 
            return "Jan";
            break;
            case 2:
            return "Feb";
            break;
            case 3:
            return "Mar";
            break;
            case 4:
            return "Apr";
            break;
            case 5:
            return "Mei";
            break;
            case 6:
            return "Jun";
            break;
            case 7:
            return "Jul";
            break;
            case 8:
            return "Agu";
            break;
            case 9:
            return "Sep";
            break;
            case 10:
            return "Okt";
            break;
            case 11:
            return "Nov";
            break;
            case 12:
            return "Des";
            break;
        }
    } 
    
    function cek_terakhir($datetime, $full = false) {
        $today = time();    
        $createdday= strtotime($datetime); 
        $datediff = abs($today - $createdday);  
        $difftext="";  
        $years = floor($datediff / (365*60*60*24));  
        $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
        $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
        $hours= floor($datediff/3600);  
        $minutes= floor($datediff/60);  
        $seconds= floor($datediff);  
        //year checker  
        if($difftext=="")  
        {  
            if($years>1)  
            $difftext=$years." Tahun";  
            elseif($years==1)  
            $difftext=$years." Tahun";  
        }  
        //month checker  
        if($difftext=="")  
        {  
            if($months>1)  
            $difftext=$months." Bulan";  
            elseif($months==1)  
            $difftext=$months." Bulan";  
        }  
        //month checker  
        if($difftext=="")  
        {  
            if($days>1)  
            $difftext=$days." Hari";  
            elseif($days==1)  
            $difftext=$days." Hari";  
        }  
        //hour checker  
        if($difftext=="")  
        {  
            if($hours>1)  
            $difftext=$hours." Jam";  
            elseif($hours==1)  
            $difftext=$hours." Jam";  
        }  
        //minutes checker  
        if($difftext=="")  
        {  
            if($minutes>1)  
            $difftext=$minutes." Menit";  
            elseif($minutes==1)  
            $difftext=$minutes." Menit";  
        }  
        //seconds checker  
        if($difftext=="")  
        {  
            if($seconds>1)  
            $difftext=$seconds." Detik";  
            elseif($seconds==1)  
            $difftext=$seconds." Detik";  
        }  
        return $difftext;  
    }
    function getYEmbedUrl($url){
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
        
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        
        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id ;
    }
    function format_size($size) {
        $mod = 1024;
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
    function folderSize ($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : folderSize($each);
        }
        return $size;
    }
    function thumb($path,$fullname, $width, $height)
    {
        // Path to image thumbnail in your root
        $dir = $path;
        $url = base_url() . $path;
        // Get the CodeIgniter super object
        $CI = &get_instance();
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION);
        $filename = pathinfo($fullname, PATHINFO_FILENAME);
        $image_org = $dir . $filename . "." . $extension;
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;
        
        if (!file_exists($image_thumb)) {
            // LOAD LIBRARY
            $CI->load->library('image_lib');
            // CONFIGURE IMAGE LIBRARY
            $config['source_image'] = $image_org;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
        }
        return $image_returned;
    }
    function potdesc($text,$jml){
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($text)));
        //$kalimat = strip_tags($text); // membuat paragraf pada isi berita dan mengabaikan tag html
        $text = substr($text,0,$jml); // ambil sebanyak 200 karakter
        $text = substr($text,0,strrpos($text," ")); // potong per spasi kalimat
        return $text;
    }
    
    function strip_word_html($text, $allowed_tags = '')
    {
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u', '/&ndash;/u', '/&quot;/u', '/ndash/u' );
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        //$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if(mb_stripos($text, '/*') !== FALSE){
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if($num_matches){
            $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        $text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
        return $text;
    }
    function rp($angka){
        $konversi = number_format($angka, 0, ',', '.');
        return $konversi;
    }
    function image_count($directory) {
		$count = count(glob("./$directory/*.*"));
        return $count;
    }
    
	function dir_size($directory) {
        $size = 0;
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
            $size += $file->getSize();
        }
        return $size;
    }
	function getDataURI($imagePath) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($imagePath);
        return 'data:'.$type.';base64,'.base64_encode(file_get_contents($imagePath));
    }    
    
    function recursiveChmod($path, $filePerm=0644, $dirPerm=0755){
        if(!file_exists($path)){
            return false;
        }
        if(is_file($path)){
            chmod($path, $filePerm);
            } elseif(is_dir($path)) {
            $foldersAndFiles = scandir($path);
            $entries = array_slice($foldersAndFiles, 2);
            foreach($entries as $entry){
                recursiveChmod($path."/".$entry, $filePerm, $dirPerm);
            }
            chmod($path, $dirPerm);
        }
        return true;
    }
    function recursiveDelete($directory, $empty=false) {
        if(substr($directory,-1) == '/'){
            $directory = substr($directory,0,-1);
        }
        if(!file_exists($directory) || !is_dir($directory)){
            return false;
            } elseif(is_readable($directory)){
            $handle = opendir($directory);
            while (false !== ($item = readdir($handle))) {
                if($item != '.' && $item != '..') {
                    $path = $directory.'/'.$item;
                    if(is_dir($path)) {
                        recursiveDelete($path);
                        }else{
                        unlink($path);
                    }
                }
            }
            closedir($handle);
            if($empty == false) {
                if(!rmdir($directory)) {
                    return false;
                }
            }
        }
        return true;
    }
    function moveFiles($src, $dst){
        if (file_exists ( $dst )){
            recursiveDelete( $dst );
        }
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file ){
                if ($file != "." && $file != ".."){
                    moveFiles( "$src/$file", "$dst/$file" );
                }
            }
            } elseif (file_exists ( $src )){
            copy ( $src, $dst );
        }
    }            