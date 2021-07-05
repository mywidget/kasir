<input type="hidden" class="form-control" id="id_konsumencari" name="id_konsumencari">
<input type="hidden" class="form-control" id="id_invoicecari" name="id_invoicecari" value="<?=$id;?>">
<input type="hidden" class="form-control" id="id_member" name="id_member">
<div class="form-group">
	<label>Telepon</label>
	<div class="input-group">
		<input class="form-control caritlp" id="caritlp" name="caritlp"  autofocus="autofocus" required >
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" id="clear" type="button" id="button-addon2" disabled>X</button>
		</div>
	</div>
	
	<p style="color:red" id="error_caritlp"></p>
</div>
<div class="form-group tampil_form">
	<label>Nama Pelanggan</label>
	<input class="form-control" id="nama_cari" name="nama_cari" readonly >
	<p style="color:red" id="error_nama_cari"></p>
</div>
<div class="form-group tampil_form">
	<label>Alamat</label>
	<input class="form-control" id="alamat_cari" name="alamat_cari" readonly>
	<p style="color:red" id="error_alamatcari"></p>
</div>
<div class="form-group tampil_form">
	<input type="hidden" class="form-control" id="perusahaan_cari" name="perusahaan_cari">
	<p style="color:red" id="error_perusahaancari"></p>
</div>

<script>
	$(function() {
		
		$('#caritlp').keyup(function(){
			$('.tampil_form').hide();
			
			if(event.keyCode == 8){
				// $('#caritlp').val('');
				$('#id_konsumencari').val('');
				$('#id_member').val('');
				$('#nama_cari').val('');
				$('#alamat_cari').val('');
				$('#perusahaan_cari').val('');
			}
			if(event.keyCode == 13){
				$('.tampil_form').show();
			}
		})
		$("#caritlp").focus();
		$('.tampil_form').hide();
	});
	$("#clear").click(function() {
		$(".caritlp").focus();
		$('.tampil_form').hide();
		$('#caritlp').val('');
		$('#id_konsumencari').val('');
		$('#id_member').val('');
		$('#nama_cari').val('');
		$('#alamat_cari').val('');
		$('#perusahaan_cari').val('');
		$('#clear').prop('disabled',true);
		$('#caritlp').prop('readonly',false);
		$('#btn-simpan').prop('disabled',true);
	});
	$('#caritlp').autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : base_url+'penjualan/ajax_cari',
				dataType: "json",
				method: 'post',
				data: {
					name_startsWith: request.term,
					type: 'konsumen_cari',
					row_num : 1
				},
				success: function( data ) {
					response( $.map( data, function( item ) {
						var code = item.split("|");
						return {
							label: code[0],
							value: code[0],
							data : item
						}
					}));
				}
			});
		},
		
		autoFocus: true,	      	
		minLength: 3,
		select: function( event, ui ) {
			var names = ui.item.data.split("|");	
			$('#caritlp').val(names[0]);
			$('#id_konsumencari').val(names[1]);
			$('#nama_cari').val(names[2]);
			$('#alamat_cari').val(names[3]);
			$('#perusahaan_cari').val(names[4]);
			$('#id_member').val(names[5]);
			$('.tampil_form').show();
			$('#caritlp').prop('readonly',true);
			$('#clear').prop('disabled',false);
			$('#btn-simpan').prop('disabled',false);
		}
		});
</script>