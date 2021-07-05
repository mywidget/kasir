<?php
	// print_r($result);
?>
<div class="table-responsive-sm">
	<table class="table">
		<thead class="thead-light">
			<tr>
				<th>No. Order</th>
				<th>Tanggal</th>
				<th>Customer</th>
				<th class="text-right">Omset</th>
				<th class="text-right">Diskon</th>
				<th class="text-right">Pajak</th>
				<th class="text-right">Total_Omset</th>
				<th class="text-right">Bayar</th>
				<th class="text-right">Piutang</th>
				<th>Kasir</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$omset_ppajak=0;
				$piutang=0;
				$t_omset=0;
				$tt_omset=0;
				$t_bayar=0;
				$t_piutang=0;
				$sub_tpajak=0;
				$Totalbayar=0;
				$disc=0;
				if(!empty($result)) {
					$no=1;
					
					foreach($result AS $row){ 
						$rows = bayar($row['id_invoice']);
						if (isset($rows)) {
							$Totalbayar = $rows['Totalbayar'];
							}else{
							$Totalbayar = 0;
						}
						if($row['pajak'] >0 AND $row['diskon'] >0){
							$disc = '('.$row['disc'] .'% )'. rp($row['diskon']);
							$diskon = $row['diskon'];
							$omset_ppajak = $row['Tot'] - $diskon;
							$sub_tpajak = ($row['Tot'] - $diskon) * ($row['pajak'] /100);
							$omset_ppajak = $omset_ppajak + $sub_tpajak;
							$sub_tpajak = '('.$row['pajak'] .'% )'. rp($sub_tpajak);
							$piutang = $omset_ppajak-$Totalbayar;
							$tt_omset += $omset_ppajak;
							
						}elseif($row['pajak'] ==0 AND $row['diskon'] >0){
							$disc = rp($row['diskon']);
							$diskon = $row['diskon'];
							$omset_ppajak = $row['Tot'] - $diskon;
							$sub_tpajak = ($row['Tot'] - $diskon) * ($row['pajak'] /100);
							$omset_ppajak = $omset_ppajak + $sub_tpajak;
							$sub_tpajak = 0;
							$piutang = $omset_ppajak-$Totalbayar;
							$tt_omset += $omset_ppajak;
							
						}elseif($row['pajak'] >0 AND $row['diskon'] ==0){
							$omset_ppajak = $row['Tot'] + ($row['Tot'] * $row['pajak'] /100);
							$piutang = $omset_ppajak-$Totalbayar;
							$tt_omset += $omset_ppajak;
							$sub_tpajak = $row['Tot'] * $row['pajak'] /100;
							 $sub_tpajak = '('.$row['pajak'] .'% )'. rp($sub_tpajak);
							 $disc = 0;
							
						}else{
							$omset_ppajak = $row['Tot'];
							$piutang = $row['Tot'] - $Totalbayar;
							$tt_omset += $omset_ppajak;
							$sub_tpajak=0;
							 $disc = 0;
						}
					?>
					<tr>
						<td class="text-right"><a href="#">#<?=$row['id_invoice'];?></a></td>
						<td><?=dtimes($row['tgl_trx'],false,false);?></td>
						<td><?=$row['nama'];?></td>
						<td class="text-right"><?=rp($row['Tot']);?></td>
						<td class="text-right"><?=$disc;?></td>
						<td class="text-right"><?=$sub_tpajak;?> </td>
						<td class="text-right"><?=rp($omset_ppajak);?></td>
						<td class="text-right"><?=rp($Totalbayar);?></td>
						<td class="text-right"><?=rp($piutang);?></td>
						<td><span class="badge badge-success"><?=$row['kasir'];?></span></td>
					</tr> 
					<?php 
						$t_omset += $row['Tot'];
						$t_bayar += $Totalbayar;
						$t_piutang += $piutang;
					}}else{ ?>
					<tr>
						<td colspan="11">Data belum ada</td>
					</tr> 
			<?php }?>
		</tbody>
		<tfoot>
			<tr>
				<th>No. Order</th>
				<th>Tanggal</th>
				<th>Customer</th>
				<th class="text-right">Omset</th>
				<th class="text-right">Diskon</th>
				<th class="text-right">Pajak</th>
				<th class="text-right">Total_Omset</th>
				<th class="text-right">Bayar</th>
				<th class="text-right">Piutang</th>
				<th>Kasir</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th class="text-right"><?=rp($t_omset);?></th>
				<th>&nbsp;</th>
				<th class="text-right"><?=rp($tt_omset);?></th>
				<th class="text-right"><?=rp($t_bayar);?></th>
				<th class="text-right"><?=rp($t_piutang);?></th>
				<th>&nbsp;</th>
			</tr>
		</tfoot>
	</table>
</div>