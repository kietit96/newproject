<?php
$errorPage = false;
$listPage = $db->list_data_where('page_lang', 'lang', $lang);
// var_dump($listPage);
// $infoPage = new stdClass();
foreach ($listPage as $vl) {
	$key = $vl->page_parent;
	if (strlen($key)) {
		// echo "<pre>";
		$infoPage->$key = $vl->content;
		// echo "</pre>";
	}
}
// echo $infoPage->title;
$author = false;
$isAdmin = false;
if (isset($_COOKIE['user']) && isset($_COOKIE['password'])) {
	$author = $db->alone_data_where_where('user', 'password', md5($_COOKIE['password']), 'email', $_COOKIE['user']);
	if ($author && $author->isAdmin === '1') {
		$isAdmin = true;
	}
}

//routes and redirect
include_once('routes.php');

//POST REQUEST
if ($menuPage && $author) {
	if (isset($_POST['action'])) {
		$table = $_POST['table'];
		$action = $_POST['action'];
		unset($_POST['table']);
		unset($_POST['action']);
		switch ($action) {
			case 'add':
				if ($db->insertData($table, $_POST)) {
					$success = 'Thêm thành công !';
				} else {
					var_dump($db->insertDataError($table, $_POST));
				}
				break;

			case 'update':
				$value = $_POST['value'];
				if ($value !== '' && $value !== 0 && $value !== '0') {

					// $data = $db->alone_data_where($table,'id',$value);
					// if(isset($data->img)) delImg($data->img);
					switch ($table) {
						case 'menu':
							$sql .= 'UPDATE `' . dbPrefix . 'menu` SET `hide` = "1", `pos` = "-5" WHERE `id` = "' . $value . '"; ';
							if ($value !== '0' && $value !== 0 && $value !== '') {
								$allListMenuChild = array();
								$allListMenuChild = $db->allListMenuChild($value, $allListMenuChild);
								$allListDataChild = $db->allListDataChild($value);
								foreach ($allListMenuChild as $menu) {
									if ($menu->id !== 0 && $menu->menu_parent !== 0 && $menu->menu_parent !== '0' && $menu->menu_parent !== '') {
										// $sql.='DELETE FROM `'.dbPrefix.'menu` WHERE `menu_parent` = "'.$menu->id.'"; ';
										$sql .= 'UPDATE `' . dbPrefix . 'menu` SET `hide` = "1"  WHERE `menu_parent` = "' . $menu->id . '"; ';

										// $sql.='DELETE FROM `'.dbPrefix.'data` WHERE `menu` = "'.$menu->id.'"; ';
										$sql .= 'UPDATE `' . dbPrefix . 'data` SET `hide` = "1"  WHERE `menu_parent` = "' . $menu->id . '"; ';
									}
								}
								// $sql.='DELETE FROM `'.dbPrefix.'data` WHERE `data_parent` = -1 '; 
								$sql .= 'UPDATE `' . dbPrefix . 'data` SET `hide` = "1" WHERE `data_parent` = -1 ';
								foreach ($allListDataChild as $data) {
									$sql .= ' OR `data_parent` = ' . $data->id;
								}
								$sql .= ' ; ';
								// var_dump($sql);
							}
							break;
						case 'user':
							$sql .= 'UPDATE `' . dbPrefix . 'user` SET `hide` = "1" WHERE `id` = "' . $value . '"; ';
							break;
						case 'file_data_lang':
							$sql .= 'UPDATE `' . dbPrefix . 'file_data_lang` SET `hide` = "1" WHERE `id` = "' . $value . '"; ';
							break;
						case 'data':
							$sql .= 'UPDATE `' . dbPrefix . 'data` SET `hide` = "1" WHERE `id` = "' . $value . '"; ';
							$listDataChild = $db->listDataChild($value);
							foreach ($listDataChild as $dataChild) {
								if (isset($dataChild->img)) delImg($dataChild->img);
							}
							$sql .= 'UPDATE `' . dbPrefix . 'data` SET `hide` = "1" WHERE `data_parent` = "' . $value . '"; ';
							break;
					}
				}
				if ($db->execute_sql($sql)) {
					$success = 'Xóa thành công !';
				} else {
					echo $sql;
				}
				break;

			case 'del':
				$value = $_POST['value'];
				if ($value !== '' && $value !== 0 && $value !== '0') {
					$sql = 'DELETE FROM `' . dbPrefix . $table . '` WHERE `id` = "' . $value . '"; ';
					$data = $db->alone_data_where($table, 'id', $value);
					if (isset($data->img)) delImg($data->img);
					switch ($table) {
						case 'menu':
							// menu con
							$allListMenuChild = array();
							$allListMenuChild = $db->allListMenuChild($value, $allListMenuChild);
							$allListDataChild = $db->allListDataChild($value);
							if (count($allListMenuChild)) {
								foreach ($allListMenuChild as $menu) {
									// menu con + lang + slug
									if ($menu->id !== 0 && $menu->menu_parent !== 0 && $menu->menu_parent !== '0' && $menu->menu_parent !== '') {
										$sql .= 'DELETE FROM `' . dbPrefix . 'menu` WHERE `menu_parent` = "' . $menu->id . '"; ';
										$sql .= 'DELETE FROM `' . dbPrefix . 'menu_lang` WHERE `menu_id` = "' . $menu->id . '"; ';
										// data
										$sql .= 'DELETE FROM `' . dbPrefix . 'data` WHERE `menu` = "' . $menu->id . '"; ';
									}
								}
							}
							// menu + lang + slug
							$sql .= 'DELETE FROM `' . dbPrefix . 'menu` WHERE `id` = "' . $value . '"; ';
							$sql .= 'DELETE FROM `' . dbPrefix . 'menu_lang` WHERE `menu_id` = "' . $value . '"; ';

							// data
							$sql .= 'DELETE FROM `' . dbPrefix . 'data` WHERE `menu` = "' . $value . '"; ';
							// data
							foreach ($allListDataChild as $data) {
								$sql .= 'DELETE FROM `' . dbPrefix . 'data` WHERE `data_parent` = "' . $data->id . '"; ';
								$sql .= 'DELETE FROM `' . dbPrefix . 'data_lang` WHERE `data_id` = "' . $data->id . '"; ';
							}

							break;
						case 'data':
							$listDataChild = $db->listDataChild($value);
							foreach ($listDataChild as $dataChild) {
								if (isset($dataChild->img)) delImg($dataChild->img);
							}
							$sql .= 'DELETE FROM `' . dbPrefix . 'data_lang` WHERE `data_id` = "' . $value . '"; ';
							$sql .= 'DELETE FROM `' . dbPrefix . 'data` WHERE `data_parent` = "' . $value . '"; ';
							break;
						case 'file_data':
							$sql .= 'DELETE FROM `' . dbPrefix . 'file_data` WHERE `parent` = "' . $value . '"; ';
							break;
						case 'file_data_lang':
							$sql .= 'DELETE FROM `' . dbPrefix . 'file_data_lang` WHERE `file_data_id` = "' . $value . '"; ';
							break;
						case 'page':
							$delp = $db->alone_data_where('page', 'id', $value);
							$sql .= 'DELETE FROM `' . dbPrefix . 'page_lang` WHERE `page_parent` = "' . $delp->name . '"; ';
							$sql .= 'DELETE FROM `' . dbPrefix . 'page` WHERE `id` = "' . $value . '"; ';
							break;
					}
				}
				if ($db->execute_sql($sql)) {
					$success = 'Xóa thành công !';
				} else {
					echo $sql;
				}
				break;
		}
		getNewSlug();
	} else if (count($_POST)) {
		$timeNow = '-' . renameTitle(timeNow());
		$target_dir = '../upload/';

		if (!isset($_POST['id']))
			$_POST['id'] = (isset($idList)) ? $idList : $menuPage->id;

		if (!isset($_POST['table']))
			$_POST['table'] = 'menu';

		if (isset($id)) {
			$_POST['id'] = $id;
			$_POST['table'] = 'data';
		}
		if ($_POST['table'] == 'info') {
			$array = [];
			$dataPage = $db->list_data('page');
		}
		if ($_POST['table'] == 'user') {
			if (isset($_POST['type'])) {
				$listMenuChecked = array();
				foreach ($_POST['type'] as $key => $type) {
					if ($type == 1) {
						$listMenuChecked[] = $key;
					}
				}
				$_POST['type'] = implode(',', $listMenuChecked);
			}
		}
		if (isset($_FILES)) {
			foreach ($_FILES as $keyAction => $arFile) {
				switch ($keyAction) {
					case 'slideData':
						foreach ($arFile['name'] as $key => $vl) {
							$fileName = $arFile['name'][$key];
							$tmpName = $arFile['tmp_name'][$key];
							$uploadFile = uploadFile($fileName, $tmpName);
							if ($uploadFile['success']) {
								$post = array(
									'data_parent' => $_POST['id'],
									'type' => 'slide',
									'img' => $uploadFile['img'],
								);
								$db->insertImage('data', $post);
							}
						}
						break;
					case 'slide2Data':
						foreach ($arFile['name'] as $key => $vl) {
							$fileName = $arFile['name'][$key];
							$tmpName = $arFile['tmp_name'][$key];
							$uploadFile = uploadFile($fileName, $tmpName);
							if ($uploadFile['success']) {
								$post = array(
									'data_parent' => $_POST['id'],
									'type' => 'slide2',
									'img' => $uploadFile['img'],
								);
								$db->insertImage('data', $post);
							}
						}
						break;
					case 'listImageType':
						foreach ($arFile['name'] as $type => $listFile) {
							foreach ($arFile['name'][$type] as $key => $vl) {
								$fileName = $arFile['name'][$type][$key];
								// var_dump($fileName);
								$tmpName = $arFile['tmp_name'][$type][$key];
								$uploadFile = uploadFile($fileName, $tmpName);
								if ($uploadFile['success']) {

									// resize
									// $width = $_POST['listImageType'][$type]['width'];
									// $height = $_POST['listImageType'][$type]['height'];
									// $url = '../upload/' . $uploadFile['img'];
									// resizeImage($url, $url, $width,$height);

									$post = array(
										'file_data_id' => $_POST['id'],
										'type' => $type,
										'img' => $uploadFile['img'],
										'lang' => $_POST['lang'],
									);
									// var_dump($post);
									$db->insertData('file_data_lang', $post);
								}
							}
						}
						break;
					case 'info':
						foreach ($arFile['name'] as $key => $vl) {
							$fileName = $arFile['name'][$key];
							if ($fileName == '') continue;
							$tmpName = $arFile['tmp_name'][$key];
							$uploadFile = uploadFile($fileName, $tmpName);
							if ($uploadFile['success']) {
								$data = $db->alone_data_where('page', 'name', $key);
								delFileCol($data, 'content');
								$array[$key] = $uploadFile['img'];
							}
						}
						break;
					case 'listRowInfo':
						foreach ($arFile['name'] as $type => $listFile) {
							foreach ($arFile['name'][$type] as $key => $vl) {

								$fileName = $arFile['name'][$type][$key];
								$tmpName = $arFile['tmp_name'][$type][$key];
								foreach ($fileName as $key2 => $value) {
									if (!empty($value)) {
										$uploadFile = uploadFile($value, $tmpName[$key2]);
										$dataInfo = $db->alone_data_where('page_lang', 'id', $key);
										if (isset($dataInfo->content)) {
											delImg($dataInfo->content);
										}
										$db->updateRow('page_lang', array("content" => $uploadFile["img"]), "id", $key);
									}
								}
							}
						}
						break;
					case 'listRowMenu':
						foreach ($arFile['name'] as $type => $listFile) {
							foreach ($arFile['name'][$type] as $key => $vl) {
								$fileName = $arFile['name'][$type][$key];
								$tmpName = $arFile['tmp_name'][$type][$key];
								foreach ($fileName as $key2 => $value) {
									if (!empty($value)) {
										$uploadFile = uploadFile($value, $tmpName[$key2]);
										$db->updateRow('menu_lang', array("img" => $uploadFile["img"]), "id", $key);
									}
								}
							}
						}
						break;
					case 'listRowMenu2':
						foreach ($arFile['name'] as $type => $listFile) {
							foreach ($arFile['name'][$type] as $key => $vl) {
								$fileName = $arFile['name'][$type][$key];
								$tmpName = $arFile['tmp_name'][$type][$key];
								foreach ($fileName as $key2 => $value) {
									if (!empty($value)) {
										$uploadFile = uploadFile($value, $tmpName[$key2]);
										$db->updateRow('menu_lang', array("background" => $uploadFile["img"]), "id", $key);
									}
								}
							}
						}
						break;
					case 'listRow':
						foreach ($arFile['name'] as $type => $listFile) {
							foreach ($arFile['name'][$type] as $key => $vl) {
								$fileName = $arFile['name'][$type][$key];
								$tmpName = $arFile['tmp_name'][$type][$key];
								foreach ($fileName as $key2 => $value) {
									if (!empty($value)) {
										$uploadFile = uploadFile($value, $tmpName[$key2]);
										$db->updateRow('data_lang', array("f1" => $uploadFile["img"]), "id", $key);
									}
								}
							}
						}
						break;
					case 'importFile':
						if ($arFile['tmp_name'] !== '' && $_POST['table'] == 'menu') {
							libxml_use_internal_errors(true);
							include 'phpexcel/Classes/PHPExcel.php';
							$inputFileName = $arFile['tmp_name'];
							$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
							$idMenu = $_POST['id'];

							if ($objPHPExcel) {
								$listCols = [];
								$listData = [];
								foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
									$highestRow         = $worksheet->getHighestRow();
									$highestColumn      = $worksheet->getHighestColumn();
									$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
									for ($col = 0; $col < $highestColumnIndex; ++$col) {
										$cell = $worksheet->getCellByColumnAndRow($col, 2);
										$listCols[] = $cell->getFormattedValue();
									}
									for ($row = 3; $row <= $highestRow; ++$row) {
										$listItem = [];
										for ($col = 0; $col < $highestColumnIndex; ++$col) {
											$cell = $worksheet->getCellByColumnAndRow($col, $row);
											if ($listCols[$col] !== '') {
												$listItem[$listCols[$col]] = $cell->getFormattedValue();
											}
										}
										$listData[] = $listItem;
									}
								}
								//insertdata to $_POST['id']
								foreach ($listData as $data) {
									$data['menu'] = $idMenu;
									if (!$data['title']) $data['title'] = 'Đang cập nhật !';
									if (isset($data['img']) && $data['img'] !== '') {
										$imgData = $data['img'];
										$mime_type = substr($imgData, 11, strpos($imgData, ';base64') - 11);
										$fileName = $data['img'] = renameTitle($data['title']) . $timeNow . '.' . $mime_type;
										$pathFile = $target_dir . $fileName;
										$thumbFile = $target_dir . 'thumb-' . $fileName;
										$b64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgData));
										if (file_put_contents($pathFile, $b64)) {
											// resizeImage($pathFile,$thumbFile,$configMenu->maxWidth,$configMenu->maxHeight);
										}
									}
									$db->insertData('data', $data);
								}
							}
						}
						break;

					default:
						$uploadFile = uploadFile($arFile['name'], $arFile['tmp_name'], $arFile['type']);
						if ($uploadFile['success']) {

							// resize
							$url = '../upload/' . $uploadFile['img'];
							// resizeImage($url, $url, $configMenu->maxWidth,$configMenu->maxHeight);

							$data = $db->alone_data_where($_POST['table'], 'id', $_POST['id']);
							delImg($data->$keyAction);
							$_POST[$keyAction] = $uploadFile['img'];
						}
						break;
				}
			}
		}
		if (isset($dataPage)) {
			foreach ($dataPage as $data) {
				if (isset($_POST[$data->name])) $array[$data->name] = $_POST[$data->name];
			}
			if ($db->updateTable('page', $array, 'content', 'name')) {
				$success = 'Lưu thành công !';
			}
		}
		if (isset($_POST['listSlug'])) {
			$listRow = $_POST['listSlug'];
			foreach ($listRow as $idKey => $data) {
				$data = ($data != '') ? renameSlug($data) : time();
				$db->updateSlug($data, $idKey);
			}
		}
		if (isset($_POST['listRow'])) {
			$listRow = $_POST['listRow'];
			foreach ($listRow as $table => $row) {
				foreach ($row as $rowId => $data) {
					if (isset($data['title']) && (!isset($data['name']) || $data['name'] == '')) {
						$data['name'] = renameTitle($data['title']);
					}
					$db->updateRow($table, $data, 'id', $rowId);
				}
			}
		}
		if (isset($_POST['table'])) {
			$table = $_POST['table'];
			$value = $_POST['id'];

			switch ($table) {
				case 'user':
					$post = $_POST;

					if (empty($post['password'])) {
						unset($_POST['password']);
					} else {
						$_POST['password'] = md5($post['password']);
					}

					break;
			}

			if ($db->updateRow($table, $_POST, 'id', $value)) {
				$success = 'Lưu thành công !';
			}
		}
		clearCache();
	}
	getNewSlug();
}

$password = $db->alone_data_where('page', 'name', 'password');
$password = $password->content;
$listMenu = $db->list_data_where_where_order('menu', 'menu_parent', 0, 'hide', 0, 'pos', 'ASC');
$listMenuAdmin = $db->list_data_where_order('menu', 'menu_parent', 0, 'pos', 'ASC');
$allListMenu = $db->allListMenu();
$listConfig = $db->list_data('config');
$config = new stdClass();
foreach ($listConfig as $vl) {
	$key = $vl->name;
	if (strlen($key)) {
		$config->$key = $vl->value;
	}
}

$title = $infoPage->title;
$image = $infoPage->logo;
$des = $infoPage->des;
$keywords = $infoPage->keywords;

if ((isset($page) || isset($id)) && $page) {
	if (!isset($idList)) {
		$pageTitle = $db->alone_data_where_where('data_lang', 'data_id', $id, 'lang', $lang);
		$image = $page->img;
	} else {
		$pageTitle = $db->alone_data_where_where('menu_lang', 'menu_id', $idList, 'lang', $lang);
		$image = $pageTitle->img;
	}

	$title = $pageTitle->title;

	if ($pageTitle->des != '') $des = $pageTitle->des;
	if (isset($pageTitle->keywords) && strlen($pageTitle->keywords) > 0) $keywords = $pageTitle->keywords;
	if (isset($id) && $pageTitle->price !== '0' && $pageTitle->price !== '') $des = $pageTitle->price . ' - ' . $des;
} else if ((isset($menuPage)) && ($menuPage) && ($menuPage->file !== 'home')) {
	$homeTitle = $db->alone_data_where_where('menu_lang', 'menu_id', $menuPage->id, 'lang', $lang);
	$title = $homeTitle->title;
	$image = $homeTitle->img;
	if ($des == '') $des = $homeTitle->des;
	$keywords = $homeTitle->keywords;
	$content = $homeTitle->content;
}
if (isset($name) && $menuPage->file !== 'search' && $menuPage->file !== 'user') {
	if (!checkObject($listMenu, 'name', $name)) $errorPage = true;
}
foreach ($allListMenu as $menu) {
	$nameMenu = 'menu' . ucfirst($menu->file);
	$$nameMenu = $db->alone_data_where('menu', 'file', $menu->file);
}
$listImageHome = $db->list_data_where_order('file_data', 'type', 'listImg', 'pos', 'ASC');
if (count($listImageHome)) {
	$list = new stdClass;
	foreach ($listImageHome as $listImage) {
		if ($listImage->name) {
			$listName = $listImage->name;
			$menuHome = $db->alone_data_where('menu', 'file', 'home');
			$list->$listName = $db->list_data_where_where_where('file_data_lang', 'file_data_id', $menuHome->id, 'type', $listName, 'pos', 'ASC');
		}
	}
}
