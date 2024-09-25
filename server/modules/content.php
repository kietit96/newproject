<?php
    if(isset($configMenu) && !$errorPage){ 
?>
<?php $menuPageL = $db->alone_data_where_where('menu_lang','menu_id',$menuPage->id,'lang','en'); ?>
<div hidden>
    <h1><?=$menuPageL->title?></h1>
    <h2><?=$menuPageL->des?></h2>
    <h3><?=$infoPage->title?></h3>
</div>
<?php
    $boxHead = '?> '.html_entity_decode($config->boxHead).' <?php ';
    $contentHead = '?> '.html_entity_decode($config->contentHead).' <?php ';
    $contentFooter = '?> '.html_entity_decode($config->contentFooter).' <?php ';

    $headHtml = '?> '.html_entity_decode($configMenu->headHtml).' <?php ';
    $footerHtml = '?> '.html_entity_decode($configMenu->footerHtml).' <?php ';
    $customHtml = '?> '.html_entity_decode($configMenu->customHtml).' <?php ';


    if(($configMenu->customTemplate == 1) || $configMenu->type=='custom' || ($configMenu->onlyContent == 1) || $configMenu->type == 'block' || $configMenu->file == 'home'){
        if($configMenu->type == 'custom' || $configMenu->customTemplate == 1){
            eval($customHtml);
        }else{
            eval($boxHead);
            $db->breadcrumbMenu($menuPage,$lang);
            eval($contentHead);

            if ($configMenu->onlyContent == 1) {
                echo $menuPage->content;
            }else if($configMenu->type == 'block'){
                include('views/include/'.$menuPage->file.'.php');
            }
            eval($contentFooter);
        }
        
    }else{
        eval($headHtml);
        $file = $menuPage->file;
        $thisIsProducts = false;
        if(isset($id)){
            eval($boxHead);
                $db->breadcrumb($page,$lang);
                $thisIsProducts = true;
            eval($contentHead);
            include('modules/template/searchBox.php');
            include('modules/template/box.php');
            eval($contentFooter);
            $listData = $db->listData($page->menu);
            if(count($listData) > 1){
                eval($boxHead);
                echo 'Các sản phẩm liên quan'; 
                eval($contentHead);
                include('modules/template/box.php');
                eval($contentFooter);
            }
        }else{
            if(!isset($idList)){
                $idList = $menuPage->id;
                $page = $menuPage;
            }
            
            $listData = $db->allListDataChild($idList,$start,$config->limit);
            $allListData = $db->countAllListDataChild($idList);
            eval($boxHead);
                $db->breadcrumbMenu($page,$lang); 
            eval($contentHead);
            include('modules/template/searchBox.php');
            include('modules/template/box.php');
            eval($contentFooter);
        }
        eval($footerHtml);
    }
}else{
    include('views/include/404.php');
}
?>