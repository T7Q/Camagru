<?php
class User
{
	private $database;

	public function __construct()
	{
		$this->database = new Db;
	}


	// Regsiter user
	public function register($data)
	{
		$sql = "INSERT INTO `user` (`username`, `email`, `password`) VALUES(:username, :email, :password)";
		$this->database->query($sql);

		// Bind values
		$this->database->bind(':username', $data['username']);
		$this->database->bind(':email', $data['email']);
		$this->database->bind(':password', $data['password']);

		// // Execute
		if($this->database->execute()){
			return true;
		} else {
			return false;
		}
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


	// Finad user by email
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
}
