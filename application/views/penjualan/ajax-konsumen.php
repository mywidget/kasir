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
								<th style="width:5%;">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($posts)){
								$no=$this->uri->segment(3)+1;
								foreach($posts as $row){ 
								$query = $this->db->query("SELECT 
									SUM(`invoice`.`total_bayar`) AS `total`
									FROM `invoice` WHERE
									`invoice`.`id_konsumen` =".$row['id']);
									$rows = $query->row();	
								?>
								<tr>
									<td><?php echo $no; ?></td>
									<td><a href="#" class="edit_konsumen" data-id="<?php echo $row["id"]; ?>"><?php echo $row["nama"]; ?></a></td>
									<td><?=$row["no_hp"];?></td>
									<td><?=$row["tgl_daftar"];?></td>
									<td><?=rp($rows->total);?></td>
									<td class="aksi"><a class="dropdown-item" href="<?=base_url();?>main/detail_konsumen/<?php echo $row["id"]; ?>"><span class="badge badge-primary">Detail</span></a></td>
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