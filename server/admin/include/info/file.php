<div class="col-md-6">
  <label for=""><?php echo $data->title; ?></label>
  <?php 
    $dataL = $db->alone_data_where_where('page_lang','page_parent',$data->name,'lang',$lang); 
  ?>
  <?php if ($dataL): ?>
    <label class="btn btn-primary btn-sm" for="input<?=$dataL->id?>">
      <i class="fa fa-upload"></i>
      Up file <?=$data->title?>
    </label>

    <input  class="hidden" type="file" name="listRowInfo[page_parent][<?=$dataL->id ?>][content]" id="input<?=$dataL->id ?>" onchange="readIMG(this,'<?='input'.$dataL->page_parent ?>');" value="<?php echo $dataL->content; ?>">

    <input type="text" readonly class="form-control" value="<?php echo $dataL->content; ?>" />

  <?php else: ?>
    <button <?=linkAddInfo('page_lang','page_parent',$data->name,$lang)?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>
</div>