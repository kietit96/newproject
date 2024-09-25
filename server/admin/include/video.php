<?php if(isset($id)){ ?>
<form role="form" method="POST" action="?name=<?php echo $name ?>&id=<?php echo $id?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-6">
        <input type="hidden" name="table" value="data"/>
        <input type="hidden" name="id" value="<?php echo $id?>"/>

        <label>Tiêu đề:</label>
        <input placeholder="Tiêu đề" class="form-control" value="<?php echo $page->title?>" name="title" />

        <label>Link video:</label>
        <input placeholder="Video" class="form-control" value="<?php echo $page->link?>" name="link"/>
    </div>
    <div class="col-md-6">
        <label>Hình ảnh:</label>
        <div class="row">
          <div class="col-md-4">
            <img height="90" onclick="$('#input<?php echo $id ?>').click();" id="image<?php echo $id ?>" src="../upload/<?php echo $page->img?>">
          </div>
          <div class="col-md-8">
            <div class="info-box-content">
              <input accept="image/*" name="img" type="file" id="input<?php echo $id ?>" onchange="readIMG(this,'<?php echo 'image'.$id ?>');">
              <p class="help-block"><?php echo $page->img ?></p>
            </div>
          </div>
        </div>
    </div>

    <div class="col-md-12" style="margin-top:10px;">
        <textarea class="tinymce" name="content"><?php echo $page->content ?></textarea>
    </div> 
    <div class="col-md-12">
      <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
  </div>

</form>
<?php }else{ include('../../modules/edit.php'); } ?>