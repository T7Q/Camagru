let forgotPwdForm = document.getElementById('forgot-pwd');

forgotPwdForm.onsubmit = function (){
	event.preventDefault();
	
	data = {};
	data.email = forgotPwdForm.email.value;

	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {			
			res = JSON.parse(this.responseText);
			let email_err = document.getElementById("email_err");
			if (res['valid'] === true){
				email_err.previousElementSibling.classList.add('is-valid');
				alertBox("success", res['message'], "alert-body");
			} else {
				forgotPwdForm.reset();
				if(res['email_err'] != undefined){
                    email_err.previousElementSibling.classList.add('is-invalid');
					email_err.innerHTML = res['email_err'];
				}
			}
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/users/forgotpwd", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}