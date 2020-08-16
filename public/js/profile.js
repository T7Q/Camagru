function switchtab(id_activate){
	const profile = document.getElementById('change-profile');
	const pwd = document.getElementById('change-pwd');
	const notification = document.getElementById('change-notification');
	const profileDiv = document.getElementById('profile-modal');
	const pwdDiv = document.getElementById('pwd-modal');
	const notificationDiv = document.getElementById('notify-modal');
	
	if(profile.hasAttribute("checked")){
		profile.removeAttribute("checked");
	}
	if(id_activate == "change-profile"){
		if(!(profile.parentElement.classList.contains("active"))){
			profile.parentElement.classList.add("active");
			if(profileDiv.classList.contains("d-none")){
				profileDiv.classList.remove("d-none");
			}
			if(!(pwdDiv.classList.contains("d-none"))){
				pwdDiv.classList.add("d-none");
			}
			if(!(notificationDiv.classList.contains("d-none"))){
				notificationDiv.classList.add("d-none");
			}
		}
		if(pwd.parentElement.classList.contains("active")){
			pwd.parentElement.classList.remove("active");
		}
		if(notification.parentElement.classList.contains("active")){
			notification.parentElement.classList.remove("active");
		}
	} else if(id_activate == "change-pwd"){
		if(!(pwd.parentElement.classList.contains("active"))){
			pwd.parentElement.classList.add("active");
			console.log("activated pwd");

			if(pwdDiv.classList.contains("d-none")){
				console.log("remove d-none");
				pwdDiv.classList.remove("d-none");
			}
			if(!(profileDiv.classList.contains("d-none"))){
				profileDiv.classList.add("d-none");
			}
			if(!(notificationDiv.classList.contains("d-none"))){
				notificationDiv.classList.add("d-none");
			}
		}
		if (profile.parentElement.classList.contains("active")){
			profile.parentElement.classList.remove("active");
		}
		if (notification.parentElement.classList.contains("active")){
			notification.parentElement.classList.remove("active");
		}
		
	} else if(id_activate == "change-notification"){
		if(!(notification.parentElement.classList.contains("active"))){
			notification.parentElement.classList.add("active");
			if(notificationDiv.classList.contains("d-none")){
				notificationDiv.classList.remove("d-none");
			}
			if(!(pwdDiv.classList.contains("d-none"))){
				pwdDiv.classList.add("d-none");
			}
			if(!(profileDiv.classList.contains("d-none"))){
				profileDiv.classList.add("d-none");
			}
		}
		if (pwd.parentElement.classList.contains("active")){
			pwd.parentElement.classList.remove("active");
		}
		if (profile.parentElement.classList.contains("active")){
			profile.parentElement.classList.remove("active");
		}
	}
}

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



let profileForm = document.getElementById('profile-form');
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
			console.log("response: " + res['message']);
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}


let pwdForm = document.getElementById('pwd-form');
pwdForm.onsubmit = function (event){
	event.preventDefault();

	data = {};
	data.currentpwd = pwdForm.currentPwd.value;
	data.newpwd = pwdForm.newPwd.value;
	data.confirmpwd = pwdForm.ConfirmPwd.value;
	console.log(pwdForm.currentPwd.value, pwdForm.newPwd.value, pwdForm.ConfirmPwd.value )
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-pwd");
			} else {
				alertBox("failure", res['message'], "alert-pwd");
			}
			console.log("response: " + res['message']);
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserPwd", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}


let notificationToggle= document.getElementById('notification-switch');
notificationToggle.addEventListener('change', function () {
	console.log("change");
	let notification;
	if (notificationToggle.checked) {
		notification = 1;
	  console.log('Checked');
	} else {
	  notification = 0;
	  console.log('Not checked');
	}
	
	notificationToggle.disabled = true;
	// document.getElementsByClassName('custom-switch').disabled = true;
	data = {};
	data.notification = notification;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-notify");
				notificationToggle.disabled = false;
				// document.getElementsByClassName('custom-switch').disabled = false;
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
			console.log("response: " + res['message']);
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/changeUserNotification", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));


  });