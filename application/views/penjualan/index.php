<div id="container">
    <?php
		if($id>0){
			$kon = pilih('konsumen','id',$proses['id_konsumen']);;
			$iduser = $this->session->idu;
			$id_invoice = $id;
			$pos = $proses['pos'];
			$oto = $proses['oto'];
			$pajak = $proses['pajak'];
			$id_konsumen = $proses['id_konsumen'];
			$nama = $kon['nama'];
			if(!empty($kon['panggilan'])){
				$nama = $kon['panggilan'].'. '.$kon['nama'];
			}
			$nick = $kon['panggilan'];
			$idmember = $kon['id_member'];
			$telp =$kon['no_hp'];
			$perusahaan = $kon['perusahaan'];
			$disabled = '';
			$tgl_invoice = tgl_ambil_1($proses['tgl_trx']);
			$tgl_ambil = tgl_ambil_1($proses['tgl_ambil']);
			$jam_ambil = jam_ambil($proses['tgl_ambil']);
			$marketing = $proses['id_marketing'];
			$total_bayar = $proses['total_bayar'];
			$lunas = $proses['lunas'];
			$button_1 = "";//pelanggan
			$button_2 = "";//tgl_order
			$readonly = "";
			$readonlym = "";
			if($proses['status']=='baru'){
				$readonlym = "readonly";
			}
			if($proses['status']=='simpan'){
				$readonly = "readonly";
				$disabled = 'disabled';
				$button_1 = 'disabled';
				$button_2 = 'readonly';
			}
			
			}else{
			$iduser =0;
			$id_invoice =0;
			$pos ='N';
			$oto =0;
			$pajak =0;
			$id_konsumen = 0;
			$idmember = '-';
			$nick = '-';
			$nama = '-';
			$disabled = '';
			$telp = '-';
			$perusahaan = '-';
			$readonly = '';
			$button_1 = '';
			$button_2 = '';
			$tgl_invoice = '-';
			$tgl_ambil = '-';
			$jam_ambil = '-';
			$marketing = '-';
			$total_bayar =0;
			$lunas =0;
			// echo "B";
		}
		$totbayar = 0;
		
		// $jdiskon = 0;
		// $tdiskon = 0;
		// echo $_SESSION['item'];
		// print_r($diskon);
		if($diskon->num_rows()>0){
			$rows =$diskon->row();
			$totbayar = $rows->totbayar;
			if($rows->jdiskon>0){
				$tdiskon=($totbayar*10)/100;
				$tdiskon = ($totbayar-$rows->jdiskon)/$totbayar*100;
				$tdiskon = 100-$tdiskon;
				$totbayar = rp($totbayar-$rows->jdiskon);
			}
			}else{
			$tdiskon = 0;
			$totbayar = 0;
		}
		// echo $totbayar;
		if($oto==5){ ?> <script>$("#batalin,#pending,#bayarin,#simpan").prop("disabled",false);</script> <?php }
		if($oto==1){ ?> <script>$("#pending,#bayarin,#simpan").prop("disabled",false);</script> <?php }
		if($oto==3){ $button_1 = 'disabled';$button_2 = 'readonly'; ?> <script>$("#pending,#bayarin,#simpan").prop("disabled",false);</script> <?php }
		if($cdetail==$totbayar AND $pos=='Y' AND $lunas==1 AND $oto !=3){
			$readonly = "readonly";
			$disabled = 'disabled';
			$button_1 = 'disabled';
			$button_2 = 'readonly';
		?>
		<script>
			$("#pending,#bayarin,#simpan").prop("disabled",true);
		</script>
		<?php
			// echo 2;
		}
		
		// echo $total_bayar;
		
		if($type=='edit'){
			$readonly = '';
			$disabled = '';
			}elseif($type=='lunas'){
			$readonly = 'readonly';
			$button_1 = 'disabled';
			}elseif($type=='pelunasan'){
			$readonly = 'readonly';
			$button_1 = 'disabled';
			}elseif($type=='pending'){
			$readonly = 'readonly';
			}elseif($type=='view'){
			$readonly = 'readonly';
			}elseif($type=='batal'){
			$readonly = 'readonly';
		}
		// echo $type;
		// echo $this->session->level;
			// echo $button_1;
	?>
    <input type="hidden" name="id_invoice" id="id_invoice" value="<?=$id_invoice;?>">
    <input type="hidden" name="id_konsumen" id="id_konsumen" value="<?=$id_konsumen;?>">
    <input type="hidden" name="iduser" id="iduser" value="<?=$iduser;?>">
    <input type='hidden' id='idsesi' value="<?=$idsesi;?>" />
    <input type='hidden' id='idlunas' value="<?=$lunas;?>" />
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none row">
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card shadow-none row">
                                <div class="card-header d-flex justify-content-between py-0">
                                    <h5 class="card-title"><strong id="namanya"><?=ucwords($nama);?></strong></h5>
                                    <div class="d-flex ">
										<div class="btn-group" role="group">
											<button type="button"  data-toggle='tooltip' title="Cari pelanggan" class="btn btn-primary btn-sm cari" id="cari" <?=$button_1;?>><i class="fa fa-search fa-1x" ></i> [F2]</button>
											<button type="button"  data-toggle='tooltip' title="Tambah pelanggan" class="btn btn-info btn-sm tambah" id="tambah" <?=$button_1;?>><i class="fa fa-user-plus fa-1x"></i> [F3]</button>
										</div>
									</div>
									
								</div>
                                <div class="card-body py-0">
                                    ID Member : <span id="idmember"><?php echo $idmember; ?></span>
                                    <hr class="p-1 m-0">
                                    <span id="tlpnya">Telp: <?php echo $telp;?></span>
                                    <hr class="p-1 m-0">
                                    <strong id="perusahaannya"><?=$perusahaan;?></strong>
                                    <hr class="p-1 m-0">
								</div>
							</div>
						</div>
                        <div class="col-md-4">
                            <div class="form-group mb-1">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Tanggal Pesanan</span>
									</span>
                                    <input type="date" class="form-control text-center tgl_invoice" onchange="save_invoice()" id="tgl_invoice" value="<?=$tgl_invoice;?>" <?=$button_2;?>>
								</div>
							</div>
                            <div class="form-group mb-1">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Tanggal Selesai</span>
									</span>
                                    <input type="date" class="form-control text-center" onchange="cektgl();save_invoice()" id="tgl_ambil" value="<?=$tgl_ambil;?>" <?=$readonly;?>>
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <input type="text" class="form-control text-center jam" onchange="save_invoice()"
									id="jam_ambil" value="<?=$jam_ambil;?>" placeholder="Jam" <?=$readonly;?>>
								</div>
							</div>
                            <div class="form-group mb-1">
                                <?php
									$pilih = pilih('tb_users','id_user',$marketing);
									$namamarketing=$pilih['nama_lengkap'];
									$id_user=$pilih['id_user'];
									// print_r($pilih);
								?>
                                <input type="hidden" id="marketing" value="<?=$marketing;?>">
								
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Kasir</span>
									</span>
                                    <input type="text" class="form-control" onchange="save_invoice()" id="namamarketing" value="<?=$namamarketing;?>" <?=$readonlym;?>  required>
								</div>
							</div>
						</div>
                        <div class="col-md-4">
                            <div class="form-group mb-1">
                                <div class="input-group">
									<span class="input-group-prepend">
                                        <span class="input-group-text">Pajak</span>
									</span>
                                    <input type="text" class="form-control text-right" id="pajaksum" value="<?=$pajak;?>" readonly="readonly">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Total</span>
									</span>
                                    <input type="text" class="form-control text-right w-50" id="totalSum" name="totalSum"
									readonly="readonly" aria-describedby="sizing-addon1">
								</div>
							</div>
                            <div class="form-group mb-1">
                                <div class="input-group">
                                    
									<span class="input-group-prepend">
                                        <span class="input-group-text">Bayar</span>
									</span>
                                    <input type="text" class="form-control text-right margin-5" id="uangmuka" value="<?=$totbayar;?>" readonly="readonly">
								</div>
							</div>
                            <div class="form-group mb-1">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">Sisa</span>
									</span>
                                    <input type="text" class="form-control text-right margin-5" id="sisaSum" value="0"
									readonly="readonly">
								</div>
							</div>
                            <div class="form-group">
                                <div class="input-group showd" style="display:none">
                                    <span class="input-group-prepend">Diskon</span>
                                    <input type="text" class="form-control" id="diskonb" name="diskonb"
									value="<?=$totbayar;?>" readonly="readonly">
                                    <span class="input-group-prepend">%</span>
                                    <span class="input-group-prepend">Bayar setelah diskon</span>
                                    <input type="text" class="form-control" id="bsd" name="bsd" value="<?=$totbayar;?>"
									readonly="readonly">
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class='row'>
        <div class="col-md-12">
            <table class="table table-striped table-sm" id="tablein">
				<thead>
					<tr>
						<td width="10" class="p-0">
							<button class="btn btn-default btn-sm addmore" id="addmore" type="button" data-toggle="tooltip" title="Tambah" <?=$disabled;?>><i class="fa fa-plus-circle"></i></button>
							<button class="btn btn-default btn-sm btnDelete" id="btnDelete" type="button" data-toggle="tooltip" title="Hapus" <?=$disabled;?> style="display:none"><i class="fa fa-minus-circle"></i></button>
						</td>
						<td>Produk</td>
						<td>Jenis</td>
						<td>Keterangan</td>
						<td>Bahan</td>
						<td style="width:70px!important">Ukuran</td>
						<td style="width:120px!important">Harga/m</td>
						<td style="width:70px!important">Jml</td>
						<td style="width:70px!important">Satuan</td>
						<td style="width:120px!important">Harga/pcs</td>
						<td style="width:70px!important">Disc %</td>
						<td>Total</td>
						<td><i class="fa fa-cog"></i></td>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=0;
						$ni=1;
						foreach($detail AS $val){
						?>
						<tr id='rowCount<?=$no;?>' class="rowCount" >
							<td align="center">
								<input type='hidden' id='id_rincianinvoice_<?=$no;?>' value="<?=$val['id_rincianinvoice'];?>" />
								<input type='checkbox' class='case' id="case<?=$no;?>" <?=$disabled;?> />
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input class="form-control input-sm" type='text' id='kodeproduk_<?=$no;?>'
									onchange="doMath()" value="<?=$val['title'];?>" onfocusout="sav(<?=$no;?>)"  <?=$readonly;?>/>
									<input type='hidden' id='id_produk_<?=$no;?>' value="<?=$val['id'];?>" />
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input type="text" class="form-control input-sm input" value="<?=$val['jenis'];?>"
									id="jenis_cetakan_<?=$no;?>" placeholder="jenis"  onfocusout="sav(<?=$no;?>)" <?=$readonly;?>/>
									<input type='hidden' id='id_jenis_<?=$no;?>' value="<?=$val['id_jenis'];?>" />
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0"><input type="text" class="form-control input-sm input" id='ket_<?=$no;?>' placeholder=""  value="<?=$val['keterangan'];?>" onfocusout="sav(<?=$no;?>)" <?=$readonly;?>/></div>
							</td>
							<td>
								<div class="form-group p-0 m-0"><input type="text" class="form-control input-sm input"
									placeholder="bahan" onchange="hitflexi(<?=$no;?>);sav(<?=$no;?>);doMath();" id="bahan_<?=$no;?>" placeholder="0" 
									value="<?=$val['nbahan'];?>" <?=$readonly;?>/>
									<input type='hidden' id='id_bahan_<?=$no;?>' value="<?=$val['idbahan'];?>" onfocusout="sav(<?=$no;?>)" />
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input type="text" value="<?=$val['ukuran'];?>" class="form-control input-sm ukur" onchange="hitflexi(<?=$no;?>);sav(<?=$no;?>);doMath();"
									id="ukuran_<?=$no;?>"  <?=$readonly;?> />
									<input type='hidden' id='totukuran_<?=$no;?>' value="<?=$val['tot_ukuran'];?>" />
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input type="text" class="form-control input-sm input" value="0"
									onchange="hitflexi(<?=$no;?>);sav(<?=$no;?>);" onkeyup='formatNumber(this)'
									id="hargasatuan_<?=$no;?>" value="<?=rp($val['harga_dasar']);?>" placeholder="0"
									<?=$readonly;?>/>
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input type="text" class="form-control input-sm ukur" value="<?=$val['jumlah'];?>"
									onchange="sav(<?=$no;?>)" onkeyup='formatNumber(this)' id="jumlah_<?=$no;?>" placeholder="0"
									<?=$readonly;?>/>
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input type="text" class="form-control input-sm ukur" value="<?=$val['satuan'];?>"
									onchange="sav(<?=$no;?>)" id="satuan_<?=$no;?>"  <?=$readonly;?>/>
								</div>
							</td>
							<td>
								<div class="form-group p-0 m-0">
									<input type="text" class="form-control input-sm input" value="<?=rp($val['harga']);?>"
									onchange="sav(<?=$no;?>)" onkeyup='formatNumber(this)' id="harga_<?=$no;?>" placeholder="0"
									<?=$readonly;?>/>
								</div>
							</td>
							<td>
								<input class="form-control text-center input-sm" type="text" id="diskon_<?=$no;?>" value="<?=$val['diskon'];?>" onchange="sav(<?=$no;?>)" <?=$readonly;?> >
							</td>
							<td>
								<div class="form-group p-0 m-0"><input type="text" class="form-control input-sm totalsz"
								id="total_<?=$no;?>" placeholder="0"  readonly /></div>
							</td>
							<td>
								<div class="form-group p-0 m-0"><button type="button" id='button_<?=$no;?>'
									class='btn btn-warning btn-sm' data-toggle='tooltip' title="Finishing" onclick="getproduk(<?=$no;?>)"
								<?=$disabled;?>>...</button></div>
							</td>
						</tr>
					<?php $no++;$ni++;} ?>
				</tbody>
			</table>
		</div>
	</div>
	
    <input type="hidden" name="baris" id="baris" value="<?=$no;?>">
    <input type="hidden" name="idnya" id="idnya" value="<?=$id_invoice;?>">
	
	
	<script>
		doMath();
		window.onload = doMath;	
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});
		// $('#table').arrowTable();
	</script>
    <style>
		
		.card.shadow-none {
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
		}
		
		.form-control {
        border-radius: 0 !important;
		}
		
		.input-group .form-control:last-child,
		.input-group-prepend:last-child,
		.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,
		.input-group-btn:first-child>.btn:not(:first-child),
		.input-group-btn:last-child>.btn,
		.input-group-btn:last-child>.btn-group>.btn,
		.input-group-btn:last-child>.dropdown-toggle {
        border-top-left-radius: 0px !important;
        border-bottom-left-radius: 0px !important;
		
		}
		
		.input-group-lg>.input-group-prepend>.input-group-text {
        padding: .5rem 1rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: 0;
		}
		
		.input-group-prepend span {
        -webkit-box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
        box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
        color: #fff;
        background-color: #888888;
        border-color: #777777;
		}
		
		.input-group-text {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: .375rem .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6e707e;
        text-align: center;
        white-space: nowrap;
        background-color: #eaecf4;
        border: 1px solid #d1d3e2;
        border-top-color: rgb(209, 211, 226);
        border-right-color: rgb(209, 211, 226);
        border-bottom-color: rgb(209, 211, 226);
        border-left-color: rgb(209, 211, 226);
        border-radius: 0;
		
		}
		
		.btnDelete {
        cursor: pointer;
        color: red
		}
	</style>