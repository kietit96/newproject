<div class="col-md-6">
  <label for=""><?php echo $data->title; ?></label>
  <?php
  $dataL = $db->alone_data_where_where('page_lang', 'page_parent', $data->name, 'lang', $lang);
  // var_dump($dataL); 
  ?>
  <?php if ($dataL) : ?>
    <textarea class="tinymce" name="listRow[page_lang][<?php echo $dataL->id; ?>][content]"><?= $dataL->content ?></textarea>
  <?php else : ?>
    <button <?= linkAddInfo('page_lang', 'page_parent', $data->name, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>
</div>