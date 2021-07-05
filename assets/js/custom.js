var url = window.location;

$('li.nav-item a').filter(function() {
    return this.href == url;
}).parentsUntil(".sidebar > .nav-link collapsed").addClass('active');

// var url = window.location;
// // for sidebar menu entirely but not cover treeview
$('ul.sidebar a').filter(function() {
    // alert(url);
    return this.href == url;
}).parent().addClass('collapsed');

// for treeview
$('li.nav-item a').filter(function() {
    // alert(url);
    return this.href == url;
}).closest('.collapse').addClass('show');


jQuery(document).ready(function(){
    jQuery('#viewerContainer').scrollbar();
    jQuery('.scrollbar-inner').scrollbar();
    jQuery('.scrollbar-dynamic').scrollbar();
	jQuery('.scrollbar-vista').scrollbar({
		"showArrows": true,
		"scrollx": "advanced",
		"scrolly": "advanced"
	});
});
$('.dropdown').on('shown.bs.dropdown', function(e) {
    $('.dropdown-menu input').focus();
});

function cariFilterIn(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keyword_cari').val();
    if (keywords.length >= 1) {
        
        $.ajax({
			type: 'POST',
			url: base_url + 'produk/cari_invoice',
			data: {page:page_num,keywords: keywords},
			beforeSend: function () {
                $('#button').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                $('.alert').hide();
                $('.loading-overlay').show();
                $('.overlay-content').html('<i class="fa fa-circle-o-notch fa-spin"></i>Loading');
			},
			success: function (data) {
                if(data=='error'){
                    sweet('Peringatan!!!','Maaf No. Order tidak ditemukan','warning','warning');
                    return;
                    }else{
                    $('#staticBackdrop').modal('show');
                    $('#hasil_cari').show();
                    $("#hasil_cari").html(data);
				}
			}
		});
	}
}

$(document).on('click', '.cari_invoice', function() {
    cariFilterIn();
});
$("#keyword_cari").keyup(function(event){
    if(event.keyCode == 13){
        // $('#hasil_cari').show();
        // $(".cari_invoice").click();
        cariFilterIn();
	}
});
$('.cari_invoice').prop('disabled',true);
$('#keyword_cari').keyup(function(){
    $('#hasil_cari').hide();
    $('.cari_invoice').prop('disabled', this.value == "" ? true : false);  
})
$(document).on('click', '.save_cari', function() {
    var idorder = $("#idorder").val();
    var idedit = $("#idedit").val();
    var idkasir = $("#idkasir").val();
    var jml_uang = angka($("#jml_uang").val());
    if(jml_uang!=''){
        $.ajax({
			type: 'POST',
			url: base_url + 'produk/cari_nominal',
			data: {idorder:idorder,idedit:idedit,idkasir:idkasir,jml:jml_uang},
			success: handleCari
		});
		return;
	}
	if(idedit==0){
		sweet('Peringatan!!!','Maaf Status belum dipilih','warning','warning');
		return;
	}
	if(idkasir==0){
		sweet('Peringatan!!!','Maaf kasir masih kosong','warning','warning');
		return;
	}
	simpan_cari(idorder,idedit,idkasir,jml_uang);
});
function simpan_cari(idorder,idedit,idkasir,jml) {
	$.ajax({
		'url': base_url + 'produk/save_cari_invoice',
		'data': {idorder:idorder,idedit:idedit,idkasir:idkasir,jml:jml},
		'method': 'POST',
		'dataType': 'json',
		success: function(data) {
			if(data.ok=='ok'){
				searchFilter();
				$('#staticBackdrop').modal('hide');
				}else if(data.ok=='errl'){
				sweet('Peringatan!!!',data.msg,'warning','warning');
				}else if(data.ok=='err_batal'){
				sweet('Peringatan!!!',data.msg,'warning','warning');
				}else if(data.ok=='errp'){
				sweet('Peringatan!!!',data.msg,'warning','warning');
				}else if(data.ok=='err'){
				sweet('Peringatan!!!','Maaf data gagal di simpan','warning','warning');
				}else{
				sweet('Peringatan!!!','Maaf anda tidak punya akses','warning','warning');
				return;
			}
		}
	});
}
function handleCari(data) {
	if(data.ok=='error'){
		sweet('Peringatan!!!','Maaf Nominal tidak ditemukan','warning','warning');
		return;
		}else if(data.ok=='edit'){
		$('#staticBackdrop').modal('hide');
		sweet('Edit!!!','Pembayaran sudah bisa dihapus','success','success');
		return;
		}else{
		simpan_cari(data.idorder,data.idedit,data.idkasir,data.jml)
	}
}
function searchFilter(page_num){
	page_num = page_num?page_num:0;
	var keywords = $('#keywords').val();
	var sortBy = $('#sortBy').val();
	var limits = $('#limits').val();
	var tgl = $('#tgl').val();
	var trx = $('#trx').val();
	var urlnya = base_url +"penjualan/ajaxPaginationData/"+page_num;
	$.ajax({
		type: 'POST',
		url: urlnya,
		data:{page:page_num,keywords:keywords,sortBy:sortBy,limits:limits,trx:trx,tgl:tgl},
		beforeSend: function(){
			$('.loadings').show();
		},
		success: function(html){
			$('#dataList').html(html);
			$('.loadings').fadeOut("slow");
		}
	});
}