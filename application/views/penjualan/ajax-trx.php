<div class="card-body table-responsive">
	<div class="card-block">
		<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
			<thead>
				<tr>
					<th>No.Order</th>
					<th>Tgl. Order</th>
					<th>Konsumen</th>
					<th>No. HP</th>
					<th>Kasir</th>
					<th>Status</th>
					<th>Lunas</th>
					<th>Cetak</th>
					<th style="width:5%;">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($posts)){ 
					$no=$this->uri->segment(3)+1;
					foreach($posts as $row){ 
						$pdf = '';
						$print = '';
						$target = '';
						$pelunasan = '';
						$lunas = '-';
						$edit = '';
						$batal = '';
						$view = '';
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
							$pdf = '<a class="dropdown-item" href="'.$url_print.'" target="_blank"><span class="badge badge-success"><i class="fas fa-file-pdf"></i> PDF</span></a>';
							$print = '<a class="dropdown-item" href="javascript:open_popup(url_print)" ><span class="badge badge-primary"><i class="fa fa-print"></i> Print</span></a>';
							$target = '_blank';
							$pelunasan = '';
							}elseif($row["lunas"]==1 AND $row["status"]=='simpan'){
							$lunas = 'LUNAS';
							$pdf = '<a class="dropdown-item" href="'.$url_print.'" target="_blank"><span class="badge badge-success"><i class="fas fa-file-pdf"></i> PDF</span></a>';
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
						
						<td><a href="#" data-toggle="modal" data-id="<?php echo $row["id_invoice"]; ?>" data-modEdit="<?=$view;?>" data-target="#OpenCart-1" id="cart">#<?php echo $row["id_invoice"]; ?></a></td>
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
				<?php $no++; } }else{ ?>
                <tr><td colspan="10">Data masih kosong</td></tr>
				<?php } ?>
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
            <?php echo $this->ajax_pagination->create_links(); ?>
		</nav>
	</div><!-- /.card-body -->
</div><!-- /.card-body -->
<div class="loading" style="display: none;">
	<div class="content"></div>
</div>