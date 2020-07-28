<?php
	class Emails extends Controller{
	
	
		public function __construct(){

			$this->userModel = $this->model('User');
			$this->emailModel = $this->model('Email');
		}
		
		public function forgotpwd(){		
			//Check for POST
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				// echo "POST METHOD <hr>";
				// process form
				$data = [
					'email' => trim($_POST['email']),
					'email_err' => '',
				];

				// Validate Email
				if (empty($data['email'])) {
					$data['email_err'] = 'Please enter email';
				} else {
					// Check email
					if ($this->userModel->findUserByEmail($data['email'])) {						
							$this->sendEmail($_POST['email'], 'pwd_reset');
							flash('reset_success', 'Password reset link has been sent');
						} else {
							echo "user not found <hr>";
							$data['email_err'] = 'Account with this email does not exists';
					}
				}
			}
			// Load view
			$this->view('emails/forgotpwd', $data);
		}
		
		public function message($purpose, $url){
			$data = [
				'subject' => '',
				'message' => '',
				'header' => '',

			]; 
			if ($purpose == 'pwd_reset'){
					$data['subject'] = 'Reset your password for '.SITENAME;
					$data['message'] = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
					$data['message'] .= '<p>Here is your password reset link: </br>';
					$data['message'] .= '<a href="'.$url.'">'.$url.'</a></p>';
			}
			$data['headers'] = "From: Camagru web editing app <hiveweb7@gmail.com>\r\n";
			$data['headers'] .= "Reply-To: <hiveweb7@gmail.com>\r\n";
			$data['headers'] .= "Content-type: text/html\r\n";

			return $data;

		}

		public function sendEmail($email, $purpose){
			echo "GOT TO SEND EMAIL <hr>";
			$token = $this->emailModel->createToken($email);
	
			// get user id 
			$user = $this->userModel->getUserInfo($email);
			$username = $user->username;
			
			if ($this->emailModel->tokenExists($email)){
				echo "exists <hr>";
				// $this->emailModel->deleteToken($email);
			} else {
				echo "token NOT found <hr>";

			}
			
			$url = URLROOT. "/emails/pwdreset/" . $username . "/" . $token;
			echo "url: " . $url ."<hr>";
			

			$to = $email;
			// if ($title == 'pwd_reset') {
			// 	$subject = 'Reset your password for '.SITENAME;
			// 	$message = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
			// 	$message .= '<p>Here is your password reset link: </br>';
			// 	// $message .= $url.'</p>';
			// 	$message .= '<a href="'.$url.'">'.$url.'</a></p>';
		
			// }

			// $headers = "From: Camagru web editing app <hiveweb7@gmail.com>\r\n";
			// $headers .= "Reply-To: <hiveweb7@gmail.com>\r\n";
			// $headers .= "Content-type: text/html\r\n";
		

			$message = $this->message($purpose, $url);
			mail($to, $message['subject'], $message['message'], $message['headers']);
			// mail($to, $subject, $message, $headers);
		}


		public function validateNewPwd(&$data) {
			echo "got to function <hr>";
			if (empty($data['password'])) {
				$data['password_err'] = 'Please enter password';
			} elseif (strlen($data['password']) < 6) {
				$data['password_err'] = 'Password must be at least 6 characters';
			}

			// Validate Confirm Password
			if (empty($data['confirm_password'])) {
				$data['confirm_password_err'] = 'Please confirm password';
			} else {
				if ($data['password'] != $data['confirm_password']) {
					$data['confirm_password_err'] = 'Passwords do not match';
				}
				// Make sure errors are empty
				if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
					return true;
					
				} else {
					return false;
				}
				return false;
			}
		}
		


		public function pwdreset ($username = '', $token = '') {
			session_start();
			if ($username != ''){
				$_SESSION['tkn_user'] = $username;
			}
			// validate token
			if ($_SERVER['REQUEST_METHOD'] != 'POST') {
				$this->view('emails/pwdreset');
				
				if ($this->emailModel->isValidToken($username, $token)) {
					flash('token', 'Please enter your new password');
				} else {
					echo "token invalid <hr>";
				}
			}

			// Check for POST
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// process form
				$data = [
					'password' => trim($_POST['password']),
					'confirm_password' => trim($_POST['confirm_password']),
					'password_err' => '',
					'confirm_password_err' => '',
				];

				// Validate Password
				if ($this->validateNewPwd($data)){
					// Hashed pasword
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

					// Update password data in database
					if ($this->userModel->pwdUpdate($data['password'], $_SESSION['tkn_user'])){
						unset($_SESSION['tkn_user']);
						flash('register_success', 'Your password was successfully updated, please log in');
						redirect('users/login');
					} else {
						// 	echo "failure to update <hr>";
					}
				} else {
					$this->view('emails/pwdreset', $data);
				}
				// print_r($data);

				// if (empty($data['password'])) {
				// 	$data['password_err'] = 'Please enter password';
				// } elseif (strlen($data['password']) < 6) {
				// 	$data['password_err'] = 'Password must be at least 6 characters';
				// }

				// Validate Confirm Password
				// if (empty($data['confirm_password'])) {
				// 	$data['confirm_password_err'] = 'Please confirm password';
				// } else {
				// 	if ($data['password'] != $data['confirm_password']) {
				// 		$data['confirm_password_err'] = 'Passwords do not match';
				// 	}
				// 	// Make sure errors are empty
				// 	if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
				// 		// Validated

				// 		// Hashed pasword
				// 		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

				// 		if ($this->userModel->pwdUpdate($data['password'], $_SESSION['tkn_user'])){
				// 			unset($_SESSION['tkn_user']);
				// 			flash('register_success', 'Your password was successfully updated, please log in');
				// 			redirect('users/login');
				// 		} else {
				// 			// 	echo "failure to update <hr>";
				// 		}
						
				// 	} else {
				// 		$this->view('emails/pwdreset', $data);
				// 	}
				// 	$this->view('emails/pwdreset', $data);
				// }
			} else {
				// Init data
				$data = [
					'password' => '',
					'confirm_password' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];

				// Load view
				$this->view('emails/pwdreset', $data);
			}
		}

	}	
?>
