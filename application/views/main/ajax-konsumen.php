<div class="card-body table-responsive">
	<div class="card-block">
		<table class="table">
			<?php 
				// print_r($posts);
				$omset_ppajak=0;
				$t_omset=0;
				$t_detail=0;
				$sisa=0;
				$t_omset_a=0;
				$t_bayar=0;
				$t_piutang=0;
				if(!empty($posts)) {
					$no=1;
					foreach($posts AS $row){
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
						$t_omset_a += $omset_ppajak;
						$t_bayar += $row['total_bayar'];
						$t_piutang += $sisa;
						
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
						
						// $datas= $this->db->query($detail)->result();
						$_data= $this->db->query($detail);
					?>
					<thead class="thead-dark">
						<tr>
							<th style="width:1%!important" class="pr-0">No.Order</th>
							<th class="text-right pl-0 pr-0">Tanggal_order</th>
							<th class="text-right">Order</th>
							<th class="text-left">Pajak</th>
							<th class="text-right">Total_Beli</th>
							<th class="text-left">Total_Bayar</th>
							<th class="text-right">Piutang</th>
							<th class="text-left">Kasir</th>
						</tr>
					</thead>
					<tr>
						<td class="text-left pr-0"><a href="#">#<?=$row['id_invoice'];?></a></td>
						<td class="text-right pl-0 pr-0"><?=dtimes($row['tgl_trx'],false,false);?></td>
						<td class="text-right"><?=RP($row['total_bayar']);?></td>
						<td><?=$row['pajak'];?>%</td>
						<td class="text-right"><?=rp($omset_ppajak);?></td>
						<td class="text-left"><?=rp($rowb['bayar']);?></td>
						<td class="text-right"><?=rp($sisa);?></td>
						<td><?=$row['nama_lengkap'];?></td>
					</tr> 
					<thead class="thead-light">
						<th>Jumlah</th>
						<th class="text-right pl-0 pr-0">Harga</th>
						<th class="text-right">Sub total</th>
						<th class="text-left">Diskon</th>
						<th class="text-right ">Harga_beli</th>
						<th>Keterangan</th>
						<th class="text-left">&nbsp;</th>
						<th class="text-left">Jenis</th>
					</tr>
					<?php 
						
						foreach($_data->result_array() AS $val){ 
							$t_detail = $val['jumlah']*$val['harga'];
							$t_omset = ($val['jumlah']*$val['harga']) - ($val['jumlah']*$val['harga'] * $val['diskon']/100);
							// $t_omset_a += ($val['jumlah']*$val['harga']) - ($val['jumlah']*$val['harga'] * $val['diskon']/100);
						?>
						<tr>
							<td class="text-left"><?=$val['jumlah'];?></td>
							<td class="text-right"><?=rp($val['harga']);?></td>
							<td class="text-right"><?=rp($t_detail);?></td>
							<td><?=$val['diskon'];?>%</td>
							<td class="text-right"><?=rp($t_omset);?></td>
							<td><?=$val['keterangan'];?></td>
							<td class="text-left"></td>
							<td><?=$val['nama_jenis'];?></td>
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
					<th class="text-right"><?=rp($t_omset_a);?></th>
					<th class="text-left"><?=rp($t_bayar);?></th>
					<th class="text-right"><?=rp($t_piutang);?></th>
					<th>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
	</div>
	<nav aria-label="Page navigation example">
		<?php echo $this->ajax_pagination->create_links(); ?>
	</nav>
</div>