<?php

	// user account manamgement: register, login, logout, create user session, forgot password

	class Users extends Controller {
		public function __construct() {
			$this->userModel = $this->model('User');
			$this->emailModel = $this->model('Email');
		}

		public function register() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$res = json_decode($_POST['data'], true);

					// Init data
					$data = [
						'first_name' => trim(filter_var($res['first_name'], FILTER_SANITIZE_STRING)),
						'last_name' => trim(filter_var($res['last_name'], FILTER_SANITIZE_STRING)),
						'username' => trim(filter_var($res['username'], FILTER_SANITIZE_STRING)),
						'password' => trim($res['password']),
						'confirm_password' => trim($res['confirm_password']),
						'email' => filter_var($res['email'], FILTER_SANITIZE_EMAIL),
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
							$json['valid'] = true;
							$json['message'] = 'Activation email has been send to your email';
							
						} else {
							$json['valid'] = false;
							$json['message'] = "Oops, did not manage to register user";
						} 
					} else {
						$json['valid'] = false;
						$json['error'] = [
							'username_err' => $data['username_err'],
							'password_err' => $data['password_err'],
							'confirm_password_err' => $data['confirm_password_err'],
							'first_name_err' => $data['first_name_err'],
							'last_name_err' => $data['last_name_err'],
							'email_err' => $data['email_err'],

						];
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "Oops, something went wrong during registration in process";
				}
				echo json_encode($json);
			} else {
				if (isset($_SESSION['user_id'])) {
					$this->redirect('');
				}
				$this->view('users/register');
			}
		}

		public function login() {

			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$res = json_decode($_POST['data'], true);

					$data = [
						'username' => trim($res['username']),
						'password' => trim($res['password']),
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
							$json['valid'] = true;
						} else {
							// Load view with errors
							$json['valid'] = false;
							$json['error'] = ['password_err' => "Password incorrect"];
						}
					} else {
						// Load view with errors
						$json['valid'] = false;
						$json['error'] = [
							'password_err' => $data['password_err'],
							'username_err' => $data['username_err'],
						];
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "Oops, something went wrong during log in process";
				}
				echo json_encode($json);
			} else {
				if (isset($_SESSION['user_id'])) {
					$this->redirect('');
				}
				$this->view('users/login');
			}
		}

		public function createUserSession($user) {
			$_SESSION['user_id'] = $user->id_user;
			$_SESSION['user_username'] = $user->username;
			$_SESSION['user_email'] = $user->email;
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
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$res = json_decode($_POST['data'], true);

				// process form
				$data = [
					'email' => trim($res['email']),
					'email_err' => '',
				];

				// Validate Email
				if (empty($data['email'])) {
					$data['email_err'] = 'Please enter email';
				} else {
					if ($this->userModel->findUserByEmail($data['email'])) {	
						// user found
						if($this->userModel->isActivatedByEmail($data['email'])){
							// User account is activated
							$this->emailModel->sendEmail($data['email'], 'pwd_reset');
							$json['valid'] = true;
							$json['message'] = "Password reset link has been sent to your email";
						} else {
							// User account is not activated
							$json['valid'] = false;
							$json['email_err'] = 'You account is not activated, check your email';
						}
						
					} else {
						// user not found
						$json['email_err'] = 'Account with this email does not exists';
					}
				}
				
				} else {
					$json['valid'] = false;
					$json['message'] = "Oops, something went wrong during registration in process";
				}
				echo json_encode($json);
			} else {
				$this->view('users/forgotpwd');
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