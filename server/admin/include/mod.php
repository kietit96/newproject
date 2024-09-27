<?php include 'head_lang.php'?>
<?php
if(isset($_GET['user_id'])){
  $user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '';
  $userCurrent = $db->alone_data_where("user", "id", $user_id);
  if (!$userCurrent) {
    echo "<h1>Tài khoản không tồn tại</h1>";
    die();
  }
?>
<form role="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
  <input type="hidden" name="table" value="user"/>
  <input type="hidden" name="id" value="<?=$userCurrent->id?>"/>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="titleUser">Tên:</label>
        <input id="titleUser" class="form-control" value="<?=$userCurrent->title?>" name="title"/>
      </div>
      <div class="form-group">
        <label for="user">Email:</label>
        <input class="form-control" value="<?=$userCurrent->email?>" name="email"/>
      </div>
      <div class="form-group">
        <label for="pwd">Mật khẩu:</label>
        <input id="pwd" class="form-control" value="" name="password"/>
      </div>
      <div class="form-group">
        <label for="pwd">Quản trị:</label>
        <div class="onoffswitch">
          <input type="hidden" name="isAdmin" value="0" />
          <input type="checkbox" <?=returnWhere('checked',$userCurrent->isAdmin,true)?> name="isAdmin" class="onoffswitch-checkbox" id="switchhideisAdmin" value="1" />
          <label class="onoffswitch-label" for="switchhideisAdmin"></label>
        </div>
      </div>
      
    </div>
    <div class="col-md-6">
      <div class="text-center">
        <label class="btn btn-primary" style="width:100%;" for="fileImg">
          <i class="fa fa-upload"></i> Ảnh đại diện (Rộng:<?=$configMenu->maxWidth?>px Cao:<?=$configMenu->maxHeight?>px)
        </label>
        <hr>
        <img height="100" onclick="$('#input<?=$userCurrent->id ?>').click();" id="image<?=$userCurrent->id ?>" src="../upload/<?=$userCurrent->img?>">
        <input class="hidden" id="fileImg" accept="image/*" name="img" type="file" id="input<?=$userCurrent->id ?>" onchange="readIMG(this,'<?='image'.$userCurrent->id ?>');">
      </div>
      <br/>
      <label class="col-md-12">Được chỉnh sửa các danh mục: </label>
      <?php foreach($listMenuAdmin as $menu){ if($menu->file !=='search'){
        $checkedMenu = false;
        $listMenuCheck = explode(',', $userCurrent->type);
        if(in_array($menu->id,$listMenuCheck)){
          $checkedMenu = true;
        }
      ?>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-3">
            <div class="onoffswitch">
                <input type="hidden" name="type[<?=$menu->id?>]" value="0" />
                <input type="checkbox" <?=returnWhere('checked',$checkedMenu,true)?> name="type[<?=$menu->id?>]" class="onoffswitch-checkbox" id="switchhide<?=$menu->id ?>" value="1" />
                <label class="onoffswitch-label" for="switchhide<?=$menu->id ?>"></label>
            </div>
          </div>
          <div class="col-md-9">
            <?=$menu->title?>
          </div>
        </div>
      </div>
      <?php }} ?>
    </div>
  </div>
  <button type="submit" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
</form>
<?php
}else{
  $listData = $db->list_data('user');  
?>
<div class="box-header">
  <h3 class="box-title">
    <a <?=linkAdd('user')?> >
      <i class="fa fa-plus"></i> Thêm thành viên
    </a>
  </h3>
</div>
<div class="box-body">
  <table class="table">
    <thead>
      <tr>
        <th>Tên</th>
        <th>Email</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
    <?php
      foreach($listData as $key=>$data){
        if ($data->hide == 1){ continue; }
    ?>
      <tr align="center" data-id="<?=$data->id?>">
       <td>
          <a href="<?php echo pageUrlRemoveParams() ?>?user_id=<?php echo $data->id ?>">
            <?php 
              if ($data->title == '') {
                echo "Đang cập nhật";
              }else {
                echo $data->title;
              }
            ?>
          </a>
        </td>
       <td>
          <a href="<?php echo pageUrlRemoveParams() ?>?user_id=<?php echo $data->id ?>">
            <?=$data->email?>
          </a>
        </td>
       <td class="action">
        <a <?=linkDelId($data->id,"user"); ?>><i class="fa fa-trash"></i></a>
       </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>