<?php
	class Email
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		// Find user by email
		public function tokenExists($email)
		{
			// check if token from this user already exists
			$this->database->query('SELECT * FROM pwdreset WHERE email = :email');
			$this->database->bind(':email', $email);
			
			$row = $this->database->single();
			// check row
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
				// no previous tokens, do nothing
			}
		}

		// public function deleteToken($email){

		// }

		// // Add token to database
		// public function addToken($data){
		// 	$hashed_token = password_hash($data['token'], PASSWORD_DEFAULT);
		// 	$sql = "INSERT INTO `pwdreset` (`email`, `selector`, `token`, `expire`) VALUES(:email, :selector, :token, :expire)";
		// 	$this->database->query($sql);

		// 	// Bind values
		// 	$this->database->bind(':email', $data['email']);
		// 	$this->database->bind(':selector', $data['selector']);
		// 	$this->database->bind(':token', $hashed_token);
		// 	$this->database->bind(':expire', $data['expire']);

		// 	// // Execute
		// 	if($this->database->execute()){
		// 		return true;
		// 	} else {
		// 		return false;
		// 	}
		// }

		// // Finad if token is valid
		// public function isValidToken($token)
		// {
		// 	$hashed_token = password_hash($token, PASSWORD_DEFAULT);
		// 	$this->database->query('SELECT * FROM pwdreset WHERE token = :hashed_token');
		// 	$this->database->bind(':token', $hashed_token);

		// 	$row = $this->database->single();

		// 	// check row
		// 	if ($this->database->rowCount() > 0) {
		// 		return true;
		// 	} else {
		// 		return false;
		// 	}
		// }
	}
?>