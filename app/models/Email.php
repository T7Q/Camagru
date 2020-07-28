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
			
			$this->database->execute();
			return $token;
		}

		// Validate token
		public function isValidToken($username, $token) {

			// add token to database
			$this->database->query('SELECT * FROM `user` WHERE username=:username');
			$this->database->bind(':username', $username);

			$row = $this->database->single();
			if ($row > 0) {
				return ( $row->token == $token ? true : false);
			} else {
				// echo "user does not exit <hr>";
				return false;
			}
			return false;
		}

		// Get user info
		public function getUserInfo($email){
			$this->database->query('SELECT * FROM user WHERE email = :email');
			$this->database->bind(':email', $email);
			return $this->database->single();
		}

		public function message($purpose, $url){
			$data = [
				'subject' => '',
				'message' => '',
				'header' => ''
			];

			if ($purpose == 'pwd_reset'){
					$data['subject'] = 'Reset your password for '.SITENAME;

					$data['message'] = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
					$data['message'] .= '<p>Here is your password reset link: </br>';
					$data['message'] .= '<a href="'.$url.'">'.$url.'</a></p>';
			} else if ($purpose == 'activate') {
				$data['subject'] = 'Account activation for '.SITENAME;

				$data['message'] = '<p>Welcome to Camagru. </p>';
				$data['message'] .= '<p>Here is your account activation link: </br>';
				$data['message'] .= '<a href="'.$url.'">'.$url.'</a></p>';
			}
			
			$data['headers'] = "From: Camagru web editing app <hiveweb7@gmail.com>\r\n";
			$data['headers'] .= "Reply-To: <hiveweb7@gmail.com>\r\n";
			$data['headers'] .= "Content-type: text/html\r\n";

			return $data;
		}

		public function sendEmail($email, $purpose){
			$token = $this->createToken($email);
	
			// get username
			$user = $this->getUserInfo($email);
			$username = $user->username;
			
			if ($purpose == 'pwd_reset'){
				$url = URLROOT. "/emails/pwdreset/" . $username . "/" . $token;
			} else if ($purpose == 'activate') {
				$url = URLROOT. "/emails/activateaccount/" . $username . "/" . $token;
			}
			
			$to = $email;
			$message = $this->message($purpose, $url);
			mail($to, $message['subject'], $message['message'], $message['headers']);
		}
	}
?>