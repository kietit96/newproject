<?php if (!file_exists($idFile)) { ?>
    <?php
    $dataL = $db->alone_data_where_where('data_lang', 'data_id', $page->id, 'lang', $lang);
    ?>
    <?php if ($dataL) { ?>
        <div class="col-md-6">
            <input type="hidden" name="table" value="data" />
            <input type="hidden" name="id" value="<?= $id ?>" />
            <div class="form-group">
                <label class="control-label col-md-3">Tiêu đề</label>
                <div class="col-md-12">
                    <input class="form-control" value="<?= $page->title ?>" name="title" />
                </div>
            </div>
            <?php if (canEditSlug) : ?>
                <div class="form-group">
                    <label class="control-label col-md-3">Đường dẫn</label>
                    <div class="col-md-12">
                        <input id="slugId" class="form-control" type="text" name="listSlug[<?= $slugCurrent->id ?>]" value="<?= $slugCurrent->slugName ?>" />
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($configMenu->listCheck as $check) {
                $dataCol = $check->col; ?>
                <div class="form-group">
                    <label class="control-label col-md-3" for="switch<?= $check->col ?>"><?= $check->title ?>:</label>
                    <div class="col-md-12">
                        <div class="onoffswitch">
                            <input type="hidden" name="<?= $check->col ?>" value="0" />
                            <input type="checkbox" <?= returnWhere('checked', $page->$dataCol, 1) ?> name="<?= $check->col ?>" class="onoffswitch-checkbox" id="switch<?= $check->col ?>" value="1" />
                            <label class="onoffswitch-label" for="switch<?= $check->col ?>"></label>
                            <p class="hidden"><?= $page->$dataCol ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-md-12">Tiêu đề hiển thị: </label>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="listRow[data_lang][<?php echo $dataL->id; ?>][title]" value="<?php echo $dataL->title; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Keywords: </label>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="listRow[data_lang][<?php echo $dataL->id; ?>][keywords]" data-role="tagsinput" value="<?php echo $dataL->keywords; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Mô tả: </label>
                <div class="col-md-12">
                    <input class="form-control" type="text" name="listRow[data_lang][<?php echo $dataL->id; ?>][des]" value="<?php echo $dataL->des; ?>">
                </div>
            </div>
            <?php foreach ($configMenu->listF as $data) {
                $dataCol = $data->col; ?>
                <div class="form-group">
                    <?php switch ($data->type) {
                        case 'content':
                    ?>
                            <label class="control-label col-md-3"><?= $data->title ?></label>
                            <div class="col-md-12">
                                <textarea class="tinymce" name="listRow[data_lang][<?php echo $dataL->id; ?>][<?= $dataCol ?>]"><?= $dataL->$dataCol ?></textarea>
                            </div>
                        <?php
                            break;
                        case 'file':
                        ?>
                            <label class="control-label col-md-3"><?= $data->title ?></label>
                            <div class="col-md-12">
                                <input name="listRow[data_lang][<?php echo $dataL->id; ?>][<?= $dataCol ?>]" type="file">
                                <a target="_blank" href="../upload/<?= $dataL->$dataCol ?>"><?= $dataL->$dataCol ?></a>
                            </div>
                        <?php
                            break;
                        default:
                        ?>
                            <label class="control-label col-md-3"><?= $data->title ?></label>
                            <div class="col-md-12">
                                <input class="form-control <?= $data->type ?>" value="<?= $dataL->$dataCol ?>" name="listRow[data_lang][<?php echo $dataL->id; ?>][<?= $dataCol ?>]" />
                            </div>
                    <?php
                            break;
                    } ?>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <label class="btn btn-primary" style="width:100%;" for="fileImg">
                    <i class="fa fa-upload"></i> Ảnh đại diện web(Rộng:<?= $configMenu->maxWidth ?>px Cao:<?= $configMenu->maxHeight ?>px)
                </label>
                <hr>
                <img height="100" onclick="$('#input<?= $id ?>').click();" id="image<?= $id ?>" src="../upload/<?= $page->img ?>">
                <input class="hidden" id="fileImg" accept="image/*" name="img" type="file" id="input<?= $id ?>" onchange="readIMG(this,'<?= 'image' . $id ?>');">
            </div>
            <hr>
        </div>
        <div class="col-md-12">
            <?php $listSlide = $db->list_data_where_where_order('data', 'data_parent', $id, 'type', 'slide', "pos", "asc"); ?>
            <input id="fileListSlide" class="hidden" type="file" name="slideData[]" multiple="" accept="image/*" />
            <label class="btn btn-primary" for="fileListSlide"><i class="fa fa-upload"></i> Up hình slide : </label>
            <button class="btn btn-success selectAll" data-target="#tableSlide > tbody > tr" type="button"><i class="fa fa-check-square-o"></i> Chọn tất cả</button>
            <button class="btn btn-danger delAll" data-target="#tableSlide >tbody > tr.selected" type="button"><i class="fa fa-trash"></i> Xóa đã chọn</button>
            <div class="box">
                <div class="box-body">
                    <table id="tableSlide" class="table slide">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th width="100px"><i class="fa fa-picture-o"></i> Hình</th>
                                <th>Tiêu đề</th>
                                <th width="100px"><i class="fa fa-trash"></i> Xóa</th>
                            </tr>
                        </thead>
                        <tbody class="sortAjax">
                            <?php
                            foreach ($listSlide as $key => $data) {
                            ?>
                                <tr align="center" data-name="data" data-id="<?= $data->id ?>">
                                    <td><?= $key + 1; ?></td>
                                    <td><img style="height:50px;" src="../upload/<?= $data->img ?>" class="img-responsive"></td>
                                    <td><input class="form-control" type="text" name="listRow[data][<?= $data->id ?>][title]" value="<?= $data->title ?>" /></td>
                                    <td class="action">
                                        <a <?= linkDelId($data->id); ?>><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <button <?= linkAddLang('data_lang', 'data_id', $id, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
<?php }
} else {
    include($idFile);
} ?>