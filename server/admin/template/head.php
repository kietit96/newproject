<!DOCTYPE html>
<html class='no-js' lang='en' ng-app="myApp">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <base href="<?php echo baseUrl ?>admin/" data-url="<?= baseUrl ?>" />
  <meta charset='utf-8'>
  <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Edit: <?= $title ?></title>
  <meta content='kienlua.vn' name='author'>

  <link href="../upload/<?php echo $infoPage->icon ?>" rel="icon" type="image/ico" />

  <!-- Custom fonts for this template-->
  <link href="plugins/fontawesome-5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="new-template/css/sb-admin-2.min.css" rel="stylesheet">


  <link href="plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet">
  <link href="plugins/nprogress/nprogress.css" rel="stylesheet">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables/buttons.dataTables.min.css">

  <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="plugins/selectBox/css/bootstrap-multiselect.css" type="text/css" />
  <script src="new-template/vendor/jquery/jquery-3.1.1.min.js"></script>
</head>

<body id="page-top" class="">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion navAjax sortAjax" id="accordionSidebar" data-active='active' data-e="li">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
        <img src="assets/images/logoadmin.png" style="position: relative;display: block;width: 80%;">
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Dashboard -->
      <?php foreach ($listMenuAdmin as $keyFlag => $menu) : ?>
        <?php if ($menu->pos == '-5') {
          continue;
        } ?>
        <?php if ($menu->file !== 'lang' && $menu->file !== 'search' && $menu->file !== 'config' && ($isAdmin || (isset($author->type) && (in_array($menu->id, explode(',', $author->type)))))):
          $menuT = $menu->file === 'shop' ? "Đơn hàng" : $menu->title ?>
          <li data-name="<?= $menu->name ?>" class="nav-item <?= returnWhere('active', $menu->id, $menuPage->id) ?>">
            <a class="nav-link" title="Bấm Alt + <?= $keyFlag + 1 ?>" shortcut='alt+<?= $keyFlag + 1 ?>' <?= linkMenu($menu); ?>>
              <i class="<?= returnIcon($menu->file) ?>"></i>
              <span><?= $menuT ?></span>
            </a>
          </li>
        <?php endif ?>
      <?php endforeach ?>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <!-- Sidebar Toggler (Sidebar) -->
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <?php
          $menuLang = $db->alone_data_where('menu', 'file', 'lang');
          $listLang = $db->listMenuChild($menuLang->id);
          foreach ($listLang as $key => $lang1) {
            $url = $lang1->name === 'vn' ? url . 'admin/' . $_GET['slug'] : url . 'admin/' . $lang1->name . '/' . $_GET['slug'];
          ?>
            <li class="nav-item " style="visibility: hidden;">
              <a class="nav-link" href='<?= $url ?>'>
                <img <?php echo srcImg($lang1); ?>>
              </a>
            </li>
          <?php } ?>
          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search searchAjax" method="get" action="tim-kiem">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2" name="title">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
          <!-- Topbar Navbar -->
          <div class="row" style="margin-right: 250px;margin-top: 6px;width: 370px;text-align: center;vertical-align: middle;">
            <div class="col-md-6">
              <a title="Alt + H" shortcut="alt+h" onclick="window.open('<?= baseUrl ?>');" style="color:#858796"><i class="fa fa-home"></i> Xem trang chủ</a>
            </div>
            <div class="col-md-6">
              <a title="Alt + V" onclick="viewPage()" shortcut="alt+v" style="color:#858796"><i class="fa fa-eye"></i> Xem trang hiện tại</a>
            </div>
          </div>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search searchAjax" action="tim-kiem">
                  <div class="input-group">
                    <input type="text" name="title" class="form-control bg-light border-0 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $author->title ?></span>
                <?php $img = $author->img !== '' ? srcImg($author) : 'src="assets/images/admin_icon.png"' ?>
                <img class="img-profile rounded-circle" <?= $img ?>>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Đăng xuất
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid contentAjax">