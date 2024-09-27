<?php
function listLang($listLang = array('vn', 'en'))
{
    foreach ($listLang as $lang) {
        $hrefLang = str_replace('/' . lang . '/', '', baseUrl);
        if (lang !== 'vn') $hrefLang .= '/';
        if ($lang !== 'vn') $hrefLang .= $lang . '/';
?>
        <a href="<?= $hrefLang ?>">
            <img src="admin/assets/images/<?= $lang ?>.png">
        </a>
    <?php
    }
}

function delFileCol($data, $col)
{
    if (isset($data->$col) && $data->$col !== '' && file_exists('../upload/' . $data->$col)) {
        delImg($data->$col);
    }
}
function delImg($file)
{
    $ar = array('', 'thumb-');
    foreach ($ar as $vl) {
        if ($file !== '') {
            $path = '../upload/' . $vl . $file;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
function delFile($data)
{
    if ($data) {
        $listUnlink = array('img', 'thumbnail', 'file', 'link');
        foreach ($listUnlink as $file) {
            if (isset($data->$file) && $data->$file !== '') {
                delImg($data->$file);
            }
        }
    }
}
function isKanji($str)
{
    return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
}

function isHiragana($str)
{
    return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
}

function isKatakana($str)
{
    return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
}

function isJapanese($str)
{
    return isKanji($str) || isHiragana($str) || isKatakana($str);
}
function renameTitle($string)
{
    if (!isJapanese($string)) {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            '/[^a-zA-Z0-9\-\_]/',
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
    }
    return $string;
}
function renameSlug($string)
{
    if (!isJapanese($string)) {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            '/\s/',
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = trim($string);
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = trim($string, "/");
    }
    return $string;
}
function renameTitle2($string)
{
    if (!isJapanese($string)) {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(đ|Đ)#',
            '/[^a-zA-Z0-9\-\_]/',
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
    }
    return $string;
}
function returnArray($string)
{
    $string = preg_replace('/\s+/', '', $string);
    if (strpos($string, ';') !== false) {
        $arString = array_filter(explode(';', $string));
        return $arString;
    } else {
        $string = array($string);
        return $string;
    }
}
function returnWhere($string, $data, $where)
{
    if ($data == $where) {
        return $string;
    }
}
function returnWhereArray($active, $dataActive, $array)
{
    $myArray = explode(',', $array);
    if (in_array($dataActive, $myArray)) {
        return $active;
    }
}
function returnNotWhere($string, $data, $where)
{
    if ($data !== $where) {
        return $string;
    }
}
function timeNow()
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $now = date('d/m/Y H:i:s');
    return $now;
}
function renameLink($title, $id)
{
    return renameTitle($title) . '-' . $id . '.html';
}
function renameLink2($title, $id)
{
    return renameTitle($title);
}
function renameLinkParent($title, $id)
{
    return renameTitle($title) . '-' . $id . '.html';
}
function pageUrl($clearAjax = true)
{
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = preg_replace('~(\?|&)ajax=[^&]*~', '$1', $url);
    return $url;
}
function pageUrlRemoveParams($clearAjax = true)
{
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = preg_replace('~(\?|&)ajax=[^&]*~', '$1', $url);
    $url = strtok($url, '?');
    $url = strtok($url, '&');
    return $url;
}
function convertLinkYoutube($url)
{
    if (strpos($url, 'https://www.youtube.com/embed/') !== FALSE) {
        $rt = $url;
    } else if (strpos($url, 'https://www.youtube.com/watch?v=') !== FALSE) {
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        $rt = 'https://www.youtube.com/embed/' . $query['v'];
    }
    return $rt;
}
function returnIcon($file)
{
    switch ($file) {
        case 'content':
            $icon = 'edit';
            break;
        case 'config':
            $icon = 'cog';
            break;
        case 'shop':
            $icon = 'shopping-cart';
            break;
        case 'picture':
            $icon = 'image';
            break;
        case 'video':
            $icon = 'video';
            break;
        case 'service':
            $icon = 'list';
            break;
        case 'customer':
            $icon = 'users';
            break;
        case 'backlink':
            $icon = 'link';
            break;
        case 'mod':
            $icon = 'user-secret';
            break;
        case 'home':
            $icon = 'tachometer-alt';
            break;
        case 'lang':
            $icon = 'language';
            break;
        case 'info':
            $icon = 'info';
            break;
        case 'user':
            $icon = 'user';
            break;
        case 'map':
            $icon = 'map-marker';
            break;
        case 'support':
            $icon = 'user';
            break;
        case 'download':
            $icon = 'download';
            break;
        case 'search':
            $icon = 'search';
            break;
        case 'post':
            $icon = 'upload';
            break;
        case 'design':
            $icon = 'paint-brush';
            break;
        case 'news':
            $icon = 'newspaper';
            break;
        case 'contact':
            $icon = 'phone';
            break;
        case 'product':
            $icon = 'list-alt';
            break;
        default:
            $icon = 'file-alt';
            break;
    }
    return 'fa fa-' . $icon;
}
function checkObject($object, $key, $value)
{
    foreach ($object as $data) {
        if ($value == $data->$key) {
            return true;
        }
    }
}
function listMenuChild($listMenuChild, $table, $col)
{
    foreach ($listMenuChild as $menuChild) {
        $listMenuChildChild = $db->list_data_where($table, $col, $menuChild->id);
        if (count($listMenuChildChild)) {
            array_push($listMenuChild, $listMenuChildChild);
        }
    }
}
/*===================================*/
function linkAdd($table, $parent = '', $id = '')
{
    $link = 'data-action="add" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-title="Đang cập nhật" ';
    if ($parent !== '' && $id !== '') {
        $link .= 'data-' . $parent . '="' . $id . '" ';
    }
    $link .= 'class="btn btn-primary btn-sm btnAjax" ';
    $link .= 'type="button" ';
    return $link;
}
function linkAddLang($table, $parent = '', $name = '', $lang)
{
    $link = 'data-action="add" ';
    $link .= 'data-title="Đang cập nhật" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-' . $parent . '="' . $name . '" ';
    $link .= 'data-lang="' . $lang . '" ';
    $link .= 'class="btn btn-primary btn-sm btnAjax" ';
    $link .= 'type="button" ';
    return $link;
}
function linkAddInfo($table, $parent = '', $name = '', $lang)
{
    $link = 'data-action="add" ';
    $link .= 'data-content="Đang cập nhật" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-' . $parent . '="' . $name . '" ';
    $link .= 'data-lang="' . $lang . '" ';
    $link .= 'class="btn btn-primary btn-sm btnAjax" ';
    $link .= 'type="button" ';
    return $link;
}
function linkAddMenu($id)
{
    $link = 'data-action="add" ';
    $link .= 'data-table="menu" ';
    $link .= 'data-menu_parent="' . $id . '" ';
    $link .= 'class="btn btn-primary btn-sm btnAjax" ';
    $link .= 'type="button" ';
    return $link;
}
function linkAddId($id, $table = 'data')
{
    $link = 'data-action="add" ';
    $link .= 'data-table="' . $table . '" ';
    if ($table !== 'user') {
        $link .= 'data-menu="' . $id . '" ';
    }
    $link .= 'class="btn btn-primary btn-sm btnAjax" ';
    $link .= 'type="button" ';
    return $link;
}
function linkAddIdData($id)
{
    $link = 'data-action="add" ';
    $link .= 'data-table="data" ';
    $link .= 'data-data_parent="' . $id . '" ';
    $link .= 'class="btn btn-primary btn-sm btnAjax" ';
    $link .= 'type="button" ';
    return $link;
}
/*===================================*/
function linkDelMenu($id)
{
    $link = 'data-action="del" ';
    $link .= 'data-table="menu" ';
    $link .= 'data-value="' . $id . '" ';
    $link .= 'class="btn btn-danger btnAjax confirm" ';
    $link .= 'type="button" ';
    return $link;
}
function linkDelId($id, $table = 'data')
{
    $link = 'data-action="del" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-value="' . $id . '" ';
    $link .= 'class="btn btn-danger btnAjax confirm" ';
    $link .= 'type="button" ';
    return $link;
}
function linkDel($table, $id)
{
    $link = 'data-action="del" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-value="' . $id . '" ';
    $link .= 'class="btn btn-danger btnAjax confirm" ';
    $link .= 'type="button" ';
    return $link;
}
function checkShowFile($name)
{
    $rt = true;
    $listFile = ['home', 'config'];
    foreach ($listFile as $file) {
        if ($name == $file) {
            $rt = false;
        }
    }
    return $rt;
}
function angleDown($listData)
{
    $rt = '';
    if (count($listData)) {
        $rt = '<i class="fa fa-angle-down"></i>';
    }
    return $rt;
}
function angleRight($listData)
{
    $rt = '';
    if (count($listData)) {
        $rt = '<i class="fa fa-angle-right"></i>';
    }
    return $rt;
}
function srcImg($data, $method = '', $resize = '')
{
    if ($method == 'thumb' && $data->img !== '') {
        $data->img = 'thumb-' . $data->img;
    }
    if ($data->title == '') {
        $data->title = $data->img;
    }
    if (isset($data->img) && ($data->img !== '')) {
        $img = baseUrl . 'upload/' . $data->img;
    } else {
        $img = baseUrl . 'admin/assets/images/404.png';
    }

    $resizeImage = '';
    if (is_array($resize)) {
        $resizeImage = '?';
        foreach ($resize as $key => $value) {
            if (strlen($value) >= 1) {
                $resizeImage .= $key . '=' . $value;
                if ($key != count($resize) - 1) {
                    $resizeImage .= '&';
                }
            }
        }
    }

    return 'src="' . $img . $resizeImage . '" alt="' . $data->title . '" title="' . $data->title . '" ';
}
function checkLength($text, $data = 'Liên hệ')
{
    if ($text == '' || $text == '0') {
        echo $data;
    } else {
        $text = number_format($text, 0, ",", ".");
        echo $text;
    }
}
function formatDateTime($date, $type = "date")
{
    $result = explode(" ", $date);
    if ($type != "date") {
        $result = $result[1];
    } else {
        $result = $result[0];
    }
    return $result;
}
function formatPhoneNumber($phoneNumber)
{
    $number = $phoneNumber;
    $number = preg_replace('/[^0-9]/', '', $number);
    if (strlen($number) < 10) {
        $number = "Vui lòng nhập số dt";
    } else if (strlen($number) == 11) {
        $areaCode = substr($number, 0, 3);
        $last = substr($number, -8, 8);

        $number = $areaCode . ' ' . $last;
    } else if (strlen($number) == 10) {
        $areaCode = substr($number, 0, 3);
        $nextThree = substr($number, 3, 3);
        $lastFour = substr($number, 6, 4);

        $number = $areaCode . ' ' . $nextThree . ' ' . $lastFour;
    } else {
        $number = $phoneNumber;
    }

    return $number;
}

//get vouchervalue
function getVoucherValue($totalprice, $discount)
{
    $result = 0;
    if (!is_null($discount)) {
        switch ($discount->unit_voucher) {
            case 'giamgia':
                $result = $discount->value_voucher;
                break;
            case 'phantram':
                $result = ($totalprice * ($discount->value_voucher)) / 100;
                break;
            case 'freeship':
                $result = 'Miễn ship';
                break;
            default:
                $result = 'something wrong';
                break;
        }
    }
    return $result;
}
//get totalprice
function getTotalPrice($totalprice, $discount)
{
    $result = 0;
    if (!is_null($discount)) {
        switch ($discount->unit_voucher) {
            case 'giamgia':
                $result = $totalprice - $discount->value_voucher;
                break;
            case 'phantram':
                $result = ($totalprice * (100 - $discount->value_voucher)) / 100;
                break;
            case 'freeship':
                $result = $totalprice;
                break;
            default:
                $result = 'something wrong';
                break;
        }
    } else {
        $result = $totalprice;
    }
    return $result;
}
function mySubstr($str, $limit = 160)
{
    if (strlen($str) <= $limit) return $str;
    return mb_substr($str, 0, $limit - 3, 'UTF-8') . '...';
}
function showCookie($name)
{
    if (isset($_COOKIE['user_' . $name])) echo $_COOKIE['user_' . $name];
}
function showCookieUser($user, $check, $name)
{
    if ($check) {
        if (isset($user->$name) && strlen($user->$name)) {
            $rt = $user->$name;
        } else {
            $rt = showCookie($name);
        }
    } else {
        $rt = showCookie($name);
    }
    return $rt;
}
function checkCookieUser($user, $email, $password)
{
    if (isset($user) && $user && $user->email == $email && $user->password == $password) {
        return true;
    } else {
        return false;
    }
}
function linkSearch($menu, $q)
{
    $link = 'href="' . $menu->name . '.html?' . $q . '" ';
    $link .= 'data-name="' . $menu->name . '" ';
    $link .= 'data-title="' . $menu->title . '" ';
    $link .= 'data-q="' . $q . '" ';
    return $link;
}
function watermark($SourceFile, $WatermarkFile, $SaveToFile = NULL)
{
    $watermark = @imagecreatefrompng($WatermarkFile)
        or exit('Cannot open the watermark file.');
    imageAlphaBlending($watermark, false);
    imageSaveAlpha($watermark, true);
    $image_string = @file_get_contents($SourceFile)
        or exit('Cannot open image file.');
    $image = @imagecreatefromstring($image_string)
        or exit('Not a valid image format.');
    $imageWidth = imageSX($image);
    $imageHeight = imageSY($image);
    $watermarkWidth = imageSX($watermark);
    $watermarkHeight = imageSY($watermark);
    $coordinate_X = ($imageWidth - 5) - ($watermarkWidth);
    $coordinate_Y = ($imageHeight - 5) - ($watermarkHeight);
    imagecopy(
        $image,
        $watermark,
        $coordinate_X,
        $coordinate_Y,
        0,
        0,
        $watermarkWidth,
        $watermarkHeight
    );
    if (!($SaveToFile)) header('Content-Type: image/jpeg');
    imagejpeg($image, $SaveToFile, 100);
    imagedestroy($image);
    imagedestroy($watermark);
    if (!($SaveToFile)) exit;
}
function srcLogo($infoPage, $logo = 'logo', $resize = '')
{
    //$resize = array('witdh'=>, 'height'=>, 'zc' => 0)
    $resizeImage = '';
    if (is_array($resize)) {
        $resizeImage = '?';
        foreach ($resize as $key => $value) {
            if (strlen($value) >= 1) {
                $resizeImage .= $key . '=' . $value;
                if ($key != count($resize) - 1) {
                    $resizeImage .= '&';
                }
            }
        }
    }
    echo "src='upload/" . $infoPage->$logo . "$resizeImage' title='" . $infoPage->title . "' alt='" . $infoPage->title . "'";
}
function convertToObject($array)
{
    $object = new stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = convertToObject($value);
        }
        $object->$key = $value;
    }
    return $object;
}
function showCaptcha()
{
    require_once('recaptchalib.php');
    echo recaptcha_get_html('6LdyfQsUAAAAAJADYUcOwnfJbdZpJlZ-BsgA7Zj4');
}
function showComment()
{
    ?>
    <div class="fb-comments" data-href="<?= pageUrl(); ?>" data-width="100%" data-numposts="5"></div>
<?php
}
function rmkdir($path)
{
    $path = explode('/', $path);
    $rebuild = '';
    foreach ($path as $p) {
        $rebuild .= "$p/";
        if (!is_dir($rebuild) && (!strpos($rebuild, 'html'))) mkdir($rebuild, 0777, true);
    }
}
function clearCache()
{
    $files = glob('../cache/*');
    foreach ($files as $file) {
        if (is_file($file))
            unlink($file);
    }
    clearstatcache();
}
function resizeImage($sourceFile, $destFile, $width = 1024, $height = 768)
{
    $proportional = true;
    $output = 'file';
    copy($sourceFile, $destFile);
    $file = $destFile;
    if ($height <= 0 && $width <= 0) return false;
    $info = getimagesize($file);
    $image = '';
    list($width_old, $height_old) = $info;
    $final_width = 0;
    $final_height = 0;
    $dims = resizeBoundary($width_old, $height_old, $width, $height);
    $final_height = $dims['height'];
    $final_width = $dims['width'];
    switch ($info[2]) {
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($file);
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($file);
            break;
        default:
            return false;
    }
    $image_resized = imagecreatetruecolor($final_width, $final_height);
    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $transparency = imagecolortransparent($image);
        $trnprt_indx = ImageColorTransparent($image);
        if ($transparency >= 0) {
            $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
            $transparent_color = imagecolorsforindex($image, $trnprt_indx);
            $transparency = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
            imagefill($image_resized, 0, 0, $transparency);
            imagecolortransparent($image_resized, $transparency);
        } elseif ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
        }
    }
    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
    $output = $file;
    switch ($info[2]) {
        case IMAGETYPE_GIF:
            imagegif($image_resized, $output);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($image_resized, $output);
            break;
        case IMAGETYPE_PNG:
            imagepng($image_resized, $output);
            break;
        default:
            return false;
    }
    return true;
}

function resizeBoundary($oldW, $oldH, $newW = '', $newH = '')
{
    if (!($oldW > 0 && $oldH > 0))
        return;
    $tempW = ($oldW * $newH) / ($oldH);
    $tempH = ($oldH * $newW) / ($oldW);
    if ($newW == "" && $newH != "") {
        if ($newH > $oldH) {
            $dims = resizeBoundary($oldW, $oldH, '', $oldH);
            $finalH = $dims['height'];
            $finalW = $dims['width'];
        } else {
            $finalH = $newH;
            $finalW = $tempW;
        }
    } else if ($newW != "" && $newH == "") {
        if ($newW > $oldW) {
            $dims = resizeBoundary($oldW, $oldH, $oldW, '');
            $finalH = $dims['height'];
            $finalW = $dims['width'];
        } else {
            $finalH = $tempH;
            $finalW = $newW;
        }
    } else if ($newW != "" && $newH != "") {
        if ($tempW > $newW) {
            if ($newW > $oldW) {
                $dims = resizeBoundary($oldW, $oldH, $oldW, '');
                $finalH = $dims['height'];
                $finalW = $dims['width'];
            } else {
                $finalH = $tempH;
                $finalW = $newW;
            }
        } else {
            if ($newH > $oldH) {
                $dims = resizeBoundary($oldW, $oldH, '', $oldH);
                $finalH = $dims['height'];
                $finalW = $dims['width'];
            } else {
                $finalH = $newH;
                $finalW = $tempW;
            }
        }
    }
    $dims['height'] = $finalH;
    $dims['width'] = $finalW;
    return $dims;
}
function uploadFile($fileName, $tmpFile, $type = 'image')
{
    $rt = array('success' => false);
    if (strpos($fileName, '.php')) return $rt;
    if ($fileName !== '') {
        $timeNow = '-' . renameTitle(timeNow());
        $path_parts = pathinfo($fileName);
        $fileName = $path_parts['filename'] . '_' . $timeNow . '.' . $path_parts['extension'];
        $vlFile = explode('.', $fileName);
        if (count($vlFile) > 1) {
            if (($type !== '') && (strpos($type, 'image') !== false)) {
                if (move_uploaded_file($tmpFile, '../upload/' . $fileName)) {
                    $rt['success'] = true;
                    $rt['img'] = $fileName;
                }
            } else {
                if (move_uploaded_file($tmpFile, '../upload/' . $fileName)) {
                    $rt['success'] = true;
                    $rt['img'] = $fileName;
                }
            }
        }
    }
    return $rt;
}
function encrypt($string, $key = 5)
{
    $result = '';
    for ($i = 0, $k = strlen($string); $i < $k; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}
function decrypt($string, $key = 5)
{
    $result = '';
    $string = base64_decode($string);
    for ($i = 0, $k = strlen($string); $i < $k; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }
    return $result;
}
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'năm',
        'm' => 'tháng',
        'w' => 'tuần',
        'd' => 'ngày',
        'h' => 'giờ',
        'i' => 'phút',
        's' => 'giây',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' trước' : 'ngay bây giờ';
}
function generateToken($length = 32)
{
    return bin2hex(random_bytes($length / 2));
}

/*===================================*/
function linkUpdateMenu($id)
{
    $link = 'data-action="update" ';
    $link .= 'data-table="menu" ';
    $link .= 'data-value="' . $id . '" ';
    $link .= 'class="btn btn-danger btnAjax confirm" ';
    $link .= 'type="button" ';
    return $link;
}
function linkUpdateId($id, $table = 'data')
{
    $link = 'data-action="update" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-value="' . $id . '" ';
    $link .= 'class="btn btn-danger btnAjax confirm" ';
    $link .= 'type="button" ';
    return $link;
}
function linkUpdate($table, $id)
{
    $link = 'data-action="update" ';
    $link .= 'data-table="' . $table . '" ';
    $link .= 'data-value="' . $id . '" ';
    $link .= 'class="btn btn-danger btnAjax confirm" ';
    $link .= 'type="button" ';
    return $link;
}
?>