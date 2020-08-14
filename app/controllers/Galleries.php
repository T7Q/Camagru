<?php
	class Galleries extends Controller {

		public function __construct(){
			$this->galleryModel = $this->model('Gallery');
			$this->imageModel = $this->model('Image');
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
				$data = json_decode($_POST['data'], true); // ANY NEED OF THIS?

				$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
				if($this->galleryModel->galleryExists()){
					$json['valid'] = true;
					$json['res'] = $this->galleryModel->getAllImages($id_user);
				} else {
					$json['message'] = "There are no photos yet, visit Photobooth to create some!";
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
					if($this->galleryModel->alreadyFollow($id_user, $temp[0]->id_user)){
						$json['follow'] = "true";
					} else {
						$json['follow'] = "false";
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
				$id = $temp[1];
				$json['message'] = "got reponse" . $id;
				// $json['res'] = "Got this in php" + $data['id_image'];
				
				if($this->galleryModel->imageExists($id)){
					$json['message'] = "before call";
					$temp = $this->galleryModel->deleteImage($id);
					$json['message'] = "succes";
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
					$json['message'] = "You need to be logged in to like";
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

				if(strlen($comment_text) > 0){
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;

					if($this->galleryModel->imageExists($id_image)){					
						if (isset($_SESSION['user_id'])){
							if($this->galleryModel->saveComment($id_user, $id_image, $comment_text)){
								$id_comment = $this->galleryModel->lastInsertId();
								$json['comment_info'] = $this->galleryModel->getOneComment($id_comment);
								$json['valid'] = true;
								$json['message'] = "Comment has been saved";
								
								// $json['id_image'] = $id_image;
								// $json['id_user'] = $id_user;
								$json['comment_total'] =  $this->galleryModel->commentCount($id_image);
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
				$json['message'] = "Seems like you forgot to write your commment";
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
					$json['message2'] = "id_comment: " . $id_comment;
					$temp = $this->galleryModel->findImgByComment($id_comment); // CAN'T FIND IMG
					$json['message2'] = "id_image: " . $temp['id_image'];
					if($this->galleryModel->commentExists($id_comment, $id_user)){
						$json['valid'] = true;
						if($this->galleryModel->deleteComment($id_comment)){
							// $json['message'] = "id_comment: " . $id_comment;
							$json['valid'] = true;
							$json['message'] = "Comment was successfully removed";

							// $json['count'] = $this->galleryModel->commentCount($id_image);
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