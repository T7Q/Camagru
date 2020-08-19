<?php
	class Avatar
	{
		private $database;

		public function __construct(){
			$this->database = new Db;
		}

		public function saveAvatar($id_image, $id_user){
			$this->database->query('SELECT path FROM `gallery` WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id_image);
			$path = $this->database->single();

			$this->database->query('UPDATE `user` SET `profile_pic_path` = :path 
				WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':path', $path->path);

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