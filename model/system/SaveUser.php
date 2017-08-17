<?php

namespace model\system;

use model\exceptions\ValidationException;
use model\system\Token;
use model\system\Cookie;
use PDO;
use Slim\Http\Response;

class SaveUser {

	private $userData;

	private $cookieLiveTime = 3600 * 8;

	public function __construct( array $userDataArray ) {
		$this->setUserData( $userDataArray );
	}

	function posted() {
		session_start();

		$userInput = $this->getUserData();

		$postValidationResults = $this->checkInput( $userInput );

		$errors    = $postValidationResults['errors'];
		$userInput = $postValidationResults['validUserInput'];

		if ( ! empty( $errors ) ) {
			$usSession = Session::getInstance();
			$usSession->setSession( 'error', $errors );
			$usSession->setSession( 'prevUserInput', $userInput );
			header( "Location: registration" );
			exit;
		}

		$token = $this->saveCookieToken();

		$this->saveToDb( $userInput['name'], $userInput['surname'], $userInput['mail'], $userInput['phone'], $userInput['login'], $userInput['password'], $token );

		return true;
	}

	function checkInput($userInput){

		$errors = array();

		try {

			$name     = $this->prepareInput( $userInput['name'] );
			$surname  = $this->prepareInput( $userInput['surname'] );
			$mail     = $this->prepareInput( $userInput['mail'] );
			$phone    = $this->prepareInput( $userInput['phone'] );
			$login    = $this->prepareInput( $userInput['login'] );
			$password = $this->prepareInput( $userInput['password'] );

		}catch (ValidationException $e){
			$errors['error_msg'] = $e->getMessage();
		}

		try{

			$this->isValidEmail($mail);

		}catch (ValidationException $e){

			$errors['error_mail'] = $e->getMessage();

		}

		try{

			$this->validateNumber( $phone );

		}catch (ValidationException $e){

			$errors['error_phone'] = $e->getMessage();

		}

		try{
			$this->validateLogin($login);
		}catch (ValidationException $e){
			$errors['error_login'] = $e->getMessage();
		}

		$validUserInput = array(
			'name' => $name,
			'surname' => $surname,
			'mail' => $mail,
			'phone' => $phone,
			'login' => $login,
			'password' => $password
		);

		$results = array(
			'errors' => $errors,
			'validUserInput' => $validUserInput
		);

		return $results;
	}

	function prepareInput( $data ) {
		$data = trim( $data );
		$data = stripslashes( $data );
		$data = htmlspecialchars( $data );

		if ( strlen( $data ) != 0) {
			return $data;
		} else {
			throw new ValidationException("You can't send empty value");
		}
	}

	function validateLogin( $login ){

		$connection = $this->getConnection();

		$statement = $connection->prepare("SELECT * FROM `Users` WHERE `login` = ?");
		$statement->execute(array(
			$login
		));

		$result = $statement->fetchAll(PDO::FETCH_OBJ);

		if($result) {
			throw new ValidationException('You can\'t use this login');
		}
	}

	function isValidEmail( $email ) {

		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			throw new ValidationException("Your email not equals templates.");
		}

		list( $user, $host ) = explode( "@", $email );

		if ( ! checkdnsrr( $host, "MX" ) && ! checkdnsrr( $host, "A" ) ) {
			throw new ValidationException("Sorry, but we can't found email box like: \"".$host."\"");
		}

		return true;
	}

	function validateNumber( $phone ) {
		if ( strlen( $phone ) != 10) {
			throw new ValidationException('Your number have to much numbers');
		}elseif (!ctype_digit($phone)){
			throw new ValidationException('You must entered just a numbers');
		}

		if( $phone[0] != 0){
			throw new ValidationException('You number is wrong');
		}

		return true;
	}

	function saveToDb( $name, $surname, $mail, $phone, $login, $password, $token ) {

		$connection = $this->getConnection();

		$statement = $connection->prepare( 'INSERT INTO `Users` (`name`, `surname`, `mail`, `phone`, `login`, `password`, `token`) VALUES (?, ?, ?, ?, ?, ?, ?)' );

		$statement->execute( array(
			$name,
			$surname,
			$mail,
			$phone,
			$login,
			$password,
			$token
		) );

	}

	function getToken(){
		$token = Token::generateToken();
		return $token;
	}

	function saveCookieToken(){
		$cookie = Cookie::getInstance();
		$token = Token::generateToken();
		$time = time()+$this->getCookieLiveTime();

		$cookie->setCookie('token', $token, $time);

		return $token;
	}

	function getConnection(){
		$connection = new PDO( 'mysql:host=localhost;dbname=words-game.com;charset=utf8', 'root', 'toor' );
		return $connection;
	}

	/**
	 * @return mixed
	 */
	public function getUserData() {
		return $this->userData;
	}

	/**
	 * @param mixed $userData
	 */
	public function setUserData( $userData ) {
		$this->userData = $userData;
	}

	/**
	 * @return int
	 */
	public function getCookieLiveTime(): int {
		return $this->cookieLiveTime;
	}

	/**
	 * @param int $cookieLiveTime
	 */
	public function setCookieLiveTime( int $cookieLiveTime ) {
		$this->cookieLiveTime = $cookieLiveTime;
	}



}