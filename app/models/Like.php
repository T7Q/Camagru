<?php
	class Like
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		public function isLiked($id_user, $id_image){
			$this->database->query('SELECT * FROM `like` WHERE id_image = :id_image AND id_user = :id_user');
			$this->database->bind(':id_image', $id_image);
			$this->database->bind(':id_user', $id_user);

			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}					
		}

		public function likeImage($id_user, $id_image){
			$this->database->query('INSERT INTO `like` (`id_user`, `id_image`) VALUES (:id_user, :id_image)');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':id_image', $id_image);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}

		public function unlikeImage($id_user, $id_image){
			$this->database->query('DELETE FROM `like` WHERE id_image = :id_image AND id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':id_image', $id_image);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}

		public function likeCount($id_image){
			$this->database->query('SELECT * FROM `like` WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id_image);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
		}


	}
?>