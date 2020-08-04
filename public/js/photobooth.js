// all manupalitons on photo page
// ajax to send saved images to the server 
// on page reload everything not saved disappears

// Turn on camera
// initialize video element 
const video = document.getElementById("video");

// accessing getUserMedia API (supports most of browsers)
// if statement ensures that media-related code only works if getUserMedia is supported
if (navigator.mediaDevices.getUserMedia) {
	navigator.mediaDevices.getUserMedia({ video: true, audio: false }) // requesting video stream (without audio)
	  .then(function (stream) {
		video.srcObject = stream; // set stream to video element srcObject property
		video.play(); // ??? added from another source
	})
	  .catch(function (err) {
		console.log("An error occurred: " + err);
	});

	// SET VIDEO HEIGHT 
	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
		
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);
}


function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }

// stop webcam stream
function stop() {
	let stream = video.srcObject;
	let tracks = stream.getTracks();

	for (let i = 0; i < tracks.length; i++) {
		let track = tracks[i];
		track.stop();
	}
	video.srcObject = null;
	// ADD DEFAULT IMAGE HERE
}

let stopStream = document.getElementById("stop");
stopStream.addEventListener("click", stop);






var width = 320;    // We will scale the photo width to this
var height = 0;     // This will be computed based on the input stream

var streaming = false;

var canvas = null;
var photo = null;
var startbutton = null;


canvas = document.getElementById('canvas');
photo = document.getElementById('photo');
startbutton = document.getElementById('startbutton');


startbutton.addEventListener('click', function(ev){
	console.log("click");
	takepicture();
	ev.preventDefault();
}, false);

clearphoto();

function takepicture() {
	console.log("got to takepicture");
    var context = canvas.getContext('2d');
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
    
      var data = canvas.toDataURL('image/png');
	  photo.setAttribute('src', data);
	  console.log("took pic");
    } else {
      clearphoto();
    }
  }

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }