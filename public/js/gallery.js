function getPageId(n) {
	return 'article-page-' + n;
}

function getDocumentHeight() {
	const body = document.body;
	const html = document.documentElement;
	
	return Math.max(
		body.scrollHeight, body.offsetHeight,
		html.clientHeight, html.scrollHeight, html.offsetHeight
	);
};

function getScrollTop() {
	return (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
}

function getArticleImage() {
	const image = new Image;
	image.className = 'full_width article-list__item__image--loading border'; 

	image.setAttribute("id", 'id_img' + photo_list[0]['id_image']);
	image.setAttribute("onclick","openModal(this.id)");
	// add source 
	image.src = photo_list[0]['path'];
	
	// Create anchor element. 
	const a = document.createElement('a');
	// Set the href property. 
	a.href = "#";

	a.appendChild(image);


	image.onload = function() {
		image.classList.remove('article-list__item__image--loading');
	};
	
	return a;
}

function getArticle() {
	const card = document.createElement('div');
	card.className = 'col-md-4 mx-auto mt-4';

	const articleImage = getArticleImage();
	const article = document.createElement('div');
	article.className = 'thumbnail';
	article.appendChild(articleImage);
	
	const btn_wrapper = document.createElement('div');
	btn_wrapper.className = 'd-flex justify-content-center card-img-overlay hide';
	btn_wrapper.setAttribute("id", "reaction");

	const btn_like = document.createElement('button');
	btn_like.className = 'btn';
	btn_like.setAttribute("id", 'bodylike' + photo_list[0]['id_image']);
	number_like = photo_list[0]['total_like'];
	btn_like.innerHTML = '<i class="fas fa-heart icon-7x">' + " " + number_like +'</i>';

	if (loggedIn === true){
		btn_like.style.color = photo_list[0]['mylike'] > 0 ? "#ff5011" : "black";
	}

	btn_wrapper.appendChild(btn_like);

	const btn_comment = document.createElement('button');
	btn_comment.className = 'btn';
	btn_comment.setAttribute("id", 'comment_body' + photo_list[0]['id_image']);
	number_comment = photo_list[0]['total_comment'];
	btn_comment.innerHTML = '<i class="fas fa-comment icon-7x">' + " " + number_comment + '</i>';

	btn_wrapper.appendChild(btn_comment);

	card.appendChild(article);
	card.appendChild(btn_wrapper);
	

	// remove from list
	photo_list.shift();
	return card;
}

function getArticlePage(page, articlesPerPage = imagesOnPage) {

	const pageElement = document.createElement('div');
	pageElement.id = getPageId(page);

	let urlpath = window.location.pathname.split('/');
	
	if (!(urlpath[2] === "profiles") && !(urlpath[3] === "user")){
		pageElement.className = 'article-list__page';
	}
	
	const page1stRow = document.createElement('div');
	page1stRow.id = 'row1';

	if (!(urlpath[2] === "profiles") && !(urlpath[3] === "user")){
		page1stRow.className = 'row mt-5';
		
	} else {
		page1stRow.className = 'row';
	}
	pageElement.appendChild(page1stRow);
	
	rowBreaker = articlesPerPage; 

	while (articlesPerPage--) {
		
		if (photo_list.length > 0) {
			if (articlesPerPage < rowBreaker && articlesPerPage >= 0) {
				page1stRow.appendChild(getArticle());
			}
		}
	}
	
	return pageElement;
}

function addPaginationPage(page) {
	const pageLink = document.createElement('a');
	pageLink.href = '#' + getPageId(page);
	pageLink.innerHTML = page;
	
	const listItem = document.createElement('li');
	listItem.className = 'article-list__pagination__item';
	listItem.appendChild(pageLink);
	
	articleListPagination.appendChild(listItem);
	
	if (page === 2) {
		articleListPagination.classList.remove('article-list__pagination--inactive');
	}
}

function fetchPage(page) {
	articleList.appendChild(getArticlePage(page));
}

function addPage(page) {
	fetchPage(page);
	addPaginationPage(page);
}


let db_data = [];
const articleList = document.getElementById('article-list');
const articleListPagination = document.getElementById('article-list-pagination');
let length = 0
let page = 0


let photo_list = [];
let loggedIn = false;



function getContent(galleryType = "") {
	data = {};
	let urlpath = window.location.pathname.split('/');
	let path;
	if (urlpath[2] === "galleries" && urlpath[3] === "all"){
		path = "/" + firstPath + "/galleries/getimages";
		data.id_user_for_gallery = 0;
	} else if (urlpath[2] === "profiles" && urlpath[3] === "user" && urlpath[4] !== null){
		path = "/" + firstPath + "/galleries/getimages/" + urlpath[4];
		data.id_user_for_gallery = urlpath[4];
	} else {
		path = "incorrect path";
		window.location.href = firstPath + "/galleries/all";
	}

	data.gallery_type = galleryType == "" ? "none" : galleryType;
	
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			temp = JSON.parse(this.responseText);
			db_data = temp['res'];
			loggedIn = temp['loggedIn'];

			if(temp['valid'] === true){
				let i;
				length = db_data.length
				if (db_data.length > 0){
					for (i = 0; i < db_data.length; i++){
						photo_list[i] = db_data[i];
					}
					for (i = 0; i < photo_list.length; i++){
						photo_list[i]['path'] = "/" + firstPath + "/" + photo_list[i]['path'];
					}
				}
	
				urlpath = window.location.pathname.split('/');
				if (urlpath[2] === "profiles" && urlpath[3] === "user"){
					document.getElementById("article-list-pagination").classList.add("d-none");
					document.getElementById("article-list").classList.remove("mt-5");
					document.getElementById("article-list").classList.add("mt-1");
				}
				
				if (photo_list.length > 0) {
					addPage(++page);
				}
			} else {
				alertBox("failure", temp['message'], "alert-body");
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/galleries/getimages", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
  }


window.onload = function (){
	getContent();
}


function scrollReaction() {
	let content_height = articleList.offsetHeight;
	let current_y = window.innerHeight + window.pageYOffset;
	if (current_y >= content_height){
		if (photo_list.length > 0) {
			addPage(++page);
		}
	}
}



let windowHeight = window.innerHeight + window.pageYOffset;
let imagesOnPage = 12;

// calculate how many images show on the page
if (windowHeight < 1200) {
	imagesOnPage = 12;
} else if (windowHeight < 1800) {
	imagesOnPage = 24;
} else if (windowHeight < 2500) {
	imagesOnPage = 36;
} else {
	imagesOnPage = 48;
}


window.onscroll = function () {
	scrollReaction();
}

function removeGallery() {
	document.getElementById("article-list").innerHTML= "";
	document.getElementById("article-list-pagination").innerHTML= "";
}


// if Gallery is loaded on Profile page
if (document.getElementById("my-gallery")){
	let galleryType;
	document.getElementById("my-gallery").addEventListener("change", function(e) {
		let galleryType = e.target.id;
		removeGallery()
		page = 0;
		getContent("my-gallery");
		
	});
	document.getElementById("follow-gallery").addEventListener("change", function(e) {
		page = 0;
		removeGallery()
		getContent("follow-gallery");
	});
}

