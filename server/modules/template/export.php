<?php if(count($listData)){ $listCols = $db->listCols('data'); 
	$listUnset = array('id','menu');
	foreach($listCols as $key=>$col){
		foreach ($listUnset as $un) {
			if($col->Field == $un) unset($listCols[$key]);
		}
	}
?>
<table>
	<tr><?php foreach($listCols as $col){ ?>
	    <th><?=$col->Field?></th>
	    <?php } ?>
	</tr>
	<?php foreach($listData as $data){?>
	<tr><?php foreach($listCols as $col){ $c = $col->Field; ?>
	    <td>
	    	<?php
	    		$content = $data->$c;
		    	if($c == 'img'){
		    		$imgPath = baseUrl.'upload/'.$content;
	    			$type = pathinfo($imgPath, PATHINFO_EXTENSION);
	    			if($type !== ''){
		    			$img = file_get_contents($imgPath);
		    			$content = 'data:image/' . $type . ';base64,' . base64_encode($img);
	    			}
		    	}
	    		echo $content;
	    	?>
	    </td>
	    <?php } ?>
	</tr>
	<?php } ?>
</table>
<?php } ?>