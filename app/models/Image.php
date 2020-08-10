<?php
	class Image
	{
		private $database;

		public function __construct()
		{
			$this->database = new Db;
		}

		public function addPhotoToDb($data){
			$sql = "INSERT INTO `gallery` (`id_user`, `path`) VALUES(:id_user, :path)";
			$this->database->query($sql);

			// Bind values
			$this->database->bind(':id_user', $data['id_user']);
			$this->database->bind(':path', $data['path']);

			// // Execute
			if($this->database->execute()){
				return true;
			} else {
				return false;
			}
		}

	}
?>