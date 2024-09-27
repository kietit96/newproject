<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$folderName = 'newproject/server';
$domain = $_SERVER['SERVER_NAME'];
define('canEditSlug', true); //On - off edit slug
define('dbPrefix', 'vt_');

define('url', 'https://' . $domain . '/' . $folderName . '/');

//Language
$lang = isset($_GET['lang']) ? $_GET['lang'] : "vn"; //default VN
$_LANG = include_once("modules/language.php");
$_TRANS = json_decode(json_encode($_LANG[$lang]['text'])); //Convert array to object

//Cấu hình Host/localhost
if ($domain == 'localhost') {
	define('dbName', $_LANG[$lang]['databaseName']);
	define('baseUrl', 'https://' . $domain . '/' . $folderName . '/');
	define('dbUser', 'root');
	define('dbPass', '');
} else {
	define('dbUser', 'anhkiet');
	define('dbPass', '@kietvt123');
	define('dbName', $_LANG[$lang]['databaseName']);
	define('baseUrl', 'https://' . $domain . '/' . $folderName . '/');
}
include_once('modules/sql.php');

$listSl = (object) array(
	(object) array('title' => 'Tỉnh thành', 'name' => 'province'),
	(object) array('title' => 'Quận huyện', 'name' => 'district'),
);
$listFp = (object) array(
	(object) array('title' => 'Họ tên', 'name' => 'titlePost', 'icon' => 'user'),
	(object) array('title' => 'Số điện thoại', 'name' => 'phone', 'icon' => 'phone'),
	(object) array('title' => 'Tên sản phẩm', 'name' => 'title', 'icon' => 'tag'),
	(object) array('title' => 'Mô tả sản phẩm', 'name' => 'des', 'icon' => 'info'),
	(object) array('title' => 'Giá', 'name' => 'price', 'icon' => 'money'),
	(object) array('title' => 'Địa chỉ', 'name' => 'address', 'icon' => 'map-marker'),
);
