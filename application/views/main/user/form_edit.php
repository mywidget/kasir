<div class="container-fluid" id="container-wrapper">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800"><?=$judul;?></h1>
         <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="./">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page"><?=$judul;?></li>
         </ol>
     </div>
<?php
echo $this->session->flashdata('message');
$attributes = array('class'=>'form-horizontal','role'=>'form');
	echo form_open_multipart($this->uri->segment(1).'/edit_user',$attributes); 
?>
	<input type='hidden' name='id' value='<?=$rows['id_user'];?>'>
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
                             <input type="email" name="email" class="form-control" value="<?=$rows['email'];?>" required>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputPassword1">Nama lengkap</label>
                             <input type="text" name="nama" class="form-control" value="<?=$rows['nama_lengkap'];?>" required>
                         </div>
						 <div class="form-group">
                             <label for="exampleInputPassword1">Password</label>
                             <input type="password" name="password" class="form-control" value="">
                         </div>
						 <?php  
						 if ($rows['level'] == 'admin'){ 
							 $readonly ='readonly';
						 }else{
							 $readonly ='';
						 }
						 ?>
						<div class="form-group">
                             <label>Level akses</label>
							 <select name="level" class="custom-select form-control" <?=$readonly;?>>
							 <?php 
							  $akses =$this->model_app->view_ordering('hak_akses','id_level','ASC');
							 foreach($akses AS $key=>$val){
							 if($val['id_level']==$rows['id_level']){
							 echo '<option value="'.$val['id_level'].','.$val['level'].'" selected>'.$val['nama'].'</option>';
							 }else{
							 echo '<option value="'.$val['id_level'].','.$val['level'].'">'.$val['nama'].'</option>';
							 }
							 } ?>
							 </select>
                         </div>
                             <label>Aktif</label>
						<div class="form-group d-flex flex-row">
<?php  if ($rows['level'] == 'admin'){ ?>
<div class="custom-control custom-radio">
                                 <input type="radio" id="aktif1" value="Y" name="aktif" class="custom-control-input" checked>
                                 <label class="custom-control-label" for="aktif1">Ya</label>
                             </div>
<?php }else{ 
if ($rows['aktif']=='Y'){
?>
                             <div class="custom-control custom-radio">
                                 <input type="radio" id="aktif1" value="Y" name="aktif" class="custom-control-input" checked>
                                 <label class="custom-control-label" for="aktif1">Ya</label>
                             </div>
                             <div class="custom-control custom-radio">
                                 <input type="radio" id="aktif2" value="N" name="aktif" class="custom-control-input">
                                 <label class="custom-control-label" for="aktif2">Tidak</label>
                             </div>
<?php }else{ ?>
 <div class="custom-control custom-radio">
                                 <input type="radio" id="aktif1" value="Y" name="aktif" class="custom-control-input" >
                                 <label class="custom-control-label" for="aktif1">Ya</label>
                             </div>
                             <div class="custom-control custom-radio">
                                 <input type="radio" id="aktif2" value="N" name="aktif" class="custom-control-input" checked>
                                 <label class="custom-control-label" for="aktif2">Tidak</label>
                             </div>
<?php } ?>
<?php } ?>
                         </div>	
                         <button type="submit" name="submit" class="btn btn-success">Update</button>
                         <a href="<?=base_url();?>user" class="btn btn-danger">Batal</a>
                    
                 </div>
             </div>

           
         </div>
		 <div class="col-md-6">
             <!-- Form Basic -->
             <div class="card mb-4">
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-primary">Menu akses pengguna</h6>
					 
                 </div>
                 <div class="card-body">
                    <div class="over-user">
                                                    <!-- text input -->
<?php
$resultz = $this->db->query("SELECT * FROM menuadmin order by urutan");
foreach ($resultz->result_array() as $rowz){
$dataTz[$rowz['idparent']][] = $rowz;
}
echo checkbox($dataTz,0,0,$rows['idmenu']);
?>
                                                </div>
                 </div>
             </div>
         </div>
     </div>
	  </form>
 </div>