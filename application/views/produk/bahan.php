<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data bahan</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data bahan</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">List Data bahan</h6>
						<span id="nestable-menu" class="float-right">
							<button type="button" class="btn btn-primary add_bahan" data-id="0"><i class="fa fa-plus"></i> Tambah</button>
						</span>
					</div>
					
					<?php echo $this->session->flashdata('message'); ?>
					<div class="card-body table-responsive">
						<div class="card-block dataBahan">
							
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalBahan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Jenis produk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<input type='hidden' name='bahan_id' id='bahan_id' value='0'>
				<input type='hidden' name='type' id="type">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="judul">Nama bahan</label>
							<input type="text" name="judul" id="judul" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="harga">Harga dasar</label>
							<input type="text" onkeyup='formatNumber(this)' name="harga" id="harga" class="form-control" required>
						</div>
						<label>Aktif </label>
						<div class="form-group d-flex flex-row">
							<select name="aktif" id="aktif" class="form-control custom-select" required>
								<option value="">Pilih</option>
								<option value="1">Ya</option>
								<option value="0">Tidak</option>
							</select>
						</div>	
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_bahan">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
				<input type="hidden" id="url-hapus">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger hapus_bahan" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		bahan();
		
	});
	function bahan(){
		$.ajax({
			url: base_url + "produk/data_bahan",
			dataType: 'html',
			success: function(data) {
				$(".dataBahan").html(data);
			}
		});
	}
	$(document).on('click','.add_bahan',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		// alert(id);
		if(id==0){
            $("#type").val('add');
			}else{
            $("#type").val('edit');
		}
		$('#ModalBahan').modal({backdrop: 'static', keyboard: false});
		$.ajax({
			url: base_url + 'produk/edit_bahan',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				$("#bahan_id").val(data.id);
				$("#judul").val(data.judul);
				$("#harga").val(data.harga);
				$("#aktif").val(data.aktif);
			}
		});
	});
	$(document).on('click','.hapus_bahan',function(e){
		var url = $("#url-hapus").val();
		$.ajax({
			url: url,
			method: 'GET',
			dataType:'json',
			success: function(data) {
				if(data.ok=='ok'){
					$('#confirm-delete').modal('hide');
					sweet('Hapus!!!',data.msg,'success','success');
					bahan();
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
			}
		});
	});
	$("#judul").keyup(function(){
		$("#judul").removeClass("is-invalid").addClass("is-valid");
	});
	$("#harga").keyup(function(){
		$("#harga").removeClass("is-invalid").addClass("is-valid");
	});
	$("#aktif").change(function(){
		$("#aktif").removeClass("is-invalid").addClass("is-valid");
	});
	$(document).on('click','.save_bahan',function(e){
		e.preventDefault();
		var id = $("#bahan_id").val();
		var type = $("#type").val();
		var judul = $("#judul").val();
		var harga = angka($("#harga").val());
		var aktif = $("#aktif").val();
		if(judul==''){
			$("#judul").addClass('is-invalid');
			$("#judul").focus();
			// sweet('Peringatan!!!','Nama bahan masih kosong','warning','warning');
			return;
		}
		if(harga==''){
			$("#harga").addClass('is-invalid');
			$("#harga").focus();
			// sweet('Peringatan!!!','Harga bahan masih kosong','warning','warning');
			return;
		}
		if(aktif==''){
			$("#aktif").addClass('is-invalid');
			$("#aktif").focus();
			// sweet('Peringatan!!!','Status masih kosong','warning','warning');
			return;
		}
		$.ajax({
			url: base_url + 'produk/save_bahan',
			data: {id:id,type:type,judul:judul,harga:harga,aktif:aktif},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				if(data.ok=='ok'){
					bahan();
					sweet('Sukses!!!',data.msg,'success','success');
					$('#ModalBahan').modal('hide');
					}else{
					sweet('Peringatan!!!','Data gagal disimpan','warning','warning');
				}
			}
		});
	});
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#url-hapus').val($(e.relatedTarget).data('href'));
	});
	
</script>