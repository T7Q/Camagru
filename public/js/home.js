// not logged in see home page 
// logged in have updated context

const colors = ["#0000ff", "#cc3300", "#ff5011", "#ffc000", "#3eba3a", "#59f3cd", "#0099ff"];
let colorIndex = 0;
window.onload = function (){
	setInterval(function(){
		console.log("color active");
		colorIndex++;
		colorIndex  = (colorIndex == 7) ? 0 : colorIndex;
		document.getElementById("baloon").style.backgroundColor = colors[colorIndex];
	}, 3000);
  }