// Fill Gallery Image Modal box, delete image

const imgModal = document.getElementById('pop-up-img');
const deleteImg = document.getElementById('pop-up-del').firstElementChild;
const usernameModal = document.getElementById('pop-up-username');
const urlpath = '/' + window.location.pathname.split('/')[1];

// Get data and fill Image modal box
function getDetails(param){
    data = {};
	data.id_image = param;
	
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			db_data = res['message'];

			// add image src
            db_data[0].path = "/" + firstPath + "/" + db_data[0].path;
			imgModal.src = db_data[0].path;
			
			// add username
			usernameModal.innerHTML = db_data[0].username;

			// add comments
			temp_list = res['comment_list'];
			temp_len = temp_list.length;

			// clear previously attached comments 
			document.getElementById('comment-list').innerHTML = "";

			let idLoggedUser = res['loggedIn'] === true ? res['idLoggedUser'] : 0;
			// append all comments to the DOM
			for (let i = 0; i < temp_len; i++){
				let id_comment = temp_list[i]['id_comment'];
				let username = temp_list[i]['username'];
				let comment_text = temp_list[i]['comment']
				let button = idLoggedUser == temp_list[i]['id_user'] ? 1 : 0;
				let comment = createComment(id_comment, username, comment_text, button);
				document.getElementById('comment-list').appendChild(comment);
			}
			
			// show likes in red for likes owners
			if (res['loggedIn'] === true){
				likeModal.firstElementChild.style.color = db_data[0].my_like > 0 ? "#ff5011" : "black";
			} else {
				likeModal.firstElementChild.style.color = "black";
			}

			// add follow button for non-logged in user images
			if ((res['loggedIn'] === true) && (db_data[0].id_user != idLoggedUser)){
				if(followModal.classList.contains("d-none")){
					followModal.classList.remove("d-none");
				}
				if (res['follow'] === true){
					
					followModal.classList.remove("btn-outline-success");
					followModal.classList.add("btn-outline-secondary");
					followModal.innerHTML = "Unfollow";
				} else {
					followModal.classList.remove("btn-outline-secondary");
					followModal.classList.add("btn-outline-success");
					followModal.innerHTML = "Follow";
				}
			} else {
				followModal.classList.add("d-none");
				followModal.setAttribute("id", "follow");
			}
			
			// add set as profile pic for image owners

			if((res['loggedIn'] === true) && (db_data[0].id_user == idLoggedUser)){
				
				if(document.getElementById('pop-up-del').classList.contains("d-none")){
					document.getElementById('pop-up-del').classList.remove("d-none");
				}
				deleteImg.setAttribute("id", "del_img" + db_data[0].id_image);
				
				// set as profile image
				if(document.getElementById('set-profile-img').classList.contains("d-none")){
					document.getElementById('set-profile-img').classList.remove("d-none");
				}
				setAvatar.setAttribute("id", "avatar" + db_data[0].id_image);
				
			} else {
				document.getElementById('pop-up-del').classList.add("d-none");
				document.getElementById('set-profile-img').classList.add("d-none");
				deleteImg.setAttribute("id", "del_img");
				setAvatar.setAttribute("id", "avatar");
			}

			// update id for traking
			likeModal.setAttribute("id", "modallike" + db_data[0].id_image);
			likeModal.setAttribute("onclick","like(this.id)");
			commentModal.setAttribute("id", "comment" + db_data[0].id_image);
			
			followModal.setAttribute("id", "follow" + db_data[0].id_user);
			followModal.setAttribute("onclick","follow(this.id)");
			postComment.setAttribute("id", "post" + db_data[0].id_image);

			// add link to user profile
			document.getElementById('user-link').setAttribute('href', "/" + firstPath + "/profiles/user/" + db_data[0].id_user);

			// add avatar 
			document.getElementById("user-avatar").src = "/" + firstPath + "/" + res['avatar'].profile_pic_path;

			// add total amount of likes and comments
			likeModal.firstElementChild.innerHTML = db_data[0].total_like;
			commentModal.firstElementChild.innerHTML = db_data[0].total_comment;
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/getImageData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

// event listerner on "Delete" image button (only available for image owners)
deleteImg.addEventListener('click', function(e) {
    data = {};
    data.id_image = e.target.id;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-modal");
				setTimeout(function(){
					closeModal();
				}, 5000);
				location.reload()
			} else {
				alertBox("failure", res['message'], "alert-modal");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/images/delete", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}, false);