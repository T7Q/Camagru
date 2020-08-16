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

		public function commentCount($id_image){
			$this->database->query('SELECT * FROM `comment` WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id_image);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
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
		
		public function lastInsertId(){
			return $this->database->lastInsertId();
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

		public function getOneComment($id_comment){
			$this->database->query('
				SELECT comment.comment, comment.id_comment, comment.id_user, comment.id_image, user.username FROM `comment` 
				JOIN `user` ON comment.id_user = user.id_user 
				WHERE id_comment = :id_comment
				');
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

		public function deleteComment($id_comment){
			$this->database->query('DELETE FROM `comment` WHERE id_comment = :id_comment');
			$this->database->bind(':id_comment', $id_comment);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}

		public function findImgByComment($id_comment){
			$this->database->query('SELECT id_image FROM `comment` WHERE id_comment = :id_comment');
			$this->database->bind(':id_comment', $id_comment);
			return $this->database->single();
		}

		public function followingCount($id_user){
			$this->database->query('SELECT following_id FROM `follow` WHERE following_id = :following_id');
			$this->database->bind(':following_id', $id_user);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
		}

		public function followersCount($id_user){
			$this->database->query('SELECT follower_id FROM `follow` WHERE follower_id = :follower_id');
			$this->database->bind(':follower_id', $id_user);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
		}

		public function alreadyFollow($id_user, $id_user_to_follow){
			$this->database->query('SELECT * FROM `follow` WHERE follower_id = :follower_id AND following_id = :following_id');
			$this->database->bind(':follower_id', $id_user);
			$this->database->bind(':following_id', $id_user_to_follow);

			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}					
		}

		public function followUser($id_user, $id_user_to_follow){
			$this->database->query('INSERT INTO `follow` (`follower_id`, `following_id`) VALUES (:follower_id, :following_id)');
			$this->database->bind(':follower_id', $id_user);
			$this->database->bind(':following_id', $id_user_to_follow);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}

		public function unfollowUser($id_user, $id_user_to_follow){
			$this->database->query('DELETE FROM `follow` WHERE follower_id = :follower_id AND following_id = :following_id');
			$this->database->bind(':follower_id', $id_user);
			$this->database->bind(':following_id', $id_user_to_follow);

			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}


		public function imageOwner($id_image) {
			$this->database->query('SELECT id_user FROM `gallery` WHERE id_image = :id_image');
			$this->database->bind(':id_image', $id_image);
			return $this->database->single();
		}


	}
?>