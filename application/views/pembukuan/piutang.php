<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data piutang</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data piutang</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">
							<div class="input-group">
								<select name="user" id="user" class="form-control custom-select">
									<option value="0">Semua</option>
									<?php  
										foreach ($pilihan AS $values){
											if($this->session->idu==$values['id_user']){
												echo '<option value="'.$values['id_user'].'" selected>'.$values['nama_lengkap'].'</option>';
												}else{
												echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
											}
										}
									?>
								</select>
								<input type="text" onchange="search_Filter()" value="<?=$bulan;?>" class="form-control bulan" name="dari" id="dari">
								<input type="text" onchange="search_Filter()" value="<?=$tahun;?>" class="form-control tahun" name="sampai" id="sampai">
								<input type="text" onkeyup="search_Filter()" class="form-control" name="keywords" id="keywords" placeholder="Cari nomor order">
								
							</div>
						</h6>
						<span id="nestable-menu" class="float-right">
							<button type="button" data-info="cari" class="btn btn-success cari_piutang" data-id="0"><i class="fa fa-search"></i> Lihat</button>
						</span>
					</div>
					
					<div class="card-body table-responsive">
						<div class="card-block">
							<div id="data_piutang"></div>
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>
<style>
	.custom-select {
    display: inline-block;
    width: 100%;
    height: 43px;
    padding: 5px 1.75rem 5px .75rem;
	
	}
</style>
<style>
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 2px;
	
	}
	.card .table td, .card .table th {
    padding-right: 5px;
    padding-left: 5px;
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
</style>
<script>
$('.tahun').datepicker({
    format: "yyyy",
    startView: 2,
    minViewMode: 2,
    maxViewMode: 2,
	clearBtn: true,
    autoclose: true
	});	
	$('.bulan').datepicker({
    autoclose: true,
    minViewMode: 1,
	clearBtn: true,
    format: 'mm'
	});
	$('.datepicker').datepicker({
		todayBtn: "linked",
        format: "dd/mm/yyyy",
		autoclose: true,
		todayHighlight: true
	});
	function search_Filter(){
		$(".harian").click();
	}
	$(document).on('click','.cari_piutang',function(e){
		e.preventDefault();
		var info = $(this).attr('data-info');
		var user = $("#user").val();
		var bulan = $("#dari").val();
		var tahun = $("#sampai").val();
		var keywords = $("#keywords").val();
		$.ajax({
			url: base_url + 'pembukuan/cari_piutang',
			data: {user:user,bulan:bulan,tahun:tahun,info:info,keywords:keywords},
			method: 'POST',
			// dataType:'json',
			success: function(data) {
				$("#data_piutang").html(data);
				$("#rekapan").attr('disabled',false);
			}
		});
	});
	
	
</script>			