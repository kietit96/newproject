<?php
$menuLang = $db->alone_data_where('menu', 'file', 'lang');
$listLang = $db->listMenuChild($menuLang->id);
$idFile = 'include/' . $menuPage->file . '.php';
/*Nếu không tồn tại idFile thì cấu hình chi tiết sản phẩm theo mặc định*/
?>
<?php include '../admin/include/head_lang.php' ?>
<?php if (isset($id)) { ?>
  <form role="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <div class="row">
      <?php if ($menuPage->id == $menuPicture->id) {
        include('edit/picture.php');
      } else {
        include('edit/page.php');
      } ?>
      <div class="col-md-12">
        <br />
        <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt+
          S)</button>
      </div>
    </div>
  </form>
<?php } else {
  $colList = ($configMenu->showList) ? 8 : 12;
  if (!isset($idList)) {
    $idList = $menuPage->id;
    $page = $menuPage;
  }
  $listData = $db->listData($idList);
  $listMenuChild = $db->listMenuChild($idList);
  ?>
  <form role="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <div class="row">
      <?php if ($menuPage->file == 'ship'): ?>
        <?php include('edit/ship.php'); ?>
      <?php else: ?>
        <?php include('edit/idList.php'); ?>
        <?php include('edit/menuPage.php'); ?>
      <?php endif ?>

      <div class="col-md-12">
        <br />
        <button type="submit" class="btn btn-success form-control">
          <i class="fa fa-save"></i> Lưu (Alt + S)
        </button>
      </div>
    </div>
  </form>
<?php } ?>