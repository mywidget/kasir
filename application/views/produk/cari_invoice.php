<?php
	// var_dump($posts);
	
?>
<div class="input-group mb-3 mt-2">
	<div class="input-group-prepend">
		<label class="input-group-text" >No. Order</label>
	</div>
	<input type="text" class="form-control" id="idorder" value="<?=$posts;?>" readonly>
</div>
<div class="input-group mb-3">
	<div class="input-group-prepend">
		<label class="input-group-text" for="idedit">Status</label>
	</div>
	<select class="custom-select" name="idedit" id="idedit" onchange="idedit()">
		<option value="0" selected>Pilih...</option>
		<option value="1">Edit Order</option>
		<option value="2">Hapus Pembayaran</option>
		<option value="3">Edit Order Lunas</option>
		<option value="4">Pending Order</option>
		<option value="5">Batal Order</option>
	</select>
</div>
<div class="input-group mb-3 jml_uang">
	<div class="input-group-prepend">
		<label class="input-group-text" for="idedit">Nominal</label>
	</div>
	<input type="text" onkeyup='formatNumber(this)' name="jml_uang" id="jml_uang" class="form-control">
</div>
<div class="input-group mb-3 jml_uang">
	<div id="load_bayar"></div>
</div>
</div>
<div class="input-group mb-3">
	<div class="input-group-prepend">
		<label class="input-group-text" for="idkasir">Kasir</label>
	</div>
	<select class="custom-select" id="idkasir">
		<option selected>Pilih kasir...</option>
		<?php  
			foreach ($pilihan AS $values){
				if($this->session->idu==$values['id_user']){
					echo '<option value="'.$values['id_user'].'" selected>'.$values['nama_lengkap'].'</option>';
					}else{
					echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
				}
			}
		?>
	</select>
</div>
<script>
	$(".jml_uang").hide();
	function idedit(){
		var idorder = $("#idorder").val();
		var idedit = $("#idedit").val();
		if(idedit==2){
			$(".jml_uang").show();
			load_bayar(idorder)
			}else{
			$(".jml_uang").hide();
		}
	}
	function load_bayar(a){
		$.ajax({
			'url': base_url + 'load/load_bayar',
			'data': {idorder:a},
			'method': 'POST',
			// 'dataType': 'json',
			success: function(data) {
					$('#load_bayar').html(data);
			}
		});
	}
</script>