<div class="card-body table-responsive">
	<div class="card-block">
		<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
			<tr>
				<th style="width:3%!important" class="text-right">No.</th>
				<th>Tanggal</th>
				<th class="text-right">Debit</th>
				<th class="text-right">Kredit</th>
				<th class="text-right">Saldo</th>
			</tr>
			<tbody>
				<?php 
						$debet=0;$kredit=0;$saldo=0;$tdebet=0;$tkredit=0;$tsaldo=0;
					if(!empty($result)){
						$no=$this->uri->segment(3)+1;
						foreach($result AS $row){ 
							$debet = $row['debet'];
							$kredit = $row['kredit'];
							$tdebet += $row['debet'];
							$tkredit +=  $row['kredit'];
							$tsaldo +=  $debet - $kredit;
							if($debet>0){
								$saldo = $saldo + $row['debet'];			
								}else{
								$saldo = $saldo - $row['kredit'];
							}
							echo "<tr><td>$no</td>";
							echo "<td>".dtimes($row['tgl_rekap'],false,false)."</td>";
							echo "<td class='text-right'>".rp($debet)."</td>";
							echo "<td class='text-right'>".rp($kredit)."</td>";
							echo "<td class='text-right'>".rp($saldo)."</td></tr>";
						$no++; }
					}
				?>
				<tr>
					<td colspan="2">Total</td>
					<td class='text-right'><?=rp($tdebet);?></td>
					<td class='text-right'><?=rp($tkredit);?></td>
					<td class='text-right'><?=rp($tsaldo);?></td>
				</tr>
			</tbody>
		</table>
		<nav aria-label="Page navigation">
			<?php echo $this->ajax_pagination->create_links(); ?>
		</nav>
	</div><!-- /.card-body -->
</div><!-- /.card-body -->		