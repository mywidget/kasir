<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data uang masuk</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data uang masuk</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					
					
					<div class="card-body table-responsive">
						<div class="card-block">
							<ul class="nav nav-tabs tabs-dark bg-dark" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Rekap uang masuk</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Data uang masuk</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<div class="card-header  d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-warning">
											<div class="input-group">
												<select name="user" id="user" onchange="search_Filter()" class="form-control custom-select">
													<option value="0">Pilih</option>
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
												<input type="text" onchange="search_Filter()" value="<?=$tgl;?>" class="form-control datepicker" name="dari" id="dari">
											</div>
										</h6>
										<span id="nestable-menu" class="float-right">
											<button type="button" data-info="harian" class="btn btn-success harian" data-id="0"><i class="fa fa-search"></i> Tampilkan</button>
											<button type="button" data-info="rekapan" class="btn btn-info rekapan" data-id="<?=$this->session->idu;?>" id="rekapan"><i class="fa fa-list"></i> Rekap</button>
										</span>
									</div>
									<div id="data_uang_masuk"></div>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
									<div class="card-header  d-flex flex-row align-items-center justify-content-between">
										<h6 class="m-0 font-weight-bold text-warning">
											<div class="input-group">
												<select name="user_list" id="user_list" onchange="search_List()" class="form-control custom-select">
													<option value="0">Pilih</option>
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
												<input type="text" onchange="search_List()" value="<?=$tgl;?>" class="form-control datepicker" name="list_dari" id="list_dari">
											</div>
										</h6>
										<span id="nestable-menu" class="float-right">
											<button type="button" data-list="list" class="btn btn-primary list" data-id="0"><i class="fa fa-search"></i> Tampilkan</button>
										</span>
									</div>
									<div id="list_uang_masuk"></div>
								</div>
							</div>
							
							
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
	<br>
</div>
<form id="form_cetak" action="<?=base_url();?>pembukuan/cetak_uang_masuk" method="post" target="_blank">
	<input type="hidden" name="dari" id="tgl_dari">
	<input type="hidden" name="id_user" id="id_user">
</form>
<style>
	.custom-select {
    display: inline-block;
    width: 100%;
    height: 43px;
    padding: 5px 1.75rem 5px .75rem;
	
	}
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
	function search_List(){
		$(".list").click();
	}
	function search_Filter(){
		$(".harian").click();
	}
	$("#rekapan").attr('disabled','disabled');
	$(document).on('click','.rekapan',function(e){
		e.preventDefault();
		var info = $(this).attr('data-info');
		var jml = $("#total_u").val();
		var user = $("#user").val();
		var dari = $("#dari").val();
		
		if(user==0){
			sweet('Peringatan!!!','Maaf pilih dulu kasirnya','warning','warning');
			return;
		}
		$.ajax({
			url: base_url + 'pembukuan/rekap_uang_masuk',
			data: {user:user,total:jml,info:info,tgl:dari},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				if(data.ok=='ada'){
					sweet('Peringatan!!!','Maaf data sudah direkap','warning','warning');
					}else if(data.ok=='error_user'){
					sweet('Peringatan!!!',data.msg,'warning','warning');
					}else if(data.ok=='error_total'){
					search_List();
					sweet('Peringatan!!!',data.msg,'warning','warning');
					}else if(data.ok=='ok'){
					search_Filter();
					sweet('Sukses!!!','Data berhasil direkap','success','success');
					}else{
					sweet('Peringatan!!!','Maaf rekapan harus per kasir','warning','warning');
				}
			}
		});
	});
	$(document).on('click','.harian',function(e){
		e.preventDefault();
		var info = $(this).attr('data-info');
		var user = $("#user").val();
		var dari = $("#dari").val();
		$("#tgl_dari").val(dari);
		$("#id_user").val(user);
		$.ajax({
			url: base_url + 'pembukuan/data_uang_masuk',
			data: {user:user,dari:dari,info:info},
			method: 'POST',
			// dataType:'json',
			success: function(data) {
				$("#data_uang_masuk").html(data);
				$("#rekapan").attr('disabled',false);
			}
		});
	});
	$(document).on('click','.list',function(e){
		e.preventDefault();
		var info = $(this).attr('data-list');
		var user = $("#user_list").val();
		var dari = $("#list_dari").val();
		$("#tgl_dari").val(dari);
		$("#id_user").val(user);
		$.ajax({
			url: base_url + 'pembukuan/list_uang_masuk',
			data: {user:user,dari:dari,info:info},
			method: 'POST',
			// dataType:'json',
			success: function(data) {
				$("#list_uang_masuk").html(data);
			}
		});
	});
	$(document).on('click','#cetak_u_masuk',function(e){
		e.preventDefault();
		var total_u = $("#total_u").val();
		if(total_u==0){
			sweet('Peringatan!!!','Maaf total masih kosong','warning','warning');
			}else{
			$("#form_cetak").submit();
		}
	});
</script>			