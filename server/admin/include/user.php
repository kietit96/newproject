<?php
  $listData = $db->list_data('user');  
?>
<div class="box-header">
  <h3 class="box-title">
    <a <?=linkAddId($menuPage->id,'user')?> >
      <i class="fa fa-plus"></i> Thêm thành viên
    </a>
  </h3>
</div>
<div class="box-body">
  <table class="table">
    <thead>
      <tr>
        <th>Tên</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Xác nhận</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
    <?php
      foreach($listData as $key=>$data){
        if ($data->hide == 1){ continue; }
    ?>
      <tr align="center" data-id="<?=$data->id?>">
        <td><?=$data->title?></td>
        <td><?=$data->email?></td>
        <td><?=$data->phone?></td>
        <td>
          <?php if($data->confirm == 0){ ?>
          <span class="text-danger"><i class="fa fa-close"></i> Chưa xác nhận email</span>
          <?php }else{ ?>
          <span class="text-success"><i class="fa fa-check"></i> Đã xác nhận</span>
          <?php } ?>
        </td>
        <td class="action">
          <a <?=linkUpdateId($data->id,'user'); ?>><i class="fa fa-trash"></i></a>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>