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
	console.log("GOT TO PROFILE DATA");
    data = {};
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			db_data = res['message'];

            // imgModal.src = db_data[0].path;
			// usernameModal.innerHTML = db_data[0].username;
			// temp_list = res['comment_list'];
			// temp_len = temp_list.length;

			// clear previously attached comments 
			document.getElementById('comment-list').innerHTML = "";
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/profiles/getProfileData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

