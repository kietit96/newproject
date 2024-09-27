<?php if(isset($id)){ ?>
<form role="form" method="POST" class="form-horizontal" action="?name=<?=$name ?>&id=<?=$id?>" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-6">
        <input type="hidden" name="table" value="data"/>
        <input type="hidden" name="id" value="<?=$id?>"/>
        <div class="form-group">
          <label class="control-label col-md-3">Tiêu đề</label>
          <div class="col-md-9">
            <input class="form-control" value="<?=$page->title?>" name="title"/>
          </div>
        </div>
    </div>
    <div class="col-md-6">
    	<div class="form-group">
          <div class="col-md-6">
            <img height="130" onclick="$('#input<?=$id ?>').click();" id="image<?=$id ?>" src="../upload/<?=$page->img?>">
          </div>
          <div class="col-md-6">
            <div class="info-box-content">
              <input accept="image/*" name="img" type="file" id="input<?=$id ?>" onchange="readIMG(this,'<?='image'.$id ?>');">
              <p class="help-block"><?=$page->img ?></p>
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-12">
    	<label>Nội dung: </label>
      <textarea class="ckeditor" name="content"><?=$page->content ?></textarea>
    </div> 
    <div class="col-md-12">
      <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
  </div>

</form>
<?php }else{ include('../../modules/edit.php'); } ?>