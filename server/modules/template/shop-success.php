<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once("../../config.php");
include_once("../../modules/sql.php");
$db = new DB();

?>
<h4 class="text-success text-center"> <i class="fa fa-check"></i> Đặt hàng thành công !</h4>
<p><i class="fa fa-info"></i> Tên khách hàng: <?php echo $_POST['title'] ?></p>
<p><i class="fa fa-phone"></i> Số điện thoại: <?php echo $_POST['phone'] ?></p>
<p><i class="fa fa-envelope"></i> Email: <?php echo $_POST['email'] ?></p>
<p><i class="fa fa-map-marker"></i> Địa chỉ: <?php echo $_POST['address'] ?></p>
<p><i class="fa fa-envelope"></i> Tin nhắn: <?php echo $_POST['content'] ?></p>
<p>Quận huyện: <?= $_POST['province']; ?></p>
<p>Xã phường: <?= $_POST['district'] ?></p>
<p>Phương thức thanh toán: <?php echo $_POST['method_cart'] ?></p>
<?php
$voucher = $db->alone_data_where('voucher', 'code_name', $_POST['sale_code']);
?>
<hr>
<span class="text-center"><b>Danh sách đơn hàng</b></span>
<hr>

<table class="table" style="width: 100%">
  <thead>
    <tr>
      <th>Hình</th>
      <th>Tên sản phẩm</th>
      <th>Giá</th>
      <th>Số lượng</th>
      <th>Kích thước</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $listCart = json_decode($_SESSION['cart']);
    foreach ($listCart->list as $cart) {
      $sp = $db->alone_data_where('data', 'id', $cart->id);
      $spTitle = $db->alone_data_where_where('data_lang', 'data_id', $sp->id, 'lang', $lang);
    ?>
      <tr align="center">
        <td>
          <a>
            <img style="height:50px;" <?php echo srcImg($sp); ?> />
          </a>
        </td>
        <td><a><?php echo $spTitle->title ?></a></td>
        <td>
          <?php
          if ($spTitle->sale != '' && $spTitle->sale != 0) {
            echo $spTitle->sale . '<br>';
            echo "<del>" . $spTitle->price . "</del>";
          } else {
            echo $spTitle->price;
          }
          ?>
        </td>
        <td><?php echo $cart->count ?></td>
        <td><?php
            $option = $cart->option;
            ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<h4><b>Tạm tính: <?php echo $_POST['temp_price'] ?></b></h4>
<?php if ($voucher) {
  $unit_voucher = $voucher->unit;
  if ($unit_voucher == 'freeship') {
?>
    <h4>
      Phí ship: <del><?= number_format($_POST['ship']) . ' đ' ?></del>
    </h4>
  <?php } else { ?>
    <h4>
      Phí ship: <?= number_format($_POST['ship']) . ' đ' ?>
    </h4>
  <?php  } ?>
  <h4>
    Voucher: <?= $voucher->code_name ?>
  </h4>
<?php } else { ?>
  <h4>
    Phí ship: <?= number_format($_POST['ship']) . ' đ' ?>
  </h4>
<?php } ?>
<h3><b>Tổng tiền: <?php echo $_POST['price'] ?></b></h3>