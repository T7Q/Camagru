// Follow and Unfollow users button in Image modal box

const followModal = document.getElementById('pop-up-follow').firstElementChild;

function follow (id_user_input){
	const type = id_user_input.split("follow");
	const id_user = type[1];
	data = {};
	data.id_user_to_follow = id_user;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			loggedIn = res['loggedIn'];
			
			if (loggedIn === true){
				if ( res['message'] === "follow"){
					followModal.classList.remove("btn-outline-success");
					followModal.classList.add("btn-outline-secondary");
					followModal.innerHTML = "Unfollow";
				} else {
					followModal.classList.remove("btn-outline-secondary");
					followModal.classList.add("btn-outline-success");
					followModal.innerHTML = "Follow";

					// Reload the page, if UNFOLLOW takes place on Profile page in Following gallery
					let urlpath = window.location.pathname.split('/');
					if ((urlpath[2] === "profiles") && (urlpath[3] === "user")){
						alertBox("warning", "Following gallery page will be updated", "alert-modal");
						setTimeout(function(){
							closeModal();
						}, 8000);
						location.reload()
					}
				}
			} else {
					alertBox("failure", res['message'], "alert-modal");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/follow", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}