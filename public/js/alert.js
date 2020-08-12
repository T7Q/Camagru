function alertBox(type, message, location) {
	// alert = document.getElementById("alert");
	alert = document.getElementById(location);
	if (type === "success"){
		alert.classList.add(type);
	} else if (type === "failure"){
		alert.classList.add(type);
	} else if (type === "warning"){
		alert.classList.add(type);
	}
	alert.innerHTML = message;
	alert.classList.remove("d-none");
	setTimeout(function(){
		alert.innerHTML = "";
		alert.classList.remove(type);
		alert.classList.add("d-none");
	}, 5000);
}
