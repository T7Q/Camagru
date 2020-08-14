<?php
	class Profile
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		public function getUsername($id_user){
			$this->database->query('SELECT username FROM `user` WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			return $this->database->single();
		}

		public function imageCount($id_user){
			$this->database->query('SELECT * FROM `gallery` WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
		}

	}
?>