<?php if ($menuPage && !$errorPage): ?>
	<div id="infoPage" data-file="<?=$menuPage->file?>" data-img="<?=baseUrl.'upload/'.$image ?>" data-url="<?=pageUrl()?>" data-title="<?=$title?>" data-name="<?=$name?>" data-description="<?=$des?>" data-keywords="<?=$keywords?>" data-slug="<?php echo $slugCurrent->slugName; ?>">&nbsp;</div>
<?php endif ?>