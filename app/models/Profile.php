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

		public function getUserData($id_user){
			$this->database->query('SELECT id_user, username, email, first_name, last_name FROM `user` WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			return $this->database->single();
		}
		
		public function updateUserData($id_user, $email, $last_name, $first_name, $username){
			$this->database->query('
			UPDATE `user` 
			SET username = :username, email = :email, first_name = :first_name, last_name = :last_name
			WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':email', $email);
			$this->database->bind(':last_name', $last_name);
			$this->database->bind(':first_name', $first_name);
			$this->database->bind(':username', $username);
			if($this->database->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function validateUserbyPwd($id_user, $password){
			$this->database->query('SELECT * FROM user WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
	
			$row = $this->database->single();
			$hashed_password = $row->password;
			if(password_verify($password, $hashed_password)){
				return true;
			} else {
				return false;
			}
		}

		public function updateUserPwd($id_user, $password){
			$this->database->query('
			UPDATE `user` 
			SET password = :password
			WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':password', $password);
			if($this->database->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function updateNotification($id_user, $notification){
			$this->database->query('
				UPDATE `user` 
				SET notification_preference = :notification_preference
				WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			$this->database->bind(':notification_preference', $notification);
			
			if($this->database->execute()){
				return true;
			} else {
				return false;
			}			
		}
		public function getNotificationSetting($id_user){
			$this->database->query('
			SELECT notification_preference FROM `user`
			WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			return $this->database->single();	
		}
		
		public function getAvatar($id_user){
			$this->database->query('SELECT profile_pic_path FROM `user` WHERE id_user = :id_user');
			$this->database->bind(':id_user', $id_user);
			return $this->database->single();
		}
		
		public function userFollowerExists($id_user){
			$this->database->query('SELECT * FROM follow
				WHERE following_id = :id_user');
			$this->database->bind(':id_user', $id_user);
			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}

		public function userFollowingExists($id_user){
			$this->database->query('SELECT * FROM follow
				WHERE follower_id = :id_user');
			$this->database->bind(':id_user', $id_user);
			$row = $this->database->resultSet();
			if ($this->database->rowCount() > 0) {
				return true;
			} else {
				return false;
			}		
		}


		public function getFollowerList($id_user){
			$this->database->query('
			SELECT follow.follower_id AS follow_id, user.username, user.profile_pic_path
			FROM `follow`
			JOIN `user` ON follow.follower_id = user.id_user
			WHERE follow.following_id = :id_user
			ORDER BY user.id_user DESC
			');
			$this->database->bind(':id_user', $id_user);
			return $this->database->resultSet();			
		}

		public function getFollowingList($id_user){
			$this->database->query('
			SELECT follow.following_id AS follow_id, user.username, user.profile_pic_path 
			FROM `follow` 
			JOIN `user` ON follow.following_id = user.id_user 
			WHERE follow.follower_id = :id_user
			ORDER BY user.id_user DESC
			');
			$this->database->bind(':id_user', $id_user);
			return $this->database->resultSet();			
		}

	}
?>