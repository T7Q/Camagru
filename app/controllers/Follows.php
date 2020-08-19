<?php
	class Follows extends Controller {

		public function __construct(){
			$this->followModel = $this->model('Follow');
		}

		public function followuser() {
			if ($this->isAjaxRequest()) {
				if (isset($_POST['data'])) {
					$data = json_decode($_POST['data'], true);
					$id_user_to_follow = $data['id_user_to_follow'];
	
					$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
					$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
	
					if (isset($_SESSION['user_id'])){						
						if($this->followModel->alreadyFollow($id_user, $id_user_to_follow)){
							// unfollow
							if($this->followModel->unfollowUser($id_user, $id_user_to_follow)){
								$json['message'] = "unfollow";
	
							} else{
								$json['message'] = "Smth went wrong in following this user";
							}
						} else {
							// follow
							if($this->followModel->followUser($id_user, $id_user_to_follow)){
								$json['message'] = "follow";
	
							} else{
								$json['message'] = "Smth went wrong in following this user";
							}
						}
						$json['following'] = $this->followModel->followingCount($id_user);
						$json['followers'] = $this->followModel->followersCount($id_user);
	
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
	} 
?>