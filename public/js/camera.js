// all manupalitons on photo page
// ajax to send saved images to the server 
// on page reload everything not saved disappears

document.getElementById("baloon").addEventListener(('click'), function(e) {
	console.log("click on baloon");
});
	data = 'update';
	request  = new Request ({
	url        : "pages/color.php",
	method     : 'POST',
	handleAs   : 'json',
	parameters : { data : JSON.stringify(data) },
	onSuccess  : function(res) {
					if (res['valid']) {
						new_color = res['color']
						document.getElementById("baloon").style.color = new_color;
						console.log("got to if");
					}
					else
						console.log("got to else");
	},
	onError    : function(status, res) {
					console.log("error occured");
	}
});