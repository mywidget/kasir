<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cetak Uang Masuk</title>
		<link href="<?= FCPATH; ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<style>
			@page { width:21cm;height:14.8cm;margin: 0.6cm 0.5cm 0.1cm 0.5cm; }
			.invoice-box {
			width:100%;
			margin: auto;
			padding: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
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
			background: <?=$info['warna_lunas'];?>;
			color: #fff;
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
			border-bottom:1px dotted #000;
			font-weight:bold;
			}
			.invoice-box table td.tkepada {
			background:<?=$info['warna_lunas'];?>;
			width:12%!important
			}
			.invoice-box table tr.kepada td.bawah {
			color:#000;
			width:30%!important
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
			right:4cm;
			width:    4.5cm;
			height:   auto;
			opacity:0.2;
			z-index:-1
			
			/** Your watermark should be behind every content**/
            }
			
		</style>
	</head>
	
	<body>
		<?php
			// print_r($detail);
		?>
		<div class="invoice-box">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3" rowspan="5"><img src="<?=$logo;?>" style="width:100%; max-width:350px;"></td>
					<td colspan="2" class="tgl">REKAP UANG MASUK</td>
				</tr>
				<tr class="">
					<td colspan="2">Serang, <?=tgl_indo(date('Y-m-d'));?></td>
				</tr>
				<tr class="">
					<td colspan="2"></td>
				</tr>
				<tr class="kepada">
					<td class="tkepada">KASIR</td>
					<td class="bawah"><?=$user['nama_lengkap'];?></td>
				</tr>
				<tr class="">
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="4"><i style="margin-top:2px" class="fa fa-whatsapp"></i>&nbsp;<span class="sosmed"><?=$info['phone'];?></span> <i style="margin-top:2px" class="fa fa-envelope-square"></i>&nbsp;<span class="sosmed"><?=$info['email'];?></span> <i style="margin-top:2px" class="fa fa-facebook-square"></i>&nbsp;<span class="sosmed"><?=$info['fb'];?></span>&nbsp;<i style="margin-top:2px" class="fa fa-instagram"></i>&nbsp;<span class="sosmed"><?=$info['ig'];?></span></td>
					<td colspan="2"></td>
				</tr>
			</table>
			<table style="width:100%;margin-top:5px" cellpadding="0" cellspacing="0">
				<tr class="heading">
					<td style="width:3%!important" class="text-right">No.</td>
					<td style="width:5%!important" class="text-right">ID_Order</td>
					<td class="total">Tgl. Transaksi</td>
					<td class="total">Nama Konsumen</td>
					<td class="total">Tgl. Bayar</td>
					<td class="total">Keterangan</td>
					<td class="total" style="width:16%!important">Jml. Bayar</td>
				</tr>
				<?php 
					$no=1; 
					$totsetors = 0;
					$totsetor = 0;
					foreach($detail  AS $rows){
						$databayar = $this->db->query("SELECT 
						`bayar_invoice_detail`.`id_invoice`,
						`konsumen`.`nama`,
						`invoice`.`tgl_trx`,
						`bayar_invoice_detail`.`tgl_bayar`,
						`bayar_invoice_detail`.`jml_bayar`,
						`cara_bayar`.`cara_bayar`,
						`bayar_invoice_detail`.`id`,
						`bayar_invoice_detail`.`id_byr`
						FROM
						`invoice`
						RIGHT OUTER JOIN `bayar_invoice_detail` ON (`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`)
						INNER JOIN `cara_bayar` ON (`bayar_invoice_detail`.`id_byr` = `cara_bayar`.`id_byr`)
						INNER JOIN `konsumen` ON (`invoice`.`id_konsumen` = `konsumen`.`id`)
						WHERE  `bayar_invoice_detail`.id_byr='$rows[id_byr]' $and
						ORDER BY
						`bayar_invoice_detail`.`id`");
						foreach($databayar->result_array() AS $row){
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td>#<?php echo $row['id_invoice'];?></td>
							<td class="total"><?php echo dtimes($row['tgl_trx'],false,false);?></td>
							<td class="total"><?php echo $row['nama'];?></td>
							<td class="total"><?php echo dtimes($row['tgl_bayar'],false,false);?></td>
							<td class="total"><?php echo $row['cara_bayar'];?></td>
							<td class="total"><?php echo rp($row['jml_bayar']);?></td>
						</tr>
						<?php 
							$totsetor = $totsetor + $row['jml_bayar'];
							$totsetors +=  $row['jml_bayar'];
						$no++; } 
					} 
					
				?>
				
			</table>
			<table class="table" style="width:100%;margin-top:10px" cellpadding="0" cellspacing="0">
				<tr>
					
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="total1" style="width:12%">Total</td>
					<td class="total2" style="width:19%"><?=rp($totsetors);?></td>
				</tr>
			</table>
		</div>
	</body>
</html>
