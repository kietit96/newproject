<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include_once('../config.php');
include_once('sql.php');
include('../modules/control.php');
include 'services/cart.php';
$db     = new DB();
$cart     = new Cart();
$result = ['error' => 1];
$do = $_GET["do"];
switch ($do) {
    case 'getListMenu':
        $result['result'] = $listMenu;
        $result['error'] = 0;
        break;
    case 'getVoucher':
        if ($_GET['content']) {
            $data = $db->alone_data_where_where('voucher', 'code_name', $_GET['content'], 'hide', '0');
            if (isset($data) && $data) {
                if ($data->quantity > 0) {
                    $arr = array('title_voucher' => $data->title, 'codename_voucher' => $data->code_name, 'quantity_voucer' => $data->quantity, 'unit_voucher' => $data->unit);
                    $json_voucher = base64_encode(json_encode($arr));
                    setcookie("voucher", $json_voucher, time() + (86400 * 1), "/");
                    $result['error'] = 0;
                    $result['text'] = 'Bạn được ' . $data->title;
                } else {
                    $result['error'] = 0;
                    $result['text'] = 'Mã giảm giá đã hết số lần sử dụng !!!';
                }
            } else {
                $result['error'] = 0;
                $result['text'] = 'Mã giảm giá không tồn tại !!!';
            }
        } else {
            $result['error'] = 0;
            $result['text'] = 'Chưa nhập hoặc mã giảm giá không tồn tại !!!';
        }
        break;
    case 'getListDistrict':
        if (isset($_GET['province'])) {
            $result['result'] = $listDistrict = $db->list_data_where('district', 'province', $_GET['province']) ?? [];
            $result['error'] = 0;
        }
        break;
    case "register":
        $post = json_decode(file_get_contents('php://input'), true);
        unset($post["retypepassword"]);
        $checkUser = $db->checkUser($post['email'], $post['username']);
        $message = "Account is already exist";
        $token = '';
        $user = [];
        $sql =  "";
        if ($checkUser->count * 1 < 1) {
            $message = "Register success";
            $result['error'] = 0;
            $token = generateToken();
            $post["password"] = md5($post["password"]);
            $post["time"] = timeNow();
            if (!$db->insertData("user", $post)) {
                $message = "SQL ERROR";
                $sql = $db->insertDataError("user", $post);
                $result['error'] = 1;
            }
            unset($post["password"]);
            $user = $post;
        }
        $result['response'] = ["mess" => $message, "user" => $user, "token" => $token, "sql" => $sql];
        break;
    default:
        $result['result'] = [];
        $result['error'] = 1;
        break;
}
if (count($result)) {
    echo json_encode($result);
}
