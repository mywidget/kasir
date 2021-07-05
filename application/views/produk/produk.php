<div class="container-fluid" id="container-wrapper">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800">Data produk</h1>
         <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="./">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page">Data produk</li>
         </ol>
     </div>
<div class="row">
<div class="col-md-12">
	<form action="#" method="post">
		<div class="card">
		<div class="card-header  d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-warning">List data produk</h6>
					 <span id="nestable-menu" class="float-right">
       <a href="<?=base_url();?>produk/add_produk" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
    </span>
                 </div>
				 
			<?php echo $this->session->flashdata('message'); ?>
			<div class="card-body table-responsive">
			 <div class="card-block">
				<table class="table table-bordered table-striped table-mailcard" id="dataTable">
					<thead>
						<tr>
							<th style="width:1% !important;">No</th>
							<th>Nama produk</th>
							<th>Jenis Produk</th>
							<th>Harga Dasar</th>
							<th style="width:5%;text-align:center">Aktif</th>
						</tr>
					</thead>
					<tbody>
<?php 
                    $no = 1;
                    foreach ($record as $row){
                    if ($row['pub'] == 1){ $aktif ='<i class="fa fa-check-circle"></i>'; }else{ $aktif = '<i class="fa fa-check-circle-o"></i>'; }
                    echo "<tr><td>$no</td>
                              <td><a  title='Edit Data' href='".base_url()."produk/edit_produk/$row[idp]'>$row[nproduk]</a></td>
                              <td>$row[jenis_cetakan]</td>
                              <td>".rp($row['harga_dasar'])."</td>
                              <td class='text-center'>$aktif</td>
                          </tr>";
                      $no++;
                    }
                  ?>
					</tbody>
				</table>
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
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
			</div>
			<div class="modal-body">
				<p>Anda akan menghapus satu url, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" type="button">Batal</button> <a class="btn btn-danger danger" href="#">Hapus</a>
			</div>
		</div>
	</div>
</div>
    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
            
            //$('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
        });
			var uTable;
			$(document).ready(function() {
			uTable = $('#dataTable').DataTable();
			});
    </script>