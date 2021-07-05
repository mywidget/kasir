<table class="table table-bordered table-striped table-mailcard" id="dataBahan">
	<thead>
		<tr>
			<th style="width:1% !important;">No</th>
			<th>Nama bahan</th>
			<th>Harga dasar</th>
			<th style="width:5%;text-align:center">Aktif</th>
			<th style="width:10%;text-align:center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			foreach ($record as $row){
				if ($row['pub'] == 1){ $aktif ='<i class="fa fa-check-circle"></i>'; }else{ $aktif = '<i class="fa fa-check-circle-o"></i>'; }
				$hapus = '<a data-href="'.base_url().'produk/hapus_bahan/'.$row['id'].'" data-toggle="modal" data-target="#confirm-delete" href="#"><i class="fa fa-trash"></i></a>';
				echo "<tr><td>$no</td>
				<td>$row[title]</td>
				<td>".rp($row['harga'])."</td>
				<td>$aktif</td>
				<td><center>
				<a class='btn-sm add_bahan' title='Edit Data' data-id='$row[id]' href='#'><i class='fa fa-pencil-alt'></i></a>
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
		uTable = $('#dataBahan').DataTable();
	});
</script>