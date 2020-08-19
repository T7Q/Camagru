<?php
	class Avatar
	{
		private $database;

		public function __construct(){
			$this->database = new Db;
		}

		public function saveAvatar($img_path, $id_user){
			$this->database->query('UPDATE `user` SET `profile_pic_path` = :path 
				WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':path', $img_path);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}	

		}

		public function getUserAvatar($id_user) {
			$this->database->query('SELECT profile_pic_path FROM `user` WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			return $this->database->single();
		}

	}
?>