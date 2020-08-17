<?php

	// user account manamgement: register, login, logout, create user session, forgot password

	class Users extends Controller {
		public function __construct() {
			$this->userModel = $this->model('User');
			$this->emailModel = $this->model('Email');
		}

		public function register() {
			// Check for POST
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// process form

				// Sanitize POST data
				// $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				// Init data
				$data = [
					'first_name' => trim(filter_var($_POST['first_name'], FILTER_SANITIZE_STRING)),
					'last_name' => trim(filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)),
					'username' => trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING)),
					'password' => trim($_POST['password']),
					'confirm_password' => trim($_POST['confirm_password']),
					'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
					'first_name_err' => '',
					'last_name_err' => '',
					'username_err' => '',
					'password_err' => '',
					'confirm_password_err' => '',
					'email_err' => ''
				];

				$this->userModel->validateEmailUsername($data);
				$this->userModel->validateConfirmPassword($data);
				$this->userModel->validatePasswordFormat($data);

				
				// Make sure errors are empty
				if (empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
					// Validated

					// Hashed pasword
					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

					// Registe user
					if ($this->userModel->registerUser($data)) {
						$this->emailModel->sendEmail($data['email'], 'activate');
						$this->flash('register_success', 'Activation email has been send to your email', 'success');
						$this->redirect('users/login');
					} else {
						die('Something went wrong (controllers/users.php)');
					}
				} else {
					// Load view with errors
					$this->view('users/register', $data);
				}
			} else {
				// Init data
				$data = [
					'first_name' => '',
					'last_name' => '',
					'username' => '',
					'password' => '',
					'confirm_password' => '',
					'email' => '',
					'first_name_err' => '',
					'last_name_err' => '',
					'username_err' => '',
					'password_err' => '',
					'confirm_password_err' => '',
					'email_err' => ''
				];
				// Load view 
				$this->view('users/register', $data);
			}
		}

		public function login() {
			// Check for POST
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// process form
				$data = [
					'username' => trim($_POST['username']),
					'password' => trim($_POST['password']),
					'username_err' => '',
					'password_err' => ''
				];
				$this->userModel->validateLoginUsername($data);
				$this->userModel->validatePasswordFormat($data);

				if (empty($data['username_err']) && empty($data['password_err'])) {
					// Validate
					$loggedInUser = $this->userModel->login($data['username'], $data['password']);
					if ($loggedInUser) {
						// Create Session
						$this->createUserSession($loggedInUser);
					} else {
						// Load view with errors
						$data['password_err'] = 'Password incorrect';
						$this->view('users/login', $data);
					}
				} else {
					// Load view with errors
					$this->view('users/login', $data);
				}
			} else {
				// Init data
				$data = [
					'username' => '',
					'password' => '',
					'username_err' => '',
					'password_err' => '',
				];

				// Load view 
				$this->view('users/login', $data);
			}
		}

		public function createUserSession($user) {
			$_SESSION['user_id'] = $user->id_user;
			$_SESSION['user_username'] = $user->username;
			$_SESSION['user_email'] = $user->email;
			$this->redirect('pages/home');
		}

		public function logout(){
			unset($_SESSION['user_id']);
			unset($_SESSION['user_username']);
			unset($_SESSION['user_email']);
			session_destroy();
			$this->redirect('users/login');
		}

		public function isLoggedIn() {
			if (isset($_SESSION['user_id'])) {
				return true;
			} else {
				return false;
			}
		}

		public function forgotpwd() {		
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
					if ($this->userModel->findUserByEmail($data['email'])) {	
						// user found					
						$this->emailModel->sendEmail($_POST['email'], 'pwd_reset');
						$this->flash('forgot_pwd', 'Password reset link has been sent to your email', 'success');
					} else {
						// user not found
						$data['email_err'] = 'Account with this email does not exists';
					}
				}
				$this->view('users/forgotpwd', $data);
			}
			else {
				// Init data
				$data = [
					'email' => '',
					'email_err' => '',
				];
				// $this->flash('forgot_pwd', 'Please enter your email address', 'success');
				// Load view 
				$this->view('users/forgotpwd', $data);
			}
		}

		public function newtest(){
			if ($this->isAjaxRequest()) {
				$this->view('users/hello');
				
			} else {
				$this->view('pages/error');
			}
		}

	}
?>