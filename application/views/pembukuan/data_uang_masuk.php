<div class="table-responsive-sm">
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th style="width:1%">No.</th>
				<th style="width:2%">ID_Order</th>
				<th style="width:5%">Tgl. Transaksi</th>
				<th style="width:5%">Nama Konsumen</th>
				<th style="width:5%">Tgl. Bayar</th>
				<th style="width:5%">Keterangan</th>
				<th style="width:5%" class="text-right">Jml. Bayar</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$totsetors = 0;
				// print_r($result);
				if(!empty($result)) {
					$no=1;
					
					foreach($result AS $rows){
						$cara_bayar = $rows['cara_bayar'];
						$databayar = $this->db->query("SELECT 
						`bayar_invoice_detail`.`id_invoice`,
						`konsumen`.`nama`,
						`invoice`.`tgl_trx`,
						`bayar_invoice_detail`.`tgl_bayar`,
						`bayar_invoice_detail`.`jml_bayar`,
						`cara_bayar`.`cara_bayar`,
						`bayar_invoice_detail`.`id`,
						`bayar_invoice_detail`.`rekap`,
						`bayar_invoice_detail`.`id_byr`
						FROM
						`invoice`
						RIGHT OUTER JOIN `bayar_invoice_detail` ON (`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`)
						INNER JOIN `cara_bayar` ON (`bayar_invoice_detail`.`id_byr` = `cara_bayar`.`id_byr`)
						INNER JOIN `konsumen` ON (`invoice`.`id_konsumen` = `konsumen`.`id`)
						WHERE  `bayar_invoice_detail`.id_byr='$rows[id_byr]' $and
						ORDER BY
						`bayar_invoice_detail`.`id`");
						
						$totsetor = 0;
						foreach($databayar->result_array() AS $row){
						
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td>#<?php echo $row['id_invoice'];?></td>
							<td><?php echo dtimes($row['tgl_trx'],false,false);?></td>
							<td><?php echo $row['nama'];?></td>
							<td><?php echo dtimes($row['tgl_bayar'],false,false);?></td>
							<td><?php echo $row['cara_bayar'];?></td>
							<td class="text-right"><?php echo rp($row['jml_bayar']);?></td>
						</tr>
						<?php 
							$totsetor = $totsetor + $row['jml_bayar'];
							$totsetors +=  $row['jml_bayar'];
							$no++;
						} 
						echo '<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><i><strong>'.$cara_bayar.'</i></strong></td>
						<td class="text-right"><i><strong>'.rp($totsetor).'</i></strong></td>
						</tr>';
					}
					echo '<tfoot><tr>';
					echo '<td><button class="btn btn-info btn-sm" id="cetak_u_masuk">Print</button></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td><i><strong>Total</i></strong></td>';
					echo '<td class="text-right"><i><strong>'.rp($totsetors).'</i></strong>
					<input type="hidden" name="total_u" id="total_u" value="'.$totsetors.'">
					</td>';
					echo '</tr></tfoot>';
				}else{ ?>
				<tr>
					<td colspan="11">Data belum ada</td>
				</tr> 
			<?php }?>
		</tbody>
	</table>
</div>