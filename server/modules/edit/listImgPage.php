<div class="col-md-12">
    <label class="btn btn-primary" style="width:100%;" for="fileListImgslide">
      <i class="fa fa-picture-o"></i> Up hình slide(164x283)
    </label>
    <input type="hidden" name="id" value="<?=$dataL->id?>"/>
    <input class="hidden" id="fileListImgslide" type="file" name="listImageType[slide][]" multiple="" accept="image/*" />
    <input type="hidden" name="listImageType[slide][width]" value="<?php echo $listImage->width ?>">
    <input type="hidden" name="listImageType[slide][height]" value="<?php echo $listImage->height ?>">

    <hr>

    <?php 
      $listImg = $db->list_data_where_where_hide('file_data_lang','file_data_id',$dataL->id,'type','slide');
    ?>
    <?php if(isset($listImg) && count($listImg)){ ?>
        <div class="box">
            <div class="box-body">
              <table id="slide" class="table slide">
                  <thead>
                    <tr>
                      <th width="100px"><i class="fa fa-picture-o"></i> Hình</th>
                        <th><i class="fa fa-link"></i> Link</th>
                        <th width="100px"><i class="fa fa-trash"></i> Xóa</th>
                    </tr>
                </thead>
                  <tbody class="sortAjax">
                    <?php foreach($listImg as $data){ ?>
                      <tr align="center" data-slide="<?=$data->id ?>">
                        <td><img style="height:50px;" src="../upload/<?=$data->img ?>" class="img-responsive"></td>
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