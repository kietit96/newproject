<?php
$listLang = $db->listMenuChild($menuLang->id);
// $listData = $db->listData($menuPage->id);

?>
<?php include 'head_lang.php' ?>
<form role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="title" value="<?php echo $menuPage->title ?>">
    <div class="col-md-12">
        <?php $listData = $db->list_data('voucher'); ?>
        <a <?= linkAddId($menuPage->id, 'voucher') ?>>
            <i class="fa fa-plus"></i> Thêm bài viết : <?= $page->title ?> (<?= count($listData); ?>)
        </a>
        <table class="table w-100">
            <thead>
                <tr>
                    <th width="10px">#</th>
                    <th><i class="fa fa-info"></i> Tiêu đề(title)</th>
                    <th>Mã giảm giá (code_name)</th>
                    <th>Giá trị(value)</th>
                    <th>Đơn vị giảm(unit)</th>
                    <th>Số lượng (quantity)</th>
                    <th width="100px"><i class="far fa-hand-point-down"></i></th>
                </tr>
            </thead>
            <tbody <?= returnWhere('class="sortAjax"', $configMenu->orderProduct, 1) ?>>
                <?php

                foreach ($listData as $key => $data) {
                ?>
                    <tr align="center" data-id="<?= $data->id ?>">
                        <td><?= $key + 1; ?></td>
                        <td>
                            <input type="text" value="<?= $data->title; ?>" name="listRow[voucher][<?= $data->id ?>][title]" class="form-control" />
                            <p class="hidden"><?= $data->title ?></p>
                        </td>
                        <td>
                            <input type="text" value="<?= $data->code_name; ?>" name="listRow[voucher][<?= $data->id ?>][code_name]" class="form-control" />
                            <p class="hidden"><?= $data->code_name ?></p>
                        </td>
                        <td>
                            <input type="text" value="<?= $data->value; ?>" name="listRow[voucher][<?= $data->id ?>][value]" class="form-control" />
                            <p class="hidden"><?= $data->value ?></p>
                        </td>
                        <td>
                            <select name="listRow[voucher][<?= $data->id ?>][unit]" class="form-control">
                                <?php $listUnit = $db->list_data('unit');
                                foreach ($listUnit as $key => $unit) {
                                ?>
                                    <option <?php echo returnWhere('selected', $unit->type, $data->unit) ?> value="<?php echo $unit->type ?>"><?php echo $unit->title ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" value="<?= $data->quantity; ?>" name="listRow[voucher][<?= $data->id ?>][quantity]" class="form-control" />
                            <p class="hidden"><?= $data->quantity ?></p>
                        </td>
                        <td class="action">
                            <div class="onoffswitch">
                                <input type="hidden" name="listRow[voucher][<?= $data->id ?>][hide]" value="0" />
                                <input type="checkbox" <?= returnWhere('checked', $data->hide, 1) ?> name="listRow[voucher][<?= $data->id ?>][hide]" class="onoffswitch-checkbox" id="switch<?= 'hide' . $data->id ?>" value="1" />
                                <label class="onoffswitch-label" for="switch<?= 'hide' . $data->id ?>"></label>
                                <p class="hidden"><?= $data->hide ?></p>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php if (canEditSlug) : ?>
        <div class="col-md-12">
            <label for="inputKeywords">Đường dẫn: </label>
            <input id="slugId" class="form-control" type="text" name="listSlug[<?= $slugCurrent->id ?>]" value="<?= $slugCurrent->slugName ?>" />
        </div>
    <?php endif; ?>
    <br>

    <?php
    $dataL = $db->alone_data_where_where('menu_lang', 'menu_id', $menuPage->id, 'lang', $lang);
    // var_dump($dataL);
    ?>
    <?php if ($dataL) : ?>
        <div class="col-md-12">
            <label>Tiêu đề: </label>
            <input class="form-control" type="text" name="listRow[menu_lang][<?php echo $dataL->id; ?>][title]" value="<?php echo $dataL->title; ?>">
        </div>
        <div class="col-md-12">
            <label>Giới thiệu: </label>
            <textarea class="tinymce" name="listRow[menu_lang][<?php echo $dataL->id; ?>][content]"><?= $dataL->content ?></textarea>
        </div>
    <?php else : ?>
        <button <?= linkAddLang('menu_lang', 'menu_id', $menuPage->id, $lang) ?>><i class="fa fa-plus"></i> Thêm thông tin</button>
    <?php endif ?>

    <div class="col-md-12">
        <button type="submit" value="info" class="btn btn-success form-control"> <i class="fa fa-save"></i> Lưu (Alt + S)</button>
    </div>
</form>