<?php
class User
{
	private $database;

	public function __construct()
	{
		$this->database = new Db;
	}


	// Register user
	public function registerUser($data){
		$sql = "INSERT INTO `user` (`username`, `email`, `password`, `first_name`, `last_name`, `profile_pic_path`) VALUES(:username, :email, :password, :first_name, :last_name, :profile_pic_path)";
		$this->database->query($sql);

		// Bind values
		$this->database->bind(':username', $data['username']);
		$this->database->bind(':email', $data['email']);
		$this->database->bind(':password', $data['password']);
		$this->database->bind(':first_name', $data['first_name']);
		$this->database->bind(':last_name', $data['last_name']);
		$this->database->bind(':profile_pic_path', "public/img/general/avatar.png");


		// // Execute
		if($this->database->execute()){
			return true;
		} else {
			return false;
		}
	}

	// Update password
	public function pwdUpdate($password, $username){
		$sql = "UPDATE `user` SET password=:password WHERE username=:username";
		$this->database->query($sql);

		// Bind values
		$this->database->bind(':password', $password);
		$this->database->bind(':username', $username);

		// // Execute
		if($this->database->execute()){
			$this->removeToken($username);
			return true;
		} else {
			return false;
		}
	}

	// Activate account
	public function updateActiveStatus($status, $username){
		$sql = "UPDATE `user` SET active=:status WHERE username=:username";
		$this->database->query($sql);

		// Bind values
		$this->database->bind(':status', $status);
		$this->database->bind(':username', $username);

		// // Execute
		if($this->database->execute()){
			$this->removeToken($username);
			return true;
		} else {
			return false;
		}
	}

	// Remove token
	public function removeToken($username){
		$sql = "UPDATE `user` SET token=:token WHERE username=:username";
		$this->database->query($sql);

		// Bind values
		$this->database->bind(':token', null);
		$this->database->bind(':username', $username);

		// // Execute
		$this->database->execute();
	}

	// Login User
	public function login($username, $password){
		$this->database->query('SELECT * FROM user WHERE username = :username');
		$this->database->bind(':username', $username);

		$row = $this->database->single();
		$hashed_password = $row->password;
		if(password_verify($password, $hashed_password)){
			return $row;
		} else {
			return false;
		}
	}


	// Find user by email
	public function findUserByEmail($email)
	{
		$this->database->query('SELECT * FROM user WHERE email = :email');
		$this->database->bind(':email', $email);

		$row = $this->database->single();

		// check row
		if ($this->database->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
	

	// Find if account is activated by usernmae
	public function isActivated($username)
	{
		$this->database->query('SELECT * FROM user WHERE username = :username');
		$this->database->bind(':username', $username);

		$row = $this->database->single();

		// check row
		if ($row->active === '1') {
			return true;
		} else {
			return false;
		}
	}

	// Find if account is activated by email
	public function isActivatedByEmail($email)
	{
		$this->database->query('SELECT * FROM user WHERE email = :email');
		$this->database->bind(':email', $email);

		$row = $this->database->single();

		// check row
		if ($row->active === '1') {
			return true;
		} else {
			return false;
		}
	}


	// Finad user by username
	public function findUserByUsername($username)
	{
		$this->database->query('SELECT * FROM user WHERE username = :username');
		$this->database->bind(':username', $username);

		$row = $this->database->single();

		// check row
		if ($this->database->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Finad useremail by user ID
	public function getEmailByUserId($id_user)
	{
		$this->database->query('SELECT email FROM user WHERE id_user = :id_user');
		$this->database->bind(':id_user', $id_user);

		return $this->database->single();
	}


	// Get user info
	public function getUserInfo($email) {
		$this->database->query('SELECT * FROM user WHERE email = :email');
		$this->database->bind(':email', $email);

		return $this->database->single();
	}

	public function validateConfirmPassword(&$data){
		if (empty($data['confirm_password'])) {
			$data['confirm_password_err'] = 'Please confirm password';
		} else {
			if ($data['password'] != $data['confirm_password']) {
				$data['confirm_password_err'] = 'Passwords do not match';
			}
		}
	}

	public function validatePasswordFormat(&$data){
		if (empty($data['password'])) {
			$data['password_err'] = 'Please enter password';
		} else if (strlen($data['password']) < 6 || strlen($data['password']) > 24) {
			$data['password_err'] = 'Password must be between 6 - 24 characters';
		} else if (!preg_match('/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $data['password'])){
			$data['password_err'] = 'Password must contain at least 1 lowercase, 1 uppercase, 1 numeric character';
		}
	}

	public function validateLoginUsername(&$data){
		// check user field
		if (empty($data['username'])) {
			// Username filed is empty
			$data['username_err'] = 'Please enter name';
		} else if ($this->findUserByUsername($data['username'])) {
			// User found
			if($this->isActivated($data['username'])){
				// User account is activated
			} else {
				// User account is not activated
				$data['username_err'] = 'You account is not activated, check your email';
			}
		} else {
			// Username not found
			$data['username_err'] = 'Username not found';
		}
	}

	public function getUserByEmail($email){
		$this->database->query('SELECT id_user FROM user WHERE email = :email');
		$this->database->bind(':email', $email);

		return $this->database->single();
	}

	public function getUserByUsername($username){
		$this->database->query('SELECT id_user FROM user WHERE username = :username');
		$this->database->bind(':username', $username);

		return $this->database->single();
	}


	public function userExists($id_user){
		$this->database->query('SELECT * FROM user WHERE id_user = :id_user');
		$this->database->bind(':id_user', $id_user);

		$row = $this->database->single();
		if ($this->database->rowCount() > 0) {
			return true;
		} else {
			return false;
		}		
	}

	public function validateEmailUsername(&$data){
		// Validate Email
		if (empty($data['email'])) {
			$data['email_err'] = 'Please enter email';
		} else if (!((filter_var($data['email'], FILTER_VALIDATE_EMAIL)))){
			$data['email_err'] = 'Invalid email';
		} 
		else if ($this->findUserByEmail($data['email'])) {
			if (array_key_exists("id_user", $data)){
				$temp = $this->getUserByEmail($data['email']);
				if (!($data['id_user'] == $temp->id_user)){
					$data['email_err'] = 'Account with this email already exists';
				}
			} else {
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
		} else if ($this->findUserByUsername($data['username'])) {
			if (array_key_exists("id_user", $data)){
				$temp = $this->getUserByUsername($data['username']);
				if (!($data['id_user'] == $temp->id_user)){
					$data['username_err'] = 'This username has already been taken';
				}
			} else {
				$data['username_err'] = 'This username has already been taken';
			}
		}

		// Validate First Name
		if (!$data['first_name'] || empty($data['first_name'])) {
			$data['first_name_err'] = 'Please enter first name';
		} else if (!preg_match('/^[a-zA-z]+([ \'-][a-zA-Z]+)*$/', $data['first_name'])) {
			$data['first_name_err'] =  "First name must include letters only";
		} else if (strlen($data['first_name']) > 25) {
			$data['first_name_err'] =  "First name must be less than 25 characters";
		}

		// Validate Last Name
		if (!$data['last_name'] || empty($data['last_name'])) {
			$data['last_name_err'] = 'Please enter last name';
		} else if (!preg_match('/^[a-zA-z]+([ \'-][a-zA-Z]+)*$/', $data['last_name'])) {
			$data['last_name_err'] =  "Last name must include letters only";
		} else if (strlen($data['last_name']) > 25) {
			$data['last_name_err'] =  "Last name must be less than 25 characters";
		}
	}


}
