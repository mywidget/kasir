<?php
	$sqlj= $this->db->query("SELECT * from jenis_cetakan where id_jenis=".$jenis);
	$rowj = $sqlj->row();
?>
<div class="card-body table-responsive">
	<div class="card-block">
		<span>Pengeluaran : <?=$rowj->jenis_cetakan;?><span>
			<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
				<thead>
					<tr>
						<th style="width:3%!important" class="text-right">No.</th>
						<th>Tanggal</th>
						<th class="text-left">Keterangan</th>
						<th class="text-right" style="width:15%!important">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						// echo $jenis;
						// print_r($result);
						$total=0;
						$total_all=0;
						$button='';
						$warna='';
						$warna2='';
						if(!empty($result)){
							$no=$this->uri->segment(3)+1;
							foreach($result AS $aRow){ 
								$harga = 0;
								$total_all += 0;
							?>
							<tr style="<?=$warna;?>">
								<td class="text-center"><b><a href='#' data-info="edit" class="tpengeluaran" data-id="<?=$aRow['id_pengeluaran'];?>" title='Edit Pengeluaran'>#<?=$aRow['id_pengeluaran'];?><a></b>
								</td>
								<td class="sorting_1"><b><?=$aRow['tgl_pengeluaran'];?></b></td>
								<td>a</td>
								<td align="right"><?=rp($harga);?></td>
					
							<?php } ?>
							<?php $no++;}else{ ?>
							<tr>
								<td colspan="6">Belum ada pengeluaran</td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="2"></td>
							<td><strong>Total</strong></td>
							<td class="text-right"><strong><input type="text" class="form-control form-control-sm text-right" value="<?=rp($total_all);?>" readonly></strong></td>
						</tr>
					</tbody>
				</table>
				<nav aria-label="Page navigation">
					<?php echo $this->ajax_pagination->create_links(); ?>
				</nav>
			</div><!-- /.card-body -->
		</div><!-- /.card-body -->
		<script>
			$(".rekap").on('click', function(e) {
				e.preventDefault();
				var id = $(this).attr('data-id');
				var tgl = $("#dari").val();
				var user = $('#user').val();
				var subtotal = $('#subtotal').val();
				if(subtotal==0){
					sweet('Peringatan!!!','Maaf Data masih kosong','warning','warning');
					return;
				}
				$.ajax({
					url: base_url + 'pembukuan/save_rekap_pengeluaran',
					method: 'POST',
					dataType: 'json',
					data :{tgl:tgl,id:id,user:user},
					success: function(data) {
						console.log(data);
						if(data.ok=='ok'){
							sweet('Rekap data!!!','Data berhasil direkap','success','success');
							FilterPengeluaran();
							}else{
							sweet('Rekap data!!!','Data telah direkap','warning','warning');
						}
					}
				})
			});
		</script>				