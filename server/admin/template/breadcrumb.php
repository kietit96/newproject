<?php if ($menuPage): ?>
<div id="infoPage" data-title="<?=$title?>" data-name="<?=$name?>" data-table="<?=(isset($id))?'data':'menu'?>" data-idList="<?php if(isset($idList)){echo $idList;}?>" data-id="<?php if(isset($id)){echo $id;}?>" data-slug="<?php echo ($menuPage->file == 'config') ? 'cau-hinh/'.$slugCurrent->slugName: $slugCurrent->slugName; ?>"></div>
<?php endif ?>
  
<?php
    $allListMenuParent = [];
    if(isset($idMenu)){
    	$allListMenuParent = array_reverse($db->allListMenuParent($idMenu));
    	if(isset($idList) || $menuPage->menu_parent == '0' && !isset($id)){
    		unset($allListMenuParent[count($allListMenuParent) - 1]);
    	}
    }
?>
<nav class="breadcrumb">
    <?php foreach($allListMenuParent as $menu) { if($menu){?>
            <a <?php if($menu->menu_parent == '0' || $menu->menu_parent == '-1'){echo linkMenu($menu);
                }else{ echo linkIdList($menu,$name);} ?> class="breadcrumb-item" >
                <?=$menu->title;?>        
            </a>
    <?php }} ?>
    <span class="breadcrumb-item active"><?=$title;?></span>
</nav>
<!-- Content -->
