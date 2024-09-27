<?php
  if(!$configMenu->onlyContent){
    $colList = ($configMenu->showList)?8:12;
    if(!isset($idList)){
      $idList = $menuPage->id; 
      $page = $menuPage;
    }
    $listData = $db->listData($idList); 
?>
<form role="form" method="POST" class="form-horizontal" action="?name=<?=$name ?>&idList=<?=$idList?>" enctype="multipart/form-data">
  <div class="row">
    <?php if($configMenu->showList){ ?>
    <div class="col-md-4">
      <div class="panel panel-default grid">
        <div class="panel-heading">
          <span class="btn"><i class="fa fa-cog"></i> Quản lí danh mục</span>
        </div>
        <div class="panel-body">
          <div>
            <?php if($page->menu_parent !== '0'){ ?>
            <div class="form-group">
              <label class="control-label col-md-4">Tiêu đề: </label>
              <input type="hidden" name="table" value="menu"/>
              <input type="hidden" name="id" value="<?=$idList ?>"/>
              <div class="col-md-8">
                <input type="text" value="<?=$page->title ?>" name="title" class="form-control" />
              </div>
            </div>
            
            <?php if($configMenu->showImage){ ?>
            <div class="form-group">
              <label class="control-label col-md-4">Ảnh đại diện</label>
              <div class="col-md-8">
                <input type="file" name="img" class="form-control" />
              </div>              
              <center><img style="height:50px" src="../upload/<?=$page->img ?>" /></center>
            </div>
            <?php } ?>

            <?php }else{$listData = $db->allListDataChild($idList);} ?>
            <div class="col-md-12"> 
              <a <?=linkAddMenu($menuPage->id,$name); ?>>
                <i class="fa fa-plus"></i> Thêm danh mục con
              </a>
              <ul class="tree">
                <li class="root">
                  <ul class="tree sortAjax">
                  <?php $db->loopMenu($db->listMenuChild($menuPage->id),$name); ?>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="col-md-<?=$colList?>">
    <?php if($page->id == $menuPage->id && isset($configMenu->showImageMenu) && ($configMenu->showImageMenu)){ ?>
      <input type="hidden" name="table" value="menu"/>
      <input type="hidden" name="id" value="<?=$menuPage->id?>"/>
      <label>Ảnh <?=$menuPage->title?></label>
      <img height="100" width="100%" onclick="$('#input<?=$menuPage->id ?>').click();" id="image<?=$menuPage->id ?>" src="../upload/<?=$menuPage->img?>">
      <br><br>
      <input accept="image/*" name="img" type="file" id="input<?=$menuPage->id ?>" onchange="readIMG(this,'<?='image'.$menuPage->id ?>');">
      <br><br>
      <?php } ?>
      
      <div class="box">
        <?php if( ($configMenu->showList == true && $idList !== $menuPage->id ) || $configMenu->showList == false){ ?>
          <div class="box-header">
            <h3 class="box-title">
              <input style="width:300px;float:left;margin-right:10px;" class="btn btn-primary" type="file" name="listImageType[data][]" multiple="" accept="image/*" />
              <button class="btn btn-success selectAll" data-target="#tableData > tbody > tr" type="button"><i class="fa fa-check-square-o"></i> Chọn tất cả</button>
              <button class="btn btn-danger delAll"  data-target="#tableData >tbody > tr.selected" type="button"><i class="fa fa-trash"></i> Xóa đã chọn</button>
            </h3>
          </div>
        <?php } ?>
          <div class="box-body">
            <table id="tableData" class="table">
              <thead>
                <tr>
                  <th width="10px">#</th>
                  <th width="100px"><i class="fa fa-picture-o"></i></th>
                  <th><i class="fa fa-info"></i> Tiêu đề</th>
                  <?php if($configMenu->listCheck){ foreach($configMenu->listCheck as $check){ ?>
                  <th><?=$check->title?></th>
                  <?php }} ?>
                  <th><i class="fa fa-list"></i></th>
                  <th width="100px"><i class="fa fa-hand-pointer-o"></i></th>
                </tr>
              </thead>
              <tbody>
              <?php
                foreach($listData as $key=>$data){ $menuParent = $db->alone_data_where('menu','id',$data->menu);
              ?>
              <tr align="center" data-id="<?=$data->id ?>">
                <td><?=$key+1; ?></td>
                <td><a <?=linkId($data,$name); ?>><img style="height:50px;" src="../upload/<?=$data->img ?>" class="img-responsive"></a></td>
                <td>
                  <input type="text" value="<?=$data->title; ?>" name="listRow[data][<?=$data->id ?>][title]" class="form-control" />
                  <p class="hidden"><?=$data->title?></p>
                </td>
                <?php if($configMenu->listCheck){ foreach($configMenu->listCheck as $check){$checkName = $check->col; ?>
                <td>
                  <div class="onoffswitch">
                    <input type="hidden" name="listRow[data][<?=$data->id ?>][<?=$checkName?>]" value="0" />
                    <input type="checkbox" <?=returnWhere('checked',$data->$checkName,1) ?> name="listRow[data][<?=$data->id ?>][<?=$checkName?>]" class="onoffswitch-checkbox" id="switch<?=$checkName.$data->id ?>" value="1" />
                    <label class="onoffswitch-label" for="switch<?=$checkName.$data->id ?>"></label>
                    <p class="hidden"><?=$data->$checkName ?></p>
                  </div>
                </td>
                <?php }} ?>
                <td><a <?=linkIdList($menuParent,$name); ?> ><?=$menuParent->title?></a></td>
                <td class="action">
                  <a <?=linkId($data, $name); ?> class="btn btn-warning"><i class="fa fa-edit"></i></a>
                  <a <?=linkUpdateId($data->id,$name); ?>><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
      </div>
    </div>
    <div class="col-md-12">
      <label>Nội dung: </label>
      <textarea name="content" class="tinymce"><?=$menuPage->content?></textarea>
    </div>
    <div class="col-md-12">
      <button type="submit" class="btn btn-success form-control" > <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
  </div>
</form>
<?php }else{ ?> 
<form role="form" method="POST" class="form-horizontal" action="?name=<?=$name?>" enctype="multipart/form-data">
  <div class="row">
      <div class="col-md-12">
        <label>Nội dung: </label>
        <textarea name="content" class="tinymce"><?=$menuPage->content?></textarea>
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-success form-control" > <i class="fa fa-save"></i> Lưu (Alt + S)</button>
      </div>
  </div>
</form>
<?php } ?>