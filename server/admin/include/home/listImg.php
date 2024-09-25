<?php foreach($listImageHome as $listImage){ $listName = $listImage->name; ?> 
  <div class="col-md-12">
    <label class="btn btn-primary" style="width:100%;" for="fileListImg<?=$listName?>">
      <i class="fa fa-image"></i> Up hình <?=$listImage->title?> ($list-><?=$listImage->name?>) (<?php echo $listImage->width . 'x' . $listImage->height . 'px' ?>) 
    </label>

    <input class="hidden" id="fileListImg<?=$listName?>" type="file" name="listImageType[<?=$listName?>][]" multiple="" accept="image/*" />
    <input type="hidden" name="listImageType[<?=$listName?>][width]" value="<?php echo $listImage->width ?>">
    <input type="hidden" name="listImageType[<?=$listName?>][height]" value="<?php echo $listImage->height ?>">

    <hr>

    <?php 
      $listImg = $db->list_data_where_where_hide('file_data_lang','file_data_id',$menuHome->id,'type',$listName);
    ?>
    <?php if(isset($listImg) && count($listImg)){ ?>

      <div class="box">
          <div class="box-body">
            <table id="<?=$listName?>" class="table <?=$listName?>">
              <thead>
                <tr>
                  <th width="100px"><i class="fa fa-picture-o"></i> Hình</th>
                  <th>Tiêu đề</th>
                  <th>Mô tả</th>
                  <th><i class="fa fa-link"></i> Link</th>
                  <!-- <th>Chọn</th> -->
                  <th width="100px"><i class="fa fa-trash"></i> Xóa</th>
                </tr>
              </thead>
              <tbody class="sortAjax">
              <?php foreach($listImg as $data){
              ?>
              <tr align="center" data-name="file_data_lang" data-img="<?=$data->id ?>">
                <td><img style="height:50px;" src="../upload/<?=$data->img ?>" class="img-responsive"></td>
                <td><input type="text" class="form-control" name="listRow[file_data_lang][<?=$data->id ?>][title]" value="<?=$data->title ?>"  /></td>
                <td><input type="text" class="form-control" name="listRow[file_data_lang][<?=$data->id ?>][des]" value="<?=$data->des ?>"  /></td>
                <td><input type="text" class="form-control" name="listRow[file_data_lang][<?=$data->id ?>][link]" value="<?=$data->link ?>"  /></td>
                <td class="action">
                  <a <?=linkDelId($data->id,'file_data_lang'); ?>><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
      </div>
    <?php } ?>

  </div>
<?php } ?>