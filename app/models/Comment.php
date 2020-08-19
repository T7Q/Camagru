<?php
	class Comment
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		public function findImgByComment($id_comment){
			$this->database->query('SELECT id_image FROM `comment` WHERE id_comment = :id_comment');
			$this->database->bind(':id_comment', $id_comment);
			return $this->database->single();
		}

		public function commentExists($id_comment, $id_user){
			$this->database->query('SELECT * FROM comment WHERE id_comment = :id_comment AND id_user = :id_user');
			$this->database->bind(':id_comment', $id_comment);
			$this->database->bind(':id_user', $id_user);

			$this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}

		public function saveComment($id_user, $id_image, $comment){
			$this->database->query('
				INSERT INTO `comment` (`id_user`, `id_image`, `comment`) 
				VALUES (:id_user, :id_image, :comment);');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':id_image', $id_image);
			$this->database->bind(':comment', $comment);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}		
		}

		public function getlastInsertId(){
			return $this->database->lastInsertId();
		}

		public function getOneComment($id_comment){
			$this->database->query('
				SELECT comment.comment, comment.id_comment, comment.id_user, comment.id_image, user.username FROM `comment` 
				JOIN `user` ON comment.id_user = user.id_user 
				WHERE id_comment = :id_comment
				');
			$this->database->bind(':id_comment', $id_comment);
			return $this->database->single();
		}

		public function commentCount($id_image){
			$this->database->query('SELECT * FROM `comment` WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id_image);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
		}

		public function deleteComment($id_comment){
			$this->database->query('DELETE FROM `comment` WHERE id_comment = :id_comment');
			$this->database->bind(':id_comment', $id_comment);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}

	}
?>