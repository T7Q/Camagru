<?php
	/*
	* Base controller
	* Loads the models and views
	*/

	class Controller {
		// load model
		public function model($model) {
			// Require model file
			if (file_exists('./app/models/' . $model . '.php')) {
				require_once './app/models/' . $model . '.php';
			} else {
				echo "could not find model";
				return null;
			}
			// Instatiate model
			return new $model();
		}

		// Load view
		public function view($view, $data = []) {
			// Check for view file
			if(file_exists('./app/views/' . $view . '.php')){
			  require_once './app/views/' . $view . '.php';
			} else {
			  // View does not exist
			  die('View does not exist');
			}
		}

		public function isAjaxRequest() {
			return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
				$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
		}

		public function redirect($page) {
			header('location: ' . URLROOT . '/' . $page);
			header('Connection: close');
			exit;
		}

		public function flash($name = '', $message = '', $class = '') {
			if($class == 'success') {
				$class = 'alert alert-success';
			} else {
				$class = 'alert alert-danger';
			}
			if(!empty($name)){
				if(!empty($message) && empty($_SESSION[$name])){
				if(!empty($_SESSION[$name])){
					unset($_SESSION[$name]);
				}
	
				if(!empty($_SESSION[$name. '_class'])){
					unset($_SESSION[$name. '_class']);
				}
	
				$_SESSION[$name] = $message;
				$_SESSION[$name. '_class'] = $class;
				} elseif(empty($message) && !empty($_SESSION[$name])){
					$class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
					echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
					unset($_SESSION[$name]);
					unset($_SESSION[$name. '_class']);
				}
			}
		}

		// Check that user is logged in and exists in db. Otherwise redirect to gallery page
		public function checkAccessRights() {
			if (isset($_SESSION['user_id'])) {
				$id_user = $_SESSION['user_id'];
				
				if ($this->model('User')->userExists($id_user)) {
					return $id_user;
				} else {
					$this->flash('loggedin', 'You need to be logged in', '');
					$this->view('users/login');
					exit();
				}
			} else {
				$this->flash('loggedin', 'You need to be logged in', '');
				$this->view('users/login');
				exit();
			}
		}

	}
?>