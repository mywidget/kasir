<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?=$title;?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$title;?></li>
        </ol>
    </div>
    <?php
        echo $this->session->flashdata('message');
    ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?=$title;?></h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?=base_url();?>/main/info_save" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="judul">Title</label>
                                <input type="hidden" class="form-control" id="id" name="id" value="1" required>
                                <input type="text" class="form-control" id="judul" name="title" value="<?=$rows['title'];?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="judul">Cek Update</label>
                                    <?php
                                        if($update==1){
                                            echo '<div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="update1" name="update" value="1" checked>
                                            <label class="custom-control-label" for="update1">Aktif</label></div>';
                                            echo '<div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="update2" name="update" value="0">
                                            <label class="custom-control-label" for="update2">Tidak</label></div>';
                                            }else{
                                            echo '<div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="update1" name="update" value="1">
                                            <label class="custom-control-label" for="update1">Aktif</label></div>';
                                            echo '<div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="update" name="update2" value="0" checked>
                                            <label class="custom-control-label" for="update2">Tidak</label></div>';
                                        } ?>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control textarea" id="deskripsi" name="deskripsi"  required><?=$rows['deskripsi'];?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ket">Keterangan login</label>
                                <textarea class="form-control textarea" id="ket" name="ket" required><?=$rows['ket'];?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?=$rows['email'];?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?=$rows['phone'];?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" id="fb" name="fb" value="<?=$rows['fb'];?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ig">Instagram</label>
                                <input type="text" class="form-control" id="ig" name="ig" value="<?=$rows['ig'];?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="facebook">Warna Invloce Lunas</label>
                                <div class="input-group">
                                    <span class="input-group-btn input-group-prepend"><span class="picker" id="picker1"></span></span>
                                    <input type="text" class="form-control" id="warna_lunas" name="warna_lunas" value="<?=$rows['warna_lunas'];?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ig">Warna Belum Lunas</label>
                                <div class="input-group">
                                    <span class="input-group-btn input-group-prepend"><span class="picker picker2" id="picker2"></span></span>
                                    <input type="text" class="form-control" id="warna_blunas" name="warna_blunas" value="<?=$rows['warna_blunas'];?>" required>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ig">Warna Tema</label>
                                <div class="input-group">
                                    <span class="input-group-btn input-group-prepend"><span class="picker tema" id="picker3"></span></span>
                                    <input type="text" class="form-control" id="tema" name="tema" value="<?=$rows['tema'];?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="ig">Logo Lunas</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">
                                            <img src="<?=base_url();?>uploads/<?=$rows['logo'];?>" height="20" alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo" name="logo">
                                        <label class="custom-file-label" for="logo">Pilih logo</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 260x40 pixel</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="logo_bw">Logo Belum Lunas</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">
                                            <img src="<?=base_url();?>uploads/<?=$rows['logo_bw'];?>" height="20" alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo_bw" name="logo_bw">
                                        <label class="custom-file-label" for="logo_bw">Pilih logo</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 260x40 pixel</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ig">Icon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">
                                            <img src="<?=base_url();?>uploads/<?=$rows['favicon'];?>" height="20" alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="icon" name="icon">
                                        <label class="custom-file-label" for="icon">Pilih icon</label>
                                    </div>
                                </div>
                                <small id="iconHelp" class="form-text text-muted">size 32x32 pixel</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">
                                            <img src="<?=base_url();?>uploads/<?=$rows['stamp_l'];?>" height="20" alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="lunas" name="lunas">
                                        <label class="custom-file-label" for="lunas">Pilih Stamp LUNAS</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 300x100 pixel</small>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">
                                            <img src="<?=base_url();?>uploads/<?=$rows['stamp_b'];?>" height="20" alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="blunas" name="blunas">
                                        <label class="custom-file-label" for="blunas">Pilih Stamp Belum Lunas</label>
                                    </div>
                                </div>
                                <small id="iconHelp" class="form-text text-muted">size 300x100 pixel</small>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <!--Row-->
    </div>
</div>
<style>
    .trumbowyg-box,
    .trumbowyg-editor {
    min-height: 100px!important;
    }
    .picker {
    border-radius: 0;
    width: 43px;
    height: 43px;
    cursor: pointer;
    }
    
</style>
<script src="<?= base_url('assets/'); ?>vendor/colorpick/colorPick.js"></script>  
<script>
    $(document).ready(function() {
    var warna = "<?=$rows['warna_lunas'];?>";
    $(".picker").css("background-color",warna);
    $("#warna_lunas").val(warna);
    
    var warna2 = "<?=$rows['warna_blunas'];?>";
    $("#warna_blunas").val(warna2);
    $(".picker2").css("background-color",warna2);
    
    var warna3 = "<?=$rows['tema'];?>";
    $("#temma").val(warna3);
    $(".tema").css("background-color",warna3);
    
    $('.textarea').trumbowyg();
    });
    $("#picker1").colorPick({
    'initialColor' : '#8e44ad',
    'palette': ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1"],
    'onColorSelected': function() {
    $("#warna_lunas").val(this.color);
    // console.log("The user has selected the color: " + this.color)
    this.element.css({'backgroundColor': this.color, 'color': this.color});
    }
    });
    $("#picker2").colorPick({
    'initialColor' : '#8e44ad',
    'palette': ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1"],
    'onColorSelected': function() {
    $("#warna_blunas").val(this.color);
    // console.log("The user has selected the color: " + this.color)
    this.element.css({'backgroundColor': this.color, 'color': this.color});
    }
    });
    $("#picker3").colorPick({
    'initialColor' : '#8e44ad',
    'palette': ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1"],
    'onColorSelected': function() {
    $("#tema").val(this.color);
    // console.log("The user has selected the color: " + this.color)
    this.element.css({'backgroundColor': this.color, 'color': this.color});
    }
    });
</script>