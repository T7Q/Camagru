// not logged in see home page 
// logged in have updated context

function favorite() {
	var parent = this.parentElement;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../app/views/pages/new.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function () {
	  console.log('readyState: ' + xhr.readyState);
	  if(xhr.readyState == 2) {
		parent.innerHTML = 'Loading...';
	  }
	  if(xhr.readyState == 4 && xhr.status == 200) {
		parent.innerHTML = xhr.responseText;
		console.log(xhr.responseText);
	  }
	}
	xhr.send("id=" + parent.id);
  }

  let button = document.getElementById("home_test");
  button.addEventListener("click", favorite);