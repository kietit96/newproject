<?php
  $listData = $db->list_data_order('page','type','ASC');
  $listFile = $db->list_data_where('file','hide','0');

  $menuLang = $db->alone_data_where('menu','file','lang');
  $listLang = $db->listMenuChild($menuLang->id);
?>
<?php include 'head_lang.php'?>
<form role="form" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="table" value="info_lang">
  <div class="row" id="box-info">
    <?php foreach ($listData as $key => $data): ?>
      <?php switch ($data->type) { case 'file': ?>
        <?php include('info/file.php'); ?>
      <?php  break; case 'img': ?>
        <?php include('info/img.php'); ?>
      <?php  break; case 'content': ?>
        <?php include('info/content.php'); ?>
      <?php break; case 'switch': ?>
        <?php include('info/switch.php'); ?>
      <?php  break; default: ?>
        <?php include('info/default.php'); ?>
      <?php break; } ?>
    <?php endforeach ?>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
  </div>
</form>