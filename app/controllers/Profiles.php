<?php

// user profile page

class Profiles extends Controller {
	public function __construct() {
		$this->userModel = $this->model('User');
		$this->galleryModel = $this->model('Gallery');
		$this->profileModel = $this->model('Profile');
	}



	public function user($id_user_requested = '') {

		// REDIRECT TO ERROR PAGE IF NOT LOGGED IN 
		// ADD SAME TO PHOTOBOOTH
		$this->checkAccessRights();

		if (!($id_user_requested == '')){
			// Init data
			$data = [
				'username' => "",
				'images' => "",
				'following' => "",
				'followers' => "",
				'notification' => "",
				'show_edit_button' => "",
				'avatar' => "",
			];
			
			$id_user = $id_user_requested;
			
			if ($this->userModel->userExists($id_user)){
				// check if requested profile is for logged in user
				$loggedin_user = $_SESSION['user_id'];
				$data['show_edit_button'] = ($loggedin_user == $id_user) ? 1 : 0;

				$data['following'] = $this->galleryModel->followingCount($id_user);
				$data['followers'] = $this->galleryModel->followersCount($id_user);
				$temp = $this->profileModel->getUsername($id_user);
				$data['username'] = ucwords($temp->username);
				$temp = $this->profileModel->getNotificationSetting($id_user);
				$data['notification'] = $temp->notification_preference;
				$data['images'] = $this->profileModel->imageCount($id_user);
				$temp = $this->profileModel->getAvatar($id_user);
				$data['avatar'] = $temp->profile_pic_path;
				//== null ? "/public/img/general/avatar.png" : $temp->profile_pic_path;
				
				$this->view('profile/userprofile', $data);
			} else {
				$this->redirect('galleries/all');
			}
		} else{
			$this->redirect('galleries/all');
		}
	}


	public function getProfileData(){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);

				$id_user = $_SESSION['user_id'];
				// $new = $this->galleryModel->getUserData($id_user);
				$json['data'] = $this->profileModel->getUserData($id_user);
                $json['message'] = "Profile data found";
            } else {
				$json['message'] = "Oops, something went wrong getting your profile data";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}

	}

	public function changeUserData(){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$form_data = json_decode($_POST['data'], true);
				
				$id_user = $_SESSION['user_id'];

				$data = [
					'id_user' => $id_user,
					'first_name' => trim(filter_var($form_data['first_name'], FILTER_SANITIZE_STRING)),
					'last_name' => trim(filter_var($form_data['last_name'], FILTER_SANITIZE_STRING)),
					'username' => trim(filter_var($form_data['username'], FILTER_SANITIZE_STRING)),
					'email' => filter_var($form_data['email'], FILTER_SANITIZE_EMAIL),
					'first_name_err' => '',
					'last_name_err' => '',
					'username_err' => '',
					'email_err' => ''
				];
				$this->userModel->validateEmailUsername($data);
				if (empty($data['email_err']) && empty($data['username_err']) && empty($data['first_name_err']) && empty($data['last_name_err'])) {
					if($this->profileModel->updateUserData($id_user, $data['email'], $data['last_name'], $data['first_name'], $data['username'])){
						$json['valid'] =  true;
						$json['message'] = "Your profile data was successfully updated";
					} else {
						$json['valid'] = false;
						$json['message'] = "Oops, something went wrong saving updated data to the database";
					}
				} else {
					$json['valid'] = false;
					$temp1 = array_slice($data, 5);
					$temp2 = implode(" ",$temp1);
					$json['message'] = $temp2;
				}
            } else {
				$json['valid'] = false;
				$json['message'] = "Oops, something went wrong getting your profile data";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}

	public function changeUserPwd(){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$form_data = json_decode($_POST['data'], true);
				
				$id_user = $_SESSION['user_id'];

				$data = [
					'id_user' => $id_user,
					'oldpwd' => trim($form_data['currentpwd']),
					'password' => trim($form_data['newpwd']),
					'confirm_password' => trim($form_data['confirmpwd']),
					'oldpwd_err' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];
				$json['valid'] = false;
				$json['message'] = $data['oldpwd'];
				
				if($this->profileModel->validateUserbyPwd($id_user, $data['oldpwd'])){
					$json['valid'] = true;
					$json['message'] = "got in";
					
					$this->userModel->validatePasswordFormat($data);
					if (empty($data['password_err'])){
						$this->userModel->validateConfirmPassword($data);
						if (empty($data['confirm_password_err'])){
							$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
							// Update database pwd
							if ($this->profileModel->updateUserPwd($data['id_user'], $data['password'])) {	
								$json['valid'] = true;
								$json['message'] = "You password was successfully updated";
							} else {
								$json['valid'] = false;
								$json['message'] = "Something went wrong saving your new pwd to database";
							}

						} else {
							$json['valid'] = false;
							$json['message'] = $data['confirm_password_err'];
							// $json['message'] = "Error in confirm password";
						}
					} else {
						$json['valid'] = false;
						$json['message'] = $data['password_err'];
						// $json['message'] = "Error in new password";
					}	
				} else {
					$json['valid'] = false;
					// $json['message'] = $data['oldpwd'];
					$json['message'] = "Current password is wrong";
				}
            } else {
				$json['valid'] = false;
				$json['message'] = "Oops, something went wrong getting your profile data";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}



	public function changeUserNotification(){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$new_setting = $data['notification'];
				$id_user = $_SESSION['user_id'];

				if ($this->profileModel->updateNotification($id_user,$new_setting)){
					$json['valid'] = true;
					$updated_setting = $this->profileModel->getNotificationSetting($id_user);
					$json['notification'] = $updated_setting;
					if($updated_setting->notification_preference == 1){
						$json['message'] = "Notification turned ON";
					} else {
						$json['message'] = "Notification turned OFF";
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "Something went wrong saving your preferences to the database";
				}
            } else {
				$json['valid'] = false;
				$json['message'] = "Oops, something went wrong getting your notificatin data";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}


	public function getFollowersList() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
			
				$id_user = $data['id_user'];
				$type = $data['type'];

				$json['type'] = $type;
				if ($type == "following"){
					if($this->profileModel->userFollowingExists($id_user)){
						$json['valid'] = true;
						$json['user-list'] = $this->profileModel->getFollowingList($id_user);
						$json['message'] = "following";
					} else {
						$json['message'] = "You dont follow anyone, visit Gallery";
						$json['valid'] = false;
					}
				} else if ($type == "followers"){
						if($this->profileModel->userFollowerExists($id_user)){
							$json['valid'] = true;
							$json['user-list'] = $this->profileModel->getFollowerList($id_user);
							$json['message'] = "followers";
						} else {
							$json['message'] = "Seems like you dont have followers yet";
							$json['valid'] = false;
						}
				} else {
					$json['message'] = "Error occured getting followers data";
					$json['valid'] = false;
				}

				
			} else {
				$json['message'] = "Oops, something went wrong getting data for checking Followers";
				$json['valid'] = false;
			}
			echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}

}