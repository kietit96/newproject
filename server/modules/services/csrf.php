<?php 

/**
 * CSRF
 */
class CSRF
{
	const NAME_OF_CSRF_SESSION = 'CSRF_KEY';

	private $key;

	function __construct()
	{
		$this->key = (isset($_SESSION[self::NAME_OF_CSRF_SESSION])) ? $_SESSION[self::NAME_OF_CSRF_SESSION] : false;
	}

	protected function pushToSession()
	{
		$_SESSION[self::NAME_OF_CSRF_SESSION] = $this->key;
	}

	public function generateKey()
	{
		$this->key = uniqid();
		$this->pushToSession();
	}

	public function verifyKey()
	{
		if (!isset($_SESSION[self::NAME_OF_CSRF_SESSION])) return false;
		return ($this->key === $_SESSION[self::NAME_OF_CSRF_SESSION]);
	}
}