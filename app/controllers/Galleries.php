<?php
	class Galleries extends Controller {

		public function __construct(){
			$this->galleryModel = $this->model('Gallery');
			$this->imageModel = $this->model('Image');
			$this->emailModel = $this->model('Email');
			$this->userModel = $this->model('User');
			$this->profileModel = $this->model('Profile');
		}
		
		public function all($param = ''){
			$this->view('gallery/gallery');
		}

		public function show() {
			if ($this->isAjaxRequest()) {
				$this->view('gallery/test');
			} else {
				$this->view('users/register');
			}
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
					$json['avatar'] = $this->galleryModel->getUserAvatar($id_user);
					if($this->galleryModel->alreadyFollow($id_user, $temp[0]->id_user)){
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

	public function deleteImgDb() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("del_img", $data['id_image']);
				$id_image = $temp[1];

				$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
				if (isset($_SESSION['user_id'])){
					if($this->galleryModel->imageExists($id_image)){
						$image_owner = $this->galleryModel->imageOwner($id_image);
						$json['valid'] = false;
						// $json['message'] = $image_owner->id_user;
						if ($id_user === $image_owner->id_user){
							$temp = $this->galleryModel->getImgPath($id_image);
							$this->galleryModel->deleteImage($id_image);
							$json['valid'] = true;
							$json['message'] = "Successfully deleted";
							// unlink(APPROOT . '/' . $temp->path); // DELETE FOLDER HERE
						} else {
							$json['valid'] = false;
							$json['message'] = "You can't delete other user images";
						}
					} else {
						$json['valid'] = false;
						$json['message'] = "Image does not exist in your gallery";
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "You need to be logged in to remove image";
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
							$this->galleryModel->updateAvatar($id_image, $id_user);
							$temp2 = $this->galleryModel->getUserAvatar($id_user);
							$json['path'] = $temp2->profile_pic_path;
							$json['valid'] = true;
							$json['message'] = "Your profile photo was successfully updated";
							
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


	public function like() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("like", $data['id_image']);
				// $id_image = $temp[1];
				$id_image = $data['id_image']; // new

				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
				$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
				$json['id_image'] = $id_image;
				if($this->galleryModel->imageExists($id_image)){					
					if (isset($_SESSION['user_id'])){
						$json['message2'] = "result" . $this->galleryModel->isLiked($id_user, $id_image);

						if($this->galleryModel->isLiked($id_user, $id_image)){
							// unlike
							if($this->galleryModel->unlikeImage($id_user, $id_image)){
								$json['message'] = "false";
								$json['count'] = $this->galleryModel->likeCount($id_image);
							} else{
								$json['message'] = "Failed updating db in unlike";
							}
						} else {
							// like
							if($this->galleryModel->likeImage($id_user, $id_image)){
								$json['count'] = $this->galleryModel->likeCount($id_image);
								$json['message'] = "true";
							} else{
								$json['message'] = "Failed updating db in unlike";
							}
						}
						$json['count'] = $this->galleryModel->likeCount($id_image);
					} else {
						$json['count'] = $this->galleryModel->likeCount($id_image);
						$json['message'] = "You need to be logged in to like";
					}
				} else {
					$json['message'] = "Image is not found";
				}
			
				
			} else {
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}



	public function follow() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$id_user_to_follow = $data['id_user_to_follow'];

				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
				$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;

				if (isset($_SESSION['user_id'])){
					// $json['message2'] = "to follow" . $id_user_to_follow . " follower : " . $id_user;
					
					if($this->galleryModel->alreadyFollow($id_user, $id_user_to_follow)){
						// $json['message'] = "UNFOLLOWED";
						// unfollow
						if($this->galleryModel->unfollowUser($id_user, $id_user_to_follow)){
							$json['message'] = "unfollow";

						} else{
							$json['message'] = "Smth went wrong in following this user";
						}
					} else {
						// follow
						if($this->galleryModel->followUser($id_user, $id_user_to_follow)){
							$json['message'] = "follow";

						} else{
							$json['message'] = "Smth went wrong in following this user";
						}
					}
					$json['following'] = $this->galleryModel->followingCount($id_user);
					$json['followers'] = $this->galleryModel->followersCount($id_user);

				} else {
					$json['message'] = "You need to be logged in to follow";
				}
			
				
			} else {
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}



	public function postComment() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("post", $data['id_image']);
				$id_image = $temp[1];

				// The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
				$comment_text = filter_var($data['comment'], FILTER_SANITIZE_STRING);

				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;

				if(strlen($comment_text) > 0 && strlen($comment_text) < 150){
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;

					if($this->galleryModel->imageExists($id_image)){					
						if (isset($_SESSION['user_id'])){
							if($this->galleryModel->saveComment($id_user, $id_image, $comment_text)){
								$id_comment = $this->galleryModel->lastInsertId();
								$comment_info = $this->galleryModel->getOneComment($id_comment);
								$json['comment_info'] = $comment_info;
								$json['valid'] = true;
								$json['idLoggedUser'] = $_SESSION['user_id'];
								$json['comment_total'] =  $this->galleryModel->commentCount($id_image);
								$id_image_owner = $this->galleryModel->imageOwner($id_image);
								$notification = $this->profileModel->getNotificationSetting($id_image_owner->id_user);
								if($notification->notification_preference == 1){
									$temp = $this->userModel->getEmailByUserId($id_image_owner->id_user);
									$email = $temp->email;
									$this->emailModel->sendEmail($email, 'notification', $comment_info);
								}
							}
							else {
								$json['valid'] = false;
								$json['message'] = "Could not save a comment";
							}
						} else {
							$json['valid'] = false;
							$json['message'] = "Image that does not exist can not be commented";
						}
					}
				} else {
					$json['valid'] = false;
				$json['message'] = "Comment must contain less that 150 characters";
				}
			} else {
				$json['valid'] = false;
				$json['message'] = "Oops, something went wrong getting your comment";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}


	public function deleteComment() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				// $temp = explode("id_comment", $data['id_comment']);
				// $id_comment = $temp[1];
				$id_comment = $data['id_comment'];

				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
				$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;


				if (isset($_SESSION['user_id'])){					
					// $json['message2'] = "id_comment: " . $id_comment;
					$temp = $this->galleryModel->findImgByComment($id_comment);
					$json['id_image'] = $temp->id_image;
					if($this->galleryModel->commentExists($id_comment, $id_user)){
						$json['valid'] = true;
						if($this->galleryModel->deleteComment($id_comment)){
							// $json['message'] = "id_comment: " . $id_comment;
							$json['valid'] = true;
							$json['message'] = "Comment was successfully removed";
							$json['count'] = $this->galleryModel->commentCount($temp->id_image);
						} else {
							$json['valid'] = false;
							$json['message'] = "Something went wrong deleting your comment";
						}	
					} else {
						$json['valid'] = false;
						$json['message'] = "You can't delete other users comments: ";
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "You need to be logged in to delete comments";
				}
			} else {
				$json['valid'] = false;
				$json['message'] = "Oops, something went wrong sending comment data";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}




}
?>