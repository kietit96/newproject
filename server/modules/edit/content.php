  <?php if($configMenu->tab){$listData = $db->list_data_where_where('data','data_parent',$id,'type',''); ?>
  <div class="col-md-12">
      <div>
        <a <?=linkAddIdData($id); ?>><i class="fa fa-plus"></i> Thêm tab con</a>
        <br>
        <ul class="nav nav-tabs">
          <?php foreach($listData as $key=>$data){ ?>
            <li class="<?=returnWhere('active',$key,0) ?>"><a data-toggle="tab" href="#tab<?=$data->id?>"><?=$data->title ?></a></li>
          <?php } ?>
        </ul>
        <br>
        <div class="tab-content">
          <?php foreach($listData as $key=>$data){ $listDataChild = $db->listDataChild($data->id);?>
            <div id="tab<?=$data->id?>" class="tab-pane fade <?=returnWhere('in active',$key,0) ?>">
              <a <?=linkUpdateId($data->id); ?>><i class="fa fa-trash"></i> Xóa</a>
              <br>
                <label>Tiêu đề:</label>
                <input type="text" value="<?=$data->title ?>" name="listRow[data][<?=$data->id ?>][title]" class="form-control" /><br>
                <label>Nội dung:</label>
                <textarea name="listRow[data][<?=$data->id ?>][content]" class="tinymce"><?=$data->content?></textarea><br>
              </div>
         <?php } ?>
        </div>
      </div>
  </div>
  <?php }else{ ?>
  <div class="col-md-12">
    <label>Nội dung:</label>
    <textarea class="tinymce" name="content"><?=$page->content ?></textarea>
  </div>
  <?php } ?>