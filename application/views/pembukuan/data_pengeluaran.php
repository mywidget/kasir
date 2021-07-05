<?php
								if($result->num_rows() > 0){ ?>
								<div class="table-responsive-sm">
									<table class="">
										<thead>
											<tr>
												<th style="width:3%!important" class="text-right">No.</th>
												<th>Tanggal</th>
												<th class="text-left">Pencatat</th>
												<th class="text-left">Keterangan</th>
												<th class="text-right"></th>
												<th class="text-right">Total</th>
												<th class="text-center">Cetak</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$no=1;
											foreach($result->result() AS $aRow){ 
												$query = $this->db->query("SELECT 
												`tb_users`.`nama_lengkap` FROM
												`tb_users` WHERE `tb_users`.`id_user` =".$aRow->id_user);
												$row = $query->row();
												if($no%2==0){
												$warna = "background:#8c0023";
												$warna2 = "background:#8c0023";
												}else{
												$warna = "background:#ececfb;padding:10px";
												$warna2 = "background:#bfcfff";
												}
											?>
											<tr style="<?=$warna;?>">
												<td style="padding:3px"><b><a href='#' data-toggle='modal' data-target='#formadmin'  data-toggle='tooltip'  onclick='getid("<?=$aRow->id_pengeluaran;?>")' title='Rubah Pengeluaran'><?=$aRow->id_pengeluaran;?><a></b>
												</td>
												<td class="sorting_1"><b><?=$aRow->tgl_pengeluaran;?></b>
												</td>
												<td><?=$row->nama_lengkap;?></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php
													$sql= $this->db->query("SELECT * from pengeluaran_detail where id_pengeluaran=".$aRow->id_pengeluaran);
													$total = 0;
													foreach ($sql->result_array() as $rr){
														$tothar = $rr['harga'] * $rr['jumlah'];
													?>
													<tr style="<?=$warna;?>">
														<td></td>
														<td class="sorting_1"><i>&nbsp;</i></td>
														<td>&nbsp;</td>
														<td><i><?=$rr['keterangan'];?></i></td>
														<td><i>(<?=$rr['jumlah'];?> <?=$rr['satuan'];?> x <?=$rr['harga'];?>)</i></td>
														<td class="text-right"><i><?=rp($tothar);?></i></td>
														<td></td>
													</tr>
													
													<?php 
														$total = $total + $tothar;
													} ?>
													<tr style="<?=$warna2;?>">
														<td></td>
														<td class="sorting_1"></td>
														<td></td>
														<td></td>
														<td><b><i>Total</i></b></td>
														<td class="text-right"><b><i><?=rp($total);?></i></b></td>
														<td class="text-center"><a href="/cetak/<?=$aRow->id_pengeluaran;?>" target="_blank" class="btn btn-success btn-flat btn-sm pull-right"><b>Cetak</b></a>
														</td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
											<?php } ?>