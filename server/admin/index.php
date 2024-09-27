<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("../config.php");

include_once("../modules/control.php");
$start = 0;
if (isset($_GET['page']) && $_GET['page'] !== 1 && $_GET['page'] !== 0) {
  $start = $config->limit * $_GET['page'];
}
if ((!$menuPage) || (!isset($menuPage)) || (isset($page) && (!$page)) || ($menuPage->file == '404')) {
  http_response_code('404');
  $menuPage = $menu404;
}
$filePath = "include/" . $menuPage->file . ".php";

if (isset($configMenu) && $configMenu && ($configMenu->type == '')) {
  $filePath = "../modules/edit.php";
}

if ($author) {
  if (!$isAdmin) {
    if (!in_array($menuPage->id, explode(',', $author->type))) {
      $filePath = '../modules/block-user.php';
    }
  }
  if (!isset($_GET["ajax"])) {
    include_once("template/head.php");
    include_once("template/breadcrumb.php");
    include_once("template/success.php");
    include_once($filePath);
    include_once("template/footer.php");
  } else {
    include_once("template/breadcrumb.php");
    include_once("template/success.php");
    include_once($filePath);
  }
  include_once 'template/reload-script.php';
} else {
  header("Location: " . baseUrl . 'admin/login.php');
}
