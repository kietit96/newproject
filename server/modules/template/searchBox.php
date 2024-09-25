<?php $listMenuChild  = $db->listMenuChild($menuProduct->id); ?>
<div class="col-md-12">
  <form class="formSearch searchAjax">
    <div class="row">
      <div class="col-md-4">
        <input name="title" type="text" class="form-control" placeholder="Nhập từ khóa bạn cần tìm kiếm" value="<?=(isset($_GET['title'])?$_GET['title']:'')?>">
      </div>
      <div class="col-md-2">
        <select class="form-control" name="menu">
            <option value="">Danh mục</option>
            <?php foreach($listMenuChild as $menuChild){ ?>
            <option <?=($menuChild->id == $idMenu)?'selected':''?> value="<?=$menuChild->id?>"><?=$menuChild->title?></option>
            <?php } ?>
        </select>
      </div>
      <?php foreach($listSl as $sl){ $col = $sl->name;?>
        <div class="col-md-2">
          <select class="form-control" name="<?=$col?>">
            <?php $listOp = $db->list_data($sl->name); if($col == 'province' || ($col == 'district' && isset($_GET['province'])) ){ foreach($listOp as $op){?>
            <option <?=(isset($_GET[$col]) && $_GET[$col] == $op->id)?'selected':''?> value="<?=$op->id?>">
              <?=$op->name?>
            </option>
            <?php }} ?>
          </select>
        </div>
      <?php }?>
      <div class="col-md-2">
        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
      </div>
    </div>
  </form>
</div>