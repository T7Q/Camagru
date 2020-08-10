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

		public function getAllImages(){
			$this->database->query('SELECT * FROM gallery');
			return $this->database->resultSet();			
		}

	}
?>