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

		public function userGalleryExists($id_user){
			$this->database->query('SELECT * FROM gallery
				WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}

		public function followGalleryExists($id_user){
			$this->database->query('
			SELECT gallery.id_image, follow.following_id
			FROM gallery
			JOIN follow ON gallery.id_user = follow.following_id
			WHERE follow.follower_id = :id_user'
			);
			$this->database->bind(':id_user', $id_user);
			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}

		public function getAllImages($id_user){
			if ($id_user > 0){
				$this->database->query('
				SELECT gallery.id_image, gallery.path, 
				count(DISTINCT(like.id_like)) AS total_like, 
				count(DISTINCT(comment.id_comment)) AS total_comment, 
				SUM(DISTINCT like.id_user = :id_user) AS mylike 
				FROM `gallery` 
				LEFT JOIN `like` ON gallery.id_image = like.id_image 
				LEFT JOIN `comment` ON gallery.id_image = comment.id_image 
				GROUP BY gallery.id_image 
				ORDER BY gallery.created_at DESC
				');
				$this->database->bind(':id_user', $id_user);
			} else {
				$this->database->query('
				SELECT gallery.id_image, gallery.path, 
				count(DISTINCT(like.id_like)) AS total_like, 
				count(DISTINCT(comment.id_comment)) AS total_comment 
				FROM `gallery` 
				LEFT JOIN `like` ON gallery.id_image = like.id_image 
				LEFT JOIN `comment` ON gallery.id_image = comment.id_image 
				GROUP BY gallery.id_image 
				ORDER BY gallery.created_at DESC
				');
			}
			return $this->database->resultSet();			
		}

		public function getUserImages($id_user){
			$this->database->query('
			SELECT gallery.id_image, gallery.path, 
			count(DISTINCT(like.id_like)) AS total_like, 
			count(DISTINCT(comment.id_comment)) AS total_comment, 
			SUM(DISTINCT like.id_user = :id_user) AS mylike 
			FROM `gallery`
			LEFT JOIN `like` ON gallery.id_image = like.id_image 
			LEFT JOIN `comment` ON gallery.id_image = comment.id_image 
			WHERE gallery.id_user = :id_user
			GROUP BY gallery.id_image 
			ORDER BY gallery.created_at DESC
			');
			$this->database->bind(':id_user', $id_user);
			return $this->database->resultSet();			
		}

		public function getFollowingImages($id_user){
			$this->database->query('
			SELECT gallery.id_image, gallery.path, 
			count(DISTINCT(like.id_like)) AS total_like, 
			count(DISTINCT(comment.id_comment)) AS total_comment, 
			SUM(DISTINCT like.id_user = :id_user) AS mylike 
			FROM `gallery` 
			LEFT JOIN `like` ON gallery.id_image = like.id_image 
			LEFT JOIN `comment` ON gallery.id_image = comment.id_image 
			JOIN `follow` ON gallery.id_user = follow.following_id 
			WHERE follow.follower_id = :id_user
			GROUP BY gallery.id_image 
			ORDER BY gallery.created_at DESC
			');
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
			if ($id_user > 0){
				$this->database->query(
					'SELECT gallery.id_image, gallery.id_user, gallery.path, user.username,
					(SELECT COUNT(id_like) FROM `like` where id_user = :id_user AND id_image = :id_image) AS my_like, 
					(SELECT COUNT(id_like) FROM `like` where id_image = :id_image) AS total_like,
					(SELECT COUNT(id_comment) FROM `comment` where id_image = :id_image) AS total_comment
					FROM `gallery`
					JOIN `user` ON gallery.id_user = user.id_user WHERE gallery.id_image = :id_image');

				$this->database->bind(':id_user', $id_user);
				$this->database->bind(':id_image', $id_image);
			} else {
				$this->database->query(
					'SELECT gallery.id_image, gallery.id_user, gallery.path, user.username,
					(SELECT COUNT(id_like) FROM `like` where id_image = :id_image) AS total_like,
					(SELECT COUNT(id_comment) FROM `comment` where id_image = :id_image) AS total_comment
					FROM `gallery`
					JOIN `user` ON gallery.id_user = user.id_user WHERE gallery.id_image = :id_image');
				$this->database->bind(':id_image', $id_image);
			}
				return $this->database->resultSet();			
		}

		public function getImageComments($id_image){
			$this->database->query('
				SELECT comment.comment, comment.id_comment,comment.id_user, comment.id_image, user.username 
				FROM `comment` 
				JOIN `user` ON comment.id_user = user.id_user 
				WHERE id_image = :id_image
				ORDER BY comment.created_at ASC');
			$this->database->bind(':id_image', $id_image);
			return $this->database->resultSet();
		}

		public function imageOwner($id_image) {
			$this->database->query('SELECT id_user FROM `gallery` WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id_image);
			return $this->database->single();
		}

	}
?>