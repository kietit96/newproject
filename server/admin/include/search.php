<?php
include('../modules/search.php');
if(count($listData)){
?>
 <button class="btn btn-success selectAll" data-target="table > tbody > tr" type="button"><i class="fa fa-check-square-o"></i> Chọn tất cả</button>
<button class="btn btn-danger delAll"  data-target="table >tbody > tr.selected" type="button"><i class="fa fa-trash"></i> Xóa đã chọn</button>
<br><br>
<table class="table">
	<thead>
		<tr>
		  <th width="10px">#</th>
		  <th width="100px">Hình ảnh</th>
		  <th>Tiêu đề</th>
		  <th>Mô tả</th>
		  <th>Danh mục</th>
		  <?php if($configMenu->listCheck){ foreach($configMenu->listCheck as $check){ ?>
		  <th><?=$check->title?></th>
		  <?php }} ?>
		  <th>Ngày đăng</th>
		  <th width="100px">Hành động</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($listData as $key=>$data){ 
		$menuParent = $db->menuParent($data->menu);
		if($menuParent && strlen($menuParent->name)){
	?>
	<tr align="center" data-id="<?=$data->id ?>">
		<td><?=$key+1?></td>
		<td>
			<a <?=linkId($data,$menuParent->name); ?> >
				<img style="height:50px;" src="../upload/<?=$data->img ?>" class="img-responsive">
			</a>
		</td>

		<?php if($configMenu->listCheck){ foreach($configMenu->listCheck as $check){$checkName = $check->col; ?>
		<td>
		  <div class="onoffswitch">
		    <input type="hidden" name="listRow[data][<?=$data->id ?>][<?=$checkName?>]" value="0" />
		    <input type="checkbox" <?=returnWhere('checked',$data->$checkName,1) ?> name="listRow[data][<?=$data->id ?>][<?=$checkName?>]" class="onoffswitch-checkbox" id="switch<?=$checkName.$data->id ?>" value="1" />
		    <label class="onoffswitch-label" for="switch<?=$checkName.$data->id ?>"></label>
		    <p class="hidden"><?=$data->$checkName ?></p>
		  </div>
		</td>
		<?php }} ?>
		<td>
			<a <?=linkId($data, $menuParent->name); ?> > <?=$data->title?></a>
		</td>
		<td>
			<a <?=linkId($data, $menuParent->name); ?> > <?=$data->des?></a>
		</td>
		<td>
			<a <?=linkMenu($menuParent); ?> > <?=$menuParent->title?></a>
		</td>
		<td>
			<?=$data->time?>
		</td>
		<td class="action">
		  <a class="btn btn-warning" <?=linkId($data, $menuParent->name); ?> ><i class="fa fa-edit"></i> </a>
		  <a <?=linkDelId($data->id,$menuParent->name); ?>><i class="fa fa-trash"></i></a>
		</td>
	</tr>
	<?php }} ?>
	</tbody>
</table>
<?php include('../modules/template/pagination.php'); } ?>