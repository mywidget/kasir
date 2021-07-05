<link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet" type="text/css" />
<div class="loading"></div>
<div class="error"></div>
<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data menu</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Menu Admin</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<!-- Form Basic -->
			<div class="card mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-warning">Tambah Menu</h6>
				</div>
				<div class="card-body pt-0">
					<form id="submit-form">
						<input type="hidden" id="id">
						<!-- form start -->
						<div class="box-body ">
							<div class="form-group tax-wraps">
								<label for="label">Nama Menu</label>
								<input id="type" type="hidden" value="simpan">
								<input class="form-control form-control-sm" id="label" placeholder="Nama menu" type="text" >
							</div>
							<div class="form-group">
								<label for="link">URL Menu</label>
								<input class="form-control form-control-sm" id="link" placeholder="URL Menu" type="text"  >
							</div>
							<div class="form-group tax-wrap">
								<label for="parentc">Parent Class <code>treeview</code></label>
								<input class="form-control form-control-sm" id="parentc" placeholder="treeview" type="text">
							</div>
							<div class="hide-txt">
								<label for="eclass">CLASS ICON</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
										<i class="fa fa-bars" id="showicon"></i></a>
									</div>
								</div>
								<input class="form-control" id="eclass" placeholder="bars" type="text" value="">
								<div class="input-group-append">
									<div class="input-group-text">
										<a href="#" data-toggle="modal" data-target="#myModal">
										<i class="fa fa-search"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="aktif">AKTIF</label>
									<select id="aktif" class="custom-select form-control">
										<option value="">Pilih</option>
										<option value="Y">Ya</option>
										<option value="N">Tidak</option>
									</select>					
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="submenu">SUB MENU</label>
									<select id="submenu" class="custom-select form-control">
										<option value="Y">Ya</option>
										<option value="N" selected>Tidak</option>
									</select>					
								</div>
							</div>
							<div class="col-md-12" id="rowLevel">
								<div id="result"></div>
								<label for="idlevel">Level Akses</label>
								<?php
									function checkcard($data, $parent = 0, $parent_id = 0, $Nilai = '')
									{
										static $i = 1;
										$ieTab = str_repeat("&nbsp;&nbsp;&nbsp;", $i * 2);
										$tab = $i * 0;
										if (isset($data[$parent])) {
											$i++;
											$html = "";
											$a = 0;
											foreach ($data[$parent] as $v) {
												$child = checkcard($data, $v['id_level'], $parent_id, $Nilai);
												//Edit Di Item
												
												$_arrNilai = explode(',', $Nilai);
												$_ck = (array_search($v['id_level'], $_arrNilai) === false) ? '' : 'checked';
												$html .= '<div class="checkbox">';
												$html .= '' . $ieTab . '<input type=checkbox name="idlevel[]" id="idlevel' . $v['id_level'] . '" class="get_value" value="' . $v['id_level'] . '" ' . $_ck . ' >&nbsp;' . $v['nama'] . '<br/>';
												$html .= "</div>";
												if ($child) {
													$i--;
													$html .= $child;
												}
												$a++;
											}
											return $html;
										}
									}
									
									$resultz = $this->db->query("SELECT * FROM hak_akses where publish='Y' order by id_level");
									foreach ($resultz->result_array() as $rowz){
										$dataTz[$rowz['id_parent']][] = $rowz;
									}
									echo checkcard($dataTz, 0, $rowz['id_parent'], 0);
								?>
							</div>
						</div>
						
						
					</div><!-- /.box-body -->
					
					<div class="box-footer">
						<button class="btn btn-success pull-right" id="submits">Submit</button> 
						<button class="btn btn-danger" id="reset">Reset</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="col-lg-8">
		<!-- General Element -->
		<div class="card mb-4">
			<div class="card-header py-0 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-warning">Menu Admin</h6>
				<span id="nestable-menu" class="float-right">
					<button type="button" class="btn btn-success btn-sm" onclick="callFunction(this)" id="kolapse"> Expand</button>
				</span>
			</div>
			<div class="card-body pt-0">
				<div class="cf nestable-listsss">
					<div class="dd" id="nestable">
						<div class="ns-row" id="ns-header">
							<div class="ns-actions-2">#</div>
							<div class="ns-actions">AKSI</div>
							<div class="ns-class">CLASS CSS</div>
							<div class="ns-url">URL</div>
							<div class="ns-title">NAMA MENU</div>
						</div>
						<?php
							
							$query = $this->db->query("select * from menuadmin order by urutan ");
							
							$ref   = [];
							$items = [];
							
							foreach ($query->result() as $data) {
								
								$thisRef = &$ref[$data->idmenu];
								
								$thisRef['idparent'] = $data->idparent;
								$thisRef['nama_menu'] = $data->nama_menu;
								$thisRef['link'] = $data->link;
								$thisRef['class'] = $data->icon;
								$thisRef['treeview'] = $data->treeview;
								$thisRef['idmenu'] = $data->idmenu;
								
								if($data->idparent == 0) {
									$items[$data->idmenu] = &$thisRef;
									} else {
									$ref[$data->idparent]['child'][$data->idmenu] = &$thisRef;
								}
								
							}
							
							
							function get_menu($items,$class = 'dd-list') {
								
								$html = "<ol class=\"".$class."\" id=\"menu-id\">";
								
								foreach($items as $key=>$value) {
									$html.= '<li class="dd-item dd3-item" data-id="'.$value['idmenu'].'" >
									<div class="dd-handle dd3-handle"></div>
									<div class="ns-row">
									<div class="ns-title" id="label_show'.$value['idmenu'].'">'.$value['nama_menu'].'</div>
									<div class="ns-url" id="link_show'.$value['idmenu'].'">'.$value['link'].'</div>
									<div class="ns-class" id="eclass_show'.$value['idmenu'].'">'.$value['class'].'</div>
									<div class="ns-actions">
									<a class="edit-button" id="'.$value['idmenu'].'"><i class="fa fa-pencil-alt"></i></a>
									<a href="#" class="confirm-delete" data-id="'.$value['idmenu'].'" id="'.$value['idmenu'].'"><i class="fa fa-trash"></i></a>
									</div>
									<div class="ns-actions-2"></div>
									</div>';
									if(array_key_exists('child',$value)) {
										$html .= get_menu($value['child'],'child');
									}
									$html .= "</li>";
								}
								$html .= "</ol>";
								
								return $html;
								
							}
							
							print get_menu($items);
							
						?>
						<input type="hidden" id="nestable-output">
						<div class="box-footer pull-right">
							<button id="save" type="button" class="btn btn-success">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Input Group -->
		
	</div>
</div>
</div>

<div class="modal fade" id="myModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalDel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content modal-md">
            
			<div class="modal-header">
				<h4 class="modal-title" id="myModalDel">Confirm Delete</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
            
			<div class="modal-body">
				<p>Anda akan menghapus satu data, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnYes" class="btn btn-danger danger" data-dismiss="modal">Ya</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/'); ?>js/jquery.nestable.js" type="text/javascript"></script>
<script src="<?= base_url('assets/'); ?>js/addon.js" type="text/javascript"></script>