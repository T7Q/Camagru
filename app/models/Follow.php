<?php
	class Follow
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		public function followersCount($id_user){
			$this->database->query('SELECT following_id FROM `follow` WHERE following_id = :following_id');
			$this->database->bind(':following_id', $id_user);
			$row = $this->database->resultSet();
			return $this->database->rowCount();		
		}

		public function followingCount($id_user){
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

	}
?>