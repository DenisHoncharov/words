<?php
/**
 * Created by PhpStorm.
 * User: d.goncharov
 * Date: 16.08.17
 * Time: 13:20
 */

namespace model\system;


class Token {

	public static function generateToken() {
		$token = hash('ripemd160', 'The quick brown fox jumped over the lazy dog.');
		return $token;
	}

}