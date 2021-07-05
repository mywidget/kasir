<div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800"><?=$judul;?></h1>
         <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="./">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page"><?=$judul;?></li>
         </ol>
     </div>
<?php
$attributes = array('class'=>'form-horizontal','role'=>'form');
	echo form_open_multipart($this->uri->segment(1).'/save_jenis',$attributes); 
?>
	<input type='hidden' name='id' value='0'>
     <div class="row">
         <div class="col-md-6">
             <!-- Form Basic -->
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary"><?=$judul;?></h6>
					 
                 </div>
                 <div class="card-body">
                     
                         <div class="form-group">
                             <label for="exampleInputEmail1">Email address</label>
                             <input type="email" name="email" class="form-control" required>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nama lengkap</label>
                             <input type="text" name="nama" class="form-control" required>
                         </div>
						 <div class="form-group">
                             <label for="exampleInputPassword1">Password</label>
                             <input type="password" name="password" class="form-control" value="" required>
                         </div>
							
                             <label>Aktif </label>
						<div class="form-group d-flex flex-row">
                             <div class="custom-control custom-radio">
                                 <input type="radio" id="aktif1" value="Y" name="aktif" class="custom-control-input" checked>
                                 <label class="custom-control-label" for="aktif1"> Ya </label>
                             </div>
                             <div class="custom-control custom-radio">
                                 <input type="radio" id="aktif2" value="N" name="aktif" class="custom-control-input">
                                 <label class="custom-control-label" for="aktif2"> Tidak </label>
                             </div>

                         </div>	
                         <button type="submit" name="submit" class="btn btn-info">Simpan</button>
                         <a href="/main/pimpinan" class="btn btn-danger">Batal</a>
                    
                 </div>
             </div>

           
         </div>
     </div>
	  </form>
 </div>