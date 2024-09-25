<?php
	if(!isset($idList)){
	  $idList = $menuPage->id; 
	  $page = $menuPage;
	}
  $listMenuChild = $db->listMenuChild($menuPage->id);
?>
<ul class="ul_social_fixed">
  <?php 
    if (isset($id)) {
      $slug = $db->alone_data_where_where('slug','tableName','data','idTable',$id);
    }else {
      if(!isset($idList)){
        $idList = $menuPage->id; 
        $page = $menuPage;
      }
      $slug = $db->alone_data_where_where('slug','tableName','menu','idTable',$idList);
    }
  ?>
  <?php 
      $menuLang = $db->alone_data_where('menu','file','lang');
      $listLang = $db->listMenuChild($menuLang->id);
      foreach ($listLang as $key => $lang1) {
          if ($lang1->name == 'vn') { 
  ?>
      <li class="">
          <a class="" href="<?php echo url; ?>admin/<?php echo $slug->slugName; ?>" >
              <img <?php echo srcImg($lang1); ?> >
          </a>
      </li>
  <?php }else{ ?>
      <li class="">
          <a class="" href="<?php echo url; ?><?php echo $lang1->name; ?>/admin/<?php echo $slug->slugName; ?>" >
              <img <?php echo srcImg($lang1); ?> >
          </a>
      </li>
  <?php        
          }
      }
  ?>
</ul>
<form role="form" method="POST" action="?name=<?=$name?>" enctype="multipart/form-data">
	<div class="col-md-4">
    <div class="panel panel-default grid">
      <div class="panel-heading">
        <span class="btn"><i class="fa fa-cog"></i> Quản lí ngôn ngữ</span>
      </div>
      <div class="panel-body">
        <div class="form-horizontal">
          <?php if($page->menu_parent !== '0'){ ?>
          <input type="hidden" name="table" value="menu"/>
          <input type="hidden" name="id" value="<?=$idList ?>"/>

          <div class="form-group">
            <label class="control-label col-md-4">Tiêu đề: </label>
            <div class="col-md-8">
              <input type="text" value="<?=$page->title ?>" name="title" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-4">Name: </label>
            <div class="col-md-8">
              <input type="text" value="<?=$page->name ?>" name="name" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-md-4">Hình ảnh</label>
            <div class="col-md-8">
              <input type="file" name="img" class="form-control" />
            </div>
          </div>
          
          <center class="form-group">
            <img style="max-height:50px" src="../upload/<?=$page->img ?>" />
          </center>
          <?php }else{$listData = $db->allListDataChild($idList);} ?>
          <div class="col-md-12">
            <a <?=linkAddMenu($menuPage->id,$name); ?>>
              <i class="fa fa-plus"></i> Thêm ngôn ngữ
            </a>
            <ul class="tree">
              <li class="root">
                <ul class="tree sortAjax">
                <?php foreach($listMenuChild as $menuChild){ ?>
                  <li>
                    <a class="thumuc" <?=linkIdList($menuChild,$name); ?> >
                      <?= $menuChild->title ?>
                    </a>
                    <a <?=linkDelMenu($menuChild->id) ?> ><i class="fa fa-trash"></i></a>
                  </li>
                <?php } ?>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <ul class="nav nav-tabs">
      <?php foreach($listMenuChild as $key=>$menuChild){ ?>
      <li class="">
        <a class="<?=returnWhere('active',$key,0)?>" data-toggle="tab" href="#lang<?=$menuChild->id?>"><?=$menuChild->title?></a>
      </li>
      <?php } ?>
    </ul>
    <div class="tab-content">
      <?php foreach($listMenuChild as $key=>$menuChild){ ?>
      <div id="lang<?=$menuChild->id?>" class="tab-pane fade <?=returnWhere(' in active show',$key,0)?>">
        <h3><?=$menuChild->title?></h3>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-12">
    <button type="submit" class="btn btn-success form-control" >
      <i class="fa fa-save"></i> Lưu (Alt + S)
    </button>
  </div>
</form>