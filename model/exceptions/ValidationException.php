<?php
/**
 * Created by PhpStorm.
 * User: d.goncharov
 * Date: 15.08.17
 * Time: 11:15
 */

namespace model\exceptions;

use Throwable;

class ValidationException extends \Exception {
	public function __construct( $message = "", $code = 0, Throwable $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}
}