// Post and Delet comments

const commentModal = document.getElementById('pop-up-reaction').lastElementChild;
const postComment = document.getElementById('post-comment');


function createComment(id_comment, username, comment_text, owncomment){
	const comment = document.createElement('p');
	comment.className = 'row d-flex flex-row align-items-center';
	comment.setAttribute("id", "id_comment" + id_comment);
	if (owncomment === 1){
		comment.innerHTML = "<span class=\"font-weight-bold mr-1 small p-2\" >" + 
		username+ "</span><i class=\"font-weight-light small p-2 text-wrap\">" + 
		comment_text + "</i>\
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

postComment.addEventListener('submit', function(e) {
	event.preventDefault();
	data = {};
	data.id_image = e.target.id;
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
				} else {
					alertBox("failure", res['message'], "alert-modal");
				}
			} else {
				alertBox("failure", "You need to be logged in to leave a comment", "alert-modal");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/comments/postcomment", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));

}, false);

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
				document.getElementById("id_comment" + id_comment).remove();
				// update comment count in the Modal box and body
				document.getElementById('comment_body' + res['id_image']).firstElementChild.innerHTML = res['count'];
				document.getElementById('comment' + res['id_image']).firstElementChild.innerHTML = res['count'];
			} else {
				alertBox("failure", res['message'], "alert-modal");
				return false;
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/comments/deletecomment", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}