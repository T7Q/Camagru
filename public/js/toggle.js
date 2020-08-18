// Toggle button in Profile Modal

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

			if(pwdDiv.classList.contains("d-none")){
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