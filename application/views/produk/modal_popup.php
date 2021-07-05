<div class="modal fade modal-fullscreen-xl mymodal" id="OpenCart-1" tabindex="-1"
aria-labelledby="OpenCart-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content flat">
            <div class="modal-header bg-danger py-1 flat">
                <h5 class="modal-title text-white">INVOICE #<span class="tinvoice"></span></h5>
                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Tutup</button>
            </div>
            <div class="modal-body">
                <div class="load-data"></div>
            </div>
            <div class="modal-footer">
                    <button type="button" data-toggle='tooltip' data-placement="top" title="Tutup TRX [ESC]" class="btn btn-danger btn-sm mr-auto" data-dismiss="modal">[ESC]</button>
                    <button type="button" class="btn btn-info btn-sm print" data-toggle='tooltip' title="Print [CTRL+P]" id="print">Print</button>
                    <button type="button" class="btn btn-success btn-sm bayarin" id="bayarin" data-toggle='tooltip' title="Bayar [CTRL+B]" >Bayar</button>
                    <button type="button" class="btn btn-primary btn-sm simpan" id="simpan" data-toggle='tooltip' title="Simpan [CTRL+S]">Simpan</button>
                    <button type="button" class="btn btn-warning btn-sm pending" id="pending" data-toggle='tooltip' title="Pending">Pending</button>
                    <button type="button" class="btn btn-danger btn-sm batalin" id="batalin" data-toggle='tooltip' title="Batal" disabled>Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-fullscreen-xl" id="OpenTrx-1" tabindex="-1"
aria-labelledby="OpenTrx-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content flat">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="OpenTrx-1">Data transaksi</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body scrollbar-dynamic">
                <div class="load-trx"></div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade modal-fullscreen-xl" id="OpenKon" tabindex="-1"
aria-labelledby="OpenTrx-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content flat">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="OpenTrx-1">Data Konsumen</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body scrollbar-dynamic">
                <div class="load-data-konsumen"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-cari-2" tabindex="-1" aria-labelledby="modal-cari" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content flat">
            <form role="form" id="form-cari">
                <div class="modal-header py-1">
                    <h4 class="modal-title">Cari Pelanggan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="data-cari"></div>
                    <p style="color:red;font-weight:bold;display:none" id="error_piutang"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info tutup-cari"
                    data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-tambah-1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content flat">
            <form role="form" id="form-tambah" method="post">
                <div class="modal-header py-1">
                    <h4 class="modal-title">Tambah Pelanggan</h4>
                    <button type="button" class="close tutup-con" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="error_input"></span>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Telepon</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control phone form-control-sm" id="teleponadd" name="teleponadd" autofocus="" >
                                <div class="input-group-append" id="dispu">     
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label">Panggilan</label>
                        <div class="col-sm-9">
                            <select name="panggilan" id="panggilan" class="form-control custom-select pl-1"
                            required>
                                <option value="" selected></option>
                                <option value="Bpk">Bpk</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Mba">Mba</option>
                                <option value="Mas">Mas</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input class="form-control form-control-sm" id="namaadd" name="namaadd" autofocus="autofocus">
                            <input type="text" class="form-control" id="id_nya" name="id_nya" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea id="alamatadd" name="alamatadd" class="form-control"
                            rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Perusahaan</label>
                        <div class="col-sm-9">
                            <input class="form-control form-control-sm" id="perusahaanadd" name="perusahaanadd"
                            value="Personal">
                        </div>
                    </div>
                    
                    
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Referal</label>
                        <div class="col-sm-9">
                            <select name="via" id="via" class="form-control custom-select form-control-sm pl-1" required>
                                <option value="build" selected>langsung</option>
                                <option value="wa">whatsapp</option>
                                <option value="fb">facebook</option>
                                <option value="ig">instagram</option>
                                <option value="tw">twitter</option>
                                <option value="em">email</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save-cari">Simpan</button>
                    <button type="button" class="btn btn-danger tutup-con" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-edit-konsumen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content flat">
            <form role="form" id="form-edit-k" method="post">
                <div class="modal-header py-1">
                    <h4 class="modal-title">Edit Pelanggan</h4>
                    <button type="button" class="close tutup-con" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="error_input"></span>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Telepon</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control phone form-control-sm" id="telepon_edit" name="telepon_edit" autofocus="" >
                                <input type="hidden" class="form-control" id="id_edit" name="id_edit" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label">Panggilan</label>
                        <div class="col-sm-9">
                            <select name="panggilan_edit" id="panggilan_edit" class="form-control custom-select pl-1"
                            required>
                                <option value="" selected></option>
                                <option value="Bpk">Bpk</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Mba">Mba</option>
                                <option value="Mas">Mas</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input class="form-control form-control-sm" id="nama_edit" name="nama_edit" autofocus="autofocus">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea id="alamat_edit" name="alamat_edit" class="form-control"
                            rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Perusahaan</label>
                        <div class="col-sm-9">
                            <input class="form-control form-control-sm" id="perusahaan_edit" name="perusahaan_edit"
                            value="Personal">
                        </div>
                    </div>
                    
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label">Referal</label>
                        <div class="col-sm-9">
                            <select name="via_edit" id="via_edit" class="form-control custom-select form-control-sm pl-1" required>
                                <option value="build" selected>langsung</option>
                                <option value="wa">whatsapp</option>
                                <option value="fb">facebook</option>
                                <option value="ig">instagram</option>
                                <option value="tw">twitter</option>
                                <option value="em">email</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-sm-3 col-form-label">Boleh Utang</label>
                        <div class="col-sm-9">
                            <select name="status" id="status" class="form-control custom-select form-control-sm pl-1" required>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-3 col-form-label">Max Ngutang</label>
                        <div class="col-sm-9">
                            <input class="form-control form-control-sm" id="max_u" name="max_u">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger tutup-con" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- cetak invoice -->
<div class="modal fade modal-fullscreen-xl" id="print-4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-2 flat">
                <h4 class="modal-title">Cetak Invoice #<span class="cetak_invoice"></span> <span class="invoice_print_url"></span>&nbsp;&nbsp;<span class="print_url"></span></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body p-0 scrollbar-inner">
                <div id="loading" class="text-center" style="">Sedang memuat INVOICE ORDER #<span class="cetak_invoice"></span></div>
                <div id="error">Load Timeout Klik disini&nbsp;&nbsp;<span class="invoice_print_url"></span>&nbsp;&nbsp;<span class="print_url"></span></div>
                <div class="load-pdf"></div>
            </div>
        </div>
    </div>
</div>

<!-- bayar invoice -->
<div class="modal fade" id="pembayaran-5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content flat">
            <div class="modal-header py-1">
                <h4 class="modal-title">Bayar Invoice #<span class="tinvoice"></span></h4>
            </div>
            <div class="modal-body pb-0">
                <div class="form-group row mb-1">
                    <label for="bayar" class="col-4 col-form-label">Cara Bayar</label> 
                    <div class="col-8">
                        <select name="id_byr" id="id_byr" onchange="sumawal()" class="custom-select form-control" data-source="<?= base_url(); ?>produk/cara_bayar" data-valueKey="id" data-displayKey="name" required>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="pajak" class="col-4 col-form-label">Besar Pajak</label> 
                    <div class="col-8">
                        <div class="input-group">
                            <input id="pajak" name="pajak" value="0" type="text" onchange="inputan()" class="form-control form-control-sm"> 
                            <div class="input-group-append">
                                <div class="input-group-btn">
                                    <button type="button" onclick="pajak();" class="btn btn-warning btn-sm pajakd" id="pajakd">% input pajak</button>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <button style="display:none" type="button" onclick="savpajak();" class="btn btn-success btn-sm savpajak" id="savpajak" data-toggle='tooltip' title="Simpan Pajak"><i class="fa fa-save"></i></button>
                                        <button style="display:none" type="button" onclick="batal();" class="btn btn-danger btn-sm batal" id="batal"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="sisabayar" class="col-4 col-form-label">Sub Total</label> 
                    <div class="col-8">
                        <div class="input-group">
                            <input id="sisabayar" name="sisabayar" type="text" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                </div> 
                <div class="form-group row mb-0">
                    <label for="sisabayar" class="col-4 col-form-label">Total Pajak</label> 
                    <div class="col-8">
                        <div class="input-group">
                            <input id="sumpajak" name="sumpajak" type="text" value="0" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                </div> 
                <div class="form-group row mb-0">
                    <label for="sisabayar" class="col-4 col-form-label">Total bayar</label> 
                    <div class="col-8">
                        <div class="input-group">
                            <input id="totalbyr" name="totalbyr" type="text" value="0" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                </div> 
                <div class="form-group row mb-0">
                    <label for="uangm" class="col-4 col-form-label">Jml. Bayar</label> 
                    <div class="col-8">
                        <div class="input-group">
                            <input id="uangm" name="uangm" type="text" onchange="inputan()" onkeyup="formatNumber(this);" class="form-control form-control-sm"> 
                            <div class="input-group-append">
                                <div class="input-group-btn">
                                    <button type="button" onclick="lunasd();" class="btn btn-danger btn-sm lunasd">Lunas</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="kembalian" class="col-4 col-form-label">Kembalian</label> 
                    <div class="col-8">
                        <div class="input-group">
                            <input id="kembalian" name="kembalian" type="text" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="col-12 load-bayar">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary bayar_l" id="bayar_l">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="DetailCart" tabindex="-1" aria-labelledby="DetailCart" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content flat">
            <form role="form" id="form-finishing">
                <div class="modal-header">
                    <h4 class="modal-title">Finishing</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="finishing"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info tutup-cari"
                    data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="cetaksimpan" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content flat">
            <div class="modal-header py-1">
                <h3 class="modal-title">Cetak & Simpan data?</h3>
            </div>
            <div class="modal-body">
				<div class="form-group text-center">
                    <!-- Cetak dan Posting data-->
                    <p>Anda akan mencetak dan menyimpan data. 
                    <br>Pastikan data yang anda masukan sudah benar.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success okprint" type="button" id="print">Ya</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Akses Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="hasil_cari"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary save_cari" >Simpan</button>
            </div>
        </div>
    </div>
</div>
<style>
    iframe,#error {
    display: none;
    }
    #loading {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    }
    #error {
    height: 100%;
    justify-content: center;
    align-items: center;
    }
</style>
<script>
    
    var isTimeout;
    var isLoaded;
    
    function success() {
        if (isTimeout) {
            return;
        }
        
        $('#loading').hide();
        $('iframe').show();
        isLoaded = true;
    };
    
    setTimeout(function() {
        if (isLoaded) {
            return;
        }
        $('#loading').hide();
        $('iframe').hide();
        $('#error').show();
        $('#error').css('display','flex');
        isTimeout = true;
    }, 100000);
    
    $("#teleponadd").change(function() {
    var idinvoice = $("#idnya").val();
        var telp = $('#teleponadd').val();
        if (telp.length <= 9) {
            $("#dispu").html("<img src='" + base_url + "assets/img/ajax-loader.gif' data-toggle='tooltip' title='cek data'/>");
            } else {
            $.ajax({
                url: base_url + "penjualan/cek_telp",
                data: { telp: telp },
                type: "POST",
                dataType: "json",
                success: function(respon) {
                    if (respon[0] == 'ada') {
                        $("#dispu").html("<a href='#' class='btn btn-info btn-sm cariada' data-toggle='tooltip' data-placement='left' title='No. Telp. sudah ada' data-idkon='" + respon.idnya + "' data-idin='" + idinvoice + "' data-idTelp='" + telp + "'><i class='fa fa-user-plus'></i></a><a href='#' class='btn btn-danger btn-sm clearada' data-toggle='tooltip' data-placement='left' title='Clear'><i class='fa fa-user-times'></i></a>");
                        $('#panggilan,#namaadd,#teleponadd,#alamatadd,#perusahaanadd,#via,#save-cari').prop('disabled', true);
                        $("#panggilan").val(respon.panggilan);
                        $("#namaadd").val(respon.nama);
                        $("#perusahaanadd").val(respon.perusahaan);
                        $("#alamatadd").val(respon.alamat);
                        $("#via").val(respon.reff);
                        $('#errore').hide();
                        } else if (respon[0] == 'notelp') {
                        $("#errore").fadeIn(1000, function() {
                            $("#errore").html('<div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span>No. telp harus berawalan 0</div>');
                        });
                        } else {
                        $("#dispu").html("<button class='btn btn-success btn-sm takada' data-toggle='tooltip' data-placement='left' title='No. belum ada'><i class='fa fa-user'></i></button>");
                        $('#panggilan,#namaadd,#teleponadd,#alamatadd,#perusahaanadd,#via,#save-cari').prop('disabled', this.value == "" ? true : false);
                        $('#errore').hide();
                    }
                    
                }
            });
            return false;
        }
    });
    function searchFilterKonsumen(page_num){
        page_num = page_num?page_num:0;
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();
        var limits = $('#limits').val();
        var urlnya = '<?php echo base_url("penjualan/ajaxKonsumen/"); ?>'+page_num
        $.ajax({
            type: 'POST',
            url: urlnya,
            data:{page:page_num,keywords:keywords,sortBy:sortBy,limits:limits},
            beforeSend: function(){
                $('.loadings').show();
            },
            success: function(html){
                $('#dataListKonsumen').html(html);
                $('.loadings').fadeOut("slow");
            }
        });
    }
    $(document).on('click', '.edit_konsumen', function(e) {
        e.preventDefault();
        
        var dataID = $(this).attr('data-id');
        $.ajax({
            'url': base_url + 'main/cek_konsumen',
            'data': {id: dataID},
            'method': 'POST',
            dataType: 'json',
            success: function(data) {
                $('#modal-edit-konsumen').modal({backdrop: 'static', keyboard: false});
                $('#error_piutang').css('display','none');
                $("#id_edit").val(data.id);
                $("#panggilan_edit").val(data.panggilan);
                $("#telepon_edit").val(data.nohp);
                $("#nama_edit").val(data.nama);
                $("#alamat_edit").val(data.alamat);
                $("#perusahaan_edit").val(data.perusahaan);
                $("#via_edit").val(data.via);
                $("#status").val(data.status);
                $("#max_u").val(data.max);
            }
        })
    });
    $("#form-edit-k").submit(function(e) {
        e.preventDefault();
        var dataform = $("#form-edit-k").serialize();
        $.ajax({
            url: base_url + "main/update_konsumen",
            type: "post",
            data: dataform,
            dataType: 'json',
            success: function(arr) {
                if (arr.ok == "ok") {
                    sweet('Update!!!',arr.msg,'success','arr.ok');
                    searchFilterKonsumen();
                    }else{
                    sweet('Peringatan!!!',arr.msg,'warning','warning');
                }
                $('#modal-edit-konsumen').modal('hide');
            }
        });
    });
</script>