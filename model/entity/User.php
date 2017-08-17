<?php

namespace model\entity;

/**
 * Created by PhpStorm.
 * User: d.goncharov
 * Date: 16.08.17
 * Time: 13:10
 */

class User {

	private $name;
	private $surname;
	private $mail;
	private $phone;
	private $login;
	private $password;

	/**
	 * User constructor.
	 *
	 * @param string $name
	 * @param string $surname
	 * @param string $mail
	 * @param string $phone
	 * @param string $login
	 * @param string $password
	 */
	public function __construct( $name = '', $surname = '', $mail = '', $phone = '', $login = '', $password= '' ) {
		$this->setName($name);
		$this->setSurname($surname);
		$this->setMail($mail);
		$this->setPhone($phone);
		$this->setLogin($login);
		$this->setPassword($password);
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getSurname() {
		return $this->surname;
	}

	/**
	 * @param mixed $surname
	 */
	public function setSurname( $surname ) {
		$this->surname = $surname;
	}

	/**
	 * @return mixed
	 */
	public function getMail() {
		return $this->mail;
	}

	/**
	 * @param mixed $mail
	 */
	public function setMail( $mail ) {
		$this->mail = $mail;
	}

	/**
	 * @return mixed
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 */
	public function setPhone( $phone ) {
		$this->phone = $phone;
	}

	/**
	 * @return mixed
	 */
	public function getLogin() {
		return $this->login;
	}

	/**
	 * @param mixed $login
	 */
	public function setLogin( $login ) {
		$this->login = $login;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword( $password ) {
		$this->password = $password;
	}


}