<?php 
	$coun = count($detail); 
	if($coun==2){
		$top = '6cm';
		}elseif($coun==3){
		$top = '7.5cm';
		}elseif($coun==4){
		$top = '8cm';
		}elseif($coun==5){
		$top = '9.5cm';
		}elseif($coun==6){
		$top = '10cm';
		}elseif($coun==7){
		$top = '11.5cm';
		}elseif($coun==8){
		$top = '12cm';
		}elseif($coun==9){
		$top = '13.5cm';
		}elseif($coun==10){
		$top = '14cm';
		}elseif($coun==11){
		$top = '15.5cm';
		}elseif($coun==12){
		$top = '16cm';
		}else{
		$top = '5cm';
	}
	if($konsumen['no_hp']=='-'){
		$no_hp = '-';
		}else{
		$no_hp = hp_1(hp_2($konsumen['no_hp']));
	}
	if($tdetail == $total->total AND $pajak==0){
		$stamp = $lunas;
		$logo = $logo_lunas;
		$color = $info['warna_lunas'];
		}elseif($tdetail == $total->total AND $pajak>0){
		$stamp = $lunas;
		$logo = $logo_lunas;
		$color = $info['warna_lunas'];
		}elseif($tdetail != $total->total AND $pajak==0){
		$stamp = $blunas;
		$logo = $logo_blunas;
		$color = $info['warna_blunas'];
		}elseif($tdetail != $total->total AND $pajak>0){
		$stamp = $blunas;
		$logo = $logo_blunas;
		$color = $info['warna_blunas'];
		}else{
		$stamp = $blunas;
		$logo = $logo_blunas;
		$color = $info['warna_blunas'];
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cetak Invoice</title>
		<link href="<?= FCPATH; ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<style>
			@page { width:21cm;height:14.8cm;margin: 0.6cm 0.5cm 0.1cm 0.5cm; }
			.invoice-box {
			width:100%;
			margin: auto;
			padding: 10px;
			font-size: 12px;
			line-height: 18px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
			}
			
			.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
			}
			
			.invoice-box table td {
			padding: 0 5px 0 5px;
			vertical-align: top;
			}
			
			.invoice-box table tr td:nth-child(2) {
			
			}
			
			.invoice-box table tr.top table td {
			padding-bottom: 0;
			}
			
			.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
			}
			
			.invoice-box table tr.information table td {
			
			}
			
			.invoice-box table tr.heading td {
			background: <?=$color;?>;
			color: #fff;
			opacity:0.7;
			font-weight: bold;
			padding: 5px;
			}
			
			.invoice-box table tr.details td {
			padding-bottom: 20px;
			}
			
			.invoice-box table tr.item td{
			border-bottom: 1px solid #000;
			
			}
			.invoice-box table tr.kepada td{
			font-weight:bold;
			color: #fff;
			border-bottom:1px dotted #000
			}
			
			.invoice-box table tr.item.last td {
			
			}
			.invoice-box table tr.total{
			font-weight: bold;
			text-align:right;
			}
			.invoice-box table tr.hormat{
			font-weight: bold;
			text-align:left;
			}
			.invoice-box table tr.pelanggan{
			font-weight: bold;
			text-align:center;
			}
			.invoice-box table td.total {
			text-align:right;
			}
			.invoice-box table td.tgl {
			font-weight:bold;
			border-bottom:1px dotted #000;
			}
			.invoice-box table td.tkepada {
			background:<?=$color;?>;
			opacity:0.7;
			width:12%!important
			}
			.invoice-box table tr.kepada td.bawah {
			color:#000;
			width:30%!important
			}
			.invoice-box table td.nomor {
			font-weight:bold;
			}
			.invoice-box table td.total1 {
			border-left:1px solid #000;
			border-top:1px solid #000;
			border-bottom:1px dotted #000;
			}
			.invoice-box table td.total2 {
			border-top:1px solid #000;
			border-right:1px solid #000;
			border-bottom:1px dotted #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.umuka1 {
			border-left:1px solid #000;
			border-bottom:1px dotted #000;
			}.invoice-box table td.umuka2 {
			border-right:1px solid #000;
			border-bottom:1px dotted #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.sisa1 {
			border-left:1px solid #000;
			border-bottom:1px solid #000;
			}
			.invoice-box table td.sisa2 {
			border-right:1px solid #000;
			border-bottom:1px solid #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.ttd {
			border-bottom:1px dotted #000;
			text-align:center;
			font-weight:bold;
			}
			.invoice-box table td.border {
			border-right:1px dotted #000;
			}
			
			
			.invoice-box .table img{
			position: fixed;
			z-index:-1000;
			}
			.watermark{
			top:<?=$top;?>;
			right:4cm;
			width:    4.5cm;
			height:   auto;
			opacity:0.2;
			z-index:-1
			
			/** Your watermark should be behind every content**/
            }
			.sosmed{font-size:10pt;}
		</style>
		<?php if($html=="Y"){ ?>
		<style>
		@media print {
         .invoice-box {
			width:100%;
			margin: auto;
			padding: 10px;
			font-size: 12px;
			line-height: 18px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
			}
			
			.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
			}
			
			.invoice-box table td {
			padding: 0 5px 0 5px;
			vertical-align: top;
			}
			
			.invoice-box table tr td:nth-child(2) {
			
			}
			
			.invoice-box table tr.top table td {
			padding-bottom: 0;
			}
			
			.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
			}
			
			.invoice-box table tr.information table td {
			
			}
			
			.invoice-box table tr.heading td {
			background: #<?=$color;?>;
			color: #fff;
			opacity:0.7;
			font-weight: bold;
			padding: 5px;
			}
			
			.invoice-box table tr.details td {
			padding-bottom: 20px;
			}
			
			.invoice-box table tr.item td{
			border-bottom: 1px solid #000;
			
			}
			.invoice-box table tr.kepada td{
			font-weight:bold;
			color: #fff;
			border-bottom:1px dotted #000
			}
			
			.invoice-box table tr.item.last td {
			
			}
			.invoice-box table tr.total{
			font-weight: bold;
			text-align:right;
			}
			.invoice-box table tr.hormat{
			font-weight: bold;
			text-align:left;
			}
			.invoice-box table tr.pelanggan{
			font-weight: bold;
			text-align:center;
			}
			.invoice-box table td.total {
			text-align:right;
			}
			.invoice-box table td.tgl {
			font-weight:bold;
			border-bottom:1px dotted #000;
			}
			.invoice-box table td.tkepada {
			background:#<?=$color;?>;
			opacity:0.7;
			width:12%!important
			}
			.invoice-box table tr.kepada td.bawah {
			color:#000;
			width:30%!important
			}
			.invoice-box table td.nomor {
			font-weight:bold;
			}
			.invoice-box table td.total1 {
			border-left:1px solid #000;
			border-top:1px solid #000;
			border-bottom:1px dotted #000;
			}
			.invoice-box table td.total2 {
			border-top:1px solid #000;
			border-right:1px solid #000;
			border-bottom:1px dotted #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.umuka1 {
			border-left:1px solid #000;
			border-bottom:1px dotted #000;
			}.invoice-box table td.umuka2 {
			border-right:1px solid #000;
			border-bottom:1px dotted #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.sisa1 {
			border-left:1px solid #000;
			border-bottom:1px solid #000;
			}
			.invoice-box table td.sisa2 {
			border-right:1px solid #000;
			border-bottom:1px solid #000;
			text-align:right;
			font-weight:bold;
			}
			.invoice-box table td.ttd {
			border-bottom:1px dotted #000;
			text-align:center;
			font-weight:bold;
			}
			.invoice-box table td.border {
			border-right:1px dotted #000;
			}
			
			
			.invoice-box .table img{
			position: fixed;
			z-index:-1000;
			}
			.watermark{
			top:<?=$top;?>;
			right:4cm;
			width:    4.5cm;
			height:   auto;
			opacity:0.2;
			z-index:-1
			
			/** Your watermark should be behind every content**/
            }
			.sosmed{font-size:10pt;}
      }
		</style>
		<script type="text/javascript">
			<!--
			window.print();
			window.onfocus=function(){ window.close();}
			//-->
		</script>
		<?php } ?>
	</head>
	
	<body>
		<?php
			// echo $total->total;
			// echo "<br>";
			// echo $cdiskon;
			// print_r($bdetail);
		?>
		<div class="invoice-box">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="4" rowspan="5"><img src="<?=$logo;?>" style="width:420px;"></td>
					<td colspan="4" rowspan="6">&nbsp;</td>
					<td colspan="2" class="tgl">Serang, <?=tgl_indo($cetak['tgl_trx']);?></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">Kepada Yth.</td>
					<td class="bawah"><?=$konsumen['nama'];?></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">Perusahaan</td>
					<td class="bawah"><?=$konsumen['perusahaan'];?></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">Telp</td>
					<td class="bawah"><?=$no_hp;?></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">Alamat</td>
					<td class="bawah"><?=$konsumen['alamat'];?></td>
				</tr>
				<tr>
					<td colspan="4"><i style="margin-top:2px" class="fa fa-whatsapp"></i>&nbsp;<span class="sosmed"><?=$info['phone'];?></span> <i style="margin-top:2px" class="fa fa-envelope-square"></i>&nbsp;<span class="sosmed"><?=$info['email'];?></span> <i style="margin-top:2px" class="fa fa-facebook-square"></i>&nbsp;<span class="sosmed"><?=$info['fb'];?></span>&nbsp;<i style="margin-top:2px" class="fa fa-instagram"></i>&nbsp;<span class="sosmed"><?=$info['ig'];?></span></td>
					<td colspan="2" class="nomor">NO. ORDER #<?=$cetak['id_invoice'];?></td>
				</tr>
			</table>
			<table style="width:100%;margin-top:5px" cellpadding="0" cellspacing="0">
				<tr class="heading">
					<td align="center" style="width:5%!important">Banyaknya</td>
					<td style="width:15%!important">Jenis Barang</td>
					<td style="width:15%!important">Bahan</td>
					<td>Keterangan</td>
					<td align="center" style="width:10%!important">Ukuran</td>
					<td style="width:15%!important;text-align:right">Harga</td>
					<?php if($cdiskon>0){ ?>
						<td style="width:5%!important;text-align:right">Disc%</td>
					<?php } ?>
					<td class="total" style="width:16%!important">Total harga</td>
				</tr>
				<?php 
					$no=1; 
					$totalb=0; 
					$subtotal=0; 
					$sisa=0; 
					$diskon=0; 
					foreach($detail  AS $val){
						$diskon = $val['jumlah'] * $val['harga'] * $val['diskon']/100;
						$totalb = $val['jumlah'] * $val['harga'] - $diskon;
						$subtotal += $totalb;
						$ukuran = '';
						if($val['ukuran']!=''){
							$ukuran = $val['ukuran'].' '.$val['satuan'];
						}
					?>
					<tr class="item">
						<td align="center" class="border"><?=$val['jumlah'];?></td>
						<td class="border"><?=$val['title'];?></td>
						<td class="border"><?=$val['nbahan'];?></td>
						<td class="border"><?=$val['keterangan'];?></td>
						<td class="border" align="center"><?=$ukuran;?></td>
						<td class="border" align="right"><?=rp($val['harga']);?></td>
						<?php if($cdiskon>0){ ?>
							<td class="border" align="right"><?=rp($val['diskon']);?></td>
						<?php } ?>
						<td class="total"><?=rp($totalb);?></td>
					</tr>
					<?php $no++; } 
					$pajak = ($subtotal * $cetak['pajak']) /100;
					$sisa = $pajak + $subtotal - $total->total;
					$cek_bayar = $pajak + $subtotal;
				?>
				
			</table>
			<?php
				// if($sisa==0){
				// $stamp = $lunas;
				// }else{
				// $stamp = $blunas;
				// }
			?>
			<table class="table" style="width:100%;margin-top:10px" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" style="width:20%!important">HORMAT KAMI</td>
					<td>&nbsp;</td>
					<td align="center" style="width:20%!important">PEMESAN</td>
					<td>&nbsp;</td>
					<td class="total1" style="width:12%">Total</td>
					<td class="total2" style="width:19%"><?=rp($subtotal);?></td>
				</tr>
				
				<?php if($cetak['pajak'] >0){?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="umuka1">Pajak <?=$cetak['pajak'];?>%</td>
						<td class="umuka2"><?=rp($pajak);?></td>
					</tr>
				<?php } ?>
				<?php 
					$urutan  =0;
					$numItems = count($bdetail);
					$i = 0;
					foreach($bdetail AS $val){
						if($sisa==0 AND $cdetail==1 AND $val['jml_bayar']==$cek_bayar){
							echo '<tr>
							<td><img class="watermark" src="'.$stamp.'" width="100px"/></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="umuka1">Bayar</td>
							<td class="umuka2">'.rp($total->total).'</td>
							</tr>';
							}elseif($sisa >0 AND $cdetail >=1 AND $val['jml_bayar']!=$cek_bayar){
							echo '<tr>
							<td><img class="watermark" src="'.$stamp.'" width="100px"/></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="umuka1">DP 1</td>
							<td class="umuka2">'.rp($total->total).'</td>
							</tr>';
							}else{
							echo '<tr>
							<td><img class="watermark" src="'.$stamp.'" width="100px"/></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>';
							if($cdetail >1 AND $total->total!=$cek_bayar){
								echo '<td class="umuka1">DP '.$numItems.'</td>';
								}elseif($cdetail >1 AND $total->total==$cek_bayar){
								if(++$i === $numItems) {
									echo '<td class="umuka1">Pelunasan</td>';
									}else{
									echo '<td class="umuka1">DP</td>';
								}
								}else{
								echo '<td class="umuka1">Pelunasan</td>';
							}
							echo '<td class="umuka2">'.rp($val['jml_bayar']).'</td>
							</tr>';
						}
					}
				?>
				
				<tr>
					<td class="ttd"><?=$marketing['nama_lengkap'];?></td>
					<td>&nbsp;</td>
					<td class="ttd"><?=$konsumen['nama'];?></td>
					<td>&nbsp;</td>
					<?php if($sisa >0){ ?>
						<td class="sisa1">Sisa</td>
						<td class="sisa2"><?=rp($sisa);?></td>
						<?php }else{ ?>
						<td class="sisa1">&nbsp;</td>
						<td class="sisa2">&nbsp;</td>
					<?php } ?>
				</tr>
			</table>
			
			<table width="100%">
				<tr>
					<td class="title" style="width:70%!important;font-weight:bold">
						Cara Bayar : <?php if($total->total!=0){ if(isset($cara)){ echo strtoupper($cara->cara_bayar);}} ?>
					</td>
					<td align="center" style="font-size:6pt">
						dicetak pada <?=dtimes(date('Y-m-d H:i:s'));?> | <?php if(isset($cara)){ 
						echo $cara->cetak;} ?><br>
					</td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td style="font-size:8pt;line-height:6pt;width:70%!important;">Pembayaran Transfer Via Rekening</td>
					<td rowspan="2" align="center" style="font-size:6pt;width:30%!important;line-height:6pt">Menunda nunda pembayaran hutang oleh orang mampu<br>
					merupakan suatu kedzaliman | H.T. Abu Daud |</td>
				</tr>
				<tr>
					<td style="font-size:8pt;line-height:8pt"><?php foreach($bank AS $val){
						echo $val['slug'].' a.n '.$val['pemilik'].' <b>'.$val['no_rek'].'</b>&nbsp;';
					} ?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
