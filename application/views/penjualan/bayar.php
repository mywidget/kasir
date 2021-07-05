<?php
if($bayar->num_rows() >0){
?>
<table class="table tbayar mb-0">
  <thead class="thead-dark p-0">
    <tr>
      <th scope="col" class="w-2">#</th>
      <th scope="col">Tanggal</th>
      <th scope="col">Jumlah</th>
      <th scope="col" class="w-2">Aksi</th>
    </tr>
  </thead>
  <tbody>
<?php 
$total=0;
$no=1;

foreach($bayar->result_array() AS $val){
$total += $val['jml_bayar'];
if ($this->session->level=='admin' OR $this->session->level=='owner'){
$hapus = '<button type="button" data-jml="'.$val['jml_bayar'].'" data-kunci=1"  data-idin="'.$val['id_invoice'].'" data-id="'.$val['id'].'"  class="btn btn-danger btn-sm delbayar"><i class="fa fa-trash"></i></button>';
}else{
$hapus = '<button type="button" data-jml="'.$val['jml_bayar'].'" data-kunci="'.$val['kunci'].'"  data-idin="'.$val['id_invoice'].'" data-id="'.$val['id'].'"  class="btn btn-danger btn-sm delbayar"><i class="fa fa-trash"></i></button>';
}
?>
    <tr>
      <th scope="row"><?=$no;?>.</th>
      <td><?=tgl_indo($val['tgl_bayar']);?></td>
      <td><?=rp($val['jml_bayar']);?></td>
      <td><?=$hapus;?></td>
    </tr>
<?php 
$no++; }
?>
  </tbody>
  <tfoot>
  <tr>
      <td colspan="2">Jumlah</td>
      <td scope="col"><?=rp($total);?></td>
      <td scope="col" class="w-2">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<input type="hidden" value="<?=$no;?>" id="no_bayar" name="no_bayar" >
<?php 
}else{
echo '<input type="hidden" value="1" id="no_bayar" name="no_bayar" >';
}
?>