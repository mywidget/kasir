<table class="table table-bordered table-striped table-mailcard" id="dataTable">
					<thead>
						<tr>
							<th style="width:1% !important;">No</th>
							<th style="width:10%;">Nama</th>
							<th>Email</th>
							<th>Tgl. Reg</th>
							<th style="width:5%;text-align:center">Aktif</th>
							<th style="width:10%;text-align:center">Aksi</th>
						</tr>
					</thead>
					<tbody>
<?php 
                    $no = 1;
                    foreach ($record as $row){
                    if ($row['level'] == 'admin'){ 
					// $hapus = "<a class='' title='Delete Data' href='#' onclick=\"return confirm('Admin tidak dapat dihapus !')\"><i class='fa fa-trash'></i></a>";
					$hapus = '<a data-id="'.$row['id_user'].'" data-toggle="modal" data-target="#confirm-delete" href="#"><i class="fa fa-trash text-info"></i></a>';
					}else{ 
						$hapus = '<a data-id="'.$row['id_user'].'" data-toggle="modal" data-target="#confirm-delete" href="#"><i class="fa fa-trash text-danger"></i></a>';
					// $hapus = "<a class='' title='Delete Data' href='".base_url()."main/hapus_user/$row[id_user]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><i class='fa fa-trash'></i></a>";
					}
                    if ($row['aktif'] == 'Y'){ $aktif ='<i class="fa fa-check-circle"></i>'; }else{ $aktif = '<i class="fa fa-check-circle-o"></i>'; }
                    echo "<tr><td>$no</td>
                              <td>$row[nama_lengkap]</td>
                              <td>$row[email]</td>
                              <td>$row[tgl_daftar]</td>
                              <td>$aktif</td>
                              <td><center>
                                <a class='btn-sm' title='Edit Data' href='".base_url()."user/edit_user/$row[id_user]'><i class='fa fa-pencil-alt'></i></a>
                                $hapus
                              </center></td>
                          </tr>";
                      $no++;
                    }
                  ?>
					</tbody>
				</table>
<script>
var uTable;
			$(document).ready(function() {
			uTable = $('#dataTable').DataTable();
			});
</script>
