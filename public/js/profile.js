// Load Profile  and edit profile info

let profileForm = document.getElementById('profile-form');
let pwdForm = document.getElementById('pwd-form');
let notificationToggle= document.getElementById('notification-switch');


function getProfileData(){
	data = {};
	clearProfileFormError();
	clearPwdFormError();
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
            document.getElementById('username-form').setAttribute("value", res['data'].username);
            document.getElementById('first-name-form').setAttribute("value", res['data'].first_name);
            document.getElementById('last-name-form').setAttribute("value", res['data'].last_name);
            document.getElementById('email-form').setAttribute("value", res['data'].email);
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/getProfileData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}


profileForm.onsubmit = function (event){
	event.preventDefault();

	data = {};
	data.username = profileForm.username.value;
	data.last_name = profileForm.last_name.value;
	data.first_name = profileForm.first_name.value;
	data.email = profileForm.email.value;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			clearProfileFormError();
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-profile");

				username_err.previousElementSibling.classList.add('is-valid');
				first_name_err.previousElementSibling.classList.add('is-valid');
				last_name_err.previousElementSibling.classList.add('is-valid');
				email_err.previousElementSibling.classList.add('is-valid');

				document.getElementById("username").innerHTML = "";
				document.getElementById("username").innerHTML = res['username'];

			} else {
				for (var key in res['error']) {
					if(res['error'][key] != undefined){
						temp = res['error'][key];
						if(temp.length > 0){
							element = document.getElementById(key);
							element.previousElementSibling.classList.add('is-invalid');
							element.innerHTML = res['error'][key];
						}
					}
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}


function clearProfileFormError(){
	const error = [ 
		"username_err",
		"first_name_err",
		"last_name_err",
		"email_err",
	];
	for (let i = 0; i < error.length; i++) {
		element = document.getElementById(error[i]);

		if(element.previousElementSibling.classList.contains("is-invalid")){
			element.previousElementSibling.classList.remove("is-invalid");
			element.innerHTML = "";
		}
		if(element.previousElementSibling.classList.contains("is-valid")){
			element.previousElementSibling.classList.remove("is-valid");
		}
	}
}


function clearPwdFormError(){
	const error = [ 
		"old_password_err",
		"password_err",
		"confirm_password_err",
	];
	for (let i = 0; i < error.length; i++) {
		
		if(document.getElementById(error[i])){
			element = document.getElementById(error[i]);

			if(element.previousElementSibling.classList.contains("is-invalid")){
				element.previousElementSibling.classList.remove("is-invalid");
				element.innerHTML = "";
			}
			if(element.previousElementSibling.classList.contains("is-valid")){
				element.previousElementSibling.classList.remove("is-valid");
			}
		}
	}
}

// // select elements to update for warning messages


pwdForm.onsubmit = function (event){
	event.preventDefault();

	data = {};
	data.currentpwd = pwdForm.currentPwd.value;
	data.newpwd = pwdForm.newPwd.value;
	data.confirmpwd = pwdForm.ConfirmPwd.value;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			clearPwdFormError();
			if (res['valid'] === true){
				// valid input
				let old_password_err = document.getElementById("old_password_err");
				let password_err = document.getElementById("password_err");
				let confirm_password_err = document.getElementById("confirm_password_err");
				old_password_err.previousElementSibling.classList.add('is-valid');
				password_err.previousElementSibling.classList.add('is-valid');
				confirm_password_err.previousElementSibling.classList.add('is-valid');
				alertBox("success", res['message'], "alert-pwd");
			} else {
				for (var key in res['error']) {
					if(res['error'][key] != undefined){
						element = document.getElementById(key);
						element.previousElementSibling.classList.add('is-invalid');
						element.innerHTML = res['error'][key];
					}
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserPwd", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

notificationToggle.addEventListener('change', function () {
	let notification;
	if (notificationToggle.checked) {
		notification = 1;
	} else {
	  notification = 0;
	}
	
	notificationToggle.disabled = true;
	data = {};
	data.notification = notification;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-notify");
				notificationToggle.disabled = false;
				if (res['notification'] === 1){
					if(!notificationToggle.checked){
							notificationToggle.addAttribute("checked");
						}
					} else {
					if(notificationToggle.checked){
						notificationToggle.removeAttribute("checked");
					}
				}
			} else {
				alertBox("failure", res['message'], "alert-notify");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserNotification", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));


  });


 function getFollowersData(param){
	data = {};
	data.type = param.split('modal')[1];
	let urlpath = window.location.pathname.split('/');
	let path;
	if (urlpath[2] === "profiles" && urlpath[3] === "user" && urlpath[4] !== null){
		path = "/" + firstPath + "/galleries/getimages/" + urlpath[4];
		data.id_user = urlpath[4];
	}
	// clear previously attached followers and header
	document.getElementById('list-user').innerHTML = "";
	document.getElementById("follow-title").innerHTML = "";
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);

			
			let header = res['type'];
			header = header.charAt(0).toUpperCase() + header.slice(1)
			document.getElementById("follow-title").innerHTML = header;

			if (res['valid'] === true){
				let temp_list = res['user-list'];
				let temp_len = temp_list.length;

				// append all comments to the DOM
				for (let i = 0; i < temp_len; i++){			
					let avatarSrc = "/" + firstPath + "/" + res['user-list'][i].profile_pic_path;
					let username = res['user-list'][i].username;
					let accountLink =  "/" + firstPath + "/profiles/user/" + res['user-list'][i].follow_id;

					let div = document.createElement('div');
					div.innerHTML = "\
					<div class=\"ml-2\">\
						<img id='user-avatar' src='" + avatarSrc + "\' alt=\"user avatar\" class=\"avatar img-thumbnail\">\
						<a href=\"" + accountLink + "\">" + username + "</a>\
					</div>";
					document.getElementById('list-user').appendChild(div);
				}
			} else {
				alertBox("failure", res['message'], "alert-follow");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/getFollowersList", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
 }