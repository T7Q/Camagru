<?php
	// gets info for Gallery page and image Modal box

	class Galleries extends Controller {

		public function __construct(){
			$this->galleryModel = $this->model('Gallery');
			$this->emailModel = $this->model('Email'); // to send email upon comment
			$this->followModel = $this->model('Follow'); // check follow status for Image modal data
			$this->avatarModel = $this->model('Avatar'); // get avatar for Image modal
		}
		
		public function all($param = ''){
			$this->view('gallery/gallery');
		}

		public function getImages() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$data = json_decode($_POST['data'], true);
					
					if ($data['id_user_for_gallery'] != 0){
						// Profile page
						if($data['gallery_type'] === "follow-gallery") {
							// Following gallery
							$id_user = $data['id_user_for_gallery'];
							$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
							if($this->galleryModel->followGalleryExists($id_user)){
								$json['valid'] = true;
								$json['res'] = $this->galleryModel->getFollowingImages($id_user);
							} else {
								$json['message'] = "You are not following anyone, visit Gallery!";
								$json['valid'] = false;
							}
						} else {
							// User image gallery sorted by creation date
							$id_user = $data['id_user_for_gallery'];
							$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
							if($this->galleryModel->userGalleryExists($id_user)){
								$json['valid'] = true;
								$json['res'] = $this->galleryModel->getUserImages($id_user);
							} else {
								$json['message'] = "You dont have any photos yet, visit Photobooth to create some!";
								$json['valid'] = false;
							}
						}
					} else if ($data['id_user_for_gallery'] == 0){
						// Gallery of all images sorted by creation date
						$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
						$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
						if($this->galleryModel->galleryExists()){
							$json['valid'] = true;
							$json['res'] = $this->galleryModel->getAllImages($id_user);
						} else {
							$json['message'] = "There are no photos yet, visit Photobooth to create some!";
							$json['valid'] = false;
						}
					}
				} else {
					$json['message'] = "Oops, something went wrong getting images for Gallery";
					$json['valid'] = false;
				}
				echo json_encode($json);
			} else {
				$this->view('pages/error');
			}
		}

		public function getImageData() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$data = json_decode($_POST['data'], true);
					$temp = explode("id_img", $data['id_image']);
					$id_image = $temp[1];				
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
					$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
					if($this->galleryModel->imageExists($id_image)){
						$json['message'] = "before call";
						$temp = $this->galleryModel->getImageData($id_user, $id_image);
						$json['message'] = $temp;
						$json['valid'] = true;
						$json['comment_list'] = $this->galleryModel->getImageComments($id_image);
						$json['idLoggedUser'] = $id_user;
						$json['avatar'] = $this->avatarModel->getUserAvatar($id_user);
						if($this->followModel->alreadyFollow($id_user, $temp[0]->id_user)){
							$json['follow'] = true;
						} else {
							$json['follow'] = false;
						}
					} else {
						$json['message'] = "Image is not found";
						$json['valid'] = false;
					}	
				} else {
					$json['message'] = "Oops, something went wrong getting images for Gallery";
					$json['valid'] = false;
				}
				echo json_encode($json);
			} else {
				$this->view('pages/error');
			}

		}

		
	}
?>