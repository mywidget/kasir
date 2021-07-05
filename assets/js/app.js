function cari_konsumen(){
	$('#modal-cari-2').modal({backdrop: 'static', keyboard: false});
	$("#modal-tambah-1").modal('hide');
	// var datasID = $(this).attr('data-id');
	// alert(datasID);
	var dataID = $("id_invoice").val();
	$.ajax({
		'url': base_url + 'penjualan/cari_konsumen',
		'data': {
			id: dataID
		},
		'method': 'POST',
		success: function(data) {
			$('#error_piutang').css('display','none');
			$("#data-cari").html(data);
		}
	})
}

shortcut.add("F1",function() {
	
});
shortcut.add("F2",function() {
	$(".cari").click();
});
shortcut.add("F3",function() {
	$(".tambah").click();
});

shortcut.add("ctrl+p",function() {
	$(".print").click();
	hideCari();hideTambah();
});
shortcut.add("ctrl+z",function() {
	$(".pending").click();
	hideCari();hideTambah();
});
shortcut.add("ctrl+b",function() {
	$(".bayarin").click();
	hideCari();hideTambah();
});
shortcut.add("ctrl+s",function() {
	$(".simpan").click();
	hideCari();hideTambah();
});
shortcut.add("ctrl+o",function() {
	$("#OpenCart-1").modal('show');
});
shortcut.add("escape",function() {
	hideCart();
});
shortcut.add("enter",function() {
	$(".swal2-confirm").click();
});
shortcut.add("ctrl+i",function() {
	$(".addmore").click();
});
$(document).ready(function() {
	
	$("#teleponadd").focus();
	$(".loadings").hide();
	// loadcount();baru();pending();konsumen();hari_ini();batal();
	
});
// $(document).on('click', '.tutup-cari', function() {
// $("#modal-cari-2").modal('hide');
// });
$(document).on('click', '.tambah', function() {
	$('#modal-tambah-1').modal({backdrop: 'static', keyboard: false});
	$("#modal-cari-2").modal('hide');
});


$(document).on('click', '.cari', function() {
	$('#modal-cari-2').modal({backdrop: 'static', keyboard: false});
	$("#modal-tambah-1").modal('hide');
	var dataID = $(this).attr('data-id');
	
	$.ajax({
		'url': base_url + 'penjualan/cari_konsumen',
		'data': {
			id: dataID
		},
		'method': 'POST',
		success: function(data) {
			$('#error_piutang').css('display','none');
			$("#data-cari").html(data);
		}
	})
});
$("#form-cari").submit(function(e) {
	e.preventDefault();
	
	$("#error_nama_cari").html('');
	$("#error_caritlp").html('');
	
	var dataform = $("#form-cari").serialize();
	$.ajax({
		url: base_url + "penjualan/update_konsumen",
		type: "POST",
		data: dataform,
		dataType: "json",
		beforeSend: function () {
			$(".loadings").show();
			$('#error_piutang').css('display','block');
		},
		success: function(arr) {
			if (arr.hasil == "ada") {
				$("#error_piutang").show();
				$("#error_piutang").html(arr.error);
				} else if (arr.hasil == "sukses") {
				$("#id_konsumen").val(arr.idk);
				$("#namanya").html(arr.nama);
				$("#tlpnya").html(arr.telp);
				$("#alamatnya").html(arr.alamat);
				$("#perusahaannya").html(arr.perusahaan);
				$("#idmember").html(arr.id_member);
				$('#modal-cari-2').modal('hide');
				// $.notify("Pelanggan updated", "info");
				// Notify("Pelanggan updated", null, null, 'info');
				hideCari();
				} else {
				sweet('Peringatan!!!','Maaf data tidak ditemukan','warning','warning');
				// $.notify("updated error", "danger");
				// Notify("updated error", null, null, 'danger');
			}
			searchFilter();
		}
	});
});

$("#form-finishing").submit(function(e) {
	e.preventDefault();
	
	var dataform = $("#form-finishing").serialize();
	$.ajax({
		url: base_url + "produk/update_finishing",
		type: "POST",
		data: dataform,
		dataType: "json",
		beforeSend: function () {
			$(".loadings").show();
		},
		success: function(arr) {
			console.log(arr);
			if (arr.ok == "ok") {
				$('#DetailCart').modal('hide');
			}
			},error: function (request, status, error) {
			console.log(request.responseText);
		}
	});
});


$('#modal-cari-2').on('hidden.bs.modal', function () {
	$('#error_piutang').css('display','none');
    $(this).find('form').trigger('reset');
	$('#error_piutang').hide();
});
function hideCari() {
	$("#modal-cari-2").removeClass("in");
	$(".modal-backdrop").remove();
	$("#modal-cari-2").hide();
	$('#error_piutang').hide();
}
$("#form-tambah").submit(function(e) {
	e.preventDefault();
	$("#error_namaadd").html('');
	$("#error_teleponadd").html('');
	$("#error_alamatadd").html('');
	$("#error_perusahaanadd").html('');
	$("#error_via").html('');
	
	var dataform = $("#form-tambah").serialize();
	$.ajax({
		url: base_url + "penjualan/input_konsumen",
		type: "post",
		data: dataform,
		dataType: 'json',
		success: function(arr) {
			if (arr.hasil == "sukses") {
				$('#modal-tambah-1').modal('hide');
				$("#id_konsumen").val(arr.idk);
				$("#panggilan").val(arr.nama);
				$("#namanya").html(arr.nama);
				$("#tlpnya").html(arr.telp);
				$("#alamatnya").html(arr.alamat);
				$("#perusahaannya").html(arr.perusahaan);
				$("#idmember").html(arr.id_member);
				} else if (arr.hasil == "ada") {
				$("#error_teleponadd").html(arr.telp);
				$("#error_input").hide();
				} else if (arr.hasil == "gagal") {
				$("#error_input").html(arr.input);
				} else {
				$("#error_namaadd").html(arr.nama);
				$("#error_teleponadd").html(arr.telp);
				$("#error_alamatadd").html(arr.alamat);
				$("#error_perusahaanadd").html(arr.perusahaan);
			}
			hideTambah();
		}
	});
});
$(document).on('click', '.clearada', function() {
	$("#teleponadd").val("");
	$("#panggilan").val("");
	$("#namaadd").val("");
	$("#alamatadd").val("");
	$("#perusahaanadd").val("");
	$("#via").val("");
	$('#panggilan,#namaadd,#teleponadd,#alamatadd,#perusahaanadd,#via,#save-cari').prop('disabled', this.value == "" ? true : false);
});
$(document).on('click', '.cariada', function() {
	$("#modal-tambah-1").modal('hide');
	var idkon = $(this).attr('data-idkon');
	var idin = $(this).attr('data-idin');
	var telpID = $(this).attr('data-idTelp');
	// var dataID = $(this).attr('data-id');
	// var telpID = $(this).attr('id');
	// alert(telpID);
	var telp = $('#teleponadd').val();
	if (telp != '') {
		telps = telp;
		} else {
		telps = '0';
	}
	$.ajax({
		url: base_url + "penjualan/cari_update",
		data: {
			id: idin,
			idkon: idkon,
			telp: telpID
		},
		method: 'POST',
		dataType: 'json',
		success: function(arr) {
			$('#error_piutang').css('display','');
			if (arr.hasil == "ada") {
				$("#error_piutang").show();
				$("#error_piutang").html(arr.error);
				} else if (arr.hasil == "sukses") {
				$("#id_konsumen").html(arr.idk);
				$("#namanya").html(arr.nama);
				$("#tlpnya").html(arr.telp);
				$("#alamatnya").html(arr.alamat);
				$("#perusahaannya").html(arr.perusahaan);
				$("#idmember").html(arr.id_member);
				$('#modal-cari').modal('hide');
				clearModal();
				hideTambah();
				searchFilter();
				} else {
				sweet('Peringatan!!!','Maaf data tidak ditemukan','warning','warning');
			}
		}
	})
});

function clearModal() {
	$("#teleponadd").val("");
	$("#panggilan").val("");
	$("#namaadd").val("");
	$("#alamatadd").val("");
	$("#perusahaanadd").val("");
	$("#via").val("");
	$('#panggilan,#namaadd,#teleponadd,#alamatadd,#perusahaanadd,#via,#save-cari').prop('disabled', this.value == "" ? true : false);
}
function hideTambah() {
	$("#modal-tambah-1").removeClass("in");
	$(".modal-backdrop").remove();
	$("#modal-tambah-1").hide();
	$(".cariada").hide();
	$(".takada").hide();
}
$('#modal-tambah-1').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
	$('#panggilan,#namaadd,#teleponadd,#alamatadd,#perusahaanadd,#medsos').prop('disabled', false);
	$(".cariada").hide();
	$(".takada").hide();
});


function load_modal(){
	$.ajax({
		url: base_url + "produk/modal_popup",
		success: function(data) {
			$('#load-modal').html(data);
			}
		});
	}
	$(document).on('click','.bayarin',function(e){
		e.preventDefault();
		var totalSum = angka($("#totalSum").val());
		var idkon = angka($("#id_konsumen").val());
		if(idkon==1){
			sweet('Peringatan!!!','Maaf konsumen kosong','warning','warning');
			}else if(totalSum==0){
			sweet('Peringatan!!!','Maaf data masih kosong','warning','warning');
			}else{
			var id = $(this).attr('data-id');
			cek_di_invoice(id);
		}
	});
	
	function load_list(id){
		$.ajax({
			'url': base_url + 'penjualan/list_bayar',
			'data': {
				id: id
			},
			'method': 'POST',
			success: function(data) {
				$(".load-bayar").html(data);
			}
		});
	}
	function cek_di_invoice(id){
		// 
		var total = $('#totalSum').val();
		var pajak = $('#pajaksum').val();
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/cek_di_invoice",
			data: {id:id,total:total,pajak:pajak},
			dataType: "json",
			beforeSend: function () {
				$(".loadings").show();
			},
			success: handleDataInv
		});	
	}
	function handleDataInv(data) {
		if(data.ok=='ok'){
			$('#pembayaran-5').modal({backdrop: 'static', keyboard: false});
			$.ajax({
				'url': base_url + 'penjualan/list_bayar',
				'data': {
					id: data.id
				},
				'method': 'POST',
				success: function(data) {
					$(".load-bayar").html(data);
				}
			});
			}else{
			// $(".simpan").click();
			// cek_di_invoice(data.id);
			sweet('Peringatan!!!','Maaf data belum disimpan','warning','warning');
		}
	}
	function cek_data_total(id){
		var pajak = $('#pajaksum').val();
		var iduser = $("#iduser").val();
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/cek_data_total",
			data: {id:id,iduser:iduser,pajak:pajak},
			dataType: "json",
			beforeSend: function () {
				$(".loadings").show();
			},
			success: handleData
		});	
	}
	function handleData(data) {
		if(data.ok=='ok'){
			var noin = data.id;
			var iduser = data.iduser;
			var total = data.total;
			$.ajax({
				type: 'POST',
				url: base_url + "penjualan/update_lunas",
				data: {id:noin,iduser:iduser,total:total},
				dataType: 'json',
				success: function(data) {
					searchFilter();
					// console.log(data);
				}
			});
			sweet_cetak(data.id);
			}else{
			// $(".simpan").click();
			// cek_data_total(data.id)
			sweet('Peringatan!!!','Data belum disimpan','error','danger');
		}
	}
	
	$(document).on('click','.print',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var c = $("#tablein > tbody").children().length;
		var totalSum = angka($("#totalSum").val());
		var idkon = angka($("#id_konsumen").val());
		if(idkon==1){
			sweet('Peringatan!!!','Maaf konsumen kosong','warning','warning');
			}else if(totalSum==0){
			sweet('Peringatan!!!','Maaf data masih kosong','warning','warning');
			}else{
			for (var a = 0; a < c; a++) {
				if ($('#kodeproduk_'+a).val() == ''){
					sweet('Peringatan!!!','kodeproduk masih kosong','warning','warning');
					return;
				}
				if ($('#jenis_cetakan_'+a).val() == ''){
					sweet('Peringatan!!!','jenis_cetakan_ masih kosong','warning','warning');
					return;
				}
				if ($('#ket_'+a).val() == ''){
					sweet('Peringatan!!!','Keterangan masih kosong','warning','warning');
					return;
				}
				if ($('#bahan_'+a).val() == ''){
					sweet('Peringatan!!!','Bahan masih kosong','warning','warning');
					return;
				}
				if ($('#jumlah_'+a).val() == ''){
					sweet('Peringatan!!!','jumlah_ masih kosong','warning','warning');
					return;
				}
				if ($('#satuan_'+a).val() == ''){
					sweet('Peringatan!!!','satuan_ masih kosong','warning','warning');
					return;
				}
				if ($('#harga_'+a).val() == ''){
					sweet('Peringatan!!!','harga_ masih kosong','warning','warning');
					return;
				}
			}
			
			cek_data_total(id);
		}
	});
	$(document).on('click','.pending',function(e){
		var uangmuka = angka($("#uangmuka").val());
		if(uangmuka>0){
			sweet('Peringatan!!!','Data tidak bisa di pending karena sudah ada pembayaran','warning','warning');
		}
	});
	$(document).on('click','.simpan',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var c = $("#tablein > tbody").children().length;
		var iduser = $("#iduser").val();
		var id_konsumen = $("#id_konsumen").val();
		var idlunas = angka($("#idlunas").val());
		var totalSum = angka($("#totalSum").val());
		if(id_konsumen==1){
			sweet('Peringatan!!!','Maaf Konsumen masih kosong','warning','warning');
			}else if(totalSum==0){
			sweet('Peringatan!!!','Maaf data masih kosong','warning','warning');
			}else{
			for (var a = 0; a < c; a++) {
				if ($('#kodeproduk_'+a).val() == ''){
					sweet('Peringatan!!!','kodeproduk masih kosong','warning','warning');
					return;
				}
				if ($('#jenis_cetakan_'+a).val() == ''){
					sweet('Peringatan!!!','jenis_cetakan_ masih kosong','warning','warning');
					return;
				}
				if ($('#ket_'+a).val() == ''){
					sweet('Peringatan!!!','Keterangan masih kosong','warning','warning');
					return;
				}
				if ($('#bahan_'+a).val() == ''){
					sweet('Peringatan!!!','Bahan masih kosong','warning','warning');
					return;
				}
				if ($('#jumlah_'+a).val() == ''){
					sweet('Peringatan!!!','jumlah_ masih kosong','warning','warning');
					return;
				}
				if ($('#satuan_'+a).val() == ''){
					sweet('Peringatan!!!','satuan_ masih kosong','warning','warning');
					return;
				}
				if ($('#harga_'+a).val() == ''){
					sweet('Peringatan!!!','harga_ masih kosong','warning','warning');
					return;
				}
				if ($('#harga_'+a).val() == 0){
					sweet('Peringatan!!!','harga_ masih kosong','warning','warning');
					return;
				}
			}
			simpan_data(id,iduser,idlunas,totalSum);
		}
	});
	$(document).on('click','.delbayar',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var idin = $(this).attr('data-idin');
		var kunci = $(this).attr('data-kunci');
		var jml = $(this).attr('data-jml');
		if(kunci==0){
			sweet('Peringatan!!!','data tidak bisa dihapus hub. admin','warning','warning');
			return;
		}
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/del_bayar",
			data: {id:id,noin:idin,kunci:kunci},
			dataType: 'json',
			beforeSend: function () {
				$(".loadings").show();
			},
			success: function(data) {
				if(data.ok=='ok'){
					var uangmukahide = angka($("#uangmuka").val());
					var sisabayarhide = angka($("#sisaSum").val());
					var tsisa = parseInt(angka(sisabayarhide)) + jml;	
					var tbayar = parseInt(uangmukahide) - parseInt(jml);
					$("#sisaSum").val(formatMoney(tsisa,0,"Rp."));	
					$("#uangmuka").val(formatMoney(tbayar,0,"Rp."));
					$(".loadings").hide();
					load_list(idin);
					doMath();
				}
			}
		});
	});
	
	function simpan_data(id,iduser,idlunas,total){
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/update_data",
			data: {id:id,iduser:iduser,idlunas:idlunas,total:total},
			dataType: 'json',
			beforeSend: function () {
				$(".loadings").show();
			},
			success: handleSave 
		});
	}
	function handleSave(data) {
		if(data.ok=='ok'){
			sweet_time(500,'Status!!!','Data sedang disimpan');
			}else{
			sweet('Peringatan!!!','Data gagal disimpan','error','danger');
		}
	}
	
	function cetak(id){
		var url = base_url+'produk/print_invoice/'+id;
		var url_html = base_url+'produk/print_invoice_html/'+id;
		$('#OpenCart-1').modal('hide');
		$('.cetak_invoice').html(id); //setter
		$('.invoice_print_url').html('<a href="'+url+'" target="_blank"><i class="fas fa-file-pdf"></i></a>');
		$('.print_url').html('<a href="'+url_html+'" target="_blank"><i class="fa fa-print"></i> Cetak Invoice</a>');
		$('#print-4').modal({backdrop: 'static', keyboard: false});
		$(".load-pdf").html('<iframe  id="documentiframe" src="'+base_url+'produk/print_invoice/'+id+'" frameborder="no" width="100%" height="600px" onload="success()"></iframe>');
	}
	$('body').on('hidden.bs.modal', '.modal', function() {
		$(this).removeData('bs.modal');
		$(".loadings").hide();
		$("#pending,#bayarin,#simpan,#batal").prop("disabled",false);
	});
	
	$('#OpenCart-1').on('hide.bs.modal', function() {
		// $(this).removeAttr('data-target');
		$(this).attr('data-target', '#OpenCart-1');
		$("#cart").attr('data-target', '#OpenCart-1');
		hideCart();
		searchFilter();
	});
	$('#pembayaran-5').on('show.bs.modal', function() {
		// alert(1);
		// doMath();
		$("#id_byr").val(0);
		$("#uangm").val(0);
		$("#totalbyr").val(0);
		$("#kembalian").val(0);
		$("#sumpajak").val(0);
		// $("#pajak").val(0);
	});
	$('#pembayaran-5').on('hide.bs.modal', function() {
		// alert(1);
		$("#id_byr").val(0);
		$("#uangm").val(0);
		$("#totalbyr").val(0);
		$("#kembalian").val(0);
		$("#sumpajak").val(0);
		// $("#pajak").val(0);
	});
	$('#OpenCart-1').on('show.bs.modal', function(e) {
		// alert(1);
		var id = $(e.relatedTarget).data('id');
		var edit = $(e.relatedTarget).data('modedit');
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/cart",
			data: {id:id,edit:edit},
			cache: false,
			beforeSend: function () {
				$(".loadings").show();
			},
			success: function(data) {
				// loadcount();
				$.getScript(base_url + "assets/js/penjualan.js");
				$(".loadings").hide();
				$('.load-data').html(data);
				$('#OpenTrx-1').modal('hide');
				
				// reloadScripts(scriptUrls,dtime);
			}
		});
	});
	
	function hideCart() {
		$("#OpenCart-1").removeClass("in");
		$(".modal-backdrop").remove();
		$("#OpenCart-1").hide();
	}
	$('#OpenTrx-1').on('show.bs.modal', function(e) {
		var id = $(e.relatedTarget).data('id');
		
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/trx/"+id,
			cache: false,
			beforeSend: function () {
				$(".loadings").show();
			},
			success: function(data) {
				// loadcount();
				$(".loadings").hide();
				$('.load-trx').html(data);
			}
		});
	});
	$('#OpenKon').on('show.bs.modal', function(e) {
		var id = $(e.relatedTarget).data('id');
		
		$.ajax({
			type: 'POST',
			url: base_url + "penjualan/data_konsumen/"+id,
			cache: false,
			beforeSend: function () {
				$(".loadings").show();
			},
			success: function(data) {
				// loadcount();
				$(".loadings").hide();
				$('.load-data-konsumen').html(data);
				// $.getScript(base_url + "assets/js/penjualan.js");
			}
		});
	});
	// function cek_login(){
	// $.ajax({
	// url:  base_url+"login/cek_login",
	// success: function (data) {
	// if(data=='logout'){
	// setInterval('location.reload()', 500); 
	// // return false;
	// }
	// // setInterval('location.reload()', 500); 
	// // return true;
	// }
	// });
	// }
	
	// var id_byr=0;
	$('.bayar_l').click(function(){
		// alert(1);
		
		var i = $("#tablein > tbody").children().length;
		var uang=angka($("#uangm").val());
		var totalSum=$("#totalSum").val();
		var sisabayar=$("#sisabayar").val();
		var noin=$("#id_invoice").val();
		var uid=$("#marketing").val();
		// var tgl=$("#tgl_bayar").val();
		var id_byr=$("#id_byr").val();
		var diskon=$("#diskon").val();
		var tdiskon=$("#tdiskon").val();
		var nourut=$("#no_bayar").val();
		var pajak=$("#pajak").val();
		
		if(id_byr == "" || id_byr==0) {
			sweet_time(5000,'Status!!!','Cara bayar belum dipilih');
			}else if(uang == "" || uang==0) {
			sweet_time(5000,'Status!!!','Uangnya masih kosong');
			$('#uangm').focus();
			}else{
			$.ajax({
				url : base_url + 'penjualan/save_bayar',
				dataType: "json",
				method: 'POST',
				data: {
					uang: uang,
					sisabayar: sisabayar,
					noin: noin,
					uid: uid,
					id_byr: id_byr,
					nourut: nourut,
					pajak: pajak,
					type: 'simpan_bayar'
				},
				success: function(result){
					if(result.ok=='no'){
						sweet('Peringatan!!!','Pajak belum disimpan','warning','warning');
						}else if(result.ok=='ok'){
						var total =  result.total;	
						var bayarsave =  result.uang;	
						var uangmukahide = angka($("#uangmuka").val());
						var sisabayarhide = angka($("#sisaSum").val());
						var tsisa = parseInt(angka(sisabayarhide)) - bayarsave;	
						var tbayar = parseInt(uangmukahide) + parseInt(bayarsave);
						$("#sisaSum").val(formatMoney(tsisa,0,"Rp."));	
						$("#uangmuka").val(formatMoney(tbayar,0,"Rp."));
						$("#sisabayar").val(formatMoney(tsisa,0,"Rp."));
						$("#uangm").val(0);
						if(tbayar==total){
							for (var a = 0; a < i; a++) {
								$("#case"+a).prop("disabled",true);
								$("#harga_"+a).prop("readonly",true);
								$("#ket_"+a).prop("readonly",true);
								$("#satuan_"+a).prop("readonly",true);
								$("#bahan_"+a).prop("readonly",true);
								$("#hargasatuan_"+a).prop("readonly",true);
								$("#jumlah_"+a).prop("readonly",true);
								$("#ukuran_"+a).prop("readonly",true);
								$("#kodeproduk_"+a).prop("readonly",true);
								$("#jenis_cetakan_"+a).prop("readonly",true);
								$("#diskon_"+a).prop("readonly",true);
							}
							searchFilter();
						}
						$('#pembayaran-5').modal('hide');
						}else{
						sweet('Peringatan!!!','Data gagal disimpan','warning','warning');
					}
				}
			});
			
		}
		
	});
	$("#id_byr").filter(function() {
		$('select[data-source]').each(function() {
			var $select = $(this);
			$select.append('<option value="0">Pilih</option>');
			$.ajax({
				url: $select.attr('data-source'),
				}).then(function(options) {
				options.map(function(option) {
					var $option = $('<option>');
					$option.val(option[$select.attr('data-valueKey')]).text(option[$select.attr('data-displayKey')]);
					$select.append($option);
				});
			});
		});
	});	