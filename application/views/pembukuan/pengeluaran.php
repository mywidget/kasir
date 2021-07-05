<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Pengeluaran <span id="test"></span></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data Pengeluaran </li>
		</ol>
	</div>
    <div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SORT</span>
						</div>
						<select id="sortBy" class="form-control custom-select" onchange="FilterPengeluaran()" style="width:10px!important;padding-right:0!important">
							<option value="ASC">ASC</option>
							<option value="DESC">DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select" onchange="FilterPengeluaran()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<div class="input-group-append">
							<span class="input-group-text">Jenis</span>
						</div>
						<select onchange="FilterPengeluaran()" name="jenis_p" id="jenis_p" class="form-control custom-select">
							<option value="0">Semua</option>
							<?php  
								foreach ($jenis AS $values){
									echo '<option value="'.$values['id_jenis'].'">'.$values['jenis_cetakan'].'</option>';
								}
							?>
						</select>
						<div class="input-group-append">
							<span class="input-group-text">Pengguna</span>
						</div>
						<select name="user" id="user"  class="custom-select" onchange="FilterPengeluaran()">
							<option value="0" style="font-weight:bold;border-bottom:1px solid #ddd;">PILIH</option>
							<?php  
								foreach ($pilihan AS $values){
									if($this->session->level=='admin' OR $this->session->level=='owner'){
										if($this->session->idu==$values['id_user']){
											echo '<option value="'.$values['id_user'].'" selected>'.$values['nama_lengkap'].'</option>';
											}else{
											echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
										}
										}else{
										if($this->session->idu==$values['id_user']){
										echo '<option value="'.$values['id_user'].'" selected>'.$values['nama_lengkap'].'</option>';
									}
								}
							}
						?>
					</select>
					<div class="input-group-append">
						<span class="input-group-text">Tanggal</span>
					</div>
					<input type="text" value="<?=$tgl;?>" onchange="FilterPengeluaran()" class="form-control datepicker" name="dari" id="dari">
					<input type="text" onchange="FilterPengeluaran()" class="form-control datepicker" name="sampai" id="sampai">
					<div class="btn-group" role="group">
						<button class="btn btn-success btn-sm" onclick="FilterPengeluaran();"><i class="fa fa-search"></i></button>
						<button type="button" data-info="tambah" class="btn btn-warning tpengeluaran btn-sm" data-id="0"><i class="fa fa-plus"></i></button>
					</div>
				</div>
			</div>
			<div class="post-list" id="dataListPengeluaran">
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
									// echo 1;
									$total_all=0;
									if(!empty($result)){
										$no=1;
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
												$sql= $this->db->query("SELECT * from pengeluaran_detail where id_pengeluaran=".$aRow['id_pengeluaran']);
												$total = 0;
												
												foreach ($sql->result_array() as $rr){
													$tothar = $rr['harga'] * $rr['jumlah'];
													$sqlj= $this->db->query("SELECT * from jenis_cetakan where id_jenis=".$rr['id_biaya']);
													$rowj = $sqlj->row();
												?>
												<tr style="<?=$warna;?>">
													<td></td>
													<td class="sorting_1"><i>&nbsp;</i></td>
													<td>&nbsp;</td>
													<td><i>a<?=$rowj->jenis_cetakan;?></i></td>
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
													<td class="text-center"><?=$button;?>
													</td>
												</tr>
											<?php } ?>
											<?php $no++;}else{ ?>
											<tr>
												<td colspan="8">Data belum ada</td>
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
						<!-- Display posts list -->
						
						<!-- Loading Image -->
						<div class="loading" style="display: none;">
						</div>
						<div class="pesan"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal-fullscreen-xl" id="pengeluaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah pengeluaran</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="load-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success simpan_pengeluaran">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			// FilterPengeluaran();
		});
		$(document).on('click','.tpengeluaran',function(e){
			e.preventDefault();
			var dataID = $(this).attr('data-id');
			var info = $(this).attr('data-info');
			var user = $("#user").val();
			// alert(info);
			$.ajax({
				'url': base_url + 'pembukuan/load_modal',
				'method': 'POST',
				data :{id:dataID,info:info,user:user},
				success: function(data) {
					if(data=='error'){
						sweet('Peringatan!!!','Maaf Data telah direkap & tidak bisa di edit','warning','warning');
						}else{
						$("#pengeluaran").modal('show');
						$(".load-modal").html(data);
					}
				}
			})
		});
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
		$(".simpan_pengeluaran").on('click', function() {
			var id = $("#id_pengeluaran").text();
			var date_p = $("#date_p").val();
			var pencatat = $("#pencatat").val();
			var total = angka($("#total_pengeluaran").val());
			$.ajax({
				type: "POST",
				url: base_url + "pembukuan/save_pengeluaran",
				data: { id:id,total:total,tgl:date_p,pencatat:pencatat},
				dataType: "json",
				success: function(res) {
					if (res.ok == 'ok') {
						$("#dari").val(date_p);
						FilterPengeluaran();
						sweet('Simpan!!!','Data telah disimpan','warning','success');
						$("#pengeluaran").modal('hide');
						} else {
						sweet('Peringatan!!!','Maaf data gagal disimpan','warning','warning');
					}
				}
			});
		})
		$('.datepicker').datepicker({clearBtn: true,format: "dd/mm/yyyy"});
		function FilterPengeluaran(page_num){
			page_num = page_num?page_num:0;
			// var keywords = $('#keywords').val();
			var sortBy = $('#sortBy').val();
			var limits = $('#limits').val();
			var user = $('#user').val();
			var dari = $('#dari').val();
			var sampai = $('#sampai').val();
			var jenis = $("#jenis_p").val();
			if(jenis == 0){
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url("ajax/ajaxPengeluaran/"); ?>'+page_num,
				data:{page:page_num,sortBy:sortBy,limits:limits,user:user,dari:dari,sampai:sampai},
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(html){
					$('#dataListPengeluaran').html(html);
					$('.loading').fadeOut("slow");
				}
			});
			}else{
					
				$.ajax({
				type: 'POST',
				url: '<?php echo base_url("ajax/ajaxPengeluaranProduk/"); ?>'+page_num,
				data:{page:page_num,sortBy:sortBy,limits:limits,user:user,dari:dari,sampai:sampai,jenis:jenis},
				beforeSend: function(){
					$('.loading').show();
				},
				success: function(html){
					$('#dataListPengeluaran').html(html);
					$('.loading').fadeOut("slow");
				}
			});
			// sweet('Peringatan!!!',jenis,'warning','warning');
			}
		}
	</script>																