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
    <div class="col-md-<?=$colList?>">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <a <?=linkAddId($idList,$name) ?> >
                <i class="fa fa-plus"></i> Thêm <?=$title ?> (<?=count($listData); ?>) 
              </a>
              <button class="btn btn-success selectAll" data-target=".table > tbody > tr" type="button"><i class="fa fa-check-square-o"></i> Chọn tất cả</button>
              <button class="btn btn-danger delAll"  data-target=".table >tbody > tr.selected" type="button"><i class="fa fa-trash"></i> Xóa đã chọn</button>
            </h3>
          </div>
          <div class="box-body">
            <table class="table">
              <thead>
                <tr>
                  <th width="10px">#</th>
                  <th><i class="fa fa-info"></i> Tiêu đề</th>
                  <?php if($configMenu->listCheck){ foreach($configMenu->listCheck as $check){ ?>
                  <th><?=$check->title?></th>
                  <?php }} ?>
                  <th width="100px"><i class="fa fa-hand-pointer-o"></i></th>
                </tr>
              </thead>
              <tbody class="sortAjax">
                <?php foreach($listData as $key=>$data){ ?>
                <tr align="center" data-name="data" data-id="<?=$data->id ?>">
                  <td><?=$key+1; ?></td>
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
                  <td class="action">
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
      <button type="submit" class="btn btn-success form-control" > <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
  </div>
</form>
<?php } ?>