let registerForm = document.getElementById('register-form');

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
			
			if (res['valid'] === true){
				username_err.previousElementSibling.classList.add('is-valid');
				password_err.previousElementSibling.classList.add('is-valid');
				confirm_password_err.previousElementSibling.classList.add('is-valid');
				first_name_err.previousElementSibling.classList.add('is-valid');
				last_name_err.previousElementSibling.classList.add('is-valid');
				email_err.previousElementSibling.classList.add('is-valid');
				alertBox("success", res['message'], "alert-body");
			} else {
				registerForm.reset();
				if(res['username_err'] != undefined){
                    username_err.previousElementSibling.classList.add('is-invalid');
					username_err.innerHTML = res['username_err'];
				}
				if(res['password_err'] != undefined){
					password_err.previousElementSibling.classList.add('is-invalid');
					password_err.innerHTML = res['password_err'];
				}
				if(res['confirm_password_err'] != undefined){
					confirm_password_err.previousElementSibling.classList.add('is-invalid');
					confirm_password_err.innerHTML = res['confirm_password_err'];
				}
				if(res['first_name_err'] != undefined){
					first_name_err.previousElementSibling.classList.add('is-invalid');
					first_name_err.innerHTML = res['first_name_err'];
				}
				if(res['last_name_err'] != undefined){
					last_name_err.previousElementSibling.classList.add('is-invalid');
					last_name_err.innerHTML = res['last_name_err'];
				}
				if(res['email_err'] != undefined){
					email_err.previousElementSibling.classList.add('is-invalid');
					email_err.innerHTML = res['email_err'];
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/users/register", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}