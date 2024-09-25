<?php

include_once("../config.php");
include_once("sql.php");

/**
* Store check and insert
*/
class Store
{
	protected $db;

	public function __construct()
	{
		$this->db = new DB;
	}

	public function checkUserExits($where)
	{
		$checkUser = $this->db->list_data_where_array("user", $where, 'id', 'DESC', 0, 1);
		if (!count($checkUser)) {
			return true;
		}
		throw new Exception("Thành viên đã tồn tại");
	}

	public function storeUser($listInput)
	{
		$listInput['password'] = md5($listInput['password']);
		if ($this->db->insertData("user", $listInput)) {
			return true;
		}
		throw new Exception("Can\'t not create User");
	}

	public function checkLoginUser($listInput)
	{
		$listInput['password'] = md5($listInput['password']);
		$check = $this->db->list_data_where_array('user', $listInput);
		if ($check) {
			unset($check[0]->password);
			return JWT::encode($check[0], dbPass);
		}
		throw new Exception("Tài khoản hoặc mật khẩu không đúng!");
	}

	public function refreshAccount($id)
	{
		$check = $this->db->alone_data_where("user", "id", $id);
		if ($check) {
			unset($check->password);
			return JWT::encode($check, dbPass);
		}
		throw new Exception("The ID not found");
	}

	public function ky_gui_insert($listInput)
	{
		$insert = $this->db->insertData("data", $listInput);
		if (!$insert) {
			throw new Exception("Không thể nhập dữ liệu");
		}
		return true;
	}

	public function checkPassword($id, $password)
	{
		$check = $this->db->alone_data_where_where(
			"user", 
			"id", $id, 
			"password", md5($password)
		);
		if (!$check) {
			throw new Exception("Mật khẩu cũ không chính xác!");
		}
		return true;
	}

	public function changeInfoUser($listInput, $where, $value)
	{
		$update = $this->db->updateRow("user", $listInput, $where, $value);
		if (!$update) {
			throw new Exception("Không thể cập nhật thông tin");
		}
		return true;
	}
}