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
				if(res['username_err'] != undefined){
					let span = document.getElementById("username_err");
                    span.previousElementSibling.classList.add('is-invalid');
					span.innerHTML = res['username_err'];
				}
				if(res['password_err'] != undefined){
					let span = document.getElementById("password_err");
					span.previousElementSibling.classList.add('is-invalid');
					span.innerHTML = res['password_err'];
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/users/login", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}