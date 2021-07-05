$(document).ready(function() {
	
	var idprint = $("#id_invoice").val();
	$('#print,#simpan,#cari').attr("data-id",idprint); //setter
	$('.tinvoice').html(idprint); //setter
	$('#id_nya').val(idprint); //setter
	$('#bayarin').attr("data-id",idprint); //setter
    $(".btnDelete").hide();
	var rowCount = 0;
    $(".addmore").on('click', function() {
        i = $('#tablein > tbody tr').length;
		count=$('#tablein tr').length;	
		// alert(i);
		// i = document.getElementById("baris").value;
		if(i >= 12){
			sweet('Peringatan!!!','Max per trx hanya 12 product','warning','warning');	
			return;
		}
        var cols = '<tbody>';
		cols += '<tr id="rowCount' + i + '" class="rowCount">';
        cols += '<td align="center"><input type="hidden" id="id_rincianinvoice_'+i+'" /><input type="checkbox" class="case" id="case'+i+'" /></td><td><div class="form-group p-0 m-0"><input class="form-control input-sm" type="text" id="kodeproduk_'+i+'" onchange="doMath()" onfocusout="sav('+i+')" /><input type="hidden" id="id_produk_'+i+'" /></div></td><td><div class="form-group p-0 m-0"> <input type="text" class="form-control input-sm input" id="jenis_cetakan_'+i+'" placeholder="jenis" onfocusout="sav('+i+')" /> <input type="hidden" id="id_jenis_'+i+'" /></div></td><td><div class="form-group p-0 m-0"><input type="text" class="form-control input-sm input" id="ket_'+i+'" placeholder="" onfocusout="sav('+i+')" /></div></td><td><div class="form-group p-0 m-0"><input type="text" class="form-control input-sm input" placeholder="bahan" onchange="hitflexi('+i+');sav('+i+');doMath();" id="bahan_'+i+'" placeholder="0" /> <input type="hidden" id="id_bahan_'+i+'" onfocusout="sav('+i+')" /></div></td><td><div class="form-group p-0 m-0"> <input type="text" class="form-control input-sm ukur" onchange="hitflexi('+i+');sav('+i+');doMath();" id="ukuran_'+i+'" /> <input type="hidden" id="totukuran_'+i+'" /></div></td><td><div class="form-group p-0 m-0"> <input type="text" class="form-control input-sm input" value="0" onchange="hitflexi('+i+');sav('+i+');doMath();" onkeyup="formatNumber(this)" id="hargasatuan_'+i+'" placeholder="0" /></div></td><td><div class="form-group p-0 m-0"> <input type="text" class="form-control input-sm ukur" onchange="doMath();sav('+i+')" onkeyup="formatNumber(this)" id="jumlah_'+i+'" placeholder="0" /></div></td><td><div class="form-group p-0 m-0"> <input type="text" class="form-control input-sm ukur" onchange="doMath();sav('+i+')" id="satuan_'+i+'" /></div></td><td><div class="form-group p-0 m-0"> <input type="text" class="form-control input-sm input" onchange="doMath();sav('+i+')" onkeyup="formatNumber(this)" id="harga_'+i+'" placeholder="0" /></div></td><td> <input class="form-control text-center input-sm" type="text" id="diskon_'+i+'" value="0" onchange="doMath();sav('+i+')" ></td><td><div class="form-group p-0 m-0"><input type="text" class="form-control input-sm totalsz" id="total_'+i+'" placeholder="0" readonly /></div></td><td><div class="form-group p-0 m-0"><button type="button" id="button_'+i+'" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Finishing" onclick="getproduk('+i+')">...</button></div></td>';
        cols += '</tr></tbody>';
        $('#tablein').append(cols);
		
        insert_invoice_detail(i);
        
		$('#tablein >tbody input[type="checkbox"]').click(function() {
			var rowCount = $("#tablein > tbody tr").children().length;
			var countcheck = $('#tablein > tbody input[type="checkbox"]:checked').length;
			// alert(rowCount);
			if (countcheck == 0) {
				$(".btnDelete").hide();
				$(".addmore").show();
			}
			if (countcheck > 0) {
				$(".btnDelete").show();
				$(".addmore").hide();
				shortcut.add("ctrl+d",function() {
					$(".btnDelete").click();
				});
			}
			if (countcheck >= rowCount) {
				sweet('Peringatan!!!','Sisain satu baris jangan di hapus semua a','warning','warning');
				$(".btnDelete").attr("disabled", true);
				$(".btnDelete").css("color", "#000");
				} else {
				$(".btnDelete").attr("disabled", false);
				$(".btnDelete").css("color", "#ff0000");
			}
		});
		$("#btnDelete").on('click', function() {
			// alert(1);
			// b = $("#tablein > tbody").children().length;
			
            if ($('#case' + i).length) {
                if (document.getElementById("case" + i.toString()).checked == true) {
                    kodeinvo = document.getElementById("id_rincianinvoice_" + i.toString()).value;
                    hapus_invoice_detail(kodeinvo);
					
                    jQuery('#rowCount' + i.toString()).remove();i--;
					return;
				}
			}
			
			$(".btnDelete").hide();
			$(".addmore").show();
			$("#tablein tr.rowCount input:checkbox").attr("disabled", false);
			doMath();
		});
        
		var idprod = $('#id_produk_' + i).val();
		produk_cari(i);
		satuan_cari(i);
		bahan_cari(i,idprod);
		jenis_cari(i);
		i++;
		////
		var inputWdithReturn = '100%';
		$('.ukur').focus(function() {
			if ($(this).attr('id').substring(0, 6) == 'jumlah') {
				inputWdith = '120px';
				} else if ($(this).attr('id').substring(0, 6) == 'ukuran') {
				inputWdith = '120px';
				} else if ($(this).attr('id').substring(0, 6) == 'satuan') {
				inputWdith = '100px';
			} else { inputWdith = '100px'; }
			$(this).animate({
				width: inputWdith
			}, 400)
		});
		
		$('.ukur').blur(function() {
			$(this).animate({
				width: inputWdithReturn
			}, 500)
		});
		
		$('.totalsz').focus(function() {
			inputWdith = '170px';
			$(this).animate({
				width: inputWdith
			}, 400)
			var nourut = $(this).attr('id').substring(0, 5);
			$('#total_' + nourut).animate({
				width: '120px'
			}, 400)
			
		});
		$('.totalsz').blur(function() {
			$(this).animate({
				width: inputWdithReturn
			}, 500)
			
		});
		$('.input').focus(function() {
			if ($(this).attr('id').substring(0, 5) == 'bahan') {
				inputWdith = '200px';
				} else if ($(this).attr('id').substring(0, 5) == 'jenis') {
				inputWdith = '150px';
				} else if ($(this).attr('id').substring(0, 5) == 'harga') {
				inputWdith = '150px';
				} else if ($(this).attr('id').substring(0, 11) == 'hargasatuan') {
				inputWdith = '150px';
			} else { inputWdith = '200px'; }
			$(this).animate({
				width: inputWdith
			}, 400)
		});
		
		$('.input').blur(function() {
			$(this).animate({
				width: inputWdithReturn
			}, 500)
		});
		////
	}); //--end function--------------------------
    //add detail data pesanan
    function insert_invoice_detail(a) {
        var str = $("#id_invoice").val();
        $.ajax({
            type: "POST",
            url: base_url + "penjualan/add_detail",
            data: { id: str },
            dataType: "json",
            success: function(res) {
                if (res.ok == 'ok') {
                    $("#id_rincianinvoice_" + a).val(res.idr);
					} else {
                    alert('error');
				}
			}
		});
	}
	
    $('#tablein >tbody input[type="checkbox"]').click(function() {
		var rowCount = $("#tablein > tbody").children().length;
        var countcheck = $('#tablein > tbody input[type="checkbox"]:checked').length;
		// alert(rowCount);
        if (countcheck == 0) {
            $(".btnDelete").hide();
            $(".addmore").show();
		}
        if (countcheck > 0) {
            $(".btnDelete").show();
            $(".addmore").hide();
			shortcut.add("ctrl+d",function() {
				$(".btn_Delete").click();
			});
		}
        if (countcheck >= rowCount) {
			sweet('Peringatan!!!','Sisain satu baris jangan di hapus semua s','warning','warning');
			// $(".btnDelete").hide();
            // $(".addmore").show();
			// return;
			$(".btnDelete").css("color", "#000");
            $("#btnDelete").attr("disabled", true);
            // $("#tablein tr.rowCount input:checkbox:not(:checked)").attr("disabled", true);
			// $('input:checkbox').removeAttr('checked');
			} else {
			$(".btnDelete").css("color", "#ff0000");
            $(".btnDelete").attr("disabled", false);
            // $(".addmore").hide();
			// $(".btnDelete").show();
            // $("#tablein tr.rowCount input:checkbox").attr("disabled", false);
		}
	});
	
    $(".btnDelete").on('click', function() {
		
        b = $("#tablein > tbody").children().length;
        for (var aa = 0; aa < b; aa++) {
            if ($('#case' + aa).length) {
                if (document.getElementById("case" + aa.toString()).checked == true) {
                    kodeinvo = document.getElementById("id_rincianinvoice_" + aa.toString()).value;
                    hapus_invoice_detail(kodeinvo);
                    jQuery('#rowCount' + aa.toString()).remove();aa--;
				}
			}
		}
        $(".btnDelete").hide();
        $(".addmore").show();
        $("#tablein tr.rowCount input:checkbox").attr("disabled", false);
        doMath();
	});
});
$(document).on('click', '#pending', function() {
	var id = $("#id_invoice").val();
	$.ajax({
		url: base_url + 'penjualan/pending_data',
		data: {id: id},
		method: 'POST',
		dataType:"json",
		success: function(data) {
			if(data.ok=='ok'){
				sweet('Pending!!!','Order berhasil dipending','success','success');
				$('#OpenCart-1').modal('hide');
				searchFilter();
				}else if(data.ok=='pending'){
				sweet('Pending!!!','Order masih dipending','success','success');
				$("#pending").prop("disabled",true);
				}else{
				sweet('Pending!!!','Order gagal dipending','warning','warning');
			}
		}
	})
});
function hapus_invoice_detail(c) {
    var str = c;
    $.ajax({
        type: "POST",
        url: base_url + "penjualan/hapus_detail",
        data: { idr: str },
        // dataType: "json",
        success: function(data) {
            // alert(str);
		}
	});
}
//

$('.cariada').tooltip('show');
$('.cariada').tooltip();
//// add konsumen

//Cek apakah tanggal pengambilan lebih kecil dari tanggal pesanan
function cektgl() {
    // var now = document.getElementById("hari_ini").value;
    var startDate = document.getElementById("tgl_invoice").value;
    var endDate = document.getElementById("tgl_ambil").value;
    // var tgld = document.getElementById("tgl_ambil_dummy").value;
	
	var x = new Date(startDate);
	var y = new Date(endDate);
	if(y < x){
		sweet('Peringatan!!!','tanggal pengambilan lebih kecil dari Tgl Order!!','error','danger');
		// document.getElementById("tgl_ambil").value=tgld;
	}
	
	// if(x > y){
	// sweet('Peringatan!!!','Tanggal Order harus sesuai!!','error','danger');
	// // document.getElementById("tgl_invoice").value=now;
	// // document.getElementById("tgl_ambil").value=tgld;
	// }
	
}

function save_invoice() {
	var id = $("#id_invoice").val();
	var tglin = $("#tgl_invoice").val();
	var tglambil = $("#tgl_ambil").val();
	var jamambil = $("#jam_ambil").val();
	var marketing = $("#marketing").val();
	$.ajax({
		url: base_url+"penjualan/auto_save_invoice",
		type: "POST",
		data: {id:id,tglin:tglin,tgla:tglambil,jam:jamambil,marketing:marketing},
		dataType: "json",
		success: function(arr) {
			console.log(arr);
			// if(arr.ok=='error'){
			// sweet('Peringatan!!!','Maaf data tidak bisa di update','warning','warning');
			// document.getElementById("jumlah_" + a.toString()).value=arr.jml;
			// document.getElementById("harga_" + a.toString()).value=arr.harga;
			// document.getElementById("diskon_" + a.toString()).value=arr.diskon;
			// }
			// doMath();
		}
	});
}

function sav(a) {
	doMath();
    str = a; 
    noin = document.getElementById("id_invoice").value; 
    totalSum = angka(document.getElementById("totalSum").value); 
    uangmuka = angka(document.getElementById("uangmuka").value); 
    str0 = document.getElementById("id_produk_" + a.toString()).value; 
    str1 = angka(document.getElementById("harga_" + a.toString()).value); 
    str2 = angka(document.getElementById("jumlah_" + a.toString()).value); 
    str3 = document.getElementById("satuan_" + a.toString()).value; 
    str4 = document.getElementById("id_rincianinvoice_" + a.toString()).value; 
    str5 = document.getElementById("ket_" + a.toString()).value; 
    str6 = document.getElementById("ukuran_" + a.toString()).value; 
    str7 = document.getElementById("id_bahan_" + a.toString()).value; 
    str9 = document.getElementById("id_jenis_" + a.toString()).value; 
    str10 = document.getElementById("totukuran_" + a.toString()).value; 
    str11 = document.getElementById("diskon_" + a.toString()).value; 
	///update with ajax
	$.ajax({
		url: base_url+"penjualan/auto_save_invoice_detail",
		type: "POST",
		data: "id_produk="+str0+"&jumlah="+str2+"&harga="+str1+"&id_rincianinvoice="+str4+"&ukuran="+str6+"&satuan="+str3+"&ket="+str5+"&id_bahan="+str7+"&jenis="+str9+"&totukuran="+str10+"&diskon="+str11+"&noin="+noin+"&jml="+totalSum+"&uangmuka="+uangmuka,
		dataType: "json",
		success: function(arr) {
			// console.log(arr);
			if(arr.ok=='error'){
				sweet('Peringatan!!!','Maaf data tidak bisa di update','warning','warning');
				document.getElementById("jumlah_" + a.toString()).value=arr.jml;
				document.getElementById("harga_" + a.toString()).value=arr.harga;
				document.getElementById("diskon_" + a.toString()).value=arr.diskon;
			}
			doMath();
		}
	});
	
}
$(document).ready(function() {
    var inputWdithReturn = '100%';
	
	$('.ukur').focus(function() {
        if ($(this).attr('id').substring(0, 6) == 'jumlah') {
            inputWdith = '120px';
			} else if ($(this).attr('id').substring(0, 6) == 'ukuran') {
            inputWdith = '120px';
			} else if ($(this).attr('id').substring(0, 6) == 'satuan') {
            inputWdith = '100px';
		} else { inputWdith = '100px'; }
        $(this).animate({
            width: inputWdith
		}, 400)
	});
	
    $('.ukur').blur(function() {
        $(this).animate({
            width: inputWdithReturn
		}, 500)
	});
	
	$('.totalsz').focus(function() {
        inputWdith = '170px';
        $(this).animate({
            width: inputWdith
		}, 400)
        var nourut = $(this).attr('id').substring(0, 5);
        $('#total_' + nourut).animate({
            width: '120px'
		}, 400)
		
	});
	$('.totalsz').blur(function() {
        $(this).animate({
            width: inputWdithReturn
		}, 500)
		
	});
    $('.input').focus(function() {
        if ($(this).attr('id').substring(0, 5) == 'bahan') {
            inputWdith = '200px';
			} else if ($(this).attr('id').substring(0, 5) == 'jenis') {
            inputWdith = '150px';
			} else if ($(this).attr('id').substring(0, 5) == 'harga') {
            inputWdith = '150px';
			} else if ($(this).attr('id').substring(0, 11) == 'hargasatuan') {
            inputWdith = '150px';
		} else { inputWdith = '200px'; }
        $(this).animate({
            width: inputWdith
		}, 400)
	});
	
    $('.input').blur(function() {
        $(this).animate({
            width: inputWdithReturn
		}, 500)
	});
	
});
//ukuran
function hitflexi(a) {
    var jc = document.getElementById("id_jenis_" + a.toString()).value;
    var ukuran = document.getElementById("ukuran_" + a.toString()).value;
    var h = document.getElementById("hargasatuan_" + a.toString()).value;
    var harga = document.getElementById("harga_" + a.toString()).value;
	var separators = ['X', '\\\+', 'x', '\\\(', '\\\)', '\\*', '/', ':', '\\\?'];
	var data = ukuran.split(new RegExp(separators.join('|'), 'g'));
    // var data = ukuran.split("x");
    var l = parseFloat(data[0]);
    var p = parseFloat(data[1]);
    hasil = p * roundToHalf(l);
    document.getElementById("totukuran_" + a.toString()).value = hasil;
    if (jc == 2 || jc == 3 || jc == 6) {
        if (hasil < 1) {
            document.getElementById("harga_" + a.toString()).value = 1 * angka(h);
			} else {
            document.getElementById("harga_" + a.toString()).value = formatMoney(p * (roundToHalf(l) * angka(h)));
		}
		} else {
        document.getElementById("harga_" + a.toString()).value = angka(harga);
	}
}

function roundToHalf(value) {
    var converted = parseFloat(value); // Make sure we have a number
    var decimal = (converted - parseInt(converted, 10));
    decimal = Math.round(decimal * 10);
    if (converted > 2 && converted < 3) {
        return (parseInt(converted, 10) + 1);
	}
    if (converted > 0 && converted < 1) {
        return (1);
	}
    if (decimal == 5) { return (parseInt(converted, 10) + 0.5); }
    if ((decimal < 1) || (decimal > 5)) {
        return Math.round(converted);
		} else {
        return (parseInt(converted, 10) + 0.5);
	}
}

function getjenis(pro) {
    pro = pro.toString();
    str3 = document.getElementById("jenis_cetakan_" + pro).value;
    str4 = document.getElementById("harga_" + pro).value;
    if (str3 == 1) {
        $('#hargasatuan_' + pro).val(harga(str4));
        hitflexi(pro);
		} else {
        $('#hargasatuan_' + pro).val(0);
	}
}
function produk_cari(x){
	$('#kodeproduk_' + x).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'produk/ajax',
                dataType: "json",
                method: 'POST',
                data: {
                    name_startsWith: request.term,
                    type: 'produk_table',
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
            $('#kodeproduk_' + id[1]).val(names[0]);
            $('#harga_' + id[1]).val(names[1]);
            $('#id_produk_' + id[1]).val(names[2]);
            $('#jenis_cetakan_' + id[1]).val(names[3]);
            $('#bahan_' + id[1]).val(names[4]);
            $('#id_jenis_' + id[1]).val(names[5]);
			$('#id_bahan_' + id[1]).val(names[6]);
            getjenis(id[1]);
		}
		
	});
}
function satuan_cari(x){
	$('#satuan_' + x).autocomplete({
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
            $('#satuan_' + id[1]).val(names[1]);
		}
		
	});
}
function bahan_cari(x,y){
	$('#bahan_' + x).autocomplete({
        source: function(request, response) {
			var idprod = $('#id_produk_' + x).val();
            $.ajax({
                url: base_url + 'produk/ajax',
                dataType: "json",
                method: 'post',
                data: {
                    name_startsWith: request.term,
                    type: 'bahan_table',
                    idprod: idprod,
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
            $('#bahan_' + id[1]).val(names[0]);
            $('#id_bahan_' + id[1]).val(names[1]);
            $('#hargasatuan_' + id[1]).val(names[2]);
		}
		
	});
}
function jenis_cari(x){
	$("#jenis_cetakan_" + a).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'produk/ajax',
                dataType: "json",
                method: 'post',
                data: {
                    name_startsWith: request.term,
                    type: 'jenis_table',
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
            $('#jenis_cetakan_'+a).val(names[0]);
            $('#id_jenis_'+a).val(names[0]);
		}
		
	});
}
///load produk
var b = $("#tablein > tbody").children().length;	
for (var a = 0; a < b; a++) {
	var idprod = $('#id_produk_' + a).val();
	produk_cari(a);
	satuan_cari(a);
	bahan_cari(a,idprod);
	jenis_cari(a);
} //----------------------------------------------------- end for


function getproduk(pro) {
	
    if (document.getElementById("jenis_cetakan_" + pro).value == '-') {
        alert('Isi dulu jenis Cetakannya !!!');
        return;
	}
    var invoice = $("#id_invoice").val();
    pro = pro.toString();
	
    var idr = document.getElementById("id_rincianinvoice_" + pro).value;
    var kode = document.getElementById("id_produk_" + pro).value;
    var jenis = document.getElementById("id_jenis_" + pro).value;
    $.ajax({
        type: 'POST',
        url: base_url + "produk/finishing",
        data: { id: idr, kode: kode, jenis: jenis,invoice:invoice },
        cache: false,
        // beforeSend: function () {
        // $(".se-pre-con").fadeIn("slow");
        // },
        success: function(data) {
            $('#finishing').html(data);
		}
	});
    $("#DetailCart").modal('show');
}
$('input').click(function() {
    this.select();
});

$("#pajak").prop("disabled",true);
$("#uangm").val(0);
$("#kembalian").val(0);
function lunasd() {
	totalbyr = angka(document.getElementById("totalbyr").value);
	totalbyr = parseInt(totalbyr);
	sisabayar = angka(document.getElementById("sisabayar").value);
	sisabayar = parseInt(sisabayar);
	if(totalbyr==0){
		document.getElementById("uangm").value = document.getElementById("sisabayar").value; 
		document.getElementById("totalbyr").value = document.getElementById("sisabayar").value; 
		}else if(totalbyr > sisabayar){
		document.getElementById("uangm").value = document.getElementById("totalbyr").value; 
		}else{
		document.getElementById("uangm").value = document.getElementById("sisabayar").value;
		document.getElementById("totalbyr").value = document.getElementById("sisabayar").value;
	}
	$("#kembalian").val(0);
}
function sumawal(){
	var bpajak;var total;
	bpajak = angka(document.getElementById("pajak").value);
	total = angka(document.getElementById("sisabayar").value);
	hbayar = ((total * bpajak) /100);
	document.getElementById("totalbyr").value = document.getElementById("sisabayar").value; 
	document.getElementById("sumpajak").value = formatMoney(hbayar, 0, "Rp."); 
}
function rehitung(){
	total = angka(document.getElementById("sisabayar").value);
	$("#sumpajak").val(formatMoney(total, 0, "Rp."));
}
function savpajak(){
	var noin=$("#id_invoice").val();
	var pj = $("#pajak").val();
	$.ajax({
		url : base_url +'penjualan/simpan_pajak',
		dataType: "json",
		method: 'POST',
		data: {
			id: noin,
			pajak: pj,
			type: 'simpan_pajak'
		},
		success: function(res){
			if(res.ok=='ok'){
				
				$("#pajaksum").val(res.pajak);
				doMath();
				}else{
				
			}
		}
	});
}
// $('#uangm').keyup(function() {
// $('#kembalian').val(0);
// });
function batal(){
	$("#pajak").prop("disabled",true);
	$("#batal").hide();
	$("#savpajak").hide();
	$("#pajakd").show();
}
function pajak(){
	$("#pajak").prop("disabled",false);
	$("#pajakd").hide();
	$("#batal").show();
	$("#savpajak").show();
	$("#kembalian").val(0);
	$("#uangm").val(0);
	$("#totalbyr").val(0);
}
function inputan(){
	var total;
	var bayar;
	var kembalian;
	var totbayar;
	var bpajak;
	var totalbyr;
	var tbyr;
	bpajak = angka(document.getElementById("pajak").value);
	tbyr = angka(document.getElementById("totalbyr").value);
	tbyr = parseInt(tbyr);
	total = angka(document.getElementById("sisabayar").value);
	total = parseInt(total);
	bayar = angka(document.getElementById("uangm").value);
	bayar = parseInt(bayar);
	if(bpajak >0 ){
		// if(bayar < tbyr){
		// sweet('Maaf!!!','Jumlah yg dibayar '+tbyr,'warning','warning');
		// $("#uangm").val(0);
		// }else{
		hbayar = ((total * bpajak) /100);
		$("#sumpajak").val(formatMoney(hbayar, 0, "Rp."));
		totalbyr = parseInt(total)+parseInt(hbayar);
		$("#totalbyr").val(formatMoney(totalbyr, 0, "Rp."));
		// }
		}else{
		$("#sumpajak").val(0);
		if(bayar > total){
			document.getElementById("totalbyr").value = document.getElementById("sisabayar").value; 
			totalbyr = angka(document.getElementById("totalbyr").value);
			kembalian = parseInt(bayar)-parseInt(totalbyr);
			kembalian = formatMoney(kembalian, 0, "Rp.");
			$("#kembalian").val(kembalian);
			}else if(bayar == total){
			document.getElementById("totalbyr").value = document.getElementById("sisabayar").value; 
			$("#kembalian").val(0);
			}else if(bayar < total){
			$("#totalbyr").val(formatMoney(bayar, 0, "Rp."));
			$("#kembalian").val(0);
			}else{
			alert(3);
			$("#pajak").val(0);
			$("#kembalian").val(0);
		}
	}
}

var total_cek = angka($("#totalSum").val());
var sisa_cek = angka($("#uangmuka").val());
var sisa_sum = angka($("#sisaSum").val());
if(total_cek == sisa_cek && sisa_sum > 0){
	$("#uangm").prop("disabled",true);
	$(".lunasd").prop("disabled",true);
	$("#id_byr").prop("disabled",true);
}
$('#namamarketing').autocomplete({
	source: function( request, response ) {
		$.ajax({
			url: base_url + 'produk/ajax',
			dataType: "json",
			method: 'post',
			data: {
				name_startsWith: request.term,
				type: 'marketing_table',
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
	minLength: 0,
	select: function( event, ui ) {
		var names = ui.item.data.split("|");	
		$('#namamarketing').val(names[0]);
		$('#marketing').val(names[1]);
	}	
	
});