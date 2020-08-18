// buttons use as profile pic -> update database 
// follow/unfollow

// buttons
const likeModal = document.getElementById('pop-up-reaction').firstElementChild;
const commentModal = document.getElementById('pop-up-reaction').lastElementChild;
const followModal = document.getElementById('pop-up-follow').firstElementChild;
const deleleModal = document.getElementById('pop-up-del').firstElementChild;
const setAvatar = document.getElementById('set-profile-img').firstElementChild;
const imgModal = document.getElementById('pop-up-img');
const usernameModal = document.getElementById('pop-up-username');
const postComment = document.getElementById('post-comment');
const urlpath = '/' + window.location.pathname.split('/')[1];

// const deleteComment = function (div) {
function deleteComment(){
	let temp = this.getAttribute("id");
	let id_comment = temp.split('delcomment')[1];

	data = {};
	data.id_comment = id_comment;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				alertBox("success", res['message'], "alert-modal")
				document.getElementById("id_comment" + id_comment).remove();
				
				document.getElementById('comment_body' + res['id_image']).firstElementChild.innerHTML = res['count'];
				document.getElementById('comment' + res['id_image']).firstElementChild.innerHTML = res['count'];

			} else {
				alertBox("failure", res['message'], "alert-modal");
				return false;
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/deletecomment", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

function createComment(id_comment, username, comment_text, owncomment){
	const comment = document.createElement('p');
	comment.className = 'row d-flex flex-row align-items-center';
	comment.setAttribute("id", "id_comment" + id_comment);
	if (owncomment === 1){
		comment.innerHTML = "<span class=\"font-weight-bold mr-1 small p-2\" >" + 
		username+ "</span><span class=\"font-weight-light small p-2 text-wrap\">" + 
		comment_text + "</span>\
		<button " + "id=\"delcomment" + id_comment+ "\"" +"type=\"button\" class=\"btn btn-link btn-sm rounded ml-auto p-2\">\
		<i class=\"far fa-times-circle closeicon\"></i>\
		</button>\
		";
		comment.lastElementChild.addEventListener('click', deleteComment);
	} else {
		comment.innerHTML = "<span class=\"font-weight-bold mr-1 small p-2\" >" + 
			username+ "</span><span class=\"font-weight-light small p-2\">" + 
			comment_text + "</span>";
	}
	return comment;
}

function getDetails(param){
    data = {};
	data.id_image = param;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			res = JSON.parse(this.responseText);
			db_data = res['message'];
            db_data[0].path = "/" + firstPath + "/" + db_data[0].path;

            imgModal.src = db_data[0].path;
			usernameModal.innerHTML = db_data[0].username;
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
			

			// if (res['loggedIn'] === true){
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
				console.log("my like: "  + db_data[0].my_like);
				likeModal.firstElementChild.style.color = db_data[0].my_like > 0 ? "#ff5011" : "black";

			} else {
				followModal.classList.add("d-none");
				likeModal.firstElementChild.style.color = "black";
			}
			
			console.log("before updat");
			console.log("before update" + db_data[0].id_user + "loggedin " +idLoggedUser);
			if((res['loggedIn'] === true) && (db_data[0].id_user == idLoggedUser)){
				console.log("IF");
				
				if(document.getElementById('pop-up-del').classList.contains("d-none")){
					document.getElementById('pop-up-del').classList.remove("d-none");
				}
				deleleModal.setAttribute("id", "del_img" + db_data[0].id_image);

				// set as profile image
				if(document.getElementById('set-profile-img').classList.contains("d-none")){
					document.getElementById('set-profile-img').classList.remove("d-none");
				}
				setAvatar.setAttribute("id", "avatar" + db_data[0].id_image);
				
			} else {
				document.getElementById('pop-up-del').classList.add("d-none");
				document.getElementById('set-profile-img').classList.add("d-none");
			}
			likeModal.setAttribute("id", "modallike" + db_data[0].id_image);
			likeModal.setAttribute("onclick","like(this.id)");
			commentModal.setAttribute("id", "comment" + db_data[0].id_image);
			followModal.setAttribute("id", "follow" + db_data[0].id_user);
			followModal.setAttribute("onclick","follow(this.id)");
			postComment.setAttribute("id", "post" + db_data[0].id_image);
			document.getElementById('user-link').setAttribute('href', "/" + firstPath + "/profiles/user/" + db_data[0].id_user);
			document.getElementById("user-avatar").src = "/" + firstPath + "/" + res['avatar'].profile_pic_path; /// here

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
deleleModal.addEventListener('click', function(e) {
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
	xmlhtt.open('POST', "/" + firstPath + "/galleries/deleteImgDb", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}, false);


// event listerner on "Set as profile" image button (only available for image owners)
setAvatar.addEventListener('click', function(e) {
    data = {};
	data.id_image = e.target.id;
	console.log("id_img:" + e.target.id)
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



function like (id_image_input){
	// check if like pressed in gallery or modal box
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
				
				// update likes in the modal box					
				let img_modal = document.getElementById("modallike" + id_image);
				img_modal.firstElementChild.style.color = res['message'] === "true" ? "#ff5011" : "#000000";
				img_modal.firstElementChild.innerHTML = res['count'];					
				
				// update likes in the gallery
				let img_body = document.getElementById("bodylike" + id_image);
				// img_body.style.color = res['message'] === "true" ? "#ff5011" : "#000000";
				img_body.firstElementChild.innerHTML = res['count'];
			} else {
				if (type[0] == "modal"){
					alertBox("failure", res['message'], "alert-modal");
				} else {
					alertBox("failure", res['message'], "alert-body");
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/like", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}
	


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



postComment.addEventListener('submit', function(e) {
	event.preventDefault();
	data = {};
	data.id_image = e.target.id;
	// let new_id = e.target.id;
	data.comment = document.getElementById("post-comment-text").value;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			loggedIn = res['loggedIn'];
			idLoggedUser = res['idLoggedUser'];
			if (loggedIn === true){
				if(res['valid'] === true){
					postComment.reset();
					let id_comment = res['comment_info'].id_comment;
					let username = res['comment_info'].username;
					let comment_text = res['comment_info'].comment;
					let button = idLoggedUser == res['comment_info'].id_user ? 1 : 0;
					let comment = createComment(id_comment, username, comment_text, button);
					document.getElementById('comment-list').appendChild(comment);
					commentModal.firstElementChild.innerHTML = "  " + res['comment_total'];
					document.getElementById('comment_body' + res['comment_info'].id_image).firstElementChild.innerHTML = res['comment_total'];
					alertBox("success", res['message'], "alert-modal");
					console.log("id_user", res['comment_info'].id_comment);
					console.log("message", res['message']);
				} else {
					alertBox("failure", res['message'], "alert-modal");
				}
			} else {
				alertBox("failure", "You need to be logged in to leave a comment", "alert-modal");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/postcomment", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));

}, false);
