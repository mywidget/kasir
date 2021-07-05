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
								<input type="text" onchange="search_omset()" value="<?=$tgl;?>" class="form-control datepicker" name="dari" id="dari">
								<input type="text" value="<?=$tgl;?>" class="form-control datepicker" name="sampai" id="sampai">
								
							</div>
						</h6>
						<span id="nestable-menu" class="float-right">
							<button type="button" data-info="harian" class="btn btn-success harian" data-id="0"><i class="fa fa-search"></i> Lihat</button>
							<button type="button" data-info="bulanan" class="btn btn-info harian" data-id="0"><i class="fa fa-search"></i> Perbulan</button>
						</span>
					</div>
					
					<div class="card-body table-responsive">
						<div class="card-block">
							<div id="data_omset"></div>
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
	$(document).on('click','.harian',function(e){
		e.preventDefault();
		var info = $(this).attr('data-info');
		var user = $("#user").val();
		var dari = $("#dari").val();
		var sampai = $("#sampai").val();
		$.ajax({
			url: base_url + 'pembukuan/harian',
			data: {user:user,dari:dari,sampai:sampai,info:info},
			method: 'POST',
			// dataType:'json',
			success: function(data) {
				$("#data_omset").html(data);
			}
		});
	});
	
	
</script>			