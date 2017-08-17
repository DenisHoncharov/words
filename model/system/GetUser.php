<?php
/**
 * Created by PhpStorm.
 * User: d.goncharov
 * Date: 16.08.17
 * Time: 18:53
 */

namespace model\system;

use model\exceptions\ValidationException;
use model\entity\User;
use PDO;

class GetUser {

	private $user;

	function getConnection() {
		$connection = new PDO( 'mysql:host=localhost;dbname=words-game.com;charset=utf8', 'root', 'toor' );

		return $connection;
	}


	/**
	 * @param $token
	 *
	 * @throws ValidationException
	 */
	function getUserByToken( $token ) {

		$connection = $this->getConnection();

		$statement = $connection->prepare( "SELECT * FROM `Users` WHERE `token` = ?" );
		$statement->execute( array(
			$token
		) );

		$result = $statement->fetch( PDO::FETCH_OBJ );

		if ( $result ) {
			$this->setUser( $result );
		} else {
			throw new ValidationException( 'Can\'t found user by token: ' . $token );
		}
	}

	/**
	 * @param $token
	 *
	 * @return User
	 */
	public function getUser( $token ): User {
		$this->getUserByToken($token);
		return $this->user;
	}

	/**
	 * @param $user
	 */
	public function setUser( $user ) {
		$this->user = new User( $user->name, $user->surname, $user->mail, $user->phone, $user->login, $user->password );
	}


}