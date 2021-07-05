<table class="table table-bordered table-striped table-mailcard" id="dataSatuan">
	<thead>
		<tr>
			<th style="width:1% !important;">No</th>
			<th>Nama satuan</th>
			<th style="width:5%;text-align:center">Aktif</th>
			<th style="width:10%;text-align:center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			foreach ($record as $row){
				if ($row['pub'] == 0){ $aktif ='<i class="fa fa-check-circle"></i>'; }else{ $aktif = '<i class="fas fa-minus-circle text-danger"></i>'; }
				$hapus = '<a data-id="'.$row['id'].'" data-toggle="modal" data-target="#confirm-delete" href="#"><i class="fa fa-trash text-danger"></i></a>';
				echo "<tr><td>$no</td>
				<td>$row[satuan]</td>
				<td>$aktif</td>
				<td><center>
				<a class='btn-sm ModSatuan' title='Edit Data' data-id='$row[id]' href='#'><i class='fa fa-pencil-alt text-info'></i></a>
				".$hapus."
				</center></td>
				</tr>";
				$no++;
			}
		?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$('#dataSatuan').DataTable();
	});
</script>