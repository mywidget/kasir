<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data omset</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data omset</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">
							<div class="input-group">
								<select onchange="search_omset()" name="jenis_c" id="jenis_c" class="form-control custom-select">
								<option value="0">Semua</option>
									<?php  
								foreach ($jenis AS $values){
								if($this->session->idu==$values['id_jenis']){
									echo '<option value="'.$values['id_jenis'].'" selected>'.$values['jenis_cetakan'].'</option>';
								}else{
									echo '<option value="'.$values['id_jenis'].'">'.$values['jenis_cetakan'].'</option>';
								}
								}
							?>
								</select>
								<input type="text" onchange="search_omset()" value="<?=$tgl;?>" class="form-control datepicker" name="dari" id="dari">
								<input type="text" onchange="search_omset()" value="<?=$tgl;?>" class="form-control datepicker" name="sampai" id="sampai">
								
							</div>
						</h6>
						<span id="nestable-menu" class="float-right">
							<button type="button" data-info="harian" class="btn btn-success tampil" data-id="0"><i class="fa fa-search"></i> Tampilkan</button>
						</span>
					</div>
					
					<div class="card-body table-responsive">
						<div class="card-block">
							<div id="data_omset_jenis"></div>
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
	$('.datepicker').datepicker({
        clearBtn: true,
        format: "dd/mm/yyyy"
	});
	function search_omset(){
	$(".harian").click();
	}
	$(document).on('click','.tampil',function(e){
		e.preventDefault();
		$("#data_omset_jenis").html("");
		var info = $(this).attr('data-info');
		var dari = $("#dari").val();
		var sampai = $("#sampai").val();
		var jenis = $("#jenis_c").val();
		$.ajax({
			url: base_url + 'pembukuan/perjenis',
			data: {dari:dari,sampai:sampai,jenis:jenis,info:info},
			method: 'POST',
			// dataType:'json',
			success: function(data) {
				$("#data_omset_jenis").html(data);
			}
		});
	});
	
	
</script>			