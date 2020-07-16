<?php
class Users extends Controller{
	public function __construct(){
		$this->userModel = $this->model('User');
	  }
  
	public function register(){
		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			// process form
			
			// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			// $test['test'] = $_POST['password'];
			// die(print_r($test));

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
			if(empty($data['email'])){
				$data['email_err'] = 'Please enter email';
			}
			else {
				 // Check email
				 if($this->userModel->findUserByEmail($data['email'])){
					$data['email_err'] = 'Account with this email alrady exists';
				  }
				}
	  
			  // Validate Name
			  if(empty($data['username'])){
				$data['username_err'] = 'Please enter name';
			  }
	  
			  // Validate Password
			  if(empty($data['password'])){
				$data['password_err'] = 'Please enter password';
			  } elseif(strlen($data['password']) < 6){
				$data['password_err'] = 'Password must be at least 6 characters';
			  }
	  
			  // Validate Confirm Password
			  if(empty($data['confirm_password'])){
				$data['confirm_password_err'] = 'Please confirm password';
			  } else {
				if($data['password'] != $data['confirm_password']){
				  $data['confirm_password_err'] = 'Passwords do not match';
				}
			  }
	  
			  // Make sure errors are empty
			  if(empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
				// Validated
				die('SUCCESS');
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

	public function login(){
		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			// process form
			$data = [
				'username' => trim($_POST['username']),
				'password' => trim($_POST['password']),
				'username_err' => '',
				'password_err' => '',''
			];


			  // Validate Name
			  if(empty($data['username'])){
				$data['username_err'] = 'Please enter name';
			  }
	  
			  // Validate Password
			  if(empty($data['password'])){
				$data['password_err'] = 'Please enter password';
			  } elseif(strlen($data['password']) < 6){
				$data['password_err'] = 'Wrong password';
			  }
	  
			  // Make sure errors are empty
			  if(empty($data['username_err']) && empty($data['password_err'])){
				// Validated
				die('SUCCESS');
			  } else {
				// Load view with errors
				$this->view('users/register', $data);
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
}