// all manupalitons on photo page
// ajax to send saved images to the server 
// on page reload everything not saved disappears

// initialize video element 
const video = document.getElementById("video");
const canvas = document.getElementById('canvas');
// const photo = document.getElementById('photo');
const videoStreamBtn = document.getElementById('stream_button');
const takePhotoBtn = document.getElementById('take_photo');
let isVideoLoaded = false;
let streaming = false;


// standard definition television pic is 640px x 480px (4:3 aspect ratio)
// hidh-definition 1280px x 720px
let width = 320; // We will scale the photo width to this
let height = 0; // This will be computed based on the input stream

const constraints = { 
	audio: false,
	video: true
};

// starts video stream
const startStream = function () {
	console.log("got to startStream");
	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia(constraints)
			.then(function (stream) {
				video.srcObject = stream; // set stream to video element srcObject property
				video.play(); // ??? added from another source
				isVideoLoaded = false;
			})
			.catch(function (err0r) {
				console.log("Oops smth went wrong, check if you enabled camera..");
			})
	}
	video.addEventListener('canplay', function(ev){
		if (!streaming) {
		height = video.videoHeight / (video.videoWidth/width);
		
		// Firefox currently has a bug where the height can't be read from
		// the video, so we will make assumptions if this happens.
		if (isNaN(height)) {
			height = width / (4/3);
		}
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
		streaming = true;
		}
	}, false);
}

// enables disables video stream
const streamControl = function () {
	let stream = video.srcObject;
    if (stream) {
        let tracks = stream.getTracks();
        for (let i = 0; i < tracks.length; i++) {
            let track = tracks[i];
            track.stop();
        }
        video.srcObject = null;
        videoStreamBtn.innerHTML = "Start video";
        takePhotoBtn.disabled = true;
    } else {
        if (video.srcObject === null) {
            startStream();
        }
        videoStreamBtn.innerHTML = "Stop video";
        takePhotoBtn.disabled = false;
    }
}

// takes a picture and sends to server that returns mixed image
function takePhoto(){
		console.log("BTN: takePhoto");
		let context = canvas.getContext('2d');
		let data = {};
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
		context.drawImage(video, 0, 0, width, height);
		
		data.img_data = canvas.toDataURL('image/png');
		// photo.setAttribute('src', data);
		console.log("attributes");
		console.log(canvas.width);
		console.log(canvas.height);
		console.log(video.width);
		console.log(video.height);
		
		console.log("started to create");
		let xmlhtt = new XMLHttpRequest();
		xmlhtt.onreadystatechange = function () {
			if(this.readyState == 2) {
				console.log("loading");
			}
			if(this.readyState == 4 && this.status == 200) {
				console.log("success");
				let temp = document.getElementById ("temp");
				console.log("response.text: " + this.responseText);
				temp.appendChild(createImageContainer(JSON.parse(this.responseText)));
				console.log("DOM element temp updated" + document.getElementById ("temp"));
			}
		}
		xmlhtt.open('POST', "/" + firstPath + "/images/create", true);
		xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xmlhtt.send('data=' + JSON.stringify(data));
		}
}

const deleteImageContainer = function (div) { this.parentElement.remove(); }

const createImageContainer = function (img) {
    var div = document.createElement("div");
    div.innerHTML = "<img src='" + img['photo'] + "'></img>\
                    <a class='delete'></a>\
					<p>NEW IMAGE</p>";
	div.childNodes[2].addEventListener('click', deleteImageContainer);
    return div;
}

function createImageUpload() {
	img = new Image();
	console.log("got to createImageUpload");
	if (!isVideoLoaded) {
		video.style.width = "680px";
		video.style.height = "480px";
	}
	img.onload = function imageLoaded() {
		if (document.getElementById("uploaded_photo"))
			document.getElementById("uploaded_photo").remove();
		var img = document.createElement('img');
		console.log("this.src" + this.src);
		img.src = this.src;
		img.classList.add("video_overlay");
		img.classList.add("embed-responsive-item");
		img.id = "uploaded_photo";
		let camera = document.getElementById('camera');
		console.log("camera div: " + document.getElementById('camera'));
		console.log("img" + img);
		camera.insertBefore(img, camera.firstChild);
	};
	img.src = this.result;
}


document.getElementById('file_upload').onchange = function(event) {
	console.log("got to function");
	let img = document.getElementById('file_upload').files[0];
	let reader = new FileReader();
	reader.onload = createImageUpload;
	reader.readAsDataURL(img); 
	document.getElementById('video').style.opacity = 0;
}



startStream();
videoStreamBtn.addEventListener('click', streamControl);
takePhotoBtn.addEventListener('click', takePhoto);