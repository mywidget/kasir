<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data jenis</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data jenis</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header  d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-warning">Data jenis produk</h6>
					<span id="nestable-menu" class="float-right">
						<button type="button" class="btn btn-primary jenis" data-id="0"><i class="fa fa-plus"></i> Tambah</button>
					</span>
				</div>
				
				<?php echo $this->session->flashdata('message'); ?>
				<div class="card-body table-responsive">
					<div class="card-block">
						<div class="data_Table"></div>
					</div><!-- /.card-body -->
				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div>
	</div>
</div>
<!-- Modal Scrollable -->
<div class="modal fade" id="ModalJenis" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Jenis produk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<input type='hidden' name='jenis_id' id='jenis_id' value='0'>
				<input type='hidden' name='type' id="type">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="exampleInputEmail1">Nama jenis</label>
							<input type="text" name="judul" id="judul" class="form-control" required>
						</div>
						<label>Grup </label>
						<div class="form-group d-flex flex-row">
							<select name="grup" id="grup" class="form-control custom-select" required>
								<option value="">Pilih</option>
								<option value="0">Penjualan</option>
								<option value="1">Biaya</option>
							</select>
						</div>	
						<label>Aktif </label>
						<div class="form-group d-flex flex-row">
							<select name="aktif" id="aktif" class="form-control custom-select" required>
								<option value="">Pilih</option>
								<option value="Y" selected>Ya</option>
								<option value="N">Tidak</option>
							</select>
						</div>	
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_jenis">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="confirm-delete" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<p>Anda akan menghapus satu url, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
				<input type="hidden" id="data-hapus">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger hapus_jenis" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		jenis_cetakan();
	});
	function jenis_cetakan(){
		$.ajax({
			url: base_url + "produk/data_jenis",
			cache:false,
			success: function(data) {
				$(".data_Table").html(data);
				$('#data_Table').DataTable();
			}
		});
	}
	$(document).on('click','.jenis',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		// alert(id);
		if(id==0){
            $("#type").val('add');
			}else{
            $("#type").val('edit');
		}
		$('#ModalJenis').modal({backdrop: 'static', keyboard: false});
		$.ajax({
			url: base_url + 'produk/edit_jenis',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				$("#jenis_id").val(data.id);
				$("#judul").val(data.judul);
				$("#grup").val(data.grup);
				$("#aktif").val(data.aktif);
			}
		});
	});
	$('#grup').on('change', function() {
	$("#grup").removeClass("is-invalid").addClass("is-valid");
	});
	$('#aktif').on('change', function() {
	$("#aktif").removeClass("is-invalid").addClass("is-valid");
	});
	$("#judul").keyup(function(){
		$("#judul").removeClass("is-invalid").addClass("is-valid");
	});
	$(document).on('click','.save_jenis',function(e){
		e.preventDefault();
		var id = $("#jenis_id").val();
		var type = $("#type").val();
		var judul = $("#judul").val();
		var grup = $("#grup").val();
		var aktif = $("#aktif").val();
		if(judul==''){
			$("#judul").addClass('is-invalid');
			$("#judul").focus();
			return;
		}
		if(grup==''){
			$("#grup").addClass('is-invalid');
			$("#grup").focus();
			return;
		}
		if(aktif==''){
			$("#aktif").addClass('is-invalid');
			return;
		}
		$.ajax({
			url: base_url + 'produk/save_jenis',
			data: {id:id,type:type,judul:judul,aktif:aktif,grup:grup},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				if(data.ok=='ok'){
					jenis_cetakan();
					$('#ModalJenis').modal('hide');
					}else{
					sweet('Peringatan!!!','Data gagal disimpan','warning','warning');
				}
			}
		});
	});
	$(document).on('click','.hapus_jenis',function(e){
		var id = $("#data-hapus").val();
		$.ajax({
			url: base_url + 'produk/hapus_jenis',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				if(data.ok=='ok'){
					$('#confirm-delete').modal('hide');
					sweet('Hapus!!!',data.msg,'success','success');
					jenis_cetakan();
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
			}
		});
	});
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#data-hapus').val($(e.relatedTarget).data('id'));
	});
</script>