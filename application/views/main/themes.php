<?php 
	if ($this->session->level==''){
		redirect(base_url().'adm');
		exit;
	} 
	$sessid = session_id();
	$tema = info();
	$arr = curl();
	$vupdate = $arr->update;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?= base_url('uploads/'); ?><?=info()['favicon'];?>" rel="icon">
        <title><?= SITE_NAME; ?> - <?= $title; ?></title>
        <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css">
        <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"
		type="text/css">
        <link href="<?= base_url('assets/'); ?>css/ruang-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/ns-default.css">
        <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/ns-style-other.css">
        <link href="<?= base_url('assets/'); ?>css/style-adm.css" rel="stylesheet">
        <link href="<?= base_url('assets/'); ?>css/custom-style.css" rel="stylesheet">
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/selectize/css/selectize.css" />
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/colorpick/colorPick.css" />
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.min.css" />
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/bootstrap-datepicker/bootstrap-datepicker.css" />
		
        <link href="<?= base_url('assets/'); ?>vendor/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" />
		
        <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/jquery-ui-1.12.1/jquery-ui.js" type="text/javascript"></script>
        <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/popper/src/popper.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>
        <script src="<?= base_url('assets/'); ?>js/notif.js" type="text/javascript"></script>
        <script src="<?= base_url('assets/'); ?>vendor/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
        <script src="<?= base_url('assets/'); ?>js/shortcut.js" type="text/javascript"></script>
        <script src="<?= base_url('assets/'); ?>js/arrow-table.js" type="text/javascript"></script>
		<script src="<?= base_url('assets/'); ?>vendor/bootstrap-datepicker/bootstrap-datepicker.min.js" type="text/javascript"></script>
		<!-- Import Trumbowyg -->
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/trumbowyg/dist/ui/trumbowyg.min.css">
		<script src="<?= base_url('assets/'); ?>vendor/trumbowyg/dist/trumbowyg.min.js"></script>
		
		<!-- Import Trumbowyg plugins... -->
		<script src="<?= base_url('assets/'); ?>vendor/trumbowyg/dist/plugins/upload/trumbowyg.upload.js"></script>
        <style>
			.ui-autocomplete {
			max-height: 400px;
			overflow-y: auto;   /* prevent horizontal scrollbar */
			overflow-x: hidden; /* add padding to account for vertical scrollbar */
			z-index: 9999 !important;
			}
			.trx-scroller {
			overflow-x: auto; }
			.trx-scroller .modal-body {
			flex-wrap: nowrap;
			white-space: nowrap; }
			.bg-navbar {
			background-color:<?=$tema['tema'];?>;
			}
			.sidebar-light .sidebar-brand {
			color: #fafafa;
			background-color:<?=$tema['tema'];?>;
			}
		</style>
        <script>
			var vupdate = '<?= $vupdate; ?>';
			var base_url = '<?= base_url(); ?>';
			var dtime = '<?= $sessid; ?>';
			
			shortcut.add("Home",function() {
			window.location.href = base_url;
			});
			
			$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
			$('#dari').attr('autocomplete','off');
			$('#sampai').attr('autocomplete','off');
			
			});
		</script>
	</head>
	
    <body id="page-top" class="sidebar-toggled">
        <div id="wrapper">
            <?php
				$sq = $this->db->query("SELECT * from tb_users where email='".$this->session->emailu."'");
				$n =  $sq->row_array();
				$idm = $n['id_level'];
				$sidemenu = $n['idmenu'];
				
				if ($this->session->level=='admin'){
					$sql= $this->db->query("select * from menuadmin where idparent='0' AND aktif='Y' order by urutan ASC");
					}else{
					$sql= $this->db->query("select * from menuadmin where idmenu IN ($sidemenu) AND idparent='0' AND aktif='Y' order by urutan ");
				}
				
				// echo $link_menu;
			?>
            <!-- Sidebar -->
            <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/main">
                    <div class="sidebar-brand-icon">
                        <img src="<?= base_url('uploads/'); ?><?=info()['favicon'];?>">
					</div>
                    <div class="sidebar-brand-text mx-3">Panel Admin</div>
				</a>
                <hr class="sidebar-divider my-0">
				
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('main'); ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
				</li>
                <?php
					$link_menu = $this->uri->segment(1);
					foreach ($sql->result_array() as $m){
						$idlm = $m['id_level']; 
						$carimenu=$this->db->query("select * from menuadmin where link='$m[link]'");
						$sm = $carimenu->row_array();
						$menuid = explode(",",$idm);
						if (in_array($idm, $menuid)){
							$nama_menu = $sm['nama_menu'];
							$id_nama_menu = $m['nama_menu'];
						}
						
						if($m['treeview']=='header'){
							echo  '<hr class="sidebar-divider"><div class="sidebar-heading">
							'.$m['nama_menu'].'
							</div>';
						}
						elseif($m['treeview']=='modal'){
							echo ' <li class="nav-item">
							<a class="nav-link openPopup" href="javascript:void(0);" data-href="'.base_url().$m['link'].'">
							<i class="fa fa-fw fa-'.$m['icon'].'"></i>
							<span>'.$m['nama_menu'].'</span>
							</a>
							</li>';
						}
						elseif($m['treeview']=='treeview'){
							$sub=$this->db->query("SELECT * FROM menuadmin WHERE idmenu IN ($sidemenu) AND idparent=$m[idmenu] AND aktif='Y' order by urutan");
							$subs=$this->db->query("SELECT * FROM menuadmin WHERE idparent='$m[idmenu]' AND aktif='Y' order by urutan")->row_array();
							
							$jml=$sub->num_rows();
							echo '<li class="nav-item '.$m['link'].'">
							<a class="nav-link collapsed" href="'.base_url().$m['link'].'" data-toggle="collapse" data-target="#ex'.$m['idmenu'].'" aria-expanded="true" aria-controls="ex'.$m['idmenu'].'">
							<i class="fa fa-fw fa-'.$m['icon'].'"></i>
							<span>'.$m['nama_menu'].'</span>
							</a>';
							if (isset($subs)){
								if($subs['link']==$link_menu){
									echo '<div id="ex'.$m['idmenu'].'" class="collapse show" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">';
									}else{
									echo '<div id="ex'.$m['idmenu'].'" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">';
								}
								}else{
								echo '<div id="ex'.$m['idmenu'].'" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">';
							}
							if ($jml > 0){
								
								echo'<div class="bg-white py-2 collapse-inner rounded">
								<h6 class="collapse-header">'.$m['nama_menu'].'</h6>';
								foreach ($sub->result_array() as $w){	
									echo '<a class="collapse-item" href="'.base_url().$w['link'].'">'.$w['nama_menu'].'</a>';
								}
								echo'</div>';
							}
							echo '</div>';
							echo '</li>';
							}else{
							echo ' <li class="nav-item">
							<a class="nav-link" href="'.base_url('').$m['link'].'">
							<i class="fa fa-fw fa-'.$m['icon'].'"></i>
							<span>'.$m['nama_menu'].'</span>
							</a>
							</li>';
						}
					}
				?>
                <hr class="sidebar-divider">
                <div class="version" id="version-ruangadmin"></div>
			</ul>
            <!-- Topbar -->
            <div id="content-wrapper" class="d-flex flex-column">
				<div class="loadings"></div>
                <div id="content">
                    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
						</button>
                        <ul class="navbar-nav ml-auto">
							<li class="nav-item dropdown no-arrow">
								<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fas fa-search fa-fw"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
									<form class="navbar-search">
										<div class="input-group">
											<input type="text" id="keyword_cari" class="form-control bg-light border-1 small" placeholder="No. Order" aria-label="Search" style="border-color: #3f51b5;" autofocus >
											<div class="input-group-append">
												<button class="btn btn-primary cari_invoice" type="button" id="cari_invoice">
													<i class="fas fa-search fa-sm"></i>
												</button>
											</div>
										</div>
									</form>
								</div>
							</li>
							
                            <li class="nav-item no-arrow">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#OpenCart-1">
                                    <i class="fas fa-cart-plus fa-fw"></i>
								</a>
							</li>
							<?php if($vupdate!=0){ ?>
							<li class="nav-item dropdown no-arrow mx-1 load-notif"></li>
							<?php } ?>
							<div class="topbar-divider d-none d-sm-block"></div>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="img-profile rounded-circle" src="<?= base_url('assets/'); ?>img/boy.png"
									style="max-width: 60px">
                                    <span
									class="ml-2 d-none d-lg-inline text-white small"><?=$this->session->nama;?></span>
								</a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
								aria-labelledby="userDropdown">
                                    <?php if ($this->session->level=='admin'){ ?>
										<a class="dropdown-item" href="<?=base_url();?>user">
											<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
											Profile
										</a>
										<a class="dropdown-item" href="<?=base_url();?>/main/info">
											<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
											Settings
										</a>
										<?php }else{ ?>
										<a class="dropdown-item" href="<?=base_url();?>main/profil/<?=$this->session->ids;?>">
											<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
											Profile
										</a>
									<?php } ?>
									
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url('main/'); ?>logout">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
									</a>
								</div>
							</li>
						</ul>
					</nav>
                    <!-- Topbar -->
                    <?php
						echo $contents;
						$this->load->view('produk/modal_popup');
					?>
					<div id="load-modal"></div>
				</div>
				
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>copyright &copy; 2020 - <?= SITE_NAME; ?></span>
							
						</div>
					</div>
				</footer>
                <!-- Footer -->
			</div>
		</div>
		
        <!-- Scroll to top -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
		</a>
		
        <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.js"></script>
        <script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
        <script src="<?= base_url('assets/'); ?>js/validation.min.js" type="text/javascript"></script>
		<script src="<?= base_url('assets/'); ?>vendor/selectize/js/standalone/selectize.js"></script>
		<script src="<?= base_url('assets/'); ?>js/domath.js" type="text/javascript"></script>
		<script src="<?= base_url('assets/'); ?>js/app.js" type="text/javascript"></script>
		<script src="<?= base_url('assets/'); ?>js/jquery.fileDownload.js" type="text/javascript"></script>
		<script src="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>
		<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.buttons.min.js"></script>  
		<script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.bootstrap4.min.js"></script>  
		
		<!--script src="<?= base_url('assets/'); ?>vendor/datatables/jszip.min.js"></script>  
			<script src="<?= base_url('assets/'); ?>vendor/datatables/pdfmake.min.js"></script>  
			<script src="<?= base_url('assets/'); ?>vendor/datatables/vfs_fonts.js"></script>  
			<script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.html5.min.js"></script>  
			<script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.print.min.js"></script>
		<script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.colVis.min.js"></script-->
        <script src="<?= base_url('assets/'); ?>js/custom.js"></script>
        <script src="<?= base_url('assets/'); ?>js/version.js"></script>
	</body>
</html>