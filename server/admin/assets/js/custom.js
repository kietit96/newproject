function goToTop() {
    $('html,body').animate({
        scrollTop: $("html").offset().top
    }, 300);
}

function pageUrl() {
    return document.URL;
}

function delImgInfo(imgId, inputId, name) {
    $(imgId).remove();
    $(inputId).attr({
        type: 'text',
        name: name
    });
    $(inputId).removeAttr('accept');
}

function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 3;
    var flyerClone = $(flyer).clone();
    // $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 999999});
    $('body').append($(flyerClone));
    // var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    // var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;

    $(flyerClone).animate({
        opacity: 0.4,
        // left: gotoX,
        // top: gotoY,
        width: $(flyer).width() / divider,
        height: $(flyer).height() / divider
    }, 700,
        function () {
            $(flyingTo).fadeOut('fast', function () {
                $(flyingTo).fadeIn('fast', function () {
                    $(flyerClone).fadeOut('fast', function () {
                        $(flyerClone).remove();
                    });
                });
            });
        });
}
function voucher() {
    $.ajax({
        type: 'GET',
        url: $('base').data('url') + 'modules/api.php?do=getVoucher&content=' + $('#sale_code_input').val(),
        success: function (res) {
            res = jQuery.parseJSON(res);
            NProgress.done();
            if (res.error == 0) {
                alert(res.text);
            }
            window.location.reload();
        }
    });
}
function changeTotal(value, id) {
    var total = 0;
    $.each($('.dataCart'), function (index, value) {
        var price = $(this).find('.price').text().replace(/[^\d.]/g, '');
        var count = $(this).find('.count').val().replace(/[^\d.]/g, '');
        price = parseInt(price) || 0;
        count = parseInt(count) || 0;
        total += (price * count);
    });
    $("#total").text('Tổng: ' + total + 'k');
}

function checkForm(element) {
    var isValid = true;
    $(element + ' ' + '[type="text"]').each(function () {
        if ($(this).val() === '')
            isValid = false;
    });
    return isValid;
}

function addCart(id, thisE, totalData = 1) {
    var cartCookie = readCookie('cart');
    var listCart = [];
    if (cartCookie) {
        listCart = cartCookie.split(',');
    }
    for (var i = 0; i < totalData; i++) {
        listCart.push(id);
    }
    createCookie('cart', listCart);

    var itemImg = $(thisE);
    flyToElement($(itemImg), $('#totalCart'));
    $('#totalCart').text(listCart.length);
}

function clearCart(id) {
    if ($.isNumeric(id)) {
        var cartCookie = readCookie('cart');
        var listCart = cartCookie.split(',');
        for (var i = listCart.length; i--;) {
            if (listCart[i] == id) listCart.splice(i, 1);
        }
        $('#data' + id).remove();
        if (listCart.length == 0) {
            getAjax(document.URL);
        }
        createCookie('cart', listCart);
    } else {
        createCookie('cart', '');
        getAjax(document.URL);
    }
}

function createCookie(name, value) {
    var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
    if (name == 'cart') {
        $('#totalCart').text(value.length);
    }
}

function getParam(name, url) {
    if (!url) url = document.URL;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function activeMenu(name) {
    var active = $('.navAjax').data('active');
    var e = $('.navAjax').data('e');
    $('.navAjax ' + e).removeClass(active);
    $('.navAjax ' + e + '[data-name="' + name + '"]').addClass(active);
}

function hrefPost() {
    const queryString = window.location.search; // lấy nguyên cái link url
    const urlParams = new URLSearchParams(queryString); // tách url chính - parameter
    const lang = urlParams.get('lang')
    var href = window.location.origin + window.location.pathname;
    if (window.location.search.length > 0) {
        if (!getParam('ajax', document.URL)) {
            if (lang == null) {
                href += '' + window.location.search + '&ajax=';
            } else {
                href += '?lang=' + lang + "&" + window.location.search + '&ajax=';
            }
        }
    } else {
        href += '?ajax=';
    }
    return href;
}

function removeURLParameter(url, parameter) {
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {
        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);
        for (var i = pars.length; i-- > 0;) {
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }
        url = urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}

function getAjax(href, his = false) {
    var eSidebar = '#sidenav-overlay';
    if ($(eSidebar).length > 0) {
        $(".button-collapse").click();
    }
    $.ajax({
        'url': href,
        'data': { ajax: '' },
        cache: false,
    }).done(function (data) {
        if ($('.navbar-collapse').length && $('.navbar-collapse').hasClass('in')) {
            $('.navbar-collapse').collapse('toggle');
        }
        var infoPage = $($.parseHTML(data)).filter("#infoPage");
        if ($(infoPage).data() !== undefined) {
            $.each($(infoPage).data(), function (index, value) {
                $('meta[name=' + index + ']').attr('content', $(infoPage).data(index));
                $('meta[property="og:' + index + '"]').attr('content', $(infoPage).data(index));
            });
            if ($(infoPage).data('url') !== undefined) {
                var url = removeURLParameter($(infoPage).data('url'), 'ajax');
                $('link[rel=canonical]').attr('href', url);
            }
        }

        var title = $(infoPage).data('title');
        var name = $(infoPage).data('name');
        document.title = title;
        activeMenu(name);
        goToTop();
        $('.contentAjax').html(data);
        reloadScript();
        if (his) {
            // window.history.pushState("", "", href);
        }
    });
}
$(document).ready(function () {
    // window.location.reload('1');
    // window.history.pushState("", "", document.URL);

    // $('body').on('click','a[data-name]',function(e){
    //     e.preventDefault();
    //     var href = $(this).attr('href');
    //     getAjax(href,true);
    // });

    // $('body').on('click','a[data-toggle="tab"]',function(e){
    //     window.history.pushState("", "", document.URL);
    // });

    $('body').on('change', 'select[name=province]', function (e) {
        $.ajax({
            type: "GET",
            url: $('base').data('url') + 'modules/api.php?do=getListDistrict&province=' + $(this).find('option:selected').data('id'),
            success: function (res) {
                $('select[name=district]').html(res);
                if ($('base').attr('href') == $('base').data('url') && $('.formSearch.searchAjax').length) {
                    $('.formSearch.searchAjax').submit();
                }
            }
        });
    });

    $(window).on('popstate', function (e) {
        var state = e.originalEvent.state;
        if (state !== null) {
            getAjax(pageUrl());
        }
    });

    $('body').on('submit', '.searchAjax', function (e) {
        e.preventDefault();
        const queryString = window.location.search; // lấy nguyên cái link url
        const urlParams = new URLSearchParams(queryString); // tách url chính - parameter
        const lang = urlParams.get('lang')
        var value = $(this).serialize()
        var href = $('base').attr('href') + 'tim-kiem?' + value
        if (lang != null) {
            href = $('base').attr('href') + 'tim-kiem?lang=' + lang + "&" + value
        }
        window.location.href = href
        getAjax(href)
    })
    $('body').on('submit', '.ajaxApi', function (e) {
        e.preventDefault();
        var action = $(this).attr('action');
        var button = $(this).find('[type=submit]')
        button.prop('disabled', true);
        button.prepend('<i class="fas fa-spinner fa-spin"></i>');

        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: $('base').data('url') + '/modules/api.php?do=' + action,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('[type=submit]').find('i').attr('class', 'fa fa-spin fa-spinner');
            },
        }).done(function (data) {
            data = $.parseJSON(data);
            NProgress.done();
            $('[type=submit]').find('i').attr('class', 'fa fa-send');
            $('[type=submit]').removeAttr("disabled");
            switch (action) {
                case 'addItem':
                    if (data.error == 0) {
                        var total = $("#totalCart").text();
                        $("#totalCart").html(parseInt(total) + parseInt(data.count));
                        flyToElement($("#itemVT"), $('#totalCart'));

                        var href = $('base').attr('href') + 'gio-hang';
                        window.location.replace(href);
                    }
                    break;
            }
            if (data.text.length) {
                alert(data.text);
                // window.location.reload();
            }
        });
    });
    $('body').on('submit', '.contactAjax', function (e) {
        e.preventDefault();
        var action = $(this).attr('action');
        var buttonsubmit = $(this).find('[type=submit]')
        buttonsubmit.prop('disabled', true);
        buttonsubmit.prepend('<i class="fas fa-spinner fa-spin"></i>');
        switch (action) {
            case 'post':
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                break;
            case 'cart':
                $.each($(this).find('.cookie'), function () {
                    var nameCookie = 'user_' + $(this).attr('name');
                    var value = $(this).val();
                    createCookie(nameCookie, value);
                });
                break;
            case 'design':
                var eContent = $('[data-content]').data('content');
                var content = $(eContent).html();
                $('[name=content]').val(content);
                break;
        }
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: $('base').attr('href') + '/modules/action.php?do=' + action,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('[type=submit]').find('i').attr('class', 'fa fa-spin fa-spinner');
            },
        }).done(function (data) {
            data = $.parseJSON(data);
            NProgress.done();
            $('[type=submit]').find('i').attr('class', 'fa fa-send');
            $('[type=submit]').removeAttr("disabled");
            switch (action) {
                case 'login':
                    if (data.error == 0) {
                        window.location.reload();
                    }
                    break;
                case 'post':
                    if (data.error == 0) {
                        $('.contactAjax[action=post]').find("input[type=text], textarea").val("");
                    }
                    break;
                case 'cart':
                    if (data.error == 0) {
                        // $.ajax({
                        //     url:$('base').attr('href')+'views/include/shop-success.php',
                        //     type: 'POST',
                        //     data: formData,
                        // }).done(function( data ) {
                        //     goToTop();
                        //     $('#resultCart').html(data);
                        // });
                        $.each($(this).find('.cookie'), function () {
                            var nameCookie = 'user_' + $(this).attr('name');
                            var value = $(this).val();
                            createCookie(nameCookie, value);
                        });
                        clearCart();
                        var href = $('base').attr('href') + 'gio-hang';
                        window.location.replace(href);
                    }
                    break;
                case 'contact':
                    if (data.error == 0) {
                        $('.contactAjax').trigger("reset");
                    }
                    if ($('#recaptcha_reload').length) {
                        $('#recaptcha_reload').click();
                    }
            }
            if (data.text.length) {
                alert(data.text);
            }
        });
    });
    NProgress.start();
    var activeF = $('.navAjax');
    if (activeF.length) {
        var aF = $('html').data('load');
        $('.navAjax ' + $(activeF).data('e') + '[data-name=' + aF + ']').addClass($(activeF).data('active'));
    }
    reloadScript();
});
$(document).ajaxComplete(function () {
    reloadScript();
    if ($('.fb-comments').length > 0) {
        $(".fb-comments").attr('data-href', document.URL)
        FB.XFBML.parse();
    }
});
$(document).ajaxSend(function () {
    NProgress.start();
});

function reloadScript() {
    NProgress.done();
    try {
        new WOW().init()
    } catch (e) {
        /*console.log(e);*/
    }
    if ($('#infoPage').data('file') == 'home') {
        $(".slideAjax").show();
    } else {
        $(".slideAjax").hide();
    }
}

function logout() {
    if (confirm('Bạn thật sự muốn thoát ?')) {
        document.cookie = 'email=; path=/; expires=' + new Date(0).toUTCString();
        document.cookie = 'password=; path=/; expires=' + new Date(0).toUTCString();
        window.location.reload();
    }
}

function getSelect(name, id) {
    var gets = $(id + ' option:selected').map(function () {
        return this.value;
    }).get().join(',');
    $('input[name="' + name + '"]').attr('value', gets);
}