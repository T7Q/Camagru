<?php
	class Gallery
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		public function galleryExists(){
			$this->database->query('SELECT * FROM gallery');

			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}

		// public function getAllImages(){
		// 	$this->database->query('SELECT id_image, path FROM `gallery` ORDER BY created_at DESC');
		// 	return $this->database->resultSet();			
		// }

		public function getAllImages($id_user){
			$this->database->query('
			SELECT gallery.id_image, gallery.path, 
			count(like.id_like) AS total_like, 
			SUM(like.id_user = :id_user) AS mylike 
			FROM `gallery` 
			LEFT JOIN `like` ON gallery.id_image = like.id_image 
			GROUP BY gallery.id_image
			ORDER BY gallery.created_at DESC');
			$this->database->bind(':id_user', $id_user);
			return $this->database->resultSet();			
		}




		public function imageExists($id){
			$this->database->query('SELECT * FROM gallery WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id);

			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}
		public function getImageData($id_user, $id_image){
			// $this->database->query('SELECT gallery.id_image, gallery.id_user, gallery.path, user.username FROM `gallery` JOIN `user` ON gallery.id_user = user.id_user WHERE gallery.id_image = :id_image');
			$this->database->query(
			'SELECT gallery.id_image, gallery.id_user, gallery.path, user.username,
			(SELECT COUNT(id_like) FROM `like` where id_user = :id_user AND id_image = :id_image) AS my_like, 
			(SELECT COUNT(id_like) FROM `like` where id_image = :id_image) AS total_like
			FROM `gallery`
			JOIN `user` ON gallery.id_user = user.id_user WHERE gallery.id_image = :id_image');

			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':id_image', $id_image);
			return $this->database->resultSet();			
		}

		public function deleteImage($id){
			$this->database->query('DELETE FROM gallery WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id);
			return $this->database->execute();			
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
			// // Execute
			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}

		public function unlikeImage($id_user, $id_image){
			// $this->database->query();
			$this->database->query('DELETE FROM `like` WHERE id_image = :id_image AND id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':id_image', $id_image);
			// // Execute
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