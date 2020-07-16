<?php
	class User {
		private $database;

		public function __construct(){
			$this->database = new Db;
		}
		
		// Finad user by email
		public function findUserByEmail($email){
			// die('GOT TO findUserByEmail');
			$this->database->query('SELECT * FROM user WHERE email = :email');
			$this->database->bind(':email', $email);

			$row = $this->database->single();

			// check row
			if ($this->database->rowCount() > 0){
				return true;
			} else {
				return false;
			}
		}

	}
?>