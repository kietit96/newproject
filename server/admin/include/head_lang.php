<style type="text/css" media="screen">
    ul.ul_social_fixed {
        top: 22px;
        position: fixed;
        z-index: 5000;
        padding: 0px;
    }

    ul.ul_social_fixed li {
        color: #f1f1f1;
        display: inline-block;
        width: 43px;
        height: 40px;
        padding-left: 5px;
    }
</style>
<ul class="ul_social_fixed">
    <?php
    $lang = isset($_GET['lang']) ? $_GET['lang'] : "vn"; //default VN
    if (isset($id)) {
        $slug = $db->alone_data_where_where('slug', 'tableName', 'data', 'idTable', $id);
    } else {
        if (!isset($idList)) {
            $idList = $menuPage->id;
            $page = $menuPage;
        }
        $slug = $db->alone_data_where_where('slug', 'tableName', 'menu', 'idTable', $idList);
    }
    ?>
    <?php
    $menuLang = $db->alone_data_where('menu', 'file', 'lang');
    $listLang = $db->listMenuChild($menuLang->id);
    foreach ($listLang as $key => $lang1) {
        if ($lang1->name == 'vn') {
    ?>
            <li class="">
                <a class="" href="<?php echo url; ?>admin/<?php echo $slug->slugName; ?>">
                    <img <?php echo srcImg($lang1); ?>>
                </a>
            </li>
        <?php } else { ?>
            <li class="">
                <a class="" href="<?php echo url; ?><?php echo $lang1->name; ?>/admin/<?php echo $slug->slugName; ?>">
                    <img <?php echo srcImg($lang1); ?>>
                </a>
            </li>
    <?php
        }
    }
    ?>
</ul>