<div class="form-group">
        <label class="control-label col-md-3">Mô tả</label>
        <div class="col-md-12">
          <input class="form-control" value="<?=$page->des?>" name="des"/>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">Keywords</label>
        <div class="col-md-12">
          <input class="form-control" value="<?=$page->keywords?>" data-role="tagsinput" name="keywords"/>
        </div>
      </div>
      <?php if($menuPage->file == 'product'): 
       $filter = $db->alone_data_where('menu','file','filter');
              if(($filter)):?>
        <div class="form-group">
          <label class="control-label col-md-3"><?= $filter->title ?></label>
          <div class="col-md-12">
            <select class="form-control filtersBox" multiple onchange="getSelect('filter','.filtersBox')">
              <?php 
              $listMenuFilter = $db->listMenuChild($filter->id);
              foreach($listMenuFilter as $menuFilter){?>
              <optgroup label="<?= $menuFilter->title ?>">
              <?php 
              $listDataFilter = $db->listData($menuFilter->id); 
              foreach($listDataFilter as $data){?>
              <option <?=returnWhereArray('selected',$data->id,$page->filter);?> value="<?=$data->id?>"><?=$data->title?></option>
              <?php } ?>
               </optgroup>
              <?php } ?>
            </select>
          </div>
        </div>
        <input type="hidden" name="filter" value="<?= $page->filter ?>">
        <script type="text/javascript">
            $(document).ready(function() {
                $('.filtersBox').multiselect();
                $('.multiselect').click(function (e) { 
                  e.preventDefault();
                  $('.multiselect-container').toggle(200);
                });
            });
        </script>
              <?php   
              endif; 
            endif;?>

      <?php foreach($configMenu->listF as $data){ $dataCol = $data->col; ?>
      <div class="form-group">
          <?php switch ($data->type) {
            case 'content':
              ?>
              <label class="control-label col-md-3"><?=$data->title?></label>
              <div class="col-md-12">
                <textarea class="tinymce" name="<?=$dataCol?>"><?=$page->$dataCol ?></textarea>
              </div>
              <?php
              break;
            case 'file':
              ?>
              <label class="control-label col-md-3"><?=$data->title?></label>
              <div class="col-md-12">
                <input name="<?=$dataCol?>" type="file" >
                <a target="_blank" href="../upload/<?=$page->$dataCol?>"><?=$page->$dataCol?></a>
              </div>
              <?php
              break;
            default:
              ?>
              <label class="control-label col-md-3"><?=$data->title?></label>
              <div class="col-md-12">
                <input class="form-control <?=$data->type?>" value="<?=$page->$dataCol?>" name="<?=$dataCol?>" />
              </div>
              <?php
              break;
          }?>
      </div>
      <?php } ?>
      
      <?php foreach($configMenu->listCheck as $check){ $dataCol = $check->col;?> 
      <div class="form-group">
        <label class="control-label col-md-3" for="switch<?=$check->col?>"><?=$check->title?>:</label>
        <div class="col-md-12">
          <div class="onoffswitch">
            <input type="hidden" name="<?=$check->col?>" value="0" />
            <input type="checkbox" <?=returnWhere('checked',$page->$dataCol,1) ?> name="<?=$check->col?>" class="onoffswitch-checkbox" id="switch<?=$check->col?>" value="1" />
            <label class="onoffswitch-label" for="switch<?=$check->col?>"></label>
            <p class="hidden"><?=$page->$dataCol?></p>
          </div>
        </div>
      </div>
      <?php } ?>