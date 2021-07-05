<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data rekap</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data rekap</li>
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
						<select id="sortBy" class="form-control custom-select" onchange="searchRekap()" style="width:10px!important;padding-right:0!important">
							<option value="ASC">ASC</option>
							<option value="DESC">DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select" onchange="searchRekap()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<div class="input-group-append">
							<span class="input-group-text">Pengguna</span>
						</div>
						<select name="user" id="user"  class="custom-select" onchange="searchRekap()">
							<option value="" style="font-weight:bold;border-bottom:1px solid #ddd;" selected>PILIH</option>
							<?php  
								foreach ($pilihan AS $values){
									if($this->session->level=='admin' OR $this->session->level=='owner'){
									
											echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
										
									}
								}
							?>
						</select>
						<div class="input-group-append">
							<span class="input-group-text">Tanggal</span>
						</div>
						<input type="text" value="" class="form-control datepicker" name="dari" id="dari">
						<input type="text" value="" class="form-control datepicker" name="sampai" id="sampai">
						<div class="btn-group" role="group">
							<button type="button"  class="btn btn-success btn-sm" onclick="searchRekap();"><i class="fa fa-search"></i></button>
							<button type="button" data-info="cetak" class="btn btn-warning btn-sm cetak_rekap" data-id="0"><i class="fa fa-print"></i> Cetak</button>
						</div>
					</div>
				</div>
				<div class="post-list" id="dataList">
					<div class="card-body table-responsive">
						<div class="card-block">
							<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
								<thead>
									<tr>
										<th style="width:3%!important" class="text-right">No.</th>
										<th>Tanggal</th>
										<th class="text-right">Debit</th>
										<th class="text-right">Kredit</th>
										<th class="text-right">Saldo</th>
									</tr>
								</thead>
								<tbody>
									<?php
										// print_r($result);
										$debet=0;$kredit=0;$saldo=0;$tdebet=0;$tkredit=0;$tsaldo=0;
										if(!empty($result)){
											$no=1;
											foreach($result AS $row){ 
												$debet = $row['debet'];
												$kredit = $row['kredit'];
												$tdebet += $debet;
												$tkredit +=  $kredit;
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
												echo "<td class='text-right'>".($saldo)."</td></tr>";
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
                      
						</div><!-- /.card -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form id="form_rekap" method="POST" target="_blank" action="<?=base_url();?>pembukuan/cetak_rekap">
<input type="hidden" name="id_user" id="id_user">
<input type="hidden" name="tgl_dari" id="tgl_dari">
<input type="hidden" name="tgl_sampai" id="tgl_sampai">
<input type="hidden" name="cetak" value="cetak">
</form>
<style>
	.custom-select {
	display: inline-block;
	width: 100%;
	height: 43px;
	padding: 5px 1.75rem 5px .75rem;
	
	}
	
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
	padding: 3px;
	background:#f7f7f7;
	}
	.card .table td, .card .table th {
	padding-right: 5px;
	padding-left: 5px;
	background:#f7f7f7
	}
	.form-control {
	height: 30px;
	padding: 2px 10px;
	}
	button, input, select, textarea {
	font-family: inherit;
	font-size: inherit;
	line-height: inherit;
	}
	.input-group-text {
	padding:0 5px!important;
	margin-bottom: 0;
	}
</style>
<script>
	$('.datepicker').datepicker({clearBtn: true,format: "dd/mm/yyyy"});
	
	$(document).on('click','.cetak_rekap',function(e){
	e.preventDefault();
	var info = $(this).attr('data-info');
	var id_user = $("#user").val();
	if(id_user==''){
		sweet('Peringatan!!!','Maaf pengguna harus dipilih','warning','warning');
		return;
	}
	$("#id_user").val(id_user);
	var dari = $("#dari").val();
	$("#tgl_dari").val(dari);
	var sampai = $("#sampai").val();
	$("#tgl_sampai").val(sampai);
	if(dari=='' || sampai ==''){
		sweet('Peringatan!!!','Maaf tanggal harus dipilih','warning','warning');
		return;
	}
	$( "#form_rekap" ).submit();
	// $.ajax({
	// url: base_url + 'pembukuan/rekap_data',
	// data: {user:user,dari:dari},
	// method: 'POST',
	// dataType:'json',
	// success: function(data) {
	// $("#data_pengeluaran").html(data);
	// }
	// });
	});
	$('.datepicker').datepicker({clearBtn: true,format: "dd/mm/yyyy"});
	function searchRekap(page_num){
		page_num = page_num?page_num:0;
		// var keywords = $('#keywords').val();
		var sortBy = $('#sortBy').val();
		var limits = $('#limits').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		var user = $('#user').val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url("ajax/ajaxRekap/"); ?>'+page_num,
			data:{page:page_num,sortBy:sortBy,limits:limits,dari:dari,sampai:sampai,id_kasir:user},
			beforeSend: function(){
				$('.loading').show();
			},
			success: function(html){
				$('#dataList').html(html);
				$('.loading').fadeOut("slow");
			}
		});
	}
</script>																							