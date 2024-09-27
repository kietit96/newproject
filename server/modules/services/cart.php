<?php
/**
 * @author by Quy
 * @version v1.0.2
 * @contact ductuan157@gmail.com
 *
 */
class Cart {

    /**
     * List items
     * @param object
     */
    public $list = [];

    /**
     * Total Prices items
     * @param init
     */
    public $prices = 0;

    /**
     * So luong
     * @param int
     */
    public $count = 0;

    /**
     * Khach hang
     * @param array
     */
    public $customer = [];

    /**
     * Ma giam gia
     * @param array
     */
    public $coupons = [];

     /**
     * Session Cart
     * @param array
     */
    public $cart = [];

    /**
     * Khởi tạo
     */
    public function __construct()
    {
        if (isset($_SESSION['cart'])) {
            $cartSession    = json_decode($_SESSION['cart']);
            $this->list     = $cartSession->list;
            $this->customer = $cartSession->customer;
            $this->coupons  = $cartSession->coupons;
            $this->cart     = json_decode($_SESSION['cart'],1);
        } else {
            $this->toSession();
        }
    }

    /**
     *  Cập nhật giỏ hàng
     *  Kết thúc
     */
    public function __destruct()
    {
        $this->cicrle();
        $this->toSession();
    }

    public function getCount()
    {
        $this->cicrle();
        return $this->count;
    }

    /**
     * Cap nhat toi Session
     */
    private function toSession()
    {
        $_SESSION['cart'] = json_encode([
            'list'      => $this->list,
            'prices'    => $this->prices,
            'count'     => $this->count,
            'customer'  => $this->customer,
            'coupons'   => $this->coupons
        ]);
    }

    /**
    * Xu ly tong so tien va so luong
    */
    public function cicrle()
    {
        foreach ($this->list as $key => $data) {
            $page = (object) $data;
            $this->prices   += $page->price * $page->count;
            $this->count    += $page->count;
        }
    }

    /**
     * Them moi 1 item
     */
    public function addItem($item, $quality = 1)
    {
        //Kiểm tra tồn tại và cập nhật
        $checkExitsItem = $this->checkExitsItem($item);
        if ($checkExitsItem) {
            return $this->updateItem($checkExitsItem, $quality);
        }

        //Ngẫu nhiên ID & Cập nhật item mới
        $randomId = md5(time());
        $item['count'] = $quality;
        $this->cart['list'][$randomId] = (object) $item;
        return $this->list = (object) $this->cart['list'];
    }

    /**
     * Kiem tra ton tai
     */
    public function checkExitsItem($item)
    {
        foreach ($this->list as $key => $data) {
            if (count(array_diff(array_map('json_encode', (array) $data), array_map('json_encode', $item))) == 1) {
                return $key;
            }
        }
        return false;
    }

     /**
     * Cap nhat 1 item
     */
    public function updateItem($thisId, $quality = 1)
    {
        //+1 thêm item
        return $this->list->$thisId->count += $quality;
    }

    /**
     * Thay doi so luong
     */
    public function changeCount($thisId, $quality = 1)
    {
        foreach ($this->list as $key => $item) {
            if ($key == $thisId) {
                $item->count = $quality;
            }
        }
    }

     /**
     * Xoa 1 item
     */
    public function removeItem($thisId)
    {
        foreach ($this->list as $key => $item) {
            if ($key == $thisId) {
                unset($this->list->{$key});
            }
        }
    }

     /**
     * Xoa gio hang
     */
    public function removeAllItems()
    {
        //Xóa tất cả sản phẩm
        return $this->list = (object) [];
    }

    /**
     * Cap nhat thong tin nguoi mua hang
     * @param $info array
     */
    public function addCustomer($info)
    {
        return $this->customer = (object) $info;
    }

    /**
     * Hien thi list items trong gio hang
     */
    public function all()
    {
        return $this->list;
    }

    /**
     * Hien thi thong tin cua khach hang
     */
    public function infoCustomer()
    {
        return $this->customer;
    }

    /**
     * Hien thi tong gia tri don hang
     */
    public function allPrice()
    {
        return $this->prices;
    }

    /**
    * Chuyen doi Object to Array
    */
    protected function convertToArray($object) {
        $array = [];
        foreach ($object as $key => $value) {
            if (is_object($value)) {
                $value = $this->convertToArray($value);
            }
            $array[$key] = $value;
        }
        return $array;
    }
}
