<?php
    $listMenu = $db->list_data_where_order("menu","menu_parent",0,'pos','ASC');
?>
<div class="row">
    <div class="col-md-12">
        <div style="font-size:17px;">
            <ul>
                <?php foreach($listMenu as $menu){ if($menu->file !== 'config'){ $listMenuChild = $db->listMenuChild($menu->id); ?>
                <li>
                    <a <?=linkMenu($menu); ?>><i class="<?php returnIcon($menu->file) ?>"></i> <?php echo $menu->title; ?></a>
                    <?php if(count($listMenuChild)){ ?>
                        <ul>
                            <?php $db->loopMenuSite($listMenuChild,$menu->name); ?>
                        </ul>
                    <?php } ?>
                </li>
                <?php }} ?>
            </ul>
        </div>
    </div>
</div>