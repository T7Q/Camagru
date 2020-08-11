// private
// buttons use as profile pic -> update database 
// button remove iamge
// chat
// like
// follow/unfollow
// remove comment

// buttons
const likeModal = document.getElementById('pop-up-reaction').firstElementChild;
const commentModal = document.getElementById('pop-up-reaction').lastElementChild;
const followModal = document.getElementById('pop-up-follow').firstElementChild;
const deleleModal = document.getElementById('pop-up-del').firstElementChild;
const imgModal = document.getElementById('pop-up-img');
const usernameModal = document.getElementById('pop-up-username');

function getDetails(param){
    data = {};
    data.id_image = param;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
            temp = JSON.parse(this.responseText);
			db_data = temp['message'];
            db_data[0].path = "/" + firstPath + "/" + db_data[0].path;
            // console.log("return: " + db_data[0]['username']); // OTHER OPTION
            // console.log("Applied id like: " + db_data[0].id_image);

            imgModal.src = db_data[0].path;
			usernameModal.innerHTML = db_data[0].username;
			deleleModal.setAttribute("id", "del_img" + db_data[0].id_image);
			likeModal.setAttribute("id", "like" + db_data[0].id_image);
			commentModal.setAttribute("id", "comment" + db_data[0].id_image);
			followModal.setAttribute("id", "follow" + db_data[0].id_user);

			likeModal.firstElementChild.innerHTML = "  " + db_data[0].total_like;
			likeModal.firstElementChild.style.color = db_data[0].my_like > 0 ? "#ff5011" : "#bcb7b7";
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/getImageData", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}



// event listerner on "Delete" button
deleleModal.addEventListener('click', function(e) {
	// console.log("element id:" + e.target.id );
    data = {};
    data.id_image = e.target.id;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
            temp = JSON.parse(this.responseText);
			db_data = temp['message'];
			closeModal();
			location.reload();
			// ? ADD ALERT THAT IT HAS BEEN DELETED
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/deleteImgDb", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));

}, false);


likeModal.addEventListener('click', function(e) {
	data = {};
	data.id_image = e.target.id;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			temp = JSON.parse(this.responseText);
			db_data = temp['message'];
			// console.log("liked: " + temp['message']);
			// console.log("COUNT liked: " + temp['count']);
			likeModal.firstElementChild.style.color = temp['message'] === "true" ? "#ff5011" : "#bcb7b7";
			likeModal.firstElementChild.innerHTML = "  " + temp['count'];

		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/like", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));

}, false);
	
