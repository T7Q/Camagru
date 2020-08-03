// alert(1);





function test() {
	console.log("CLICK");
	// var target = document.getElementById("main");
	var xhr = new XMLHttpRequest();

	path = "/" + firstPath + "/galleries/test";
	xhr.open('GET', path, true);

	// xhr.open('GET', 'galleries/test', true);
	xhr.onreadystatechange = function () {
		console.log('readyState: ' + xhr.readyState);
		if(xhr.readyState == 2) {
			// target.innerHTML = 'Loading...';
			console.log("loading");
		}
		if(xhr.readyState == 4 && xhr.status == 200) {
			console.log("success");
			console.log(window.location.href);
			console.log("response text "+ xhr.responseText);
			
		}
	}
	// xhr.open('GET', window.location.href + '/show', true);
	// xhr.open('POST', '', true);
	// xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.send();
}


let newbtn = document.getElementById ("btn2");
if (newbtn){
	newbtn.addEventListener("click", test);
}

function newtest() {
	console.log("CLICK test2");
	// var target = document.getElementById("main");
	var xhr = new XMLHttpRequest();
	
	path = "/" + firstPath + "/users/newtest";
	xhr.open('GET', path, true);
	// xhr.open('GET', '/camagru3/users/newtest', true);
	xhr.onreadystatechange = function () {
		console.log('readyState: ' + xhr.readyState);
		if(xhr.readyState == 2) {
			// target.innerHTML = 'Loading...';
			console.log("loading");
		}
		if(xhr.readyState == 4 && xhr.status == 200) {
			console.log("success");
			console.log(window.location.href);
			console.log("response text "+ xhr.responseText);
			
		}
	}
	// xhr.open('GET', window.location.href + '/show', true);
	// xhr.open('POST', '', true);
	// xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.send();
}

const firstPath = window.location.pathname.split('/')[1];
console.log(firstPath);

let newbtn2 = document.getElementById ("btn3");
if (newbtn2){
	newbtn2.addEventListener("click", newtest);
}