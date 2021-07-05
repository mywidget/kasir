<?php
	// print_r($result);
?>
<div class="table-responsive-sm">
	<table class="table">
			<?php 
				$omset_ppajak=0;
				$t_omset=0;
				$t_detail=0;
				$sisa=0;
				$t_omset_a=0;
				if(!empty($result)) {
					$no=1;
					foreach($result AS $row){
						$bayar = "SELECT 
						`bayar_invoice_detail`.`id_invoice`,
						SUM(`bayar_invoice_detail`.`jml_bayar`) AS `bayar`
						FROM
						`bayar_invoice_detail`
						WHERE
						`bayar_invoice_detail`.`id_invoice` = '$row[id_invoice]'
						GROUP BY
						`bayar_invoice_detail`.`id_invoice`";
						$rowb= $this->db->query($bayar)->row_array();
						$omset_ppajak = $row['total_bayar'] + ($row['total_bayar'] * $row['pajak']/100);
						$sisa = $omset_ppajak - $rowb['bayar'];
						if($jenis!=0){
							$detail = "SELECT 
							`jenis_cetakan`.`jenis_cetakan` AS nama_jenis,
							`invoice_detail`.`id_invoice`,
							`invoice_detail`.`id_produk`,
							`invoice_detail`.`jenis_cetakan`,
							`invoice_detail`.`keterangan`,
							`invoice_detail`.`jumlah`,
							`invoice_detail`.`harga`,
							`invoice_detail`.`diskon`,
							`invoice_detail`.`satuan`,
							`invoice_detail`.`ukuran`,
							`invoice_detail`.`id_bahan`
							FROM
							`invoice_detail`
							INNER JOIN `jenis_cetakan` ON (`invoice_detail`.`jenis_cetakan` = `jenis_cetakan`.`id_jenis`)
							WHERE
							invoice_detail.id_invoice='$row[id_invoice]' AND `invoice_detail`.`jenis_cetakan` = '$jenis'";
							}else{
							$detail = "SELECT 
							`jenis_cetakan`.`jenis_cetakan` AS nama_jenis,
							`invoice_detail`.`id_invoice`,
							`invoice_detail`.`id_produk`,
							`invoice_detail`.`jenis_cetakan`,
							`invoice_detail`.`keterangan`,
							`invoice_detail`.`jumlah`,
							`invoice_detail`.`harga`,
							`invoice_detail`.`diskon`,
							`invoice_detail`.`satuan`,
							`invoice_detail`.`ukuran`,
							`invoice_detail`.`id_bahan`
							FROM
							`invoice_detail`
							INNER JOIN `jenis_cetakan` ON (`invoice_detail`.`jenis_cetakan` = `jenis_cetakan`.`id_jenis`)
							WHERE id_invoice='$row[id_invoice]'";
						}
						// $datas= $this->db->query($detail)->result();
						$_data= $this->db->query($detail);
					?>
					<thead class="thead-dark">
						<tr>
							<th>No. Order</th>
							<th class="text-right">Tanggal</th>
							<th class="text-right">Omset</th>
							<th class="text-left">Pajak</th>
							<th class="text-left">Kasir</th>
							<th>Customer</th>
							<th class="text-right">Total_Omset</th>
							<th class="text-right">Total_Bayar</th>
							<th class="text-right">Sisa</th>
						</tr>
					</thead>
					<tr>
						<td class="text-left"><a href="#">#<?=$row['id_invoice'];?></a></td>
						<td class="text-right"><?=dtimes($row['tgl_trx'],false,false);?></td>
						<td class="text-right"><?=RP($row['total_bayar']);?></td>
						<td><?=$row['pajak'];?>%</td>
						<td><?=$row['nama_lengkap'];?></td>
						<td><?=$row['nama'];?></td>
						<td class="text-right"><?=rp($omset_ppajak);?></td>
						<td class="text-right"><?=rp($rowb['bayar']);?></td>
						<td class="text-right"><?=rp($sisa);?></td>
					</tr> 
					<thead class="thead-light">
						<th>Jumlah</th>
						<th class="text-right">Harga</th>
						<th class="text-right">Sub total</th>
						<th class="text-left">Diskon</th>
						<th class="text-left">Jenis Cetakan</th>
						<th>Keterangan</th>
						<th class="text-right">Total_Omset</th>
						<th class="text-left">&nbsp;</th>
						<th class="text-left">&nbsp;</th>
					</tr>
					<?php 
					
					foreach($_data->result_array() AS $val){ 
						$t_detail = $val['jumlah']*$val['harga'];
						$t_omset = ($val['jumlah']*$val['harga']) - ($val['jumlah']*$val['harga'] * $val['diskon']/100);
						$t_omset_a += ($val['jumlah']*$val['harga']) - ($val['jumlah']*$val['harga'] * $val['diskon']/100);
					?>
					<tr>
						<td class="text-left"><?=$val['jumlah'];?></td>
						<td class="text-right"><?=rp($val['harga']);?></td>
						<td class="text-right"><?=rp($t_detail);?></td>
						<td><?=$val['diskon'];?>%</td>
						<td><?=$val['nama_jenis'];?></td>
						<td><?=$val['keterangan'];?></td>
						<td class="text-right"><?=rp($t_omset);?></td>
						<td class="text-left"></td>
						<td class="text-left"></td>
					</tr> 
					
					<?php }
					}
					}else{ ?>
					<tr><th colspan="9">Data belum ada</th></tr> 
			<?php }?>
		<tfoot>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th class="text-right"><?=rp($t_omset_a);?></th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</tfoot>
	</table>
</div>