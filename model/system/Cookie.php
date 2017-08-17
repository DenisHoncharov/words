<?php
/**
 * Created by PhpStorm.
 * User: d.goncharov
 * Date: 16.08.17
 * Time: 14:21
 */

namespace model\system;

use model\exceptions\SessionEcxeption;


class Cookie {
	private static $inst;

	public static function getInstance()
	{
		if (null === self::$inst)
		{
			self::$inst = new self();
		}
		return self::$inst;
	}
	private function __clone() {}
	private function __construct() {}


	/**
	 * @param $param
	 *
	 * @return mixed
	 * @throws SessionEcxeption
	 */
	public function getCookie( $param ) {
		if(isset($_COOKIE[$param])) {
			return $_COOKIE[ $param ];
		}else{
			throw new SessionEcxeption("Undefined parameter \"".$param."\" in Cookie");
		}
	}

	/**
	 * @param $param
	 * @param $value
	 */
	public function setCookie( $param, $value, $time ) {
		setcookie($param, $value, $time);
	}

	/**
	 * @param $param
	 */
	public function deleteCookieParam($param){
		unset($_COOKIE[$param]);
	}
}