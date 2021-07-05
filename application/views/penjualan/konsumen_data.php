<style>
	.card .table td, .card .table th {
    padding-right: 1rem;
    padding-left: 1rem;
	}
</style>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Konsumen</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data Konsumen</li>
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
						<select id="sortBy" class="form-control custom-select w-5" onchange="searchFilterKonsumen()">
							<option value="ASC">ASC</option>
							<option value="DESC" selected>DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select" onchange="searchFilterKonsumen()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<input type="text" id="keywords" class="form-control" placeholder="Cari data" onkeyup="searchFilterKonsumen();"/>
						
					</div>
				</div>
				<div class="post-list pt-0" id="dataListKonsumen">
					<div class="card-body table-responsive">
						<div class="card-block">
							<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
								<thead>
									<tr>
										<th style="width:1% !important;">No.</th>
										<th>Nama</th>
										<th>No. HP</th>
										<th>Tgl.Daftar</th>
										<th>Total TRX</th>
										<th style="width:10%;">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($posts)){
										$no=1;
										foreach($posts as $row){ 
											$query = $this->db->query("SELECT 
											SUM(`invoice`.`total_bayar`) AS `total`
											FROM `invoice` WHERE
											`invoice`.`id_konsumen` =".$row['id']);
											$rows = $query->row();
										?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><a href="#"  class="edit_konsumen" data-id="<?php echo $row["id"]; ?>"><?php echo $row["nama"]; ?></a></td>
											<td><?=$row["no_hp"];?></td>
											<td><?=$row["tgl_daftar"];?></td>
											<td><?=rp($rows->total);?></td>
											<td class="aksi">
												<a class="dropdown-item" href="<?=base_url();?>penjualan/konsumen_data/<?php echo $row["id"]; ?>"><span class="badge badge-primary">Detail</span></a>
											</td>
										</tr>
									<?php $no++;} }else{ ?>
									<tr>
										<td colspan="10">Data belum ada</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<nav aria-label="Page navigation">
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