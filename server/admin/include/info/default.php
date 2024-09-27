<div class="col-md-6">
  <label for=""><?php echo $data->title; ?></label>
  <?php 
    $dataL = $db->alone_data_where_where('page_lang','page_parent',$data->name,'lang',$lang); 
  ?>
  <?php if ($dataL): ?>
    <input type="text" class="form-control" name="listRow[page_lang][<?php echo $dataL->id; ?>][content]" value="<?php echo $dataL->content; ?>" placeholder="Nhập nội dung" />
  <?php else: ?>
    <button <?=linkAddInfo('page_lang','page_parent',$data->name,$lang)?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>
</div>