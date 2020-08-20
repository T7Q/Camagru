<?php
	class Comments extends Controller {

		public function __construct(){
			$this->commentModel = $this->model('Comment'); 
			$this->galleryModel = $this->model('Gallery'); // get img owner
			$this->emailModel = $this->model('Email'); // to send email
			$this->userModel = $this->model('User'); // get user email
			$this->profileModel = $this->model('Profile'); // to get notification settings
		}


		public function postComment() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$data = json_decode($_POST['data'], true);
					$temp = explode("post", $data['id_image']);
					$id_image = $temp[1];

					// The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
					// $comment_text = filter_var($data['comment'], FILTER_SANITIZE_STRING);
					$comment_text = htmlspecialchars($data['comment']);

					$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;

					if(strlen($comment_text) > 0 && strlen($comment_text) < 150){
						$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;

						if($this->galleryModel->imageExists($id_image)){					
							if (isset($_SESSION['user_id'])){
								if($this->commentModel->saveComment($id_user, $id_image, $comment_text)){
									$id_comment = $this->commentModel->getlastInsertId();
									$comment_info = $this->commentModel->getOneComment($id_comment);
									$json['comment_info'] = $comment_info;
									$json['idLoggedUser'] = $_SESSION['user_id'];
									$json['comment_total'] =  $this->commentModel->commentCount($id_image);
									$json['valid'] = true;
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
									$json['message'] = "Could not save your comment";
								}
							} else {
								$json['valid'] = false;
								$json['message'] = "Image that does not exist can not be commented";
							}
						}
					} else {
						$json['valid'] = false;
					$json['message'] = "Comment must contain between 1 and 150 characters";
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

					$id_comment = $data['id_comment'];

					$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;

					if (isset($_SESSION['user_id'])){					
						$data = $this->commentModel->findImgByComment($id_comment);
						$json['id_image'] = $data->id_image;
						if($this->commentModel->commentExists($id_comment, $id_user)){
							$json['valid'] = true;
							if($this->commentModel->deleteComment($id_comment)){
								$json['valid'] = true;
								$json['message'] = "Comment was successfully removed";
								$json['count'] = $this->commentModel->commentCount($data->id_image);
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