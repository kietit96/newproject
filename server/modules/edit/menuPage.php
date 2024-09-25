<?php if ($menuPage->id == $page->id) { ?>
	<?php
	$dataL = $db->alone_data_where_where('menu_lang', 'menu_id', $menuPage->id, 'lang', $lang);
	?>
	<?php if ($configMenu->showImageMenu) { ?>
		<div class="col-md-12">
			<input type="hidden" name="table" value="menu_lang" />
			<input type="hidden" name="id" value="<?= $dataL->id ?>" />
			<input type="hidden" name="lang" value="<?php echo $lang; ?>">
			<label for="input<?= $dataL->id ?>" class="btn btn-primary" style="width:100%"><i class="fa fa-upload"></i> Up ảnh danh mục <?= $menuPage->title ?> <?php echo $lang->title; ?> </label>
			<img class="img-responsive" height="100" width="100%" onclick="$('#input<?= $dataL->id ?>').click();" id="image<?= $dataL->id ?>" src="../upload/<?= $dataL->img ?>">
			<input class="hidden" accept="image/*" name="listRowMenu[menu_lang][<?php echo $dataL->id; ?>][img]" type="file" id="input<?= $dataL->id ?>" onchange="readIMG(this,'<?= 'image' . $dataL->id ?>');">
		</div>
		<div class="col-md-12">
			<input type="hidden" name="table" value="menu_lang" />
			<input type="hidden" name="id" value="<?= $dataL->id ?>" />
			<input type="hidden" name="lang" value="<?php echo $lang; ?>">
			<label for="input2<?= $dataL->id ?>" class="btn btn-primary" style="width:100%"><i class="fa fa-upload"></i> Up ảnh background <?= $menuPage->title ?> <?php echo $lang->title; ?> </label>
			<img class="img-responsive" height="100" width="100%" onclick="$('#input2<?= $dataL->id ?>').click();" id="image2<?= $dataL->id ?>" src="../upload/<?= $dataL->background ?>">
			<input class="hidden" accept="image/*" name="listRowMenu2[menu_lang][<?php echo $dataL->id; ?>][background]" type="file" id="input2<?= $dataL->id ?>" onchange="readIMG(this,'<?= 'image2' . $dataL->id ?>');">
		</div>
	<?php } ?>
	<?php if ($configMenu->slidemenu == 1) {
		include 'listImgPage.php';
	} ?>
	<?php if (canEditSlug) : ?>
		<div class="col-md-12">
			<label for="inputKeywords">Đường dẫn: </label>
			<input id="slugId" class="form-control" type="text" name="listSlug[<?= $slugCurrent->id ?>]" value="<?= $slugCurrent->slugName ?>" />
		</div>
	<?php endif; ?>

	<?php
	$dataL = $db->alone_data_where_where('menu_lang', 'menu_id', $menuPage->id, 'lang', $lang);
	?>
	<?php if ($dataL) : ?>
		<div class="col-md-12">
			<label for="inputDes">Tiêu đề hiển thị: </label>
			<input id="inputDes" class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][title]" value="<?= $dataL->title ?>" />
		</div>
		<div class="col-md-12">
			<label for="inputDes">Mô tả <?php echo $lang->title; ?>: </label>
			<input id="inputDes" class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][des]" value="<?= $dataL->des ?>" />
		</div>
		<div class="col-md-12">
			<label for="inputKeywords">Keywords <?php echo $lang->title; ?>: </label>
			<input id="inputKeywords" class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][keywords]" value="<?= $dataL->keywords ?>" />
		</div>
		<?php if ($menuPage->id == $menuContent->id) { ?>
			<div class="col-md-12">
				<label>Nội dung trên trang chủ<?php echo $lang->title; ?>: </label>
				<textarea name="listRow[menu_lang][<?php echo $dataL->id; ?>][f1]" class="tinymce"><?= $dataL->f1 ?></textarea>
			</div>
		<?php } ?>
		<div class="col-md-12">
			<label>Nội dung <?php echo $lang->title; ?>: </label>
			<textarea name="listRow[menu_lang][<?php echo $dataL->id; ?>][content]" class="tinymce"><?= $dataL->content ?></textarea>
		</div>
	<?php else : ?>
		<button <?= linkAddLang('menu_lang', 'menu_id', $menuPage->id, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
	<?php endif ?>

<?php } ?>