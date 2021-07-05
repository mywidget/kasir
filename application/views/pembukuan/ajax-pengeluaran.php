<div class="card-body table-responsive">
	<div class="card-block">
		<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
			<thead>
				<tr>
					<th style="width:3%!important" class="text-right">No.</th>
					<th>Tanggal</th>
					<th class="text-left">Pencatat</th>
					<th class="text-left">Jenis</th>
					<th class="text-left">Keterangan</th>
					<th class="text-right"></th>
					<th class="text-right">Total</th>
					<th class="text-center">Cetak</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					// print_r($result);
					$total_all=0;
					$button='';
					if(!empty($result)){
						$no=$this->uri->segment(3)+1;
						foreach($result AS $aRow){ 
							$query = $this->db->query("SELECT 
							`tb_users`.`nama_lengkap` FROM
							`tb_users` WHERE `tb_users`.`id_user` =".$aRow['id_user']);
							$row = $query->row();
							if($no%2==0){
								$warna = "background:#8c0023";
								$warna2 = "background:#8c0023";
								}else{
								$warna = "background:#ececfb;padding:10px";
								$warna2 = "background:#bfcfff";
							}
							$rekap ='-';
							$button ='<button class="btn btn-flat btn-sm btn-info rekap" data-id="'.$aRow['id_pengeluaran'].'">Rekap</button>';
							if($aRow['rekap']=='Y'){
								$rekap ='Rekap Y';
								$button ='<button class="btn btn-flat btn-sm btn-danger" disabled>Rekap</button>';
							}
						?>
						<tr style="<?=$warna;?>">
							<td class="text-center"><b><a href='#' data-info="edit" class="tpengeluaran" data-id="<?=$aRow['id_pengeluaran'];?>" title='Edit Pengeluaran'>#<?=$aRow['id_pengeluaran'];?><a></b>
							</td>
							<td class="sorting_1"><b><?=$aRow['tgl_pengeluaran'];?></b>
							</td>
							<td><?=$row->nama_lengkap;?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="text-center"><a href="<?=base_url();?>pembukuan/cetak_pengeluaran/<?=$aRow['id_pengeluaran'];?>" target="_blank" class="btn btn-success btn-flat btn-sm pull-right"><b>Cetak</b></a></td>
							</tr>
							<?php
								$sql= $this->db->query("SELECT * from pengeluaran_detail where id_pengeluaran=".$aRow['id_pengeluaran'])->result_array();
								$total = 0;
								// print_r($sql);
								foreach ($sql as $rr){
								
									$tothar = $rr['harga'] * $rr['jumlah'];
									$sqlj= $this->db->query("SELECT * from jenis_cetakan where id_jenis=".$rr['id_biaya']);
									$rowj = $sqlj->row();
								?>
								<tr style="<?=$warna;?>">
									<td></td>
									<td class="sorting_1"><i>&nbsp;</i></td>
									<td>&nbsp;</td>
									<td><i><?=$rowj->jenis_cetakan;?></i></td>
									<td><i><?=$rr['keterangan'];?></i></td>
									<td><i>(<?=$rr['jumlah'];?> <?=$rr['satuan'];?> x <?=$rr['harga'];?>)</i></td>
									<td class="text-right"><i><?=rp($tothar);?></i></td>
									<td></td>
								</tr>
								
								<?php 
									$total = $total + $tothar;
									$total_all += $tothar;
								} ?>
								<tr style="<?=$warna2;?>">
									<td></td>
									<td class="sorting_1"></td>
									<td></td>
									<td></td>
									<td></td>
									<td><b><i>Total</i></b></td>
									<td class="text-right"><b><i><?=rp($total);?></i></b>
										<input type="hidden" class="form-control form-control-sm text-right" value="<?=$total;?>" id="subtotal" readonly>
									</td>
								</td>
								<td class="text-center"><?=$button;?>
								</td>
							</tr>
						<?php } ?>
						<?php $no++;}else{ ?>
						<tr>
							<td colspan="8">Belum ada pengeluaran</td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="5"></td>
						<td><strong>Total</strong></td>
						<td class="text-right"><strong><input type="text" class="form-control form-control-sm text-right" value="<?=rp($total_all);?>" readonly></strong></td>
						<td></td>
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