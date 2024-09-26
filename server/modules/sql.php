<?php
/*require_once 'htmlpurifier/library/HTMLPurifier.auto.php';
$configPurify = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($configPurify);*/
include_once("function.php");
include_once("database.php");
class DB extends database
{
	public function loopMenuMultiFilter($name, $idList = 0, $keyCheck = 0, $depth = false)
	{ ?>
		<?php
		if ($idList !== 0) {
			$listMenuParent = array_reverse($this->allListMenuParent($idList));
			$idListMenu = $listMenuParent[$keyCheck]->id;
			$idListNext = 0;
			if (isset($listMenuParent[$keyCheck + 1])) {
				$idListNext = $listMenuParent[$keyCheck + 1]->id;
			}
			$listMenu = $this->listMenuChild($idListMenu);
		}
		if (count($listMenu)) {
		?>
			<?php foreach ($listMenu as $menuChild) { ?>
				<li data-idList="<?= $menuChild->id ?>">
					<a class="thumuc" <?= linkIdList($menuChild, $name) ?>><?= $menuChild->title ?></a>
					<?php if ($menuChild->vip == 1): ?>
						<a <?= linkAddMenu($menuChild->id) ?>><i class="fa fa-plus"></i></a>
					<?php endif ?>
					<a <?php if ($idListNext == $menuChild->id) echo 'disabled'; ?> <?= linkDelMenu($menuChild->id) ?>><i class="fa fa-trash"></i></a>
					<?php if ($idListNext == $menuChild->id || $depth && $depth <= $keyCheck) { ?>
						<ul class="tree sortAjax">
							<?php $this->loopMenuMultiFilter($name, $idList, $keyCheck + 1); ?>
						</ul>
					<?php } ?>
				</li>
			<?php
			}
		}
	}
	public function findOrCreateSlug($title, $table, $id)
	{
		$slug = $this->alone_data_where_where("slug", "tableName", $table, "idTable", $id);
		if ($slug) {
			return $slug;
		}

		$createSlug = $this->insertData("slug", [
			"slugName" => renameTitle2($title),
			"tableName" => $table,
			"idTable" => $id
		]);
		if ($createSlug) {
			return $this->findOrCreateSlug($title, $table, $id);
		} else {
			return $this->findOrCreateSlug($title . '-' . time(), $table, $id);
		}
	}
	public function updateSlug($slug, $id)
	{
		$slug = renameTitle2($slug);
		$slugExists = $this->alone_data_where("slug", "slugName", $slug);
		if ($slugExists && $slugExists->id != $id) {
			return $this->updateRow("slug", ["slugName" => $slug . '-' . time()], 'id', $id);
		} else {
			return $this->updateRow("slug", ["slugName" => $slug], 'id', $id);
		}
	}
	public function listCols($table)
	{
		$sql = "SHOW COLUMNS FROM " . dbPrefix . "$table";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function all_table()
	{
		$sql = "SHOW TABLES FROM " . dbName;
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function listMenuChild($id)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "menu` WHERE `menu_parent` = '$id' ORDER BY `pos` ASC;";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function listData($id, $limit = '')
	{
		$sql = "SELECT * FROM `" . dbPrefix . "data` WHERE `menu` = '$id' ORDER BY `pos` ASC, `id` DESC ";
		if (is_numeric($limit)) {
			$sql .= " LIMIT 0," . $limit;
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function listDataChild($id)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "data` WHERE `data_parent` = '$id' ORDER BY `id` ASC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_array($table, $array = array(), $orderCol = 'id', $orderValue = 'ASC', $limitStart = 0, $limitEnd = 0)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE 1";
		if (count($array)) {
			foreach ($array as $key => $value) {
				$sql .= " AND `$key` = '$value' ";
			}
		}
		$sql .= " ORDER BY `$orderCol` $orderValue ";
		if ($limitEnd !== 0) {
			$sql .= " LIMIT $limitStart,$limitEnd ";
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function menuParent($idMenu)
	{
		$allListMenuParent = $this->allListMenuParent($idMenu);
		return end($allListMenuParent);
	}
	public function allListMenuParent($idMenu)
	{
		global $allListMenuParent;
		$allListMenuParent = array();
		$allListMenuParent = $this->findMenu($idMenu, $allListMenuParent);
		return $allListMenuParent;
	}
	public function findMenu($idMenu, $allListMenuParent)
	{
		global $allListMenuParent;
		$menu = $this->alone_data_where('menu', 'id', $idMenu);
		$allListMenuParent[] = $menu;
		if (($menu) && $menu->menu_parent !== '0') {
			$this->findMenu($menu->menu_parent, $allListMenuParent);
		}
		return $allListMenuParent;
	}
	public function dataId($table, $id)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `id` = '$id';";
		$this->setQuery($sql);
		return $this->loadRow(array($sql));
	}
	public function allListMenuChild($idMenu, $allListMenuChild)
	{
		global $allListMenuChild;
		$checkMenu = $this->alone_data_where('menu', 'id', $idMenu);
		$check = true;
		if (count($allListMenuChild)) {
			foreach ($allListMenuChild as $menuChild) {
				if ($menuChild->id == $idMenu) {
					$check = false;
				}
			}
		}
		if ($check) {
			$allListMenuChild[] = $checkMenu;
		}
		$listMenu = $this->listMenuChild($idMenu);
		if (count($listMenu)) {
			foreach ($listMenu as $menu) {
				$allListMenuChild[] = $menu;
				$this->allListMenuChild($menu->id, $allListMenuChild);
			}
		}
		return $allListMenuChild;
	}
	public function allListDataChild($idMenu, $start = 0, $limit = '', $order = 'id', $type = 'DESC', $where = '', $value = '', $equal = '=')
	{

		$sql = "";
		global $allListMenuChild;
		$allListMenuChild = array();
		$allListMenuChild = $this->allListMenuChild($idMenu, $allListMenuChild);
		if (count($allListMenuChild)) {
			$sql .= "SELECT * FROM `" . dbPrefix . "data` WHERE ( ";
			foreach ($allListMenuChild as $key => $menuChild) {
				$sql .= " `menu` = '" . $menuChild->id . "' ";
				if ($key !== count($allListMenuChild) - 1) {
					$sql .= " OR ";
				}
			}
			$sql .= " ) ";
		}
		if ($where !== '' && $value !== '') {
			$sql .= " AND `" . $where . "` $equal '" . $value . "' ";
		}
		$sql .= ' ORDER BY ' . $order . ' ' . $type;
		if (is_numeric($limit)) {
			$sql .= " LIMIT $start,$limit";
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function allListDataChildHot($idMenu, $start = 0, $limit = '', $order = 'id', $type = 'DESC', $where = '', $value = '', $equal = '=')
	{

		$sql = "";
		global $allListMenuChild;
		$allListMenuChild = array();
		$allListMenuChild = $this->allListMenuChild($idMenu, $allListMenuChild);
		if (count($allListMenuChild)) {
			$sql .= "SELECT * FROM `" . dbPrefix . "data` WHERE ( ";
			foreach ($allListMenuChild as $key => $menuChild) {
				$sql .= " `menu` = '" . $menuChild->id . "' ";
				if ($key !== count($allListMenuChild) - 1) {
					$sql .= " OR ";
				}
			}
			$sql .= " ) ";
		}
		if ($where !== '' && $value !== '') {
			$sql .= " AND `" . $where . "` $equal '" . $value . "' ";
		}
		$sql .= " AND `hot` = '1'";
		$sql .= ' ORDER BY ' . $order . ' ' . $type;
		if (is_numeric($limit)) {
			$sql .= " LIMIT $start,$limit";
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function countAllListDataChild($idMenu, $start = 0, $limit = '', $order = 'id', $type = 'DESC', $where = '', $value = '', $equal = '=')
	{

		$sql = "";
		global $allListMenuChild;
		$allListMenuChild = array();
		$allListMenuChild = $this->allListMenuChild($idMenu, $allListMenuChild);
		if (count($allListMenuChild)) {
			$sql .= "SELECT count(*) as 'rows' FROM `" . dbPrefix . "data` WHERE ( ";
			foreach ($allListMenuChild as $key => $menuChild) {
				$sql .= " `menu` = '" . $menuChild->id . "' ";
				if ($key !== count($allListMenuChild) - 1) {
					$sql .= " OR ";
				}
			}
			$sql .= " ) ";
		}
		if ($where !== '' && $value !== '') {
			$sql .= " AND `" . $where . "` $equal '" . $value . "' ";
		}
		$sql .= ' ORDER BY ' . $order . ' ' . $type;
		if (is_numeric($limit)) {
			$sql .= " LIMIT $start,$limit";
		}
		$this->setQuery($sql);
		return $this->loadRow(['data']);
	}
	public function loopMenuSitemap($listMenu, $name, $pf)
	{
		foreach ($listMenu as $menuChild) {
			$listMenuChild = $this->listMenuChild($menuChild->id);
			$linkId = $this->findOrCreateSlug($menuChild->title, 'menu', $menuChild->id);
			if (count($listMenuChild)) {
				fwrite(
					$pf,
					"<url>\n" .
						"   <loc>" . baseUrl . $linkId->slugName . "</loc>\n" .
						"   <changefreq>daily</changefreq>\n" .
						"   <priority>0.5</priority>\n" .
						"</url>\n"
				);
				$this->loopMenuSitemap($listMenuChild, $name, $pf);
			} else {
				fwrite(
					$pf,
					"<url>\n" .
						"   <loc>" . baseUrl . $linkId->slugName . "</loc>\n" .
						"   <changefreq>daily</changefreq>\n" .
						"   <priority>0.5</priority>\n" .
						"</url>\n"
				);
			}
		}
	}
	public function loopMenu($listMenu, $name, $idCheck = 0)
	{
		foreach ($listMenu as $menuChild) {
			?>
			<!-- <?php echo $menuChild->pos; ?> -->
			<li data-idList="<?= $menuChild->id ?>">
				<a class="thumuc" <?= linkIdList($menuChild, $name) ?>><?= $menuChild->title ?></a>
				<?php if ($idCheck != $menuChild->id) { ?><a <?= linkDelMenu($menuChild->id) ?>><i class="fa fa-trash"></i></a><?php } ?>
				<?php $listMenuChild = $this->listMenuChild($menuChild->id);
				if (count($listMenuChild)) { ?>
					<ul class="tree sortAjax">
						<?php $this->loopMenu($listMenuChild, $name); ?>
					</ul>
				<?php } ?>
			</li>
		<?php
		}
	}
	public function loopMenuMulti($name, $idList = 0, $keyCheck = 0)
	{ ?>
		<?php
		if ($idList !== 0) {
			$listMenuParent = array_reverse($this->allListMenuParent($idList));
			$idListMenu = $listMenuParent[$keyCheck]->id;
			$idListNext = 0;
			if (isset($listMenuParent[$keyCheck + 1])) {
				$idListNext = $listMenuParent[$keyCheck + 1]->id;
			}
			$listMenu = $this->listMenuChild($idListMenu);
		}
		if (count($listMenu)) {
		?>
			<?php foreach ($listMenu as $menuChild) { ?>
				<li data-idList="<?= $menuChild->id ?>">
					<a class="thumuc" <?= linkIdList($menuChild, $name) ?>><?= $menuChild->title ?></a>
					<a <?= linkAddMenu($menuChild->id) ?>><i class="fa fa-plus"></i></a>
					<a <?php if ($idListNext == $menuChild->id) echo 'disabled'; ?> <?= linkDelMenu($menuChild->id) ?>><i class="fa fa-trash"></i></a>
					<?php if ($idListNext == $menuChild->id) { ?>
						<ul class="tree sortAjax">
							<?php $this->loopMenuMulti($name, $idList, $keyCheck + 1); ?>
						</ul>
					<?php } ?>
				</li>
			<?php
			}
		}
	}

	public function loopOptionFilter($listMenu, $selected)
	{
		foreach ($listMenu as $key => $menu) {
			$listMenuChild = $this->listMenuChild($menu->id);
			if (count($listMenuChild)) { ?>
				<optgroup label="<?= $menu->title ?>">
					<?php $this->loopOptionFilter($listMenuChild, $selected); ?>
				</optgroup>
			<?php } else {
				$listData = $this->listData($menu->id); ?>
				<optgroup label="<?= $menu->title ?>">
					<?php foreach ($listData as $key => $data): ?>
						<option value="<?php echo $data->id ?>" <?php if (in_array($data->id, explode(',', $selected))): ?>selected<?php endif ?>><?php echo $data->title ?></option>
					<?php endforeach ?>
				</optgroup>
			<?php }
		}
	}

	public function loopMenuView($listMenu, $name)
	{
		foreach ($listMenu as $menuChild) {

			$listMenuChild = $this->listMenuChild($menuChild->id);
			if (count($listMenuChild)) { ?>
				<li class="">
					<a <?= linkIdList($menuChild, $name) ?>> <?= $menuChild->title ?> <i class="fa fa-angle-right"></i></a>
					<ul class="sub-menu">
						<?php $this->loopMenuView($listMenuChild, $name); ?>
					</ul>
				</li>
			<?php } else { ?>
				<li>
					<a <?= linkIdList($menuChild, $name) ?>><?= $menuChild->title ?></a>
				</li>
			<?php }
		}
	}
	public function loopMenuSidebar($listMenu, $name)
	{
		foreach ($listMenu as $menuChild) {
			$listMenuChild = $this->listMenuChild($menuChild->id);
			if (count($listMenuChild)) { ?>
				<li class="list-dropdown">
					<label class="tree-toggler nav-header">
						<i class="fa fa-arrow-circle-down"></i>
						<a <?= linkIdList($menuChild, $name) ?>> <?= $menuChild->title ?> </a>
					</label>
					<ul class="nav-list">
						<?php $this->loopMenuSidebar($listMenuChild, $name); ?>
					</ul>
				</li>
			<?php } else { ?>
				<li>
					<a <?= linkIdList($menuChild, $name) ?>><i class="fa fa-dot-circle-o"></i> <?= $menuChild->title ?></a>
				</li>
			<?php }
		}
	}
	public function showListMenu($listMenu, $menuPage)
	{
		foreach ($listMenu as $menu) { ?>
			<li class="<?= returnWhere('quantrong', $menuPage->name, $menu->name) ?>">
				<a <?= linkMenu($menu) ?>>
					<?php if ($menu->name == 'trang-chu') { ?>
						<i class="fa fa-home fa-2x"></i><span class="home-title">Trang Chủ</span>
					<?php } else {
						echo $menu->title;
					} ?>
					<?php if (count($this->listMenuChild($menu->id))) {
						echo '<i class="fa fa-caret-down"></i>';
					} ?>
				</a>
				<ul class="sub-menu">
					<?php $this->loopMenuView($this->listMenuChild($menu->id), $menu->name); ?>
				</ul>
			</li>
		<?php }
	}
	public function allListMenu()
	{
		$sql = "SELECT * FROM `" . dbPrefix . "menu` WHERE `menu_parent` < 1 ORDER BY `pos` ASC ;";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_order($table, $by, $type)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` ORDER BY `$by` $type,id DESC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_order_limit($table, $by, $type, $limit)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` ORDER BY `$by` $type LIMIT 0,$limit";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_order($table, $where, $value, $by, $type)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ORDER BY `$by` $type";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_where_order($table, $where, $value, $where2, $value2, $by, $type)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where2` = '$value2' ORDER BY `$by` $type ;";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_where_order_limit($table, $where, $value, $where2, $value2, $by, $type, $limit)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where2` = '$value2' ORDER BY `$by` $type LIMIT 0 ,$limit";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_order_limit($table, $where, $value, $by, $type, $limit)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ORDER BY `$by` $type LIMIT 0,$limit";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_limit($table, $where, $value, $limit)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' LIMIT 0,$limit";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data($table)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` ORDER BY `id` ASC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_new($table)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` ORDER BY `id` DESC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where($table, $where, $value)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ORDER BY `id` ASC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_new($table, $where, $value)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ORDER BY `id` DESC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_new_limit($table, $where, $value, $limit)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ORDER BY `id` DESC LIMIT $limit";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function list_data_where_where($table, $where, $value, $where1, $value1)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where1` = '$value1' ORDER BY `id` ASC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	public function list_data_where_where_new($table, $where, $value, $where1, $value1)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where1` = '$value1' ORDER BY `id` DESC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function alone_data_where($table, $where, $value)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value'";
		$this->setQuery($sql);
		return $this->loadRow(array($table));
	}
	public function alone_data_where_where($table, $where, $value, $where2, $value2)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where2` = '$value2';";
		$this->setQuery($sql);
		return $this->loadRow(array($table));
	}
	public function loadallrows_sql($sql)
	{
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function loadrow_sql($sql)
	{
		$this->setQuery($sql);
		return $this->loadRow(array($sql));
	}
	public function execute_sql($sql)
	{
		$this->setQuery($sql);
		return $this->execute();
	}
	public function insertTable($table)
	{
		$sql = "INSERT INTO `" . dbPrefix . "$table`() VALUES ();";
		$this->setQuery($sql);
		return $this->execute();
	}
	public function insertData($table, $array)
	{
		if (in_array($table, ["data", "menu"])) {
			$array['title'] = 'Đang cập nhật';
			$array['time'] = timeNow();
		}

		$sql = "INSERT INTO `" . dbPrefix . "$table`(";
		foreach ($array as $key => $vl) {
			$sql .= "`$key`,";
		};
		$sql = trim($sql, ",");
		$sql .= ") VALUES (";
		foreach ($array as $key => $vl) {
			$sql .= "'$vl',";
		};
		$sql = trim($sql, ",");
		$sql .= ");";
		$this->setQuery($sql);
		return $this->execute();
	}
	public function insertDataError($table, $array)
	{
		$sql = "INSERT INTO `" . dbPrefix . "$table`(";
		foreach ($array as $key => $vl) {
			$sql .= "`$key`,";
		};
		$sql = trim($sql, ",");
		$sql .= ") VALUES (";
		foreach ($array as $key => $vl) {
			$vl = addslashes($vl);
			$sql .= "'$vl',";
		};
		$sql = trim($sql, ",");
		$sql .= ");";
		return $sql;
	}
	public function randomRows($table, $where, $value, $limit)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ORDER BY RAND() LIMIT $limit;";
		$this->setQuery($sql);
		return $this->loadAllRows();
		/*return $sql;*/
	}
	/*======================================================================================================================*/
	public function save($table, $name, $data, $where, $value)
	{
		$data = addslashes($data);
		$sql = "UPDATE `" . dbPrefix . "$table` SET `$name` = '$data' WHERE `$where` = '$value'";
		$this->setQuery($sql);
		return $this->execute();
	}
	public function updateTable($table, $array, $set, $name)
	{
		$sql = "";
		foreach ($array as $key => $value) {
			$value = addslashes($value);
			$sql .= "UPDATE `" . dbPrefix . "$table` SET `$set` = '$value' WHERE `$name` = '$key' ;";
		}
		$this->setQuery($sql);
		return $this->execute();
	}
	public function updateRow($table, $array, $where, $value)
	{
		if ($table == 'data' && !isset($array['time'])) {
			$array['time'] = timeNow();
		}
		$sql = "UPDATE `" . dbPrefix . "$table` SET ";
		$i = 0;
		foreach ($array as $key => $vl) {
			if ($key !== "id" && $key !== "table" && $key !== "tableData_length" && $key !== "idData"  && !is_array($array[$key])) {
				$vl = addslashes($vl);
				$sql .= "`$key` = '$vl',";
			}
		}
		$sql = trim($sql, ",");
		$sql .= " WHERE `$where` = '$value' ;";
		$this->setQuery($sql);
		return $this->execute();
	}
	public function insertImage($table, $array)
	{
		if (count($array)) {
			$sql = "INSERT INTO `" . dbPrefix . "$table`(";
			$lastItem  = end($array);
			foreach ($array as $key => $value) {
				$sql .= "`$key`";
				if ($value !== $lastItem) $sql .= ', ';
			}
			$sql .= ") VALUES (";
			foreach ($array as $key => $value) {
				$sql .= "'$value'";
				if ($value !== $lastItem) $sql .= ', ';
			}
			$sql .= ");";
			$this->setQuery($sql);
			return $this->execute();
		}
	}
	public function search($table, $s)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `title` LIKE '%$s%';";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function breadcrumb($page, $lang)
	{
		$menuHome = $this->alone_data_where('menu', 'file', 'home');
		$homeT = $this->alone_data_where_where('menu_lang', 'menu_id', $menuHome->id, 'lang', $lang);
		$allListMenuParent = array_reverse($this->allListMenuParent($page->menu));
		?>
		<a <?= linkMenu($menuHome) ?>><?php echo $homeT->title; ?></a> &raquo;
		<?php foreach ($allListMenuParent as $menu) {
			$menuT = $this->alone_data_where_where('menu_lang', 'menu_id', $menu->id, 'lang', $lang);
			if ($menu->menu_parent !== '0') {
				$menuParent = $this->menuParent($menu->id);  ?>
				<a <?= linkIdList($menu, $menuParent->name) ?>><?= $menuT->title ?></a> &raquo;
			<?php } else { ?>
				<a <?= linkMenu($menu) ?>><?= $menuT->title ?></a> &raquo;
		<?php }
		} ?>
		<?php $pageT = $this->alone_data_where_where('data_lang', 'data_id', $page->id, 'lang', $lang); ?>
		<?= $pageT->title ?>
	<?php
	}
	public function breadcrumbMenu($menu, $lang)
	{
		$menuHome = $this->alone_data_where('menu', 'file', 'home');
		$titleH = $this->alone_data_where_where('menu_lang', 'menu_id', $menuHome->id, 'lang', $lang);
		$menuParent = $this->menuParent($menu->id);
		$allListMenuParent = array_reverse($this->allListMenuParent($menu->id));
	?>
		<a <?= linkMenu($menuHome) ?>><?php echo $titleH->title; ?></a> &raquo;
		<?php
		foreach ($allListMenuParent as $key => $menu) {
			$title1 = $this->alone_data_where_where('menu_lang', 'menu_id', $menu->id, 'lang', $lang);
			if ($menu->menu_parent == '0') { ?>
				<a <?= linkMenu($menu) ?>><?= $title1->title ?></a> &raquo;
			<?php } else { ?>

				<a <?= linkIdList($menu, $menuParent->name) ?>><?= $title1->title ?></a> &raquo;
<?php
			}
		}
	}
	public function login($email, $pass)
	{
		$menuThanhVien = $this->alone_data_where('menu', 'file', 'user');
		$sql = "SELECT * FROM `vt_data` WHERE `menu` = '$menuThanhVien->id' AND `email` = '$email' AND `password` = '$pass';";
		$this->setQuery($sql);
		return $this->loadRow(array($sql));
	}
	public function del($table, $where, $value)
	{
		$sql = "DELETE FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' ; ";
		$sql .= " DELETE FROM `" . dbPrefix . "slug` WHERE `idTable` = '$value' AND WHERE `tableName` = '$table' ;";
		$this->setQuery($sql);
		return $this->execute();
	}
	public function avatar($data)
	{
		$child = $this->list_data_where_where('data', 'data_parent', $data->id, 'type', 'slide');
		if ($child) {
			echo 'src="upload/' . $child[0]->img . '" alt="' . $data->title . '"';
		}
	}

	// lang
	public function list_data_where_where_hide($table, $where, $value, $where1, $value1)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where1` = '$value1'";
		$sql .= " ORDER BY `pos` ASC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	public function list_data_where_where_where($table, $where, $value, $where1, $value1, $where2, $value2)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where1` = '$value1' AND `$where2` = '$value2'";
		$sql .= " ORDER BY `id` ASC";
		$this->setQuery($sql);
		return $this->loadAllRows();
	}

	public function alone_data_where_lang($table, $where, $value, $where1, $value1)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "$table` WHERE `$where` = '$value' AND `$where1` = '$value1'";
		$this->setQuery($sql);
		return $this->loadRow(array($table));
	}
	public function listDataLang($id, $limit = '', $lang)
	{
		$sql = "SELECT * FROM `" . dbPrefix . "data` WHERE `menu` = '$id' AND `lang` = '$lang' ORDER BY `pos` ASC, `id` DESC ";
		if (is_numeric($limit)) {
			$sql .= " LIMIT 0," . $limit;
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function listDataArray($array, $start = 0, $limit = '', $order = 'pos', $type = 'asc', $where = '', $value = '', $operaton = '=')
	{
		$arr = explode(',', $array);
		$sql = "SELECT * FROM `" . dbPrefix . "data` WHERE `menu` in($array" . ',';
		foreach ($arr as $id) {
			$listMenuChild = $this->listMenuChild($id);
			foreach ($listMenuChild as $key => $menuChild) {
				$sql .= $menuChild->id . ',';
			}
		}
		$sql = trim($sql, ",");
		$sql .= ")";
		if ($where != '') {
			$sql .= " AND `$where` " . $operaton . " '$value'";
		}
		$sql .= " AND `hide` = '0' ORDER BY `$order` $type";
		if (is_numeric($limit)) {
			$sql .= " LIMIT $start," . $limit;
		}
		$this->setQuery($sql);
		return $this->loadAllRows();
	}
	public function checkUser($email, $username)
	{
		$sql = "SELECT count(*) FROM `" . dbPrefix . "user` WHERE `email`= '$email' OR `username`= '$username'";
		$this->setQuery($sql);
		return $this->loadRow(['user']);
	}
}
$db = new DB();
?>