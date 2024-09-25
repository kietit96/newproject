function sitemap(e) {
    $.ajax({
        'url': '../modules/sitemap.php'
    }).done(function (data) {
        console.log('Sitemap updated!');
    });
}

function viewPage() {
    var href = document.URL.replace('admin/', '');
    window.open(href);
}

function readIMG(input, inputName) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + inputName).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);

    }
}

function activeTab() {
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });
    var hash = window.location.hash;
    $('.nav-tabs a[href="' + hash + '"]').tab('show');
}

function sortTable() {
    $(".sortAjax").sortable({
        /*axis: 'y',*/
        update: function (event, ui) {
            var list = $(this).children();
            var e = $(list).first();
            if ($(e).attr('data-idList')) {
                type = 'idList';
            } else if ($(e).attr('data-id')) {
                type = 'id';
            } else if ($(e).attr('data-img')) {
                type = 'img';
            } else if ($(e).attr('data-tab')) {
                type = "tab";
            } else {
                type = 'name';
            }
            var data = [];
            $(list).each(function (index) {
                data[index] = $(this).attr('data-' + type);
            });
            $.ajax({
                data: { data: data, type: type },
                type: 'POST',
                datatype: 'json',
                url: '../modules/action.php?do=sort',
                success: function (msg) {
                    msg = JSON.parse(msg);
                    $.get(hrefPost(), function (data) {
                        $('.contentAjax').html(data);
                    });
                }
            });
        }
    });
}

function dataTable() {
    $('#tableData').DataTable({
        destroy: true,
        "language": {
            "sProcessing": "Đang xử lý...",
            "sLengthMenu": "Xem _MENU_ mục",
            "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
            "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
            "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
            "sInfoFiltered": "(được lọc từ _MAX_ mục)",
            "sInfoPostFix": "",
            "sSearch": "Tìm:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Đầu",
                "sPrevious": "Trước",
                "sNext": "Tiếp",
                "sLast": "Cuối"
            }
        }
    });
}
$(function () {
    $('body').on('click', '.table:not(.notSl) tr', function (e) {
        $(this).toggleClass('selected');
    });
    $("input[type=file]").change(function () {
        readIMG(this);
    });
    $('body').on('click', '.selectAll', function (e) {
        var list = $(this).data('target');
        $(this).toggleClass('checkAll');

        if ($(this).hasClass('checkAll')) {
            $(list).addClass('selected');
        } else {
            $(list).removeClass('selected');
        }
    });
    $('body').on('click', '.exportAll', function (e) {
        var list = $(this).data('target');
        var data = [];
        $.each($(list), function (index, value) {
            data[index] = $(value).data('id');
        });
        $.ajax({
            data: { data: data },
            type: 'POST',
            datatype: 'json',
            url: '../modules/action.php?do=export&menu=' + $(this).data('menu'),
            success: function (msg) {
                var html = $.parseHTML(msg);
                $(html).table2excel({
                    exclude: ".noExl",
                    filename: "Dữ liệu của danh mục " + $('#infoPage').data('title'),
                });
            }
        });
    });
    $('body').on('click', '.delAll', function (e) {
        var list = $(this).data('target');
        var table = $(this).data('table');
        if (table == undefined || table == '' || table.length < 1) {
            table = 'data';
        }
        if ($(list).length == 0) {
            alert('Vui lòng chọn sản phẩm !');
        } else {
            if (!confirm('Del ' + $(list).length + ' data ?')) {
                e.preventDefault();
            } else {
                var data = [];
                $.each($(list), function (index, value) {
                    data[index] = $(value).data('id');
                });
                $.ajax({
                    data: { data: data, table: table },
                    type: 'POST',
                    datatype: 'json',
                    url: '../modules/action.php?do=delAll',
                    success: function (msg) {
                        $.get(hrefPost(), function (data, status) {
                            $('.contentAjax').html(data);
                        });
                    }
                });
            }
        }
    });
    shortcut.add("alt+s", function () {
        tinyMCE.triggerSave();
        $(".contentAjax form").submit();
    });
    $.each($('[shortcut]'), function (index, value) {
        var sc = $(this).attr('shortcut');
        shortcut.add(sc, function () {
            $('[shortcut="' + sc + '"]').click();
        });
    });
    $('body').on('click', '.btnAjax', function (e) {
        e.preventDefault();
        if ($(this).hasClass('confirm') && confirm('Are you sure?') || !$(this).hasClass('confirm')) {
            var action = $(this).data('action');
            switch (action) {
                case 'del':
                    $('a[data-action=del]').attr('disabled', true);
                    break;
            }
            $.ajax({
                type: "POST",
                url: hrefPost(),
                data: $(this).data(),
                success: function (data) {
                    $('.contentAjax').html(data);
                    $('.success').fadeOut('slow');
                    sitemap();
                }
            });
        }
    });
    $('body').on('click', '.bootstrap-tagsinput .tag', function (e) {
        var href = $('base').attr('href') + 'tim-kiem.html?tag=' + $(this).text();
        window.history.pushState("", "", href);
        getAjax(href);
    });
    $('body').on('submit', 'form', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('searchAjax')) {
            const thisForm = $(this);
            // for ( instance in CKEDITOR.instances ) {
            //     CKEDITOR.instances[instance].updateElement();
            // }
            if ($('.codeEditor').length) {
                $('.codeEditor').each(function () {
                    var id = $(this).attr("id");
                    var editor = ace.edit(id);
                    var val = editor.getSession().getValue();
                    var val = val.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
                        return '&#' + i.charCodeAt(0) + ';';
                    });
                    $("input[for=" + id + "]").val(val);
                    /*console.log(val);*/
                })
            }
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                contentType: false,
                processData: false,
                url: hrefPost(),
                data: formData,
                success: function (data) {
                    const result = String(data);
                    const parser = new DOMParser();
                    // convert html string into DOM
                    const dom = parser.parseFromString(result, "text/html");
                    const queryString = window.location.search; // lấy nguyên cái link url
                    let val = ""
                    if (dom.getElementById("slugId")) {
                        val = dom.getElementById("slugId").value
                    }
                    let slug = $("#infoPage").data("slug")
                    if (slug != val && val != "") {
                        slug = val
                    }
                    if (queryString != "") {
                        slug = slug + queryString
                    }
                    if (thisForm.hasClass('shipAjax')) {
                        window.location.reload();
                    } else {
                        $('.contentAjax').html(data);
                        window.history.pushState("", "", slug);
                        $('.success').fadeOut('slow');
                    }
                    sitemap();
                }
            });
        }
    });
    loadFunction();

})

$(document).ajaxComplete(function () {

    loadFunction();
    // for(k in CKEDITOR.instances){
    //     var instance = CKEDITOR.instances[k];
    //     instance.destroy()
    // }
    // CKEDITOR.replaceAll();
});

function loadFunction() {
    sortTable();
    dataTable();
    activeTab();

    if ($(".codeEditor").length) {
        $(".codeEditor").each(function () {
            var editor = ace.edit($(this).attr("id"));
            editor.setTheme("ace/theme/monokai");
            editor.getSession().setMode("ace/mode/php");
        });
    }
}

function acceptPost(id) {
    $.ajax({
        type: "GET",
        contentType: false,
        processData: false,
        url: '../modules/action.php?do=acceptPost&id=' + id,
        success: function (data) {
            getAjax(document.URL);
        }
    });
}