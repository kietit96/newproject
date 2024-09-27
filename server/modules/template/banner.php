<?php if(count($listSlide)){ ?>
<script>
	$(function(){
		$('.bxslider').bxSlider({
		  auto: true,
		});
	});
</script>

<ul class="bxslider">
	<?php foreach($listSlide as $slide){
		if(isset($id)){
			$img = $slide->img;
		}else{
			$img = $slide->content;
		}
		?> 

		<li><img style="width:100%" src="upload/<?php echo $img?>"></li>
	<?php } ?>
</ul>
<?php } ?>