<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data pengguna</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data pengguna</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">Data Pengguna</h6>
						<span id="nestable-menu" class="float-right">
							<a href="user/add_user" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
						</span>
					</div>
					
					<?php echo $this->session->flashdata('message'); ?>
					<div class="card-body table-responsive">
						<div class="card-block">
							<p class="viewdata"></p>
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="confirm" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-dismiss="modal" id="delete" type="button">OK</button> <button class="btn" data-dismiss="modal" type="button">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('button.btn-default').on('click', function(e){
		if ($(this).attr("value")=='kirim')
        $('#confirm .modal-body').html('Anda yakin ingin mengirimnya');
		else
        $('#confirm .modal-body').html('unBlokir User');
		
		var $form=$(this).closest('form');
		e.preventDefault();
		$('#confirm').modal({ backdrop: 'static', keyboard: false })
        .one('click', '#delete', function (e) {
            $form.trigger('submit');
		});
	});
</script>
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
				<button class="btn btn-danger hapus_user" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	function datauser(){
		$.ajax({
			url: base_url + "main/ambildata",
			dataType: 'html',
			success: function(data) {
				
				$(".viewdata").html(data);
			}
		});
	}
	// var uTable;
	$(document).ready(function() {
		datauser();
		// uTable = $('#dataTable').DataTable();
	});
	
	$(document).on('click','.hapus_user',function(e){
		var id = $("#data-hapus").val();
		$.ajax({
			url: base_url + 'user/hapus_user',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			success: function(data) {
				if(data.erradm=='ok'){
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				if(data.ok=='ok'){
					sweet('Hapus!!!',data.msg,'success','success');
					datauser();
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
					$('#confirm-delete').modal('hide');
			}
		});
	});
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#data-hapus').val($(e.relatedTarget).data('id'));
	});
</script>