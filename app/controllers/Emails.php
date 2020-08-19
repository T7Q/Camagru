<?php	
	class Emails extends Controller{
	
		public function __construct(){

			$this->userModel = $this->model('User');
			$this->emailModel = $this->model('Email');
		}
		
		public function pwdreset ($username = '', $token = '') {
			// Save user that uses token
			if ($username != ''){
				$_SESSION['tkn_user'] = $username;
			}

			// Check for POST
			if ($_SERVER['REQUEST_METHOD'] != 'POST') {
				// Init data
				$data = [
					'password' => '',
					'confirm_password' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];
				
				// Check if token is valid
				if ($this->emailModel->isValidToken($username, $token)) {
					$this->flash('token', 'Please enter your new password', 'success');
					$this->view('emails/pwdreset');
				} else {
					$this->flash('token', 'token is invalid', '');
					$this->flash('forgot_pwd', 'Invalid toke, resent recovery link', '');
					$this->view('users/forgotpwd');
					// token is invalid
				}

			} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// process form
				$data = [
					'password' => trim($_POST['password']),
					'confirm_password' => trim($_POST['confirm_password']),
					'password_err' => '',
					'confirm_password_err' => '',
				];

				$this->userModel->validatePasswordFormat($data);
				$this->userModel->validateConfirmPassword($data);

				if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
					// If entered passwords are valid and match, hash password
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

					// Update password data in database and send user to login page
					if ($this->userModel->pwdUpdate($data['password'], $_SESSION['tkn_user'])){
						// on successful update
						unset($_SESSION['tkn_user']);
						$this->flash('register_success', 'Your password was successfully updated, please log in', 'success');
						$this->redirect('users/login');
					} else {
						// if update failed ask user to resent the activation link
						$this->flash('forgot_pwd', 'Oops.. something went wrong with updatign password, resent recovery link one more time', '');
						$this->view('users/forgotpwd');
					}
				} else {
					// show errors 
					$this->view('emails/pwdreset', $data);
				}
			} 
		}

		public function activateAccount ($username = '', $token = '') {
			// Save user that uses token
			if ($username != ''){
				$_SESSION['tkn_user'] = $username;
			}
			if ($this->emailModel->isValidToken($username, $token)) {
				// Valid token
				if ($this->userModel->updateActiveStatus('1', $_SESSION['tkn_user'])){
					unset($_SESSION['tkn_user']);
					$this->flash('register_success', 'Your account was successfully activated, please log in', 'success');
					$this->view('users/login');
				} else {
					$this->flash('register_success', 'Something went wrong, try resending the token', 'failure');
					$this->view('users/login');
				}

			} else {
				$this->flash('register_success', 'Oops, smth went wrong, please use correct activation link');
				$this->view('users/login');
			}
			
		}

	}	
?>