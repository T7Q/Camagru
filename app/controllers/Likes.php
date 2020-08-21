<?php
	class Likes extends Controller {

		public function __construct(){
			$this->likeModel = $this->model('Like');
			$this->galleryModel = $this->model('Gallery');
		}

		public function likeImage() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$data = json_decode($_POST['data'], true);

					$id_image = $data['id_image'];

					$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
					$json['id_image'] = $id_image;
					if($this->galleryModel->imageExists($id_image)){					
						if (isset($_SESSION['user_id'])){
							$json['message2'] = "result" . $this->likeModel->isLiked($id_user, $id_image);

							if($this->likeModel->isLiked($id_user, $id_image)){
								// unlike
								if($this->likeModel->unlikeImage($id_user, $id_image)){
									$json['valid'] = true;
 									$json['message'] = "false";
									$json['count'] = $this->likeModel->likeCount($id_image);
								} else{
									$json['valid'] = false;
									$json['message'] = "Failed updating db in unlike";
								}
							} else {
								// like
								if($this->likeModel->likeImage($id_user, $id_image)){
									$json['valid'] = true;
									$json['count'] = $this->likeModel->likeCount($id_image);
									$json['message'] = "red_color";
								} else{
									$json['valid'] = false;
									$json['message'] = "Failed updating db in unlike";
								}
							}
							$json['count'] = $this->likeModel->likeCount($id_image);
						} else {
							$json['valid'] = false;
							$json['count'] = $this->likeModel->likeCount($id_image);
							$json['message'] = "You need to be logged in to like";
						}
					} else {
						$json['valid'] = false;
						$json['message'] = "Image is not found";
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "Oops, something went wrong getting images for Gallery";
				}
				echo json_encode($json);
			} else {
				$this->view('pages/error');
			}
		}
	} 
?>