<?php
	class Email{
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
			if ($this->database->rowCount() > 0) {
				if ($row->token == $token){
					return true;
				} else {
					return false;
				}
			} else {
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

		public function getUserNameById($id_user){
			$this->database->query('SELECT username FROM user WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			return $this->database->single();
		}


		public function message($purpose, $input_data, $username){
			$data = [
				'subject' => '',
				'message' => '',
				'header' => ''
			];
			
			if ($purpose == 'pwd_reset'){
					$data['subject'] = 'Reset your password for '.SITENAME;

					$data['message'] = "<div style=\"background-color:#f3f3f3;\">";
        			$data['message'] .= "<h2 style=\"text-align:center; color:#0000ff; font-family:sans-serif;\">Hello, " . ucwords($username) . "!</h2>";
					$data['message'] .= '<p style="text-align:center;color:#0099ff;">We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
					$data['message'] .= '<p style="text-align:center;color:#0099ff;">Here is your password reset ';
					$data['message'] .= '<a href="'.$input_data.'"> link </a></p>';
					$data['message'] .= '<p style="text-align:center; color:#0099ff;"><small>Camagru team</p></div>';
			} else if ($purpose == 'activate') {
				$data['subject'] = 'Account activation for '.SITENAME;
				
				$data['message'] = "<div style=\"background-color:#f3f3f3;\">";
				$data['message'] .= "<h2 style=\"text-align:center; color:#0000ff; font-family:sans-serif;\">" . ucwords($username) . ", welcome to Camagru! </h2>";
				$data['message'] .= '<p style="text-align:center;color:#0099ff;">Here is your account activation ';
				$data['message'] .= '<a href="'.$input_data.'">link</a></p>';
				$data['message'] .= '<p style="text-align:center; color:#0099ff;"><small>Camagru team</p></div>';
			} else if ($purpose == 'notification') {
				$comment_author = $this->getUserNameById($input_data->id_user);
				$data['subject'] = ucwords($comment_author->username). " commented your photo in ".SITENAME;
				
				$data['message'] = "<div style=\"background-color:#f3f3f3;\">";
				$data['message'] .= "<h2 style=\"text-align:center; color:#0000ff; font-family:sans-serif;\">" . ucwords($username) . ", hi! </h2>";
				$data['message'] .= '<p style="text-align:center;color:#0099ff;">'. ucwords($comment_author->username) .' commented on your photo: ';
				$data['message'] .= '<q>' . ucwords($input_data->comment) . '</q></p>';
				$data['message'] .= '<p style="text-align:center; color:#0099ff;"><small>Camagru team</p></div>';
			}
			
			$data['headers'] = "From: Camagru web editing app <hiveweb7@gmail.com>\r\n";
			$data['headers'] .= "Reply-To: <hiveweb7@gmail.com>\r\n";
			$data['headers'] .= "Content-type: text/html\r\n";

			return $data;
		}

		public function sendEmail($email, $purpose, $comment_info = ""){
			$token = $this->createToken($email);
	
			// get username
			$user = $this->getUserInfo($email);
			$username = $user->username;
			
			if ($purpose == 'pwd_reset'){
				$data = URLROOT. "/emails/pwdreset/" . $username . "/" . $token;
			} else if ($purpose == 'activate') {
				$data = URLROOT. "/emails/activateaccount/" . $username . "/" . $token;
			} else if ($purpose == 'notification') {
				$data = $comment_info;
			}
			
			$to = $email;
			$message = $this->message($purpose, $data, $username);
			mail($to, $message['subject'], $message['message'], $message['headers']);
		}

	}
?>