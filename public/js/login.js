let loginForm = document.getElementById('login-form');


loginForm.onsubmit = function (){
	event.preventDefault();
	
	data = {};
	data.username = loginForm.username.value,
	data.password = loginForm.password.value;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			if (res['valid'] === true){
				window.location.href = "/" + firstPath + "/galleries/all";
			} else {
				loginForm.reset();
				for (var key in res['error']) {
					if(res['error'][key] != undefined){
						element = document.getElementById(key);
						element.previousElementSibling.classList.add('is-invalid');
						element.innerHTML = res['error'][key];
					}
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/users/login", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}