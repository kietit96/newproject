<?php
$listProvince = $db->list_data('province');
?>
<?php $listDistrict = $db->list_data_where('district', 'province', $_GET['id']); ?>
<?php if (isset($_GET['id']) && $_GET['id'] != '') : ?>
	<form role="form" method="POST" class="form-horizontal shipAjax" enctype="multipart/form-data">
		<input type="hidden" name="table" value="district" />
		<input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
		<div class="">
			<div class="box-body">
				<table class="table tableData">
					<thead>
						<tr>
							<th width="10px">#</th>
							<th>Quận/Huyện</th>
							<th>Phí ship</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($listDistrict as $key => $district) {
						?>
							<tr align="center" data-id="<?= $district->id ?>">
								<td><?= $key + 1; ?></td>
								<td>
									<input type="text" readonly value="<?= $district->name; ?>" name="listRow[district][<?= $district->id ?>][name]" class="form-control" />
									<p class="hidden"><?= $district->name ?></p>
								</td>
								<td>
									<input type="text" value="<?= $district->ship; ?>" name="listRow[district][<?= $district->id ?>][ship]" class="form-control" />
									<p class="hidden"><?= $district->ship ?></p>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				<br />
				<button type="submit" class="btn btn-success form-control">
					<i class="fa fa-save"></i> Lưu (Alt + S)
				</button>
			</div>
		</div>
	</form>
<?php else : ?>
	<form role="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<div class="">
			<div class="box-body">
				<table class="table tableData">
					<thead>
						<tr>
							<th width="10px">#</th>
							<th>Tỉnh/thành</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($listProvince as $key => $province) {
						?>
							<tr align="center" data-id="<?= $province->id ?>">
								<td><?= $key + 1; ?></td>
								<td>
									<input type="text" readonly value="<?= $province->name; ?>" name="listRow[province][<?= $province->id ?>][name]" class="form-control" />
									<p class="hidden"><?= $province->name ?></p>
								</td>
								<td>
									<a href="<?php echo pageUrlRemoveParams(); ?>?id=<?= $province->id ?>">Xem quận/huyện</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				<br />
				<button type="submit" class="btn btn-success form-control">
					<i class="fa fa-save"></i> Lưu (Alt + S)
				</button>
			</div>
		</div>
	</form>
<?php endif ?>