<?php
include_once('../config.php');
include_once('sql.php');
$db     = new DB();
$result = array(
    'error' => 1
);
if (isset($_GET['do'])) {
    $do        = $_GET['do'];
    $post      = array();
    $checkAdmin = false;

    $listPage = $db->list_data('page');
    $infoPage = new stdClass();
    foreach ($listPage as $vl) {
        $key = $vl->name;
        if (strlen($key)) {
            $infoPage->$key = $vl->content;
        }
    }

    if (isset($_COOKIE['password']) && isset($_COOKIE['user'])) {
        $user = $db->alone_data_where_where('user', 'email', $_COOKIE['user'], 'password', md5($_COOKIE['password']));
        if ($user) {
            $checkAdmin = true;
        } else {
            unset($user);
        }
    }
    $listPass = array('post', 'contact', 'register', 'login', 'forgotpassword', 'cart', 'filter', 'order', 'forgetPassword', 'changeInfo', 'changeEmail', 'changePassword', 'logout', 'updateCart', 'thanhtoan');
    if (in_array($do, $listPass)) $checkAdmin = true;
    if ($checkAdmin) {
        switch ($do) {
            case 'thanhtoan':
                $menuShop = $db->alone_data_where("menu", "file", "shop");
                if ($menuShop) {
                    foreach ($_POST as $key => $data) {
                        if ($data !== '' && !is_array($data)) {
                            $post[$key] = $data;
                        }
                    }
                    if (count($post) > 3 && count($_POST['cart'])) {
                        $post['time'] = timeNow();
                        $post["menu"] = $menuShop->id;
                        if ($post['payment'] == '1') { //Thanh toan = vnpay
                            include 'vnpay/config.php';
                            // include 'vnpay/vnpay_create_payment.php';
                        }
                        if ($db->insertData('data', $post)) {
                            $dataParent = $db->getLastId();
                            $postChild = array();
                            foreach ($_POST["cart"] as $id => $cartData) {
                                $postChild["cart"] = $id;
                                $postChild["data_parent"] = $dataParent;
                                $postChild["count"] = $_POST["count"][$id];
                                if ($db->insertData('data', $postChild)) {
                                    $result['sku'] = 'CELL' . $dataParent;
                                    setcookie('sku', 'CELL' . $dataParent, time() + (86400 * 30), "/");
                                    $result['text'] = 'Cám ơn quý khách đã đặt hàng ! Chúng tôi sẽ liên hệ lại sớm nhất !';
                                    $result['error'] = 0;
                                    if ($post['payment'] == '1') {
                                        unset($result['text']);
                                        $result['error'] = '2';
                                    }
                                } else {
                                    var_dump($db->insertDataError('data', $postChild));
                                }
                            }
                        } else {
                            var_dump($db->insertDataError('data', $post));
                            $result['text'] = 'Action.php Error 111 !';
                        }
                    } else {
                        $result['text'] = 'Quý khách vui lòng điền đầy đủ thông tin !';
                    }
                } else {
                    $result['text'] = 'Chưa cấu hình Giỏ hàng !';
                }
                break;
            case 'updateCart':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $data = $db->alone_data_where('data', 'id', $id);
                    $arP['f2'] = '4';
                    if ($db->updateRow('data', $arP, 'id', $id)) {
                        $result['error'] = 0;
                    }
                }
                break;
            case 'logout':
                if (isset($_COOKIE["Uemail"]) && isset($_COOKIE['Upassword'])) {
                    setcookie('Uemail', '', -1, '/');
                    setcookie('Upassword', '', -1, '/');
                    header("Location: " . baseUrl);
                }
                die();
                break;
            case 'order':
                if ($_POST) {
                    $id = $_POST['id'];
                    $filter = $_POST['filter'];

                    $listData = $db->allListDataChild($id);
                    if (count($listData)) {
                        foreach ($listData as $key => $data) {
                            $dataTitle = $db->alone_data_where_where('data_lang', 'data_id', $data->id, 'lang', $lang);
                            if ($dataTitle->price > $filter) {
                                continue;
                            }
                            include('../views/include/product-box.php');
                        }
                    }
                    die();
                }
                break;
            case 'filter':
                $id = $_POST['id'];
                $filter = $_POST['filter'];
                $fil = $_POST['id'] . ',' . $_POST['filter'];

                $listData = $db->allListDataChild($id, 0, null, 'id', 'DESC', 'filter', '%' . $filter . '%', 'LIKE');
                foreach ($listData as $key => $data) {
                    $dataTitle = $db->alone_data_where_where('data_lang', 'data_id', $data->id, 'lang', $lang);
                    include('../views/include/product-box.php');
                }
                die();
                break;
            case 'forgotpassword':
                try {
                    if (isset($_COOKIE['forgotemail'])) {
                        $emailValue = $_COOKIE['forgotemail'];
                        $email = $db->alone_data_where("user", "email", $_COOKIE['forgotemail']);
                        $code = md5(time() . '12323232');
                        $updateCode = $db->updateRow("user", ["code" => $code], "id", $email->id);
                        if ($email && $updateCode) {
                            //send Mail confirm
                            ob_start();
                            require('template/forgotPassword.php');
                            $content = ob_get_clean();
                            require 'phpmailer/class.phpmailer.php';
                            require 'phpmailer/PHPMailerAutoload.php';

                            $mail            = new PHPMailer;
                            $mail->CharSet   = 'UTF-8';
                            $mail->SMTPDebug = false; // Enable verbose debug output
                            $mail->isSMTP(); // Set mailer to use SMTP
                            $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                            $mail->SMTPAuth   = true; // Enable SMTP authentication
                            $mail->Username   = 'viettech.customer@gmail.com'; // SMTP username
                            $mail->Password   = 'zkyyxatxvuncdtzw'; // SMTP password
                            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                            $mail->Port       = 587;
                            $mail->From       = ' viettech.customer@gmail.com';
                            $mail->FromName   = 'Xác nhận từ trang ' . baseUrl; //Title 
                            $mail->addAddress($emailValue, $emailValue);
                            $mail->isHTML(true);

                            $mail->Subject = 'Thay đổi mật khẩu cá nhân';
                            $mail->Body = $content;

                            $mail->send();
                        }
                    }
                } catch (Exception $e) {
                    $result['text'] = $e->getMessage();
                }
                setcookie("forgotemail", "yourValue", 1);
                break;
            case 'acceptPost':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $data = $db->alone_data_where('data', 'id', $id);
                    $arP['menu'] = $data->menuPost;
                    if ($db->updateRow('data', $arP, 'id', $id)) {
                        $result['error'] = 0;
                    }
                }
                break;
            case 'changePassword':
                if (count($_POST) >= 3) {
                    $user = $db->alone_data_where('user', 'id', $_POST['id']);
                    if (md5($_POST['password']) == $user->password && $_POST['passwordNew'] === $_POST['passwordNewRepeat']) {
                        $ar['password'] = md5($_POST['passwordNew']);
                        if ($db->updateRow('user', $ar, 'id', $_POST['id'])) {
                            $result['error'] = 0;
                            unset($_COOKIE['Upassword']);
                            setcookie('Upassword', $ar['password'], time() + (86400 * 30), "/");
                            $result['text'] = 'Thay đổi thành công !';
                        }
                    } else {
                        $result['text'] = 'Nội dung nhập không chính xác !';
                    }
                }
                break;
            case 'changeEmail':
                if (count($_POST) >= 3) {
                    $user = $db->alone_data_where('user', 'id', $_POST['id']);
                    if (md5($_POST['password']) == $user->password && $_POST['emailNew'] === $_POST['emailNewRepeat']) {
                        $ar['email'] = $_POST['emailNew'];
                        if ($db->updateRow('user', $ar, 'id', $user->id)) {
                            $result['error'] = 0;
                            unset($_COOKIE['Uemail']);
                            setcookie('email', $ar['email'], time() + (86400 * 30), "/");
                            $result['text'] = 'Thay đổi thành công !';
                        }
                    } else {
                        $result['text'] = 'Nội dung nhập không chính xác !';
                    }
                }
                break;
            case 'changeInfo':
                $user = $db->alone_data_where('user', 'id', $_POST['id']);
                if (isset($_POST['email'])) {
                    unset($_POST['email']);
                }
                // if(isset($_POST['id'])){unset($_POST['id']);}

                foreach ($_POST as $key => $p) {
                    if ($p == '') {
                        unset($_POST[$key]);
                    }
                }
                // var_dump($_POST);
                if (count($_POST)) {
                    $data = $db->updateRow('user', $_POST, 'id', $_POST['id']);
                    // var_dump($data);
                }
                $result['error'] = 0;
                $result['text'] = 'Thay đổi thông tin thành công !';
                break;
            case 'cart':
                $menuShop = $db->alone_data_where("menu", "file", "shop");
                if ($menuShop) {
                    foreach ($_POST as $key => $data) {
                        if ($data !== '' && !is_array($data)) {
                            $post[$key] = $data;
                        }
                    }
                    if (count($post) > 1 && count($_POST['cart'])) {
                        $post['time'] = date('d/m/Y');
                        $post["menu"] = $menuShop->id;
                        $sessionCart = json_decode($_SESSION['cart']);
                        $post["session"] = base64_encode(json_encode($sessionCart));
                        $success = false;
                        if ($db->insertData('cart', $post)) {
                            $success = true;
                            if ($success) {
                                ob_start();
                                require('template/shop-success.php');
                                $content = ob_get_clean();
                                require 'phpmailer/class.phpmailer.php';
                                require 'phpmailer/PHPMailerAutoload.php';
                                $gmail = $_POST['gmail'];
                                $mail            = new PHPMailer;
                                $mail->CharSet   = 'UTF-8';
                                $mail->SMTPDebug = false; // Enable verbose debug output
                                $mail->isSMTP(); // Set mailer to use SMTP
                                $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                $mail->SMTPAuth   = true; // Enable SMTP authentication
                                $mail->Username   = 'viettech.customer@gmail.com'; // SMTP username
                                $mail->Password   = 'zkyyxatxvuncdtzw'; // SMTP password
                                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                                $mail->Port       = 587;
                                $mail->From       = 'viettech.customer@gmail.com';
                                $mail->FromName   = 'Hệ thống'; //Title 
                                $mail->addAddress($gmail, $gmail);
                                $mail->isHTML(true);

                                $mail->Subject = 'Đơn đặt hàng mới';
                                $mail->Body = $content;
                                if (!$mail->send()) {
                                    $result['text'] = $mail->ErrorInfo;
                                } else {
                                    $result = array_merge($post, $result);
                                    $result['error'] = 0;
                                    $result['text']  = 'Bạn đã đặt hàng thành công. Chúng tôi sẽ liên hệ cho bạn sớm nhất.';
                                    session_destroy();
                                    session_unset();
                                    setcookie("voucher", null, time() - (86400)*6, "/");
                                }
                            }
                        } else {
                            var_dump($db->insertDataError('cart', $post));
                            $result['text'] = 'Action.php Error 111 !';
                        }
                    } else {
                        $result['text'] = 'Quý khách vui lòng điền đầy đủ thông tin !';
                    }
                } else {
                    $result['text'] = 'Chưa cấu hình Giỏ hàng !';
                }
                break;

            case 'post':
                $arP = [];
                $uploadOk = true;
                $errorText = '';
                if ($_FILES['img']['type'] !== '') {
                    $check = getimagesize($_FILES["img"]["tmp_name"]);
                    if (!$check) {
                        $uploadOk = false;
                        $errorText = 'Chỉ được up hình !';
                    }
                    // Check file size
                    if ($_FILES["img"]["size"] > 1000000) {
                        $errorText = 'Dung lượng ảnh quá lớn !';
                        $uploadOk = false;
                    }
                    if ($uploadOk) {
                        foreach ($_POST as $key => $p) {
                            if ($p !== '') {
                                $arP[$key] = htmlentities($p);
                            }
                        }
                        if (count($_POST) == count($arP)) {
                            //upload File
                            $f = $_FILES['img'];
                            $uploadFile = uploadFile($fileName = $f['name'], $f['tmp_name']);
                            if ($uploadFile['success']) {
                                $menuPost = $db->alone_data_where('menu', 'file', 'post');
                                $arP['img'] = $uploadFile['img'];
                                $arP['menu'] = $menuPost->id;
                                if ($db->insertData('data', $arP)) {
                                    $result['error'] = 0;
                                    $errorText = 'Bạn đã đăng tin thành công, chúng tôi sẽ kiểm duyệt và đưa lên sớm nhất !';
                                } else {
                                    $errorText = 'Không cập nhật được cơ sở dữ liệu !';
                                }
                            } else {
                                $errorText = 'Up hình không thành công !';
                            }
                        } else {
                            $errorText = 'Nội dung nhập không đầy đủ !';
                        }
                    }
                } else {
                    $errorText = 'Vui lòng up hình';
                }
                $result['text'] = $errorText;
                break;
            case 'export':
                if (isset($_GET['menu'])) {
                    $menu = $db->alone_data_where('menu', 'id', $_GET['menu']);
                    if ($menu) {
                        $sql = "SELECT * FROM `" . dbPrefix . "data` WHERE `menu` = '$menu->id' ";
                        if (isset($_POST['data']) && count($_POST['data'])) {
                            $sql .= 'AND ';
                            $listId = $_POST['data'];
                            foreach ($listId as $key => $idData) {
                                if ($idData !== '') {
                                    $sql .= ' `id` = ' . $idData;
                                    if ($key < count($listId) - 1) {
                                        $sql .= ' OR';
                                    }
                                }
                            }
                        }
                        $listData = $db->loadallrows_sql($sql);
                        if (isset($listData) && count($listData)) {
                            include('template/export.php');
                            exit;
                        } else {
                            $result['text'] = 'Không có dữ liệu !';
                        }
                    } else {
                        $result['text'] = 'Không tồn tại menu !';
                    }
                }
                break;
            case 'resize':
                $folder = 'upload';
                if (isset($_GET['folder'])) $folder = $_GET['folder'];
                $files = glob('../' . $folder . '/*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE);
                foreach ($files as $file) {
                    resizeImage($file, $file, 650, 650);
                }
                break;
            case 'clean':
                $files = glob('../upload/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $check = false;
                        $img = str_replace('../upload/', '', $file);
                        if ($db->alone_data_where_search('data', 'img', $img)) {
                            $check = true;
                        } else if ($db->alone_data_where_search('menu', 'img', $img)) {
                            $check = true;
                        } else {
                            if ($db->alone_data_where_search('page', 'content', $img)) $check = true;
                        }
                        if (!$check) {
                            unlink($file);
                        }
                    }
                }
                break;
            case 'register':
                foreach ($_POST as $key => $data) {
                    if (strlen($data)) {
                        $post[$key] = $data;
                    }
                }
                if (count($post) == count($_POST)) {
                    if ($post['password'] == $post['passwordCheck']) {
                        $check    = 0;
                        $checkUser = $db->alone_data_where('user', 'phone', $post['phone']);
                        if ($checkUser) {
                            $result['text'] = 'Thành viên đã tồn tại';
                            if ($checkUser->confirm == 0) {
                                $result['text'] = 'Tài khoản chưa được xác nhận email !';
                            }
                            $check          = 1;
                        }
                        if ($check == 0) {
                            $post['code'] = md5($post['phone'] . time());
                            unset($post['passwordCheck']);
                            $post['password'] = md5($post['password']);
                            if ($db->insertData('user', $post)) {
                                //send Mail confirm
                                ob_start();
                                require('template/confirmRegister.php');
                                $content = ob_get_clean();
                                require 'phpmailer/class.phpmailer.php';
                                require 'phpmailer/PHPMailerAutoload.php';

                                $mail            = new PHPMailer;
                                $mail->CharSet   = 'UTF-8';
                                $mail->SMTPDebug = false; // Enable verbose debug output
                                $mail->isSMTP(); // Set mailer to use SMTP
                                $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                $mail->SMTPAuth   = true; // Enable SMTP authentication
                                $mail->Username   = 'viettech.customer@gmail.com'; // SMTP username
                                $mail->Password   = 'zkyyxatxvuncdtzw'; // SMTP password
                                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                                $mail->Port       = 587;
                                $mail->From       = ' viettech.customer@gmail.com';
                                $mail->FromName   = 'Xác nhận đăng ký từ trang' . baseUrl; //Title 
                                $mail->addAddress($post['email'], $post['email']);
                                $mail->isHTML(true);

                                $mail->Subject = 'Xác nhận đăng ký';
                                $mail->Body = $content;
                                if (!$mail->send()) {
                                    $result['text'] = $mail->ErrorInfo;
                                }
                                $result = array_merge($post, $result);
                                $result['error'] = 0;
                                $result['text']  = 'Đăng ký thành công ! Vui lòng xác thực tài khoản tại email ' . $post['email'];
                            } else {
                                var_dump($db->insertDataError('user', $post));
                            }
                        }
                    } else {
                        $result['text'] = 'Mật khẩu nhập lại không chính xác !';
                    }
                } else {
                    $result['text'] = 'Vui lòng nhập đầy đủ thông tin !';
                }
                break;
            case 'confirmRegister':
                if (isset($_GET['code'])) {
                    $userCheck = $db->alone_data_where('user', 'code', $_GET['code']);
                    if ($userCheck && $userCheck->confirm == 0) {
                        $array['confirm'] = 1;
                        if ($db->updateRow('user', $array, 'id', $userCheck->id)) {
?>
                            <center>
                                <h4><strong>Xác nhận đăng ký thành công ! Bấm vào <a href="<?= baseUrl ?>">đây</a> để về trang chủ.</strong></h4>
                            </center>
<?php
                        }
                    }
                    exit();
                }
                break;
            case 'login':
                if (isset($_POST['Uemail']) && isset($_POST['Upassword'])) {
                    $dataUser = $db->alone_data_where_where('user', 'email', $_POST['Uemail'], 'password', md5($_POST['Upassword']));
                    // var_dump($dataUser); 
                    if ($dataUser) {
                        //set Cookie
                        foreach ($_POST as $key => $p) {
                            unset($_COOKIE[$key]);
                            setcookie($key, $dataUser->$key, time() + (86400 * 30), "/");
                        }
                        $result['error'] = 0;
                    } else {
                        $result['text']  = 'Sai tài khoản hoặc mật khẩu !';
                    }
                }
                break;
            case 'sort':
                if (count($_POST['data']) && isset($_POST['type'])) {
                    $type = $_POST['type'];
                    $sql  = '';
                    switch ($type) {
                        case 'img':
                            $table = 'file_data_lang';
                            $where = "id";
                            break;
                        case 'id':
                            $table = 'data';
                            $where = 'id';
                            break;
                        case 'idList':
                            $table = 'menu';
                            $where = 'id';
                            break;
                        case 'tab':
                            $table = 'tabs';
                            $where = 'id';
                            break;
                        default:
                            $table = 'menu';
                            $where = 'name';
                            break;
                    }
                    foreach ($_POST['data'] as $key => $data) {
                        $sql .= 'UPDATE `' . dbPrefix . $table . '` SET `pos` = "' . $key . '" WHERE `' . $where . '` = "' . $data . '";';
                    }

                    if ($db->execute_sql($sql)) {
                        $result['error'] = 0;
                        $result['text']  = 'Thay đổi thành công !';
                    } else {
                        $result['error'] = 1;
                        $result['text']  = $sql;
                    }
                }
                break;
            case 'delAll':
                if (isset($_POST['data']) && isset($_POST['table'])) {
                    $table = $_POST['table'];
                    $sql = '';
                    foreach ($_POST['data'] as $value) {
                        $sql .= 'DELETE FROM `' . dbPrefix . $table . '` WHERE `id` = ' . $value . ' ;';
                        delFile($db->alone_data_where($table, 'id', $value));
                    }
                    if ($db->execute_sql($sql)) {
                        $result['error'] = 0;
                        $result['text']  = 'Thay đổi thành công !';
                    } else {
                        $result['error'] = 1;
                        $result['text']  = $sql;
                    }
                }
                break;
            case 'contact':
                $returnSend = false;
                $PF = $_POST;

                foreach ($PF as $data) {
                    if (strlen($data) > 5) {
                        $post[] = $data;
                    }
                }
                if (isset($_POST['security_code'])) {
                    if ($_POST['security_code'] == '') {
                        $result['text'] = 'Vui lòng nhập mã xác nhận!';
                    } else {
                        if ($_POST['security_code'] == $_SESSION['security_code']) {
                            unset($PF['security_code']);
                            $returnSend = true;
                        } else {
                            $result['text'] = 'Mã xác nhận không đúng !';
                        }
                    }
                } else {
                    if (count($post)) {
                        $returnSend = true;
                    } else {
                        $result['text'] = 'Vui lòng nhập đầy đủ nội dung !';
                    }
                }
                if ($returnSend) {
                    require 'phpmailer/class.phpmailer.php';
                    require 'phpmailer/PHPMailerAutoload.php';

                    $gmail           = $_POST['gmail'];
                    $mail            = new PHPMailer;
                    $mail->CharSet   = 'UTF-8';
                    $mail->SMTPDebug = false; // Enable verbose debug output
                    $mail->isSMTP(); // Set mailer to use SMTP
                    $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true; // Enable SMTP authentication
                    $mail->Username   = 'viettech.customer@gmail.com'; // SMTP username
                    $mail->Password   = 'zkyyxatxvuncdtzw'; // SMTP password
                    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 587;
                    $mail->From       = ' viettech.customer@gmail.com';
                    $mail->FromName   = 'Hệ thống liên hệ'; //Title 
                    $mail->addAddress($gmail, $gmail);
                    $mail->isHTML(true);

                    $mail->Subject = 'Liên hệ mới từ trang ' . $_SERVER['SERVER_NAME'] . ' - ' . timeNow(); // name subject
                    $content       = '';
                    unset($PF['gmail']);
                    foreach ($PF as $p) {
                        if ($p !== '') {
                            $content .= $p . '<br>';
                        }
                    }
                    $mail->Body = $content;
                    if (!$mail->send()) {
                        $result['text'] = $mail->ErrorInfo;
                    } else {
                        $menuContact = $db->alone_data_where('menu', 'file', 'contact');
                        if ($menuContact) {
                            $PF['menu'] = $menuContact->id;
                            $db->insertData('contact', $PF);
                        }
                        $result['error'] = 0;
                        $result['text']  = 'Cám ơn đã gửi thông tin! Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất!';
                    }
                }

                break;
        }
    }
}

if (count($result)) {
    echo json_encode($result);
}
?>