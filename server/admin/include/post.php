<?php
if(isset($id)){
?>
<form role="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <div class="col-md-12">
        <input type="hidden" name="table" value="data"/>
        <input type="hidden" name="id" value="<?=$id?>"/>
        <center style="padding:20px;"><img <?=srcImg($page)?>></center>

        <?php foreach($listFp as $f){ $col= $f->name;?>
        <div class="form-group">
          <label class="control-label col-md-3"><?=$f->title?></label>
          <div class="col-md-9">
            <input class="form-control" value="<?=$page->$col?>" name="<?=$f->name?>"/>
          </div>
        </div>
        <?php } ?>

        <?php foreach($listSl as $sl){ $col = $sl->name;?>
        <div class="form-group">
          <label class="control-label col-md-3"><?=$sl->title?></label>
          <div class="col-md-9">
            <select class="form-control" name="<?=$col?>">
              <?php $listOp = $db->list_data($sl->name); foreach($listOp as $op){?>
              <option <?=($op->id == $page->$col)?'selected':''?> value="<?=$op->id?>"><?=$op->name?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <?php }?>

    </div>
    <div class="col-md-12">
      <label>Nội dung:</label>
      <textarea class="ckeditor" name="content"><?=$page->content ?></textarea>
    </div>
    <div class="col-md-12">
      <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
</form>
<?php
}else{
  $listData = $db->listData($menuPage->id);
?>
<div class="col-md-12">
  <div class='panel panel-default grid'>
    <table class='table notSl'>
      <thead>
        <tr>
          <th>#</th>
          <th>Hình ảnh</th>
          <?php foreach($listFp as $f){ ?>
          <th><?=$f->title?></th>
          <?php } ?>
          <th>Danh mục</th>
          <th><i class="fa fa-trash"></i></th>
        </tr>
      </thead>
      <tbody align="center">
      <?php foreach($listData as $key=>$data) { ?>
          <tr>
            <td><?=$key+1?></td>
            <td>
              <img <?=srcImg($data)?> style="height: 50px;max-width: 100%;">
            </td>
            <?php foreach($listFp as $f){ $col=$f->name;?>
            <td><?=$data->$col?></td>
            <?php } ?>
            <td>
              <?php $menuData = $db->alone_data_where('menu','id',$data->menuPost);
              echo $menuData->title;
              ?>
            </td>
            <td>
              <a class="btn btn-warning btn-xs" <?=linkId($data,$name)?>>
                <i class="fa fa-edit"></i> Sửa
              </a>
              <a class="btn btn-success btn-xs" onclick="acceptPost('<?=$data->id?>')">
                <i class="fa fa-check"></i> Duyệt
              </a>
              <a <?=linkUpdateId($data->id)?>>
                <i class="fa fa-close"></i> Xóa
              </a>
            </td>
          </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php } ?>