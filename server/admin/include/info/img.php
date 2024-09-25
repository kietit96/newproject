<div class="col-md-6">
  <label for=""><?php echo $data->title; ?></label>
  <?php 
    $dataL = $db->alone_data_where_where('page_lang','page_parent',$data->name,'lang',$lang);
    // var_dump($dataL); 
  ?>
  <?php if ($dataL): ?>
    <label class="btn btn-primary btn-sm btn-changeImg" for="input<?=$dataL->id?>">
      <i class="fa fa-upload"></i>
      Up ảnh <?=$data->title?>
    </label>

    <?php if ($dataL->content != ''): ?>
      <!-- <label for="" onclick="delImgInfo('#input<?=$dataL->id ?>','#input<?=$dataL->id ?>','<?= $dataL->page_parent ?>')" class="btn btn-danger btn-sm">
        <i class="fa fa-trash"></i>
        Xóa
      </label> -->
    <?php endif ?>
    <br>
    <img data-id="input<?=$dataL->id ?>" onclick="$('#input<?=$dataL->id?>').click()" width="150" height="50" class="img-thumbnail" id="<?php echo $dataL->page_parent; ?>" src="../upload/<?php echo $dataL->content; ?>" alt="">
    <input class="hidden" accept="image/*" type="file" name="listRowInfo[page_parent][<?=$dataL->id ?>][content]" id="input<?=$dataL->id ?>" onchange="readIMG(this,'<?='input'.$dataL->page_parent ?>');" value="<?php echo $dataL->content; ?>">
  <?php else: ?>
    <button <?=linkAddInfo('page_lang','page_parent',$data->name,$lang)?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>
</div>