<?php

// user profile page

class Profiles extends Controller {
	public function __construct() {
		// $this->userModel = $this->model('User');
		$this->galleryModel = $this->model('Gallery');
		$this->galleryProfile = $this->model('Profile');
	}
	public function user() {
		// die("got here<hr>");
		// Init data
		$data = [
			'username' => "",
			'images' => "",
			'following' => "",
			'followers' => ""
		];
		$id_user = $_SESSION['user_id'];

		$data['following'] = $this->galleryModel->followingCount($id_user);
		$data['followers'] = $this->galleryModel->followersCount($id_user);
		$temp = $this->galleryProfile->getUsername($id_user);
		$data['username'] = ucwords($temp->username);
		$data['images'] = $this->galleryProfile->imageCount($id_user);
		
		
		$this->view('profile/userprofile', $data);
	}
}