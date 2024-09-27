<?php

// Chuc nang
// 1 method ma hoa va return lai 1 link
// 1 method luu lai doan hash va gan no vao cart
// 1 method handle luu lai ket qua tra ve
//

/**
* Thanh toan Onepay
*/
class Onepay
{

    public $SECRET;

    public $listRequired;

    public $tourSecretSHA256;

    public $idRef;

    function __construct()
    {
        $this->SECRET       = "A3EFDFABA8653DF2342E8DAC29B51AF0";
        $this->listRequired = [
            "Title"                     => "VPC 3-Party",
            "virtualPaymentClientURL"   => "https://mtf.onepay.vn/onecomm-pay/vpc.op?",
            "vpc_Merchant"              => "ONEPAY",
            "vpc_AccessCode"            => "D67342C2",
            "vpc_MerchTxnRef"           => date ( 'YmdHis' ) . rand (),
            "vpc_OrderInfo"             => "DON_HANG_".date ( 'YmdHis' ),
            "vpc_Amount"                => 100, // 100=1VND
            "vpc_ReturnURL"             => "http://localhost:3002/dr.php",
            "vpc_Version"               => "2",
            "vpc_Command"               => "pay",
            "vpc_Locale"                => "vn",
            "vpc_Currency"              => "VND",
        ];
    }

    public function encodeData()
    {
        ksort($this->listRequired);
        $arrayToParams = http_build_query($this->listRequired);
        $stringHashData = "";
        foreach ($this->listRequired as $key => $value) {
            if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                $stringHashData .= $key . "=" . $value . "&";
            }
        }
        $stringHashData = rtrim($stringHashData, "&");
        $this->tourSecretSHA256 = strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$this->SECRET)));
        $vpcURL = $this->listRequired['virtualPaymentClientURL'].
                    $arrayToParams."&vpc_SecureHash=" .
                    $this->tourSecretSHA256;
        return $vpcURL;
    }

    public function decodeData($request)
    {
        $secureHash = $request['vpc_SecureHash'];
        unset($request['vpc_SecureHash']);

        if ($request['vpc_TxnResponseCode'] == 7 ||
             $request['vpc_TxnResponseCode'] == "No Value Returned")
              throw new Exception("Lỗi không xác định - Unspecified Failure");

        $this->idRef = $request['vpc_MerchTxnRef'];
        $arrayToParams = http_build_query($request);

        if (strtoupper ( $secureHash ) == strtoupper(hash_hmac('SHA256', $arrayToParams, pack('H*',$this->SECRET)))) {
            return [
                "id"        => $request['vpc_MerchTxnRef'],
                "result"    => $this->getResponseDescription($request['vpc_TxnResponseCode']),
                "amount"    => $request['vpc_Amount'],
                "currency"  => $request['vpc_CurrencyCode']
            ];
        }

        throw new Exception("Không thể xác thực");
    }

    public function getResponseDescription($responseCode) {
        switch ($responseCode) {
            case "0" :
                $result = "Giao dịch thành công - Approved";
                break;
            case "1" :
                $result = "Ngân hàng từ chối giao dịch - Bank Declined";
                break;
            case "3" :
                $result = "Mã đơn vị không tồn tại - Merchant not exist";
                break;
            case "4" :
                $result = "Không đúng access code - Invalid access code";
                break;
            case "5" :
                $result = "Số tiền không hợp lệ - Invalid amount";
                break;
            case "6" :
                $result = "Mã tiền tệ không tồn tại - Invalid currency code";
                break;
            case "7" :
                $result = "Lỗi không xác định - Unspecified Failure ";
                break;
            case "8" :
                $result = "Số thẻ không đúng - Invalid card Number";
                break;
            case "9" :
                $result = "Tên chủ thẻ không đúng - Invalid card name";
                break;
            case "10" :
                $result = "Thẻ hết hạn/Thẻ bị khóa - Expired Card";
                break;
            case "11" :
                $result = "Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
                break;
            case "12" :
                $result = "Ngày phát hành/Hết hạn không đúng - Invalid card date";
                break;
            case "13" :
                $result = "Vượt quá hạn mức thanh toán - Exist Amount";
                break;
            case "21" :
                $result = "Số tiền không đủ để thanh toán - Insufficient fund";
                break;
            case "99" :
                $result = "Người sủ dụng hủy giao dịch - User cancel";
                break;
            default :
                $result = "Giao dịch thất bại - Failured";
        }
        return $result;
    }
}
