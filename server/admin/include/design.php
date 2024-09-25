<?php
	$listData = $db->listData($menuPage->id);
?>
 <button class="btn btn-success selectAll" data-target="table > tbody > tr" type="button">
    <i class="fa fa-check-square-o"></i> Chọn tất cả
  </button>
  <button class="btn btn-danger delAll"  data-target="table >tbody > tr.selected" type="button">
    <i class="fa fa-trash"></i> Xóa đã chọn
  </button>
  <br><br>

<div class='panel panel-default grid'>
  <table class='table'>
    <thead>
      <tr>
        <th>#</th>
        <th>Tên khách hàng</th>
        <th>Số điện thoại</th>
        <th>Bản thiết kế</th>
        <th><i class="fa fa-trash"></i></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($listData as $key=>$data) { ?>
      	<tr data-id="<?=$data->id ?>">
	        <td><?=$key+1 ?></td>
	        <td><?=$data->title ?></td>
	        <td><?=$data->phone ?></td>
	        <td><?=$data->content ?></td>
	        <td><a <?=linkDelId($data->id); ?>>
              <i class="fa fa-close"></i> Xóa
            </a>
          </td>
      	</tr>
    <?php } ?>
    </tbody>
  </table>
</div>

<style type="text/css" media="screen">
    .colorwell {
        cursor: pointer;
    }
    body .colorwell-selected {
        border: 2px solid #000;
        font-weight: bold;
    }
    #item1 {
        font-size: 14px;
        font-weight: bold;
        font-family: Arial;
        text-align: center;
        cursor: pointer;
        color: #291670;
    }
    #item2 {
        font-size: 22px;
        font-weight: bold;
        font-family: Times New Roman;
        text-align: center;
        cursor: pointer;
        color: #D92419;
    }
    #item3 {
        font-size: 18px;
        font-weight: bold;
        font-family: Arial;
        text-align: center;
        cursor: pointer;
        color: #00923F;
    }
    .map1 {
        display: none;
    }
    .map2 {
        display: none;
    }
    .map3 {
        display: none;
    }
    .table-border td {
        border: 2px solid #291670;
    }
</style>