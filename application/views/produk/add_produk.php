<div class="container-fluid" id="container-wrapper">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800">Add produk</h1>
         <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="./">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page">Add produk</li>
         </ol>
     </div>
<div class="row">
<div class="col-md-12">
	<form action="<?=base_url();?>produk/save_produk" method="post">
		<div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Form Produk</h6>
                 </div>
                 <div class="card-body">
						<div class="form-group">
                             <label for="nama">Nama produk</label>
                             <input type="hidden" class="form-control" id="id" name="id" value="0">
                             <input type="text" class="form-control" id="nama" name="nama" placeholder="" required>
                         </div>
						 <div class="form-group">
                             <label for="harga">Harga dasar</label>
                             <input type="text" class="form-control" id="harga" name="harga" placeholder="" required>
                         </div>
						 <div class="form-group">
                             <label for="harga">Jenis</label>
                             <select name="jenis" class="form-control custom-select" required>
							<?php
							foreach($jenis AS $row){
								echo '<option value="'.$row['id_jenis'].'">'.$row['jenis_cetakan'].'</option>';
							}
							?>
							</select>
                         </div>
                         <div class="form-group">
                             <label for="bahan">Bahan</label>
                            <select placeholder="Pilih bahan" name="bahan[]" class="selectize-control" id="chosen-tags" multiple required>
						</select>
                         </div>
                         <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
						 <a href="<?=base_url('produk');?>" class="btn btn-danger">Batal</a>
                 </div>
             </div>
	</form>
</div>
</div>
</div>
<script>
$(document).ready(function() {
$('#chosen-tags').selectize({
  labelField: 'name',
  valueField: 'id',
  searchField: 'name',
  plugins: ['remove_button'],
  options: [],
  create: false,
  load: function(query, callback) {
    if (!query.length) return callback();
    $.ajax({
       url: base_url+'produk/cari_bahan/',
      type: 'POST',
      dataType: 'json',
      data: {
        name: query,
      },
      error: function() {
        callback();
      },
      success: function(res) {
        callback(res);
      }
    });
  }
});
           // $('#chosen-tagsx').selectize({
		// plugins: ['remove_button'],
		// persist: true,
		// create: true,
		// render: {
		// item: function(data, escape) {
			// return '<div>' + escape(data.text) + '</div>';
					// }
				// }
			// });
        });
</script>