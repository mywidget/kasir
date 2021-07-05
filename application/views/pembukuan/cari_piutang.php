<div class="table-responsive"> 
	<table class="table">
		<thead>
			<tr>
				<th style="width:1%;" class="text-center">No.</th>
				<th style="width:1%"  class="text-center">No.Order.</th>
				<th style="width:10%"  class="text-left">Nama Konsumen</th>
				<th style="width:2%"  class="text-left">No.Telp</th>
				<th style="width:2%"  class="text-left">Tgl.Order</th>
				<th style="width:5%"  class="text-right">Tot.Order</th>
				<th style="width:5%"  class="text-right">Diskon</th>
				<th style="width:5%"  class="text-right">Bayar</th>
				<th style="width:5%"  class="text-right">Piutang</th>
				<th style="width:4%"  class="text-left">Kasir</th>
				<th style="width:2%" class="text-center">Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no=1;
		$totalbeli=0;
		$totalbayar=0;
		$piutang=0;
			foreach($result as $val){
			$aksi = '';
			if($val['sisa'] >0){
			$aksi = '<a href="#" data-toggle="modal" data-id="'.$val["id_invoice"].'" data-modEdit="edit" data-target="#OpenCart-1" id="cart" class="btn btn-info btn-sm">BAYAR</a>';
			}
			$totalbeli += $val['totalbeli'];
			$totalbayar += $val['totalbayar']+$val['diskon'];
			$piutang += $val['sisa'];
			?>
			<tr>
				<td class="text-center"><?php echo $no;?></td>
				<td class="text-center">#<?=$val['id_invoice'];?></td>
				<td class="text-left"><?=$val['namak'];?></td>
				<td class="text-left"><?=$val['no_hp'];?></td>
				<td class="text-left"><?=$val['tgl_trx'];?></td>
				<td class="text-right"><?=rp($val['totalbeli']);?></td>
				<td class="text-right"><?=rp($val['diskon']);?></td>
				<td class="text-right"><?=rp($val['totalbayar']);?></td>
				<td class="text-right"><?=rp($val['sisa']);?></td>
				<td class="text-left"><?=$val['fo'];?></td>
				<td class="text-left"><?=$aksi;?></td>
			</tr>
		<?php $no++; } ?>
		
		</tbody>
		<tfoot>
		<tr>
				<td colspan="5" style="width:1%;" class="text-left">Total</td>
				<td style="width:5%"  class="text-right"><?=rp($totalbeli);?></td>
				<td style="width:5%"  class="text-right"><?=rp($totalbayar);?></td>
				<td style="width:5%"  class="text-right"><?=rp($piutang);?></td>
				<td style="width:4%"  class="text-left"></td>
				<td style="width:2%" class="text-center"></td>
			</tr>
		</tfoot>
	</table>			