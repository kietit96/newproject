<?php

include_once("rules.php");

/**
* Computed Data
*/
class getData
{
	protected $rules;

	public function __construct()
	{
		$this->rules = new Rule;
	}

	public function registerData($listData)
	{
		$post = [];
		unset($listData['confirmPassword']);
		foreach ($listData as $key => $data) {
            if ($data != '') {
                $post[$key] = $this->rules->registerValidation($data);
            } else {
            	throw new Exception("Fields not equal!", 1);
            }
        }
        return $post;
	}

}