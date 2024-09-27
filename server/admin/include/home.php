<?php 
  $menuLang = $db->alone_data_where('menu','file','lang');
  $listLang = $db->listMenuChild($menuLang->id);

?>
<?php include 'head_lang.php'?>
<form role="form" method="POST" enctype="multipart/form-data">
  <?php include('home/listImg.php'); ?>
  <?php
    $dataL = $db->alone_data_where_where('menu_lang','menu_id',$menuPage->id,'lang',$lang);
    // var_dump($dataL);
  ?>
  <?php if ($dataL): ?>

      <?php if (canEditSlug): ?>
      <div class="col-md-12">
        <label for="inputKeywords">Đường dẫn: </label>
        <input id="slugId" class="form-control" type="text" name="listSlug[<?=$slugCurrent->id?>]" value="<?=$slugCurrent->slugName?>"/>
      </div>
      <?php endif; ?>
      <div class="col-md-12">
        <label>Tiêu đề: </label>
        <input class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][title]" value="<?php echo $dataL->title; ?>">
      </div>
      <div class="col-md-12">
        <label>Mô tả: </label>
        <input class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][des]" value="<?php echo $dataL->des; ?>">
      </div>
      <div class="col-md-12">
        <label>Giới thiệu: </label>
        <textarea class="tinymce" name="listRow[menu_lang][<?php echo $dataL->id; ?>][content]"><?=$dataL->content ?></textarea>
      </div>
      <br/>
      
      <div class="col-md-12">
        <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
      </div>
  <?php else: ?>
      <button <?=linkAddLang('menu_lang','menu_id',$menuPage->id,$lang)?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>
</form>

