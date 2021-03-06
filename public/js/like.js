const likeModal = document.getElementById('pop-up-reaction').firstElementChild;

function like (id_image_input){
	// get id_img from element id
	const type = id_image_input.split("like");
	const id_image = type[1];
	data = {};
	data.id_image = id_image;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			loggedIn = res['loggedIn'];
			if (loggedIn === true){
				// for Logged in users update the DOM
				if (res['valid'] == true){
					// update likes in the modal box					
					let img_modal = document.getElementById("modallike" + id_image);
					img_modal.firstElementChild.style.color = res['message'] === "red_color" ? "#ff5011" : "#000000";
					img_modal.firstElementChild.innerHTML = res['count'];					
					
					// update like count in main gallery
					let img_body = document.getElementById("bodylike" + id_image);
					img_body.firstElementChild.innerHTML = res['count'];
				} else {
					alertBox("failure", res['message'], "alert-modal");
				}
			} else {
				// show error for not logged in users
				alertBox("failure", res['message'], "alert-modal");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/likes/likeimage", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}