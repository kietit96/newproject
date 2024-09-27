<?php if ($configMenu->showList) { ?>
  <div class="col-md-4">
    <div class="card card-default grid">
      <div class="card-header">
        <span><i class="fa fa-cog"></i> Quản lí danh mục</span>
      </div>
      <div class="card-body">
        <div class="form-horizontal">
          <?php if ($page->menu_parent !== '0') { ?>
            <div class="form-group">
              <label class="control-label col-md-12">Tiêu đề: </label>
              <input type="hidden" name="table" value="menu" />
              <input type="hidden" name="id" value="<?= $idList ?>" />
              <div class="col-md-12">
                <input type="text" value="<?= $page->title ?>" name="title" class="form-control" />
              </div>
            </div>
            <?php if (canEditSlug) : ?>
              <div class="form-group">
                <label class="control-label col-md-12">Đường dẫn: </label>
                <div class="col-md-12">
                  <input id="slugId" class="form-control" type="text" name="listSlug[<?= $slugCurrent->id ?>]" value="<?= $slugCurrent->slugName ?>" />
                </div>
              </div>
            <?php endif; ?>

            <?php
            $dataL = $db->alone_data_where_where('menu_lang', 'menu_id', $page->id, 'lang', $lang);
            ?>
            <?php if ($dataL) : ?>
              <div class="col-md-12">
                <label for="inputDes">Tiêu đề hiển thị: </label>
                <input id="inputDes" class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][title]" value="<?= $dataL->title ?>" />
              </div>
              <div class="col-md-12">
                <label for="inputDes">Mô tả: </label>
                <input id="inputDes" class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][des]" value="<?= $dataL->des ?>" />
              </div>
              <div class="col-md-12">
                <label for="inputKeywords">Keywords: </label>
                <input id="inputKeywords" class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][keywords]" value="<?= $dataL->keywords ?>" />
              </div>
              <?php if ($configMenu->showImage) { ?>
                <div class="form-group">
                  <label for="imgMenu" class="control-label col-md-12">
                    <center>
                      <img class="img-responsive" style="max-height:50px" src="../upload/<?= $dataL->img ?>" />
                    </center>
                  </label>
                  <div class="col-md-12">
                    <label class="btn btn-primary btn-sm" style="width:100%" for="imgMenu"><i class="fa fa-upload"></i> Up hình danh mục</label>
                    <input class="hidden" id="imgMenu" type="file" name="listRowMenu[menu_lang][<?php echo $dataL->id; ?>][img]" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="imgMenu2" class="control-label col-md-12">
                    <center>
                      <img class="img-responsive" style="max-height:50px" src="../upload/<?= $dataL->img_hover ?>" />
                    </center>
                  </label>
                  <div class="col-md-12">
                    <label class="btn btn-primary btn-sm" style="width:100%" for="imgMenu2"><i class="fa fa-upload"></i> Up hình danh mục hover</label>
                    <input class="hidden" id="imgMenu2" type="file" name="listRowMenu2[menu_lang][<?php echo $dataL->id; ?>][img_hover]" class="form-control" />
                  </div>
                </div>
              <?php } ?>
            <?php else : ?>
              <button <?= linkAddLang('menu_lang', 'menu_id', $page->id, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
            <?php endif ?>

          <?php } else {
            $listData = $db->allListDataChild($idList, 0, '', 'pos', 'ASC');
          } ?>
          <div class="col-md-12">
            <a <?= linkAddMenu($menuPage->id, $name); ?>>
              <i class="fa fa-plus"></i> Thêm danh mục con
            </a>
            <ul class="tree">
              <li class="root">
                <ul class="tree sortAjax">
                  <?php
                  if ($configMenu->multiMenu) {
                    if (!isset($idList)) $idList = $menuPage->id;
                    $db->loopMenuMulti($name, $idList);
                  } else {
                    $db->loopMenu($db->listMenuChild($menuPage->id), $name, $idList);
                  }
                  ?>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="col-md-<?= $colList ?>">
  <div class="box">
    <!-- <?php var_dump($listMenuChild); ?> -->
    <?php if (($configMenu->showList == '1' && $idList !== $menuPage->id) || ($configMenu->showList !== '1') && ($configMenu->onlyContent !== '1')) { ?>
      <?php if ($menuPage->file == 'voucher') {
        $listData = $db->list_data_order('voucher', 'pos', 'asc');
      } ?>
      <div class="box-header">
        <h3 class="box-title">
          <?php if (!count($listMenuChild)) { ?>
            <?php if ($menuPage->file == 'voucher') { ?>
              <a <?= linkAddId($idList, 'voucher') ?>>
                <i class="fa fa-plus"></i> Thêm: <?= $page->title ?> (<?= count($listData); ?>)
              </a>
            <?php } else { ?>
              <a <?= linkAddId($idList) ?>>
                <i class="fa fa-plus"></i> Thêm bài viết : <?= $page->title ?> (<?= count($listData); ?>)
              </a>
            <?php } ?>
            <!-- <div class="pull-right">
              <label for="file-upload" class="custom-file-upload btn btn-primary btn-sm">
                  <i class="fa fa-upload"></i> Up dữ liệu (*.xls)
              </label>
              <input class="hidden" id="file-upload" name='importFile' accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" type="file"/>
              <button data-target=".tableData<?= $idList ?> >tbody > tr.selected" type="button" data-menu="<?= $idList ?>" class="exportAll btn btn-primary btn-sm">
                <i class="fa fa-download"></i> Xuất dữ liệu (*.xls)
              </button>
            </div> -->
          <?php } ?>

          <?php if (count($listData)) { ?>
            <button class="btn btn-warning btn-sm selectAll" data-target=".tableData<?= $idList ?> > tbody > tr" type="button"><i class="fa fa-check-square-o"></i> Chọn tất cả</button>
            <button class="btn btn-danger btn-sm delAll" data-target=".tableData<?= $idList ?> >tbody > tr.selected" type="button"><i class="fa fa-trash"></i> Xóa <i class="fa-fw fa fa-check-square-o"></i></button>
          <?php } ?>
        </h3>
      </div>
    <?php } ?>
    <?php if (count($listData)) { ?>
      <div class="box-body">
        <table <?= returnWhere('id="tableData" ', $configMenu->orderProduct, 0) ?> class="table tableData<?= $idList ?>">
          <thead>
            <tr>
              <th width="10px">#</th>
              <th width="100px"><i class="fa fa-picture-o"></i></th>
              <th><i class="fa fa-info"></i> Tiêu đề</th>
              <?php if ($configMenu->listCheck) {
                foreach ($configMenu->listCheck as $check) { ?>
                  <th><?= $check->title ?></th>
              <?php }
              } ?>
              <th><i class="fa fa-list"></i></th>
              <th width="100px"><i class="fa fa-hand-pointer-o"></i></th>
            </tr>
          </thead>
          <tbody <?= returnWhere(' class="sortAjax"', $configMenu->orderProduct, 1) ?>>
            <?php
            foreach ($listData as $key => $data) {
              $menuParent = $db->alone_data_where('menu', 'id', $data->menu);
            ?>
              <tr align="center" data-id="<?= $data->id ?>">
                <td><?= $key + 1; ?></td>
                <td><a <?= linkId($data, $name); ?>><img style="height:50px;" src="../upload/<?= $data->img ?>" class="img-responsive"></a></td>
                <td>
                  <input type="text" value="<?= $data->title; ?>" name="listRow[data][<?= $data->id ?>][title]" class="form-control" />
                  <p class="hidden"><?= $data->title ?></p>
                </td>
                <?php if ($configMenu->listCheck) {
                  foreach ($configMenu->listCheck as $check) {
                    $checkName = $check->col; ?>
                    <td>
                      <div class="onoffswitch">
                        <input type="hidden" name="listRow[data][<?= $data->id ?>][<?= $checkName ?>]" value="0" />
                        <input type="checkbox" <?= returnWhere('checked', $data->$checkName, 1) ?> name="listRow[data][<?= $data->id ?>][<?= $checkName ?>]" class="onoffswitch-checkbox" id="switch<?= $checkName . $data->id ?>" value="1" />
                        <label class="onoffswitch-label" for="switch<?= $checkName . $data->id ?>"></label>
                        <p class="hidden"><?= $data->$checkName ?></p>
                      </div>
                    </td>
                <?php }
                } ?>
                <td><a <?= linkIdList($menuParent, $name); ?>><?= $menuParent->title ?></a></td>
                <td class="action">
                  <a <?= linkId($data, $name); ?> class="btn btn-warning"><i class="fa fa-edit"></i></a>
                  <a <?= linkDelId($data->id); ?>><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>

  </div>
</div>