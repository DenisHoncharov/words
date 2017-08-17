<?php
/**
 * Created by PhpStorm.
 * User: d.goncharov
 * Date: 15.08.17
 * Time: 17:41
 */

namespace model\system;



use model\exceptions\SessionEcxeption;

class Session {
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
	public function getSession( $param ) {
		if(isset($_SESSION[$param])) {
			return $_SESSION[ $param ];
		}else{
			throw new SessionEcxeption("Undefined parameter \"".$param."\"");
		}
	}

	/**
	 * @param $param
	 * @param $value
	 */
	public function setSession( $param, $value ) {
		$_SESSION[$param] = $value;
	}

	/**
	 * @param $param
	 */
	public function deleteSessionParam($param){
		unset($_SESSION[$param]);
	}

}