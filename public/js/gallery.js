// infinite scroll
// button like active 
// onclick open image.php

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
	// image.className = 'full_width article-list__item__image--loading'; 
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
	card.className = 'col-md-4 mx-auto';

	const articleImage = getArticleImage();
	const article = document.createElement('div');
	article.className = 'thumbnail';
	article.appendChild(articleImage);
	
	const btn_wrapper = document.createElement('div');
	btn_wrapper.className = 'd-flex justify-content-center';
	btn_wrapper.setAttribute("id", "reaction");

	const btn_like = document.createElement('button');
	btn_like.className = 'btn';
	btn_like.setAttribute("id", 'bodylike' + photo_list[0]['id_image']);
	btn_like.setAttribute("onclick","like(this.id)");
	number_like = photo_list[0]['total_like'];
	// btn_like.innerHTML = '<i class="fas fa-heart icon-7x"></i>' + '<span>' + number_like + '</span>';
	btn_like.innerHTML = '<i class="fas fa-heart icon-7x">' + number_like +'</i>';

	if (loggedIn === true){
		btn_like.style.color = photo_list[0]['mylike'] > 0 ? "#ff5011" : "black";
	}

	btn_wrapper.appendChild(btn_like);

	const btn_comment = document.createElement('button');
	btn_comment.className = 'btn';
	btn_comment.setAttribute("id", 'comment_body' + photo_list[0]['id_image']);
	number_comment = photo_list[0]['total_comment'];
	btn_comment.innerHTML = '<i class="fas fa-comment icon-7x">' + number_comment + '</i>';

	btn_wrapper.appendChild(btn_comment);

	card.appendChild(article);
	card.appendChild(btn_wrapper);
	

	// remove from list
	photo_list.shift();
	return card;
}

function getArticlePage(page, articlesPerPage = 6) {

	const pageElement = document.createElement('div');
	pageElement.id = getPageId(page);
	pageElement.className = 'article-list__page';
	
	const page1stRow = document.createElement('div');
	page1stRow.id = 'row1';
	page1stRow.className = 'row top30';
	pageElement.appendChild(page1stRow);
	
	const page2stRow = document.createElement('div');
	page2stRow.id = 'row2';
	page2stRow.className = 'row bottom30';
	pageElement.appendChild(page2stRow);


	rowBreaker = articlesPerPage / 2; 

	while (articlesPerPage--) {
		
		if (photo_list.length > 0) {
			if (articlesPerPage < 6 && articlesPerPage >= rowBreaker) {
				page1stRow.appendChild(getArticle());
			}
			if (articlesPerPage < rowBreaker && articlesPerPage >= 0) {
				page2stRow.appendChild(getArticle());
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

function getContent() {
	data = {};
	data.test = "hello";
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			temp = JSON.parse(this.responseText);
			db_data = temp['res'];
			loggedIn = temp['loggedIn'];
			// alert("user loggedin: " + temp['loggedIn']);
	
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
			if (photo_list.length > 0) {
				addPage(++page);
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

window.onscroll = function(){
	if (getScrollTop() < getDocumentHeight() - window.innerHeight) return;
	if (photo_list.length > 0) {
		addPage(++page);
	}
};
