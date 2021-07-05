<table class="table table-bordered table-striped table-mailcard" id="data_Table">
	
	<thead>
		<tr>
			<th style="width:1% !important;">No</th>
			<th>Jenis produk</th>
			<th style="width:5%;text-align:center">Grup</th>
			<th style="width:5%;text-align:center">Aktif</th>
			<th style="width:10%;text-align:center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			foreach ($record as $row){
			if($row['status']==0){
			$status ='Penjualan';
			}else{
			$status ='Biaya';
			}
				if ($row['pub'] == 'Y'){ $aktif ='<i class="fa fa-check-circle text-success"></i>'; }else{ $aktif = '<i class="fas fa-minus-circle text-danger"></i>'; }
				$hapus = '<a data-id="'.$row['id_jenis'].'" data-toggle="modal" data-target="#confirm-delete" href="#"><i class="fa fa-trash text-danger"></i></a>';
				echo "<tr><td>$no</td>
				<td>$row[jenis_cetakan]</td>
				<td>$status</td>
				<td>$aktif</td>
				<td><center>
				<a class='btn-sm jenis' title='Edit Data' data-id='$row[id_jenis]' href='#'><i class='fa fa-pencil-alt text-info'></i></a>
				$hapus
				</center></td>
				</tr>";
				$no++;
			}
		?>
	</tbody>
</table>
<script>
	// var uTable;
	// $(document).ready(function() {
	// uTable = $('#data_Table').DataTable();
	// });
</script>