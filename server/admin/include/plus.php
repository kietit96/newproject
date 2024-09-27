<center><a href="add.php?table=child&parent=<?php echo $menuPage->id ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm</a></center>
	<ul class="nav nav-tabs">
		<?php foreach($children as $key=>$child){ ?>
	  		<li class="<?=returnWhere("active",$key,0) ?>"><a data-toggle="tab" href="#child<?php echo $child->id ?>"><i class="fa fa-<?php echo $child->logo ?>"></i> <?php echo $child->title ?></a></li>
	  	<?php } ?>
	</ul>

	<div class="tab-content">
		<?php foreach($children as $key=>$child){ ?>
			<div id="child<?php echo $child->id ?>" class="tab-pane fade in <?=returnWhere("active",$key,0) ?>">
				<form id="form<?php echo $child->id?>" action="?name=<?php echo $name?>" method="POST" enctype="multipart/form-data">
					<br/>
					<input type="hidden" name="id" value="<?php echo $child->id?>"/>
					<div class="form-group">
						<center>
						<a href="del.php?table=child&id=<?php echo $child->id?>" class="btn btn-danger confirm"><i class="fa fa-trash"></i> Xóa <i class="fa fa-arrow-right"></i> <?php echo $child->title ?></a>
						</center>
					</div>
					<div class="form-group">
						<label>Tiêu đề:</label>

						<input name="title" class="form-control" value="<?php echo $child->title ?>"/>
					</div>
					<div class="form-group">
						<label>Icon <i class="fa-fa<?php echo $child->logo?>"></i> : (Lấy tên icon tại <a href="https://fortawesome.github.io/Font-Awesome/icons/" target="_blank">đây</a>)</label>
						<input name="icon" class="form-control" value="<?php echo $child->logo ?>"/>
					</div>
					<div class="form-group">
						<label>Hình slide:</label>
						<input type="file" name="slide[]" multiple accept="image/*" /><br>
						<div class="row">
						<?php 
							$listImage = $db->list_data_where_new("data_child","parent",$child->id);
							foreach($listImage as $image){ 
						?>
							<div class="col-md-2 col-md-3 col-xs-4" style="margin:5px;">
								<div class="row">
									<img class="img-responsive" src="../upload/<?php echo $image->img ?>" />
								</div>
								<div class="row">
									<input placeholder="Tiêu đề" class="form-control" type="text" name="slideTitle[<?php echo $image->id?>]" value="<?php echo $image->title?>"/>
								</div>
								<div class="row">
									<center>
										<a href="del.php?table=data_child&id=<?php echo $image->id?>" class="btn btn-danger confirm">	<i class="fa fa-close"></i> Xóa
										</a>
									</center>
								</div>
					    	</div>
			            <?php } ?>
			            </div>
					</div>
					<div class="form-group">
						<label>Nội dung:</label>
						<textarea name="content" class="ckeditor"><?php echo $child->content?></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu</button>
					</div>
				</form>
			</div>	
		<?php } ?>
	</div>

</div>