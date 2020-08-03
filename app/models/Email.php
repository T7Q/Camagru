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
			// if (isset($row)) {
			if ($this->database->rowCount() > 0) {
				if ($row->token == $token){
					return true;
				} else {
					return false;
				}
				// return ( $row->token == $token ? true : false);
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

		public function message($purpose, $url, $username){
			$data = [
				'subject' => '',
				'message' => '',
				'header' => ''
			];
			
			if ($purpose == 'pwd_reset'){
					$data['subject'] = 'Reset your password for '.SITENAME;

					$data['message'] = "<div style=\"background-color:#f3f3f3;\">";
        			$data['message'] .= "<h2 style=\"text-align:center; color:#0000ff; font-family:sans-serif;\">Hello, " . $username . "!</h2>";
					$data['message'] .= '<p style="text-align:center;color:#0099ff;">We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
					$data['message'] .= '<p style="text-align:center;color:#0099ff;">Here is your password reset ';
					$data['message'] .= '<a href="'.$url.'"> link </a></p>';
					$data['message'] .= '<p style="text-align:center; color:#0099ff;"><small>Camagru team</p></div>';
			} else if ($purpose == 'activate') {
				$data['subject'] = 'Account activation for '.SITENAME;
				
				$data['message'] = "<div style=\"background-color:#f3f3f3;\">";
				$data['message'] .= "<h2 style=\"text-align:center; color:#0000ff; font-family:sans-serif;\">" . $username . ", welcome to Camagru! </h2>";
				$data['message'] .= '<p style="text-align:center;color:#0099ff;">Here is your account activation ';
				$data['message'] .= '<a href="'.$url.'">link</a></p>';
				$data['message'] .= '<p style="text-align:center; color:#0099ff;"><small>Camagru team</p></div>';
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
			$message = $this->message($purpose, $url, $username);
			mail($to, $message['subject'], $message['message'], $message['headers']);
		}
	}
?>