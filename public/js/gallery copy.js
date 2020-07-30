// infinite scroll
// button like active 
// onclick open image.php

const list_items = [
	"https://bit.ly/3fRAAjW",
	"https://bit.ly/3juMiDi",
	"https://bit.ly/3eUJiMW",
	"https://bit.ly/3fRAAjW",
	"https://bit.ly/3juMiDi",
	"https://bit.ly/3eUJiMW",
	"https://bit.ly/2WNuzxg",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N",
	// "https://bit.ly/3fNEn1N",
	// "https://bit.ly/3fNEn1N",
	// "https://bit.ly/3fNEn1N",
	// "https://bit.ly/3fNEn1N",
	"https://bit.ly/3fNEn1N"
];

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
	// image.className = 'article-list__item__image--loading';
	image.className = 'full_width article-list__item__image--loading';
	// image.style = 'width: 100%';

	// add source 
	image.src = list_items[0];
	// remove from list
	list_items.shift();
	
	// Create anchor element. 
	const a = document.createElement('a');
	// Set the href property. 
	a.href = "";

	a.appendChild(image);


	image.onload = function() {
		image.classList.remove('article-list__item__image--loading');
	};
	
	return a;
}

function getArticle() {
	const card = document.createElement('div');
	card.className = 'col-md-2 mx-auto';

	const articleImage = getArticleImage();
	const article = document.createElement('div');
	article.className = 'thumbnail';
	article.appendChild(articleImage);
	
	const btn_wrapper = document.createElement('div');
	btn_wrapper.className = 'd-flex justify-content-center';

	const btn_like = document.createElement('button');
	btn_like.className = 'btn';
	number_like = 10;
	btn_like.innerHTML = '<i class="fas fa-heart icon-7x"></i>' + " " + number_like;
	btn_wrapper.appendChild(btn_like);

	const btn_comment = document.createElement('button');
	btn_comment.className = 'btn';
	number_comment = 0;
	btn_comment.innerHTML = '<i class="fas fa-comment icon-7x"></i>' + " " + number_comment;
	btn_wrapper.appendChild(btn_comment);

	card.appendChild(article);
	card.appendChild(btn_wrapper);

	return card;
}

function getArticlePage(page, articlesPerPage = 6) {
	console.log("page" + page);

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
	console.log("rowBreaker " + rowBreaker);

	while (articlesPerPage--) {
		console.log("while articles per page " + articlesPerPage);
		console.log("length " + list_items.length);
		
		if (list_items.length > 0) {
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

const articleList = document.getElementById('article-list');
const articleListPagination = document.getElementById('article-list-pagination');
let page = 0;

addPage(++page);


window.onscroll = function() {
	if (getScrollTop() < getDocumentHeight() - window.innerHeight) return;
	if (list_items.length > 0) {
		addPage(++page);
	}
};

