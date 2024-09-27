<?php include 'head_lang.php' ?>
<?php
$listCart = $db->list_data_where_order('cart', 'menu', $menuPage->id, 'id', 'desc');
if (count($listCart)) {
?>
  <?php if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $cartData = $db->alone_data_where('cart', 'id', $id);
    $sessionCart = json_decode(base64_decode($cartData->session));
    $sale_code = $cartData->sale_code;
    $voucher = $db->alone_data_where('voucher', 'code_name', $sale_code);

    // echo "<pre>";
    // var_dump($sessionCart);
    // echo "</pre>";
  ?>
    <h3><b>Khách hàng: <?= htmlspecialchars($cartData->title) ?></b></h3>
    <p><i class="fa fa-phone"></i> Số điện thoại: <?= htmlspecialchars($cartData->phone) ?></p>
    <p><i class="fa fa-envelope"></i> Email: <?= htmlspecialchars($cartData->email) ?></p>
    <p><i class="fa fa-map-marker"></i> Địa chỉ: <?= htmlspecialchars($cartData->address) ?></p>
    <p><i class="fa fa-envelope"></i> Tin nhắn: <?= htmlspecialchars($cartData->content) ?></p>
    <p><i class="fa fa-clock"></i> Thời gian: <?= htmlspecialchars($cartData->time) ?></p>
    <p>Quận huyện: <?= htmlspecialchars($cartData->province) ?></p>
    <p>Xã phường: <?= htmlspecialchars($cartData->district) ?></p>
    <p>Phương thức thanh toán: <?php echo $cartData->method_cart ?></p>
    <table class="table">
      <thead>
        <tr>
          <th>Hình</th>
          <th>Tên sản phẩm</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Kích cỡ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($sessionCart->list as $key => $data) {
          $sp = $db->alone_data_where('data', 'id', $data->id);
          $spT = $db->alone_data_where_where("data_lang", 'data_id', $sp->id, "lang", $lang);
          $menuParent = $db->menuParent($sp->menu);
        ?>
          <tr align="center">
            <td>
              <a <?= linkId($sp, $menuParent->name); ?>>
                <img style="height:50px;" <?= srcImg($sp); ?> />
              </a>
            </td>
            <td><a <?= linkId($sp, $menuParent->name); ?>><?= $spT->title ?></a></td>
            <td><?php if ($spT->sale != '') {
                  echo number_format($spT->sale) . ' đ';
                } else {
                  echo number_format($spT->price) . ' đ';
                } ?></td>
            <td><?= ($data->count) ?></td>
            <td>
              <?php
              $option = $data->option;?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <h4>Tạm tính <?= number_format($cartData->temp_price) . ' đ' ?></h4>
    <?php if ($voucher) {
      $unit_voucher = $voucher->unit;
      if ($unit_voucher == 'freeship') {
    ?>
        <h4>
          Phí ship: <del><?= number_format($cartData->ship) . ' đ' ?></del>
        </h4>
      <?php } else { ?>
        <h4>
          Phí ship: <?= number_format($cartData->ship) . ' đ' ?>
        </h4>
      <?php  } ?>
      <h4>
        Voucher: <?= $voucher->title ?>
      </h4>
    <?php } else { ?>
      <h4>
        Phí ship: <?= number_format($cartData->ship) . ' đ' ?>
      </h4>
    <?php } ?>
    <h3><b>Tổng tiền: <?= number_format($cartData->price) ?></b></h3>
  <?php } else { ?>
    <div class="box-header">
      <h3 class="box-title">
        <button class="btn btn-success selectAll" data-target="table > tbody > tr" type="button"><i class="fa fa-check-square-o"></i> Chọn tất cả</button>
        <button class="btn btn-danger delAll" data-target="table >tbody > tr.selected" type="button"><i class="fa fa-trash"></i> Xóa đã chọn</button>
      </h3>
    </div>
    <div class="box-body">
      <table class="table">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Tin nhắn</th>
            <th>Tổng đơn hàng</th>
            <th>Thời gian</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($listCart as $key => $cart) {
            $total = 0;
          ?>
            <tr align="center" data-id="<?= $cart->id ?>">
              <td><?= htmlspecialchars($cart->title) ?></td>
              <td><?= htmlspecialchars($cart->phone) ?></td>
              <td><?= htmlspecialchars($cart->email) ?></td>
              <td><?= htmlspecialchars($cart->address) ?></td>
              <td><?= htmlspecialchars($cart->content) ?></td>
              <td><?= htmlspecialchars(number_format($cart->price) . ' đ') ?></td>
              <td><?= htmlspecialchars($cart->time) ?></td>
              <td class="action">
                <a href="<?= pageUrlRemoveParams() . '?id=' . $cart->id ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                <a <?= linkDelId($cart->id, 'cart'); ?>><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  <?php }
} else { ?>
  <div class="col-md-12">
    <h2>Chưa có <?php echo $dataL->title; ?></h2>
  </div>
<?php } ?>
<form role="form" method="POST" enctype="multipart/form-data">
  <?php
  $lang = isset($_GET['lang']) ? $_GET['lang'] : "en"; //default VN
  $dataL = $db->alone_data_where_where('menu_lang', 'menu_id', $menuPage->id, 'lang', $lang);
  // var_dump($dataL);
  ?>
  <?php if ($dataL) : ?>

    <?php if (canEditSlug) : ?>
      <div class="col-md-12">
        <label for="inputKeywords">Đường dẫn: </label>
        <input id="slugId" class="form-control" type="text" name="listSlug[<?= $slugCurrent->id ?>]" value="<?= $slugCurrent->slugName ?>" />
      </div>
    <?php endif; ?>
    <div class="col-md-12">
      <label>Tiêu đề: </label>
      <input class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][title]" value="<?php echo $dataL->title; ?>">
    </div>
    <br />
    <div class="col-md-12">
      <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
  <?php else : ?>
    <button <?= linkAddLang('menu_lang', 'menu_id', $menuPage->id, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
  <?php endif ?>
</form>