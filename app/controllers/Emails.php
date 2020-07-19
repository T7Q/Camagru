<?php
	class Emails extends Controller{
	
	
		public function __construct(){

			$this->userModel = $this->model('User');
			// $this->emailModel = $this->model('Email');
		}
		
		public function forgotpwd(){
			// Load view 
			// $this->view('emails/forgotpwd');
		
			//Check for POST
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
							echo "user found <hr>";
							// send email to user with recover link
							$this->sendEmail($_POST['email']);

						} else {
							echo "user not found <hr>";
							$data['email_err'] = 'Account with this email does not exists';
					}
				}
			}
			// Load view
			$this->view('emails/forgotpwd', $data);
		}
			
		public function sendEmail($email){
			echo "GOT TO SEND EMAIL <hr>";
			// $expFormat = mktime(
			// 	date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
			// 	);
			// $expDate = date("Y-m-d H:i:s",$expFormat);
			// $key = md5(2418*2 + $email);
			// $addKey = substr(md5(uniqid(rand(),1)),3,10);
			// $key = $key . $addKey;
			
			$to = $email;
			$subject_pwdreset = 'Reset your password for '.SITENAME;
			$message_pwdreset = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
			$message_pwdreset .= '<p>Here is your password reset link: </br>';
			$message_pwdreset .= 'LNK HERE</p>';
			// $message_pwdreset .= '<a href="'.$url.'">'.$url.'</a></p>';

			$headers = "From: Camagru web editing app <hiveweb7@gmail.com>\r\n";
			$headers .= "Reply-To: <hiveweb7@gmail.com>\r\n";
			$headers .= "Content-type: text/html\r\n";

			mail($to, $subject_pwdreset, $message_pwdreset, $headers);
		}
		

	}	
?>
	<!-- // // Check for username
	// if ($this->emailModel->isValidToken($data['token'])){
	// 	// Token exists
	// 	echo "token VALID <hr>";
	// 	$this->view('users/register', $data);
	// } else {
	// 	// Token expired or does not exist
	// 	echo "toke expired <hr>";
	// 	$data['token_err'] = "Token not found, resend a password".URLROOT ."/users/pwdReset";
	// }
// }
// }

// public function sendEmail($email_type, $data){
// 	$url = "test";
// 	$subject_pwdreset = 'Reset your password for '.SITENAME;
// 	$message_pwdreset = '<p>We received a password reset request. The link to reset your password is below. If you did not make this requiest, you can ignore this email.</p>';
// 	$message_pwdreset .= '<p>Here is your password reset link: </br';
// 	$message_pwdreset .= 'LNK HERE</p>';
// 	// $message_pwdreset .= '<a href="'.$url.'">'.$url.'</a></p>';

// 	$headers = "From: Camagru web editing app <hiveweb7@gmail.com>\r\n";
// 	$headers .= "Reply-To: <hiveweb7@gmail.com>\r\n";
// 	$headers .= "Content-type: text/html\r\n";

// 	mail($to, $subject, $message, $headers){
// 	redirect('users/pwdreset');
// 	}
// 	// Load view
// 	$this->view('emails/forgotpwd', $data);
// } -->