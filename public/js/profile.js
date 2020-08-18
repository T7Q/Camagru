// Load Profile  and edit profile info

let profileForm = document.getElementById('profile-form');
let pwdForm = document.getElementById('pwd-form');
let notificationToggle= document.getElementById('notification-switch');

function getProfileData(){
    data = {};
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
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-profile");
			} else {
				alertBox("failure", res['message'], "alert-profile");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

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
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-pwd");
			} else {
				alertBox("failure", res['message'], "alert-pwd");
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

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				let header = res['type'];
				header = header.charAt(0).toUpperCase() + header.slice(1)
				document.getElementById("follow-title").innerHTML = header;
				temp_list = res['user-list'];
				temp_len = temp_list.length;

				alertBox("success", res['message'], "alert-notify");
				// clear previously attached followers
				document.getElementById('list-user').innerHTML = "";
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
				alertBox("failure", res['message'], "alert-notify");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/getFollowersList", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
 }