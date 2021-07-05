<?php
	// print_r($load);
$no=1;
	foreach($load->result_array() as $val){
		echo '<label>Rp. '.rp($val['jml_bayar']).'&nbsp;</label>&nbsp;';
	$no++; }		