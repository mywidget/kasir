<style>
	.card .table td, .card .table th {
    padding-right: 1rem;
    padding-left: 1rem;
	}
</style>
<div class="container-fluid mb-3" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#OpenCart-1">
			<i class="fas fa-cart-plus fa-fw"></i>Order Baru
		</a></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data Order</li>
		</ol>
	</div>
	<div class="card">
		<div class="row">
			<div class="col-md-12">
				<div class="card-header pb-0">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SORT</span>
						</div>
						<select id="sortBy" class="form-control custom-select" onchange="searchFilter()">
							<option value="ASC">ASC</option>
							<option value="DESC" selected>DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select" onchange="searchFilter()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">PILIH</span>
						</div> 
						<select id="trx" name="trx" class="form-control custom-select" onchange="searchFilter()">
							<?php foreach($select AS $key=>$val){
								echo '<option value="'.$key.'">'.$val.'</option>';
							}
							?>
						</select>
						<input type="date" id="tgl" value="<?=$tgl;?>" class="form-control" onchange="searchFilter();"/>
						<input type="text" id="keywords" class="form-control" placeholder="Cari data" onkeyup="searchFilter();"/>
						
					</div>
				</div>
				<div class="post-list pt-0" id="dataList">
					<div class="card-body table-responsive">
						<div class="card-block">
							<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
								<thead>
									<tr>
										<th style="width:10% !important;">No.Order</th>
										<th>Tgl.Order</th>
										<th>Konsumen</th>
										<th>No.HP</th>
										<th>Kasir</th>
										<th>Status</th>
										<th>Lunas</th>
										<th>Cetak</th>
										<th style="width:5%;">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($posts)){
										$no=1;
										foreach($posts as $row){ 
											$pdf = '';
											$print = '';
											$target = '';
											$pelunasan = '';
											$lunas = '-';
											$edit = '';
											$batal = '';
											$view = '';
											$url_pdf = base_url().'produk/print_invoice/'.$row['id_invoice'];
											$url_print = base_url().'produk/print_invoice_html/'.$row['id_invoice'];
											echo "<script>
											var url_print =  '$url_print';
											</script>";
											// '0=buka,1=Edit Order,2=hapus pembayaran,3=Edit Order Lunas,4=Pending 
											if($row["oto"]==0){
												$status = 'Buka';
												$view = 'edit';
												}elseif($row["oto"]==1){
												$status = 'Edit Order';
												$view = 'edit';
												}elseif($row["oto"]==2){
												$status = 'Hapus Pembayaran';
												$view = 'view';
												}elseif($row["oto"]==3){
												$status = 'Edit Order Lunas';
												$view = 'edit';
												}elseif($row["oto"]==4){
												$status = 'Pending';
												$view = 'view';
												}elseif($row["oto"]==5){
												$status = 'Batal';
												$view = 'view';
												}else{
												$status = 'Kunci';
												$view = 'view';
											}
											if($row["cetak"]>0){
												$cetak = 'YA';
												}else{
												$cetak = 'BELUM';
											}
											if($row["lunas"]==1 AND $row["status"]!='simpan'){
												// echo 1;
												$lunas = 'LUNAS';
												$pdf = '<a class="dropdown-item" href="'.$url_pdf.'" target="_blank"><span class="badge badge-success"><i class="fas fa-file-pdf"></i> PDF</span></a>';
												$print = '<a class="dropdown-item" href="javascript:open_popup(url_print)" ><span class="badge badge-primary"><i class="fa fa-print"></i> Print</span></a>';
												$target = '_blank';
												$pelunasan = '';
												}elseif($row["lunas"]==1 AND $row["status"]=='simpan'){
												$lunas = 'LUNAS';
												$pdf = '<a class="dropdown-item" href="'.$url_pdf.'" target="_blank"><span class="badge badge-success"><i class="fas fa-file-pdf"></i> PDF</span></a>';
												$print = '<a class="dropdown-item" href="javascript:open_popup(url_print);" ><span class="badge badge-primary"><i class="fa fa-print"></i> Print</span></a>';	
											}
											if($row["status"]=='baru' AND $row["id_konsumen"]==1){
												$print = '';
												$edit = '<a href="#" class="dropdown-item" data-toggle="modal" data-id="'.$row["id_invoice"].'" data-modEdit="'.$view.'" data-target="#OpenCart-1" id="cart"><span class="badge badge-info">Edit</span></a>';
												$pelunasan = '';
												$batal = '<a class="dropdown-item" href="#"><span class="badge badge-danger">Batal</span></a>';
											}
											if($row["status"]=='baru' AND $row["id_konsumen"]!=1){
												$print = '';
												$edit = '<a href="#" class="dropdown-item" data-toggle="modal" data-id="'.$row["id_invoice"].'" data-modEdit="edit" data-target="#OpenCart-1" id="cart"><span class="badge badge-info">Edit</span></a>';
												$pelunasan = '';
												$batal = '<a class="dropdown-item" href="#"><span class="badge badge-danger">Batal</span></a>';
											}
											if($row["status"]=='simpan' AND $row["lunas"]==0){
												$pdf = '<a class="dropdown-item" href="'.$url_print.'" target="_blank"><span class="badge badge-success"><i class="fas fa-file-pdf"></i> PDF</span></a>';
												$print = '<a class="dropdown-item" href="javascript:open_popup(url_print)" ><span class="badge badge-primary"><i class="fa fa-print"></i> Print</span></a>';
												if($this->session->level=='admin'){
													$edit = '<a href="#" class="dropdown-item" data-toggle="modal" data-id="'.$row["id_invoice"].'" data-modEdit="'.$view.'" data-target="#OpenCart-1" id="cart"><span class="badge badge-info">Edit</span></a>';
													$batal = '<a class="dropdown-item" href="#"><span class="badge badge-danger">Batal</span></a>';
												}
												$pelunasan = '<a class="dropdown-item" href="#"><span class="badge badge-success" data-toggle="modal" data-id="'.$row["id_invoice"].'" data-modEdit="pelunasan" data-target="#OpenCart-1" id="cart">Pelunasan</span></a>';
											}
											
											$button = $pdf.$print.$edit.$pelunasan.$batal;
										?>
										<tr>
											<td><a href="#" data-toggle="modal" data-id="<?php echo $row["id_invoice"]; ?>" data-modEdit="<?=$view;?>" data-target="#OpenCart-1" id="cart"><span class="badge badge-info">#<?php echo $row["id_invoice"]; ?></span></a></td>
											<td><?php echo $row["tgl_trx"]; ?></td>
											<td><?php echo $row["nama"]; ?></td>
											<td><?php echo $row["no_hp"]; ?></td>
											<td><?php echo $row["nama_lengkap"]; ?></td>
											<td><?php echo $row["status"]; ?></td>
											<td><?php echo $lunas; ?></td>
											<td><?php echo $cetak; ?></td>
											<td class="aksi"><div class="btn-group dropleft">
												<button type="button" class="btn btn-danger btn-sm customs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Edit
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Invoice #<?php echo $row["id_invoice"]; ?></a>
													<div class="dropdown-divider"></div>
													<?=$button;?>
												</div>
											</div></td>
										</tr>
									<?php $no++;} }else{ ?>
									<tr>
										<td colspan="10">Data belum ada</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<nav aria-label="Page navigation" class="mt-3">
								<?php 
									echo $this->ajax_pagination->create_links(); 
								?>
							</nav>
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
					<!-- Display posts list -->
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function open_popup(url)
	{
		var w = 880;
		var h = 570;
		var l = Math.floor((screen.width-w)/2);
		var t = Math.floor((screen.height-h)/2);
		var win = window.open(url, 'Cetak Invoice', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
	}
</script>