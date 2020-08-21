let registerForm = document.getElementById('register-form');

function clearRegisterFormError(){
	const error = [ 
		"username_err",
		"password_err",
		"confirm_password_err",
		"first_name_err",
		"last_name_err",
		"email_err",
	];
	for (let i = 0; i < error.length; i++) {
		element = document.getElementById(error[i]);

		if(element.previousElementSibling.classList.contains("is-invalid")){
			element.previousElementSibling.classList.remove("is-invalid");
			element.innerHTML = "";
		}
		if(element.previousElementSibling.classList.contains("is-valid")){
			element.previousElementSibling.classList.remove("is-valid");
		}
	}
}


registerForm.onsubmit = function (){
	event.preventDefault();
	
	data = {};
	data.username = registerForm.username.value,
	data.email = registerForm.email.value,
	data.password = registerForm.password.value;
	data.confirm_password = registerForm.confirm_password.value;
	data.first_name = registerForm.first_name.value;
	data.last_name = registerForm.last_name.value;


	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			let username_err = document.getElementById("username_err");
			let password_err = document.getElementById("password_err");
			let confirm_password_err = document.getElementById("confirm_password_err");
			let first_name_err = document.getElementById("first_name_err");
			let last_name_err = document.getElementById("last_name_err");
			let email_err = document.getElementById("email_err");
			clearRegisterFormError();
			if (res['valid'] === true){
				username_err.previousElementSibling.classList.add('is-valid');
				password_err.previousElementSibling.classList.add('is-valid');
				confirm_password_err.previousElementSibling.classList.add('is-valid');
				first_name_err.previousElementSibling.classList.add('is-valid');
				last_name_err.previousElementSibling.classList.add('is-valid');
				email_err.previousElementSibling.classList.add('is-valid');
				alertBox("success", res['message'], "alert-body");
			} else {
				for (var key in res['error']) {
					if(res['error'][key] != undefined){
						temp = res['error'][key];
						if(temp.length > 0){
							element = document.getElementById(key);
							element.previousElementSibling.classList.add('is-invalid');
							element.innerHTML = res['error'][key];
						}
					}
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/users/register", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}