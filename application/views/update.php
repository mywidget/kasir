<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Download update</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Backup</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">List File Update</h6>
						<span id="nestable-menu" class="float-right">
							<button type="button" class="btn btn-primary btn-sm cek" data-toggle="tooltip" title="Cek Versi">Cek Update</button>
							<button type="button" class="btn btn-success btn-sm download" data-toggle="tooltip" title="Download Update"><i class="fa fa-download"></i> Download</button>
							<button type="button" class="btn btn-info btn-sm update" data-toggle="tooltip" title="Update Versi"><i class="fa fa-download"></i> Update</button>
						</span>
					</div>
					<?php 
						$map = directory_map('./update/', FALSE, TRUE); 
					?>
					<div class="card-body table-responsive">
						<div class="card-block">
							<table class="table align-items-center table-flush table-hover" id="dataTableHover">
								<thead>
									<tr>
										<th style="width:5%!important">No</th>
										<th>Nama File</th>
										<th style="width:15%!important">Aksi</th>
									</tr>
								</thead>
								
							</table>
						</div><!-- /.card -->
					</div><!-- /.card -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('body').tooltip({selector: '[data-toggle="tooltip"]'});
		var dataTable1 = $('#dataTableHover').DataTable({   
			"ajax":{  
				url:base_url + 'update/list_data',
				type:"POST"             
			},
			"order": [[ 0, 'desc' ]],
			"columnDefs": [
			{ "targets": [1,2], "orderable": false }
			]
			
		});
		$(document).on('click', '.download', function() {
			if(navigator.onLine){
				$.ajax({
					'url': base_url + 'update/download',
					'method': 'POST',
					'dataType':'json',
					beforeSend: function(){	 
						$(".loadings").show();
					},
					success: function(data) {
						$(".loadings").hide();
						if(data.ok=='ok'){
							sweet('Update File!!!','Data berhasil dibackup','success','success');
							}else if(data.ok=='ook'){
							sweet('Update Version!!!',data.msg,'success','success');
							}else{
							sweet('Peringatan!!!','Data gagal dibackup','warning','warning');
						}
						dataTable1.ajax.reload();  
					}
				});
				}else{
				sweet('Peringatan!!!','Tidak ada koneksi','error','error');
			}
		});
		$(document).on('click', '.unzip', function() {
			
			var file = $(this).attr('data-file');
			// alert(file);
			$.ajax({
				'url': base_url + 'update/unzip',
				'method': 'POST',
				'data': {file:file},
				'dataType':'json',
				beforeSend: function(){	 
					$(".loadings").show();
				},
				success: function(data) {
					$(".loadings").hide();
					if(data.ok=='ok'){
						sweet('Update Version!!!',data.msg,'success','success');
						}else if(data.ok=='ook'){
						sweet('Update Version!!!',data.msg,'success','success');
						}else{
						sweet('Peringatan!!!',data.msg,'warning','warning');
					}
					dataTable1.ajax.reload();  
				}
				});
				
			});
			$(document).on('click', '.update', function() {
				if(navigator.onLine){
					var file = $(this).attr('data-file');
					// alert(file);
					$.ajax({
					'url': base_url + 'update/unzipup',
					'method': 'POST',
					'data': {file:file},
					'dataType':'json',
					beforeSend: function(){	 
						$(".loadings").show();
					},
					success: function(data) {
						$(".loadings").hide();
						if(data.ok=='ok'){
							sweet('Update Version!!!',data.msg,'success','success');
							}else if(data.ok=='ook'){
							sweet('Update Version!!!',data.msg,'success','success');
							}else{
							sweet('Peringatan!!!',data.msg,'warning','warning');
						}
						dataTable1.ajax.reload();  
					}
				});
				}else{
				sweet('Peringatan!!!','Tidak ada koneksi','error','error');
			}
		});
		$(document).on('click', '.cek', function() {
			if(navigator.onLine){
				$.ajax({
					'url': base_url + 'update/cek',
					'method': 'POST',
					'dataType':'json',
					beforeSend: function(){	 
						$(".loadings").show();
					},
					success: function(data) {
						$(".loadings").hide();
						if(data.ok=='ok'){
							sweet('Cek Version!!!',data.msg,'success','success');
							}else if(data.ok=='new'){
							sweet('Cek Version!!!',data.msg,'warning','warning');
							}else{
							sweet('Peringatan!!!',data.msg,'error','error');
						}
						dataTable1.ajax.reload();  
					}
				});
				}else{
				sweet('Peringatan!!!','Tidak ada koneksi','error','error');
			}
		});
		
		$(document).on('click', '.hapus', function(e) {
			e.preventDefault();
				var file = $(this).attr('data-file');
				$.ajax({
					'url': base_url + 'update/hapus',
					'method': 'POST',
					'data':{file:file},
					'dataType':'json',
					beforeSend: function(){	 
						$(".loadings").show();
					},
					success: function(data) {
						$(".loadings").hide();
						// console.log(data);
						if(data.ok=='ok'){
							sweet('Hapus File!!!','File berhasil dihapus','success','success');
							dataTable1.ajax.reload();  
							}else{
							sweet('Peringatan!!!','File gagal dihapus','warning','warning');
						}
					}
				});
			});
	});
</script>		