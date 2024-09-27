<?php
    /**
     * HUONG DAN SU DUNG PAGINATION
     * 1. Trước tiên khái báo 1 biến $allListData để lấy tất cả rows trong câu query
     * 2. Và sử dụng function countAllListDataChild() trong sql.php để tối ưu tốc độ.
     * $allListData để lấy rows và để nó chia pages
     * countAllListDataChild() function này để lấy tất cả rows trong database
     * EXAMPLE: $allListData = $db->countAllListDataChild(args)
     */

    $params = $_GET;
    $listUnset = array('name','idList','page','ajax', 'slug', '_');
    foreach($listUnset as $data){
        unset($params[$data]);
    }
    $params = http_build_query($params);
    $url = parse_url(pageUrl());
    $pageUrl = $url['path'].'?'.$params.'&page=';
    
    $pagination = ceil($allListData->rows/$config->limit);
    if(!isset($_GET["page"]) || $_GET["page"] == 0){
        $currentPage = 0;
    }else{
        $currentPage = $_GET["page"];
    }

    $prev_page = $currentPage-1;
    $next_page = $currentPage+1;
    if($pagination > 1){
?>
<div class="center">
    <ul class='paginationVT'>
    
    <?php 
    //Prev Page
    if($currentPage >  1 && $currentPage <= $pagination - 1){ ?>
    <li>
        <a href="<?=$pageUrl.$prev_page?>" data-name="<?=$name?>" data-title="<?=$menuPage->title?> trang <?=$prev_page?>" >&larr;
        </a>
    </li> 
    <?php } ?>

    <?php if ($currentPage > 2): ?>
    <!-- Return page 1 -->
    <li>
        <a href="<?php echo $pageUrl.'0' ?>" data-name="<?php echo $name ?>">
            1
        </a>
    </li>
    <!-- More page prev -->
    <li>
        <a>
            ...
        </a>
    </li>
    <?php endif ?>

    <?php for($i = 0; $i<$pagination; $i++){
    $namePage = $i; 
    if ($i >= $currentPage + 3 || $i+3 <= $currentPage) continue; ?> 
        <?php if($i == $currentPage){ ?>
            <li class="active">
                <span>
                <?php echo $namePage+1; ?>
                </span>
            </li>
        <?php }else{ ?>
            <li>
                <a class='page-numbers' href="<?=$pageUrl.$i?>" data-name="<?=$name?>" data-title="<?=$menuPage->title?> trang <?=$i?>" >
                    <?php echo $namePage+1; ?>
                </a>
            </li>
        <?php } ?>
    <?php } ?>
    
    <?php if ($currentPage < $pagination - 4): ?>
    <!-- More paginations -->
    <li>
        <a>
            ...
        </a>
    </li>
    <?php endif ?>

    <?php if ($currentPage < $pagination - 3): ?>
    <!-- Last Page -->
    <li>
        <a href="<?= $pageUrl . ($pagination -1) ?>" data-name="<?php echo $name ?>"><?php echo $pagination ?></a>
    </li>
    <?php endif ?>

    <?php 
    //Next page
    if($currentPage < $pagination - 1){ ?>
    <li>
        <a href="<?=$pageUrl.$next_page?>" data-name="<?=$name?>" data-title="<?=$menuPage->title?> trang <?=$next_page?>" >&rarr;
        </a>
    </li> 
    <?php } ?>
</ul>
</div>
<style type="text/css">
    .center {
        text-align: center;
        clear: both;
    }

    .paginationVT {
        display: inline-block;
    }

    .paginationVT li {
        color: black;
        float: left;
        text-decoration: none;
        border: 1px solid #ddd;
    }
    .paginationVT li a{
        display: block;
        padding:8px 16px;
    }
    .paginationVT li.active {
        background-color: #222322;
        color: white;
        border: 1px solid #222322;
        display: block;
        padding:8px 16px;
    }
    .paginationVT li:hover:not(.active) {background-color: #ddd;}

    .paginationVT li:first-child {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .paginationVT li:last-child {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    @media (max-width: 400px) {
        .paginationVT li {
            padding: 5px 10px;
        }
    }
</style>
<?php } ?>