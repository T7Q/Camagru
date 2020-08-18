// Update user profile pic with any image from user gallery
const setAvatar = document.getElementById('set-profile-img').firstElementChild;

// event listerner on "Set as profile" image button (only available for image owners)
setAvatar.addEventListener('click', function(e) {
    data = {};
	data.id_image = e.target.id;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				document.getElementById("user-avatar").src = "/" + firstPath + "/" + res['path'];
				alertBox("success", res['message'], "alert-modal");
				if(document.getElementById("profile-pic")){
					document.getElementById("profile-pic").src = "/" + firstPath + "/" + res['path'];
				}
			} else {
				alertBox("failure", res['message'], "alert-modal");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/setAvatar", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}, false);