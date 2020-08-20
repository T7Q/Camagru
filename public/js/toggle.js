// Toggle button in Profile Modal

function switchtab(id_activate){

	let settings = {
		'change-profile' : "profile-modal",
		'change-pwd' : "pwd-modal",
		'change-notification' : "notify-modal",
	}

	let profile = document.getElementById('change-profile');
	if(profile.hasAttribute("checked")){
		profile.removeAttribute("checked");
	} 

	let button;
	let content;
	for (var key in settings) {
		if(key == id_activate){
			button = document.getElementById(key);
			if(!(button.parentElement.classList.contains("active"))){
				button.parentElement.classList.add("active");
			}
			content = document.getElementById(settings[key]);
			if(content.classList.contains("d-none")){
				content.classList.remove("d-none");
			}

		} 
		if (key != id_activate){
			button = document.getElementById(key);
			if (button.parentElement.classList.contains("active")){
				button.parentElement.classList.remove("active");
			}
			content = document.getElementById(settings[key]);
			if(!(content.classList.contains("d-none"))){
				content.classList.add("d-none");
			}
		}
	}
}