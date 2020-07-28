<?php
	class Email
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		// Create token (and add it to database) for account activation or password reset
		public function createToken($email) {			
			$token = bin2hex(random_bytes(32));

			// add token to database
			$this->database->query('UPDATE `user` SET token=:token WHERE email=:email');
			$this->database->bind(':token', $token);
			$this->database->bind(':email', $email);
			// echo "after database" . $token . "<hr>";
			
			$this->database->execute();
			// echo "updated database <hr>";
			// $this->updateToken($token, $email);
			
			return $token;
		}

		// Validate token
		public function isValidToken($username, $token) {

			// add token to database
			$this->database->query('SELECT * FROM `user` WHERE username=:username');
			$this->database->bind(':username', $username);

			$row = $this->database->single();
			if ($row > 0) {
				if($row->token == $token){
					// echo "token match <hr>";
					return true;
				} else {
					// echo "token does not match <hr>";
					return false;
				}
			} else {
				// echo "user does not exit <hr>";
				return false;
			}
			// echo "after database" . $token . "<hr>";
			
			$this->database->execute();
			// echo "updated database <hr>";
			// $this->updateToken($token, $email);
			
			return $token;
		}


		// Check if token exists
		public function tokenExists($email)
		{
			// check if token from this user already exists
			$this->database->query('SELECT * FROM user WHERE email = :email');
			$this->database->bind(':email', $email);
			
			$row = $this->database->single();
			// check row
			// if ($this->database->rowCount() > 0) {
			if ($row->token != NULL) {
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