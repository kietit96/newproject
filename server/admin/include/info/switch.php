<div class="col-md-6">
  	<label for=""><?php echo $data->title; ?></label>
	<?php 
		$dataL = $db->alone_data_where_where('page_lang','page_parent',$data->name,'lang',$lang); 
	?>
	<?php if ($dataL): ?>
		<div class="onoffswitch">
            <input type="hidden" name="listRow[page_lang][<?php echo $dataL->id; ?>][content]" value="0" />
            <input type="checkbox" <?=returnWhere('checked',$dataL->content,1) ?> name="listRow[page_lang][<?php echo $dataL->id; ?>][content]" class="onoffswitch-checkbox" id="switch<?=$dataL->id?>" value="1" />
            <label class="onoffswitch-label" for="switch<?=$dataL->id?>"></label>
            <p class="hidden"><?=$dataL->content?></p>
        </div>
	<?php else: ?>
		<button <?=linkAddInfo('page_lang','page_parent',$data->name,$lang)?>><i class="fa fa-plus"></i> Thêm thông tin</button>
	<?php endif ?>
</div>