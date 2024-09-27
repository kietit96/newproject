<?php
$listLang = $db->listMenuChild($menuLang->id);
// $listData = $db->listData($menuPage->id);

?>
<?php include 'head_lang.php' ?>
<form role="form" method="POST" enctype="multipart/form-data">
  <?php if (canEditSlug) : ?>
    <div class="col-md-12">
      <label for="inputKeywords">Đường dẫn: </label>
      <input id="slugId" class="form-control" type="text" name="listSlug[<?= $slugCurrent->id ?>]" value="<?= $slugCurrent->slugName ?>" />
    </div>
  <?php endif; ?>
  <br>

  <?php
  $dataL = $db->alone_data_where_where('menu_lang', 'menu_id', $menuPage->id, 'lang', $lang);
  // var_dump($dataL);
  ?>
  <?php if ($dataL) : ?>
    <?php $listData = $db->list_data_where('contact', 'menu', $menuPage->id); ?>
    <div class='panel panel-default grid'>
      <table class='table'>
        <thead>
          <tr>
            <th>#</th>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ngày gửi</th>
            <th><i class="fa fa-trash"></i></th>
          </tr>
        </thead>
        <tbody align="center">
          <?php foreach ($listData as $key => $data) { ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= htmlentities($data->name) ?></td>
              <td><?= htmlentities($data->phone) ?></td>
              <td><?= htmlentities($data->email) ?></td>
              <td><?= htmlentities($data->time) ?></td>
              <td>
                <a <?= linkDelId($data->id, 'contact') ?>><i class="fa fa-close"></i> Xóa</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="col-md-12">
      <label>Tiêu đề: </label>
      <input class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][title]" value="<?php echo $dataL->title; ?>">
    </div>
    <div class="col-md-12">
      <label>Giới thiệu: </label>
      <textarea class="tinymce" name="listRow[menu_lang][<?php echo $dataL->id; ?>][content]"><?= $dataL->content ?></textarea>
    </div>

  <?php else : ?>
    <button <?= linkAddLang('menu_lang', 'menu_id', $menuPage->id, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>

  <div class="col-md-12">
    <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
  </div>
</form>