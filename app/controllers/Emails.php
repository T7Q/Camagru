<?php
	// send activation email, password reset	
	class Emails extends Controller{
	
		public function __construct(){

			$this->userModel = $this->model('User');
			$this->emailModel = $this->model('Email');
		}
	
		public function pwdreset ($username = '', $token = '') {
			// Save user that uses token
			session_start();
			if ($username != ''){
				$_SESSION['tkn_user'] = $username;
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

				$this->userModel->validatePasswordFormat($data);
				$this->userModel->validateConfirmPassword($data);

				if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
					// If entered passwords are valid and match, hash password
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

					// Update password data in database and send user to login page
					if ($this->userModel->pwdUpdate($data['password'], $_SESSION['tkn_user'])){
						unset($_SESSION['tkn_user']);
						flash('register_success', 'Your password was successfully updated, please log in');
						redirect('users/login');
					} else {
						// 	echo "failure to update <hr>";
						// flash erro entering to database
					}
				} else {
					// show errors 
					$this->view('emails/pwdreset', $data);
				}
			} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
				// Load view
				$this->view('emails/pwdreset');
				
				// Check if token is valid
				if ($this->emailModel->isValidToken($username, $token)) {
					flash('token', 'Please enter your new password');

				} else {
					// token is invalid
				}

				// Init data
				$data = [
					'password' => '',
					'confirm_password' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];
			}
		}

		public function activateAccount ($username = '', $token = '') {
			// Save user that uses token
			session_start();
			if ($username != ''){
				$_SESSION['tkn_user'] = $username;
			}
			if ($this->emailModel->isValidToken($username, $token)) {
				// Valid token
				if ($this->userModel->updateActiveStatus('1', $_SESSION['tkn_user'])){
					unset($_SESSION['tkn_user']);
					$this->view('users/login');
					// flash('register_success', 'Your account was successfully activated, please log in');
					// redirect('users/login');
				} else {
					// 	echo "failure to update <hr>";
					// flash erro entering to database
				}

			} else {
				echo "token invalid <hr>";
			}
			
		}

	}	
?>