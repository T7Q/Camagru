<?php
	class Avatars extends Controller {

		public function __construct(){
			$this->galleryModel = $this->model('Gallery'); // to check img existance and get img owner
			$this->avatarModel = $this->model('Avatar');
			$this->imageModel = $this->model('Image');
		}

		public function setAvatar() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$data = json_decode($_POST['data'], true);
					$temp = explode("avatar", $data['id_image']);
					$id_image = $temp[1];
	
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
					$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
					if (isset($_SESSION['user_id'])){
						if($this->galleryModel->imageExists($id_image)){
							$image_owner = $this->galleryModel->imageOwner($id_image);
							if ($id_user === $image_owner->id_user){
								$img_path = $this->imageModel->getImgPath($id_image);
								$avatar_img_path = 'public/img/user_' . $id_user . '/profile.png';
								if (copy(APPPATH . '/' . $img_path->path , APPPATH . '/' . $avatar_img_path)) {
									$this->avatarModel->saveAvatar($avatar_img_path, $id_user);
									$temp2 = $this->avatarModel->getUserAvatar($id_user);
									$json['valid'] = true;
									$json['path'] = $temp2->profile_pic_path;
									$json['message'] = "Your profile photo was successfully updated";
								} else{
									$json['valid'] = false;
									$json['message'] = 'Failed to copy image';
								}
								
							} else {
								$json['valid'] = false;
								$json['message'] = "You can't use other user images";
							}
						} else {
							$json['valid'] = false;
							$json['message'] = "Image does not exist in your gallery";
						}
					} else {
						$json['valid'] = false;
						$json['message'] = "You need to be logged in to set avatar";
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "Oops, something went wrong getting image id";
				}
				echo json_encode($json);
			} else {
				$this->view('pages/error');
			}
		}


	}
?>