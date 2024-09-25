<?php

/**
* Rules
*/
class Rule
{
	public function registerValidation($data)
	{
		$data = trim($data);
	 	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	public function checkEqual($fields1, $fields2)
	{
		if (count($fields1) == count($fields2)) {
			return true;
		}
		throw new Exception("Vui lòng nhập đầy đủ thông tin !", 1);
	}

	public function confirmPassword($password, $confirmPassword)
	{
		if ($password == $confirmPassword) {
			return true;
		}
		throw new Exception("Mật khẩu xác nhận không chính xác!");
	}

	public function checkFillable($listInput, $fillable)
	{
		if (array_keys($listInput) == ($fillable)) {
			return true;
		}
		throw new Exception("Fields not unique");
	}
}