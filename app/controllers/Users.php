<?php
class Users extends Controller
{
	public function __construct()
	{
		$this->userModel = $this->model('User');
	}

	public function register()
	{
		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// process form

			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// Init data
			$data = [
				'first_name' => trim($_POST['first_name']),
				'last_name' => trim($_POST['last_name']),
				'username' => trim($_POST['username']),
				'password' => trim($_POST['password']),
				'confirm_password' => trim($_POST['confirm_password']),
				'email' => trim($_POST['email']),
				'first_name_err' => '',
				'last_name_err' => '',
				'username_err' => '',
				'password_err' => '',
				'confirm_password_err' => '',
				'email_err' => ''
			];

			// Validate Email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email';
			} else {
				// Check email
				if ($this->userModel->findUserByEmail($data['email'])) {
					$data['email_err'] = 'Account with this email already exists';
				}
			}

			// Validate Username
			if (empty($data['username'])) {
				$data['username_err'] = 'Please enter name';
			} else if (!preg_match('/^[A-Za-z0-9]{0,}$/', $data['username'])) {
				$data['username_err'] =  "Username must include letters and numbers only";
			} else if (strlen($data['username']) > 25) {
				$data['username_err'] =  "Username must be less than 25 characters";
			} else if ($this->userModel->findUserByUsername($data['username'])) {
				$data['username_err'] = 'This username has already been taken';
			}

			// Validate Password
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
			}

			// Validate First Name
			if (!$data['first_name'] || empty($data['first_name'])) {
				$data['first_name_err'] = 'Please enter first name';
			} else if (!preg_match('/^[a-zA-z]+([ \'-][a-zA-Z]+)*$/', $data['first_name'])) {
				$data['first_name_err'] =  "First name must include letters and numbers only";
			} else if (strlen($data['first_name']) > 25) {
				$data['first_name_err'] =  "First name must be less than 25 characters";
			}
	
			// Validate Last Name
			if (!$data['last_name'] || empty($data['last_name'])) {
				$data['last_name_err'] = 'Please enter last name';
			} else if (!preg_match('/^[a-zA-z]+([ \'-][a-zA-Z]+)*$/', $data['last_name'])) {
				$data['last_name_err'] =  "Last name must include letters and numbers only";
			} else if (strlen($data['last_name']) > 25) {
				$data['last_name_err'] =  "Last name must be less than 25 characters";
			}

			// Make sure errors are empty
			if (empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
				// Validated

				// Hashed pasword
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

				// Registe user
				if ($this->userModel->register($data)) {
					flash('register_success', 'You are registered and can log in');
					redirect('users/login');
				} else {
					echo "success3 <hr>";
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

	public function login()
	{
		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// process form
			$data = [
				'username' => trim($_POST['username']),
				'password' => trim($_POST['password']),
				'username_err' => '',
				'password_err' => '', ''
			];

			// Validate Name
			if (empty($data['username'])) {
				$data['username_err'] = 'Please enter name';
			}

			// Validate Password
			if (empty($data['password'])) {
				$data['password_err'] = 'Please enter password';
			} elseif (strlen($data['password']) < 6) {
				$data['password_err'] = 'Wrong password';
			}


			// Check for username
			if ($this->userModel->findUserByUsername($data['username'])) {
				// Username found
				echo "got here <hr>";
			} else {
				echo $data['username'];
				echo "got NOT FOUND <hr>";
				// Username not found
				$data['username_err'] = 'Username not found';
			}

			// Make sure errors are empty
			if (empty($data['username_err']) && empty($data['password_err'])) {
				// Validated
				// Check and set logged in user
				$loggedInUser = $this->userModel->login($data['username'], $data['password']);

				if ($loggedInUser) {
					// Create Session
					$this->createUserSession($loggedInUser);
				} else {
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

	public function createUserSession($user)
	{
		$_SESSION['user_id'] = $user->id_user;
		$_SESSION['user_username'] = $user->username;
		$_SESSION['user_email'] = $user->email;
		redirect('pages/home');
	}

	public function logout()
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['user_username']);
		unset($_SESSION['user_email']);
		session_destroy();
		redirect('users/login');
	}

	public function isLoggedIn()
	{
		if (isset($_SESSION['user_id'])) {
			return true;
		} else {
			return false;
		}
	}

	// public function createToken()
	// {
	// 	$selector = bin2hex(random_bytes(8));
	// 	$token = random_bytes(32);
	// 	$url = URLROOT . "/users/createnewpass";
	// }
}
