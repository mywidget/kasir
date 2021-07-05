<?php
	// print_r($loadp);
	// echo $loadp->tgl_pengeluaran;
?>
<div class='row'>
	<div class="col-md-4">
		<label>NO. <span id="id_pengeluaran"><?=$loadp->id_pengeluaran;?></span></label>
		</div>
		<div class="col-md-4">
		<label>Pencatat: <span id="nama"><?=$nama;?></span></label>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text">Tanggal</span>
					</span>
					<input type="text" class="form-control date_p" id="date_p" value="<?=date_sll($loadp->tgl_pengeluaran);?>">
					<input type="hidden" class="form-control date_p" id="pencatat" value="<?=$id_user;?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<table class="table table-striped table-sm" id="table_pengeluaran">
				<thead>
					<tr>
						<td>Uraian</td>
						<td>Jenis</td>
						<td>Jumlah</td>
						<td>Harga</td>
						<td>Satuan</td>
						<td>Sub total</td>
						<td><button class="btn btn-info btn-sm add_mores"><i class="fa fa-plus"></i></button></td>
					</tr>
				</thead>
				
					<?php 
						$no=0;
						foreach($loadd AS $val){ ?>
						<tbody><tr class="row_Count" id="row_Count<?=$no;?>">
							<td><input value="<?=$val['no'];?>" id="id_pengeluaran_<?=$no;?>" type="hidden"><input class="form-control form-control-sm" value="<?php echo !empty($val['keterangan']) ? $val['keterangan'] : ''; ?>" id="uraian_<?=$no;?>" onchange="saved(<?=$no;?>);" type="text"></td>
							<td><input class="form-control form-control-sm" id="jenis_<?=$no;?>" type="text" value="<?=$val['jenis_cetakan'];?>" onchange="doPengeluaran();saved(<?=$no;?>);"><input value="<?=$val['id_biaya'];?>" id="id_jenis_<?=$no;?>" type="hidden"></td>
							<td><input class="form-control form-control-sm" id="jum_<?=$no;?>" type="text" value="<?=$val['jumlah'];?>" onchange="doPengeluaran();saved(<?=$no;?>);"></td>
							<td><input class="form-control form-control-sm" id="pharga_<?=$no;?>" type="text" value="<?=$val['harga'];?>" onchange="doPengeluaran();saved(<?=$no;?>);" onkeyup='formatNumber(this)'></td>
							<td><input class="form-control form-control-sm" id="psatuan_<?=$no;?>" type="text" value="<?=$val['satuan'];?>" onchange="doPengeluaran();saved(<?=$no;?>);"></td>
							<td><input class="form-control form-control-sm" id="ptotal_<?=$no;?>" type="text" readonly></td>
							<td><button class="btn btn-danger btn-sm" onclick="del_more(<?=$no;?>)"><i class="fa fa-times"></i></button></td>
						</tr></tbody>
					<?php $no++;} ?>
			
				<tfoot>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Total</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input class="form-control form-control-sm" id="total_pengeluaran" type="text" readonly></td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<script>
		doPengeluaran();
		window.onload = doPengeluaran;	
		$('.date_p').datepicker({clearBtn: true,format: "dd/mm/yyyy"});
		
		$(".add_mores").on('click', function() {
			i = $('#table_pengeluaran > tbody').length;
			var cols = '<tbody><tr id="row_Count'+i+'" class="row_Count"><td><input type="hidden" id="id_pengeluaran_'+i+'" /><input type="text" id="uraian_'+i+'" class="form-control form-control-sm"/></td>';
			cols +='<td><input class="form-control form-control-sm" id="jenis_'+i+'" type="text"  onchange="doPengeluaran();saved('+i+');"><input  id="id_jenis_'+i+'" type="hidden"></td>';
			cols +='<td><input type="text" id="jum_'+i+'" class="form-control form-control-sm" onchange="doPengeluaran();saved('+i+')"/></td><td> <input type="text" id="pharga_'+i+'" class="form-control form-control-sm" onchange="doPengeluaran();saved('+i+')" onkeyup="formatNumber(this)"/></td><td> <input type="text" id="psatuan_'+i+'" class="form-control form-control-sm" value="0" onchange="doPengeluaran();saved('+i+')" /></td><td> <input type="text" id="ptotal_'+i+'" class="form-control form-control-sm"/></td><td> <button class="btn btn-danger btn-sm" onclick="del_more('+i+');"><i class="fa fa-times"></i></button></td></tr></tbody>';
			$('#table_pengeluaran').append(cols);
			insert_detail_pengeluaran(i);
			load_jenis(i);
			satuan_load(i);
		}); //--end function--------------------------
		function insert_detail_pengeluaran(a) {
			var str = $("#id_pengeluaran").text();
			$.ajax({
				type: "POST",
				url: base_url + "pembukuan/add_detail",
				data: { id: str },
				dataType: "json",
				success: function(res) {
					if (res.ok == 'ok') {
						$("#id_pengeluaran_" + a).val(res.idr);
						$("#jenis_" + a).val('-');
						$("#id_jenis_" + a).val(res.jenis);
						} else {
						alert('error');
					}
				}
			});
		}
		function saved(a) {
			id = document.getElementById("id_pengeluaran_" + a.toString()).value; 
			ket = document.getElementById("uraian_" + a.toString()).value; 
			jenis = document.getElementById("id_jenis_" + a.toString()).value; 
			jum = angka(document.getElementById("jum_" + a.toString()).value); 
			harga = angka(document.getElementById("pharga_" + a.toString()).value); 
			satuan = document.getElementById("psatuan_" + a.toString()).value; 
			$.ajax({
				type: "POST",
				url: base_url + "pembukuan/save_detail",
				data: { id:id,ket:ket,jum:jum,harga:harga,satuan:satuan,jenis:jenis},
				dataType: "json",
				success: function(res) {
					if (res.ok == 'ok') {
						$("#id_pengeluaran_" + a).val(res.id);
						} else {
						alert('error');
					}
				}
			});
		}
		function del_more(i){
			id = document.getElementById("id_pengeluaran_" + i.toString()).value; 
			$.ajax({
				type: "POST",
				url: base_url + "pembukuan/hapus_detail",
				data: { id:id},
				dataType: "json",
				success: function(res) {
					if (res.ok == 'ok') {
						// $("#id_pengeluaran_" + a).val(res.id);
						jQuery('#row_Count' + i.toString()).remove();
						} else {
						alert('error');
					}
				}
			});
		}
		var c = $("#table_pengeluaran > tbody").children().length;	
		for (var a = 0; a < c; a++) {
			load_jenis(a);
			satuan_load(a);
		}
		function satuan_load(x){
			$('#psatuan_' + x).autocomplete({
				source: function(request, response) {
					$.ajax({
						url: base_url + 'produk/ajax',
						dataType: "json",
						method: 'post',
						data: {
							name_startsWith: request.term,
							type: 'satuan_table',
							row_num: 1
						},
						success: function(data) {
							response($.map(data, function(item) {
								var code = item.split("|");
								return {
									label: code[0],
									value: code[0],
									data: item
								}
							}));
						}
					});
				},
				autoFocus: true,
				minLength: 0,
				select: function(event, ui) {
					var names = ui.item.data.split("|");
					id_arr = $(this).attr('id');
					id = id_arr.split("_");
					$('#psatuan_' + id[1]).val(names[1]);
				}
				
			});
		}
		function load_jenis(a){
 $("#jenis_" + a).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'produk/ajax',
                dataType: "json",
                method: 'post',
                data: {
                    name_startsWith: request.term,
                    type: 'jenis_tablep',
                    row_num: 1
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("|");
                        return {
                            label: code[0],
                            value: code[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            var names = ui.item.data.split("|");
            $('#jenis_'+a).val(names[0]);
            $('#id_jenis_'+a).val(names[1]);
        }

    });
}
	</script>		