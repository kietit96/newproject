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
if (isset($_GET["do"]) && $_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
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
            if ($checkUser->count * 1 > 0) {
                http_response_code(400);
                $message = "Account is already exist";
                echo $result["error_response"] = json_encode([
                    'message' => $message,
                    'error' => 1
                ]);
                exit;
            }
            $token = generateToken();
            $post['code'] = $token;
            $post["password"] = md5($post["password"]);
            $post["time"] = timeNow();
            if (!$db->insertData("user", $post)) {
                http_response_code(999);
                $message = "SQL ERROR";
                $sql = $db->insertDataError("user", $post);
                echo $result["error_response"] = json_encode([
                    'error' => 99,
                    'message' => $message,
                    'sql' => $sql,
                ]);
                exit;
            }
            http_response_code(200);
            unset($post["password"]);
            $user = $post;
            $result['response'] = ["error" => 0, "mess" => $message, "user" => $user, "token" => $token, "sql" => $sql];
            break;
        default:
            $result['result'] = [];
            $result['error'] = 1;
            break;
    }
    if (count($result)) {
        echo json_encode($result);
    }
}
