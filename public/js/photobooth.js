// all manupalitons on photo page
// ajax to send saved images to the server 
// on page reload everything not saved disappears

// initialize video element 
const video = document.getElementById("video");
const canvas = document.createElement("canvas");
const videoStreamBtn = document.getElementById('stream_button');
const takePhotoBtn = document.getElementById('take_photo');
let isVideoLoaded = false;
let streaming = false;
const constraints = { 
	audio: false,
	video: true
};
// standard definition television pic is 640px x 480px (4:3 aspect ratio)
let width = 640; // We will scale the photo width to this
let height = 0; // This will be computed based on the input stream

let applied_filters = [];

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
const toggleStream = function () {
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
		if (document.getElementById('instructions').classList.contains("d-none")){
			alert("stream remove d-none");
			document.getElementById('instructions').classList.remove("d-none")
		}

    } else {
        if (video.srcObject === null) {
			if (!document.getElementById('instructions').classList.contains("d-none")){
				alert("stream add d-none");
				document.getElementById('instructions').classList.add("d-none");
			}
            startStream();
        }
        videoStreamBtn.innerHTML = "Stop video";
        takePhotoBtn.disabled = false;
    }
}

// takes a picture and sends to server that returns mixed image
function takePhoto(){
		// SEPERATE BETWEEN PICTURE AND VIDEO
		// REMOVE IMAGE FROM DOM ONCE PHOTO TAKEN AND SHOW INSTRUCTIONS
		let data = {};
		let context = canvas.getContext('2d');		
		if (width && height) {
			context.drawImage(video, 0, 0, width, height);
			data.img_data = canvas.toDataURL('image/png');
			data.filter_data = canvas2.toDataURL('image/png');
			data.filters = applied_filters;
			let xmlhtt = new XMLHttpRequest();
			xmlhtt.onreadystatechange = function () {
				if(this.readyState == 2) {
					console.log("loading"); // SHOW LOADING PNG
				}
				if(this.readyState == 4 && this.status == 200) {
					console.log("success");
					let temp = document.getElementById ("temp");
					temp.appendChild(createImageContainer(JSON.parse(this.responseText)));
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
		// hide instructions if they were not hidden already
		if (!document.getElementById('instructions').classList.contains("d-none")){
			alert("upload remove d-none");
			document.getElementById('instructions').classList.add("d-none");
		}
		// remove previously uploaded photo if it exists
		if (document.getElementById("uploaded_photo"))
			document.getElementById("uploaded_photo").remove();
		// create <img> element and attach it to the DOM
		var img = document.createElement('img');
		img.src = this.src;
		img.classList.add("video_overlay");
		img.classList.add("embed-responsive-item");
		img.id = "uploaded_photo";
		let camera = document.getElementById('camera');
		camera.insertBefore(img, camera.firstChild);
	};
	img.src = this.result;
}

// Apply/remove filter
function toggleFilter(selected_filter) {
	// get (un)checked filter and its <img> source
	let checkbox = document.getElementById(selected_filter);
	let	filter_src = document.getElementById("img_" + selected_filter).src;

	if (checkbox.checked == true) {
		// Create filter <img> element
		let new_filter = new Image();
		new_filter.id = "added_" + selected_filter;
		new_filter.src = filter_src;
		new_filter.className = 'video-overlay embed-responsive-item';
		filters_id.push(new_filter.id);

		// update applied_filters array
		updated_source = filter_src.split(firstPath)[1];
		applied_filters.push(updated_source);

		// update DOM
		camera.appendChild(new_filter);

	} else if (checkbox.checked != true) {
		// Remove unchecked filters from DOM
		let element = document.getElementById("added_" + selected_filter);
		for (let i = 0; i < applied_filters.length; i++) {
			// find folder path img
			img_src = element.src.split(firstPath)[1];
			// if path matches remove from applied_filters array
			if (applied_filters[i] === img_src) { 
				applied_filters.splice(i, 1);
				element.remove();
				break;
			}
		}
	}
}

document.getElementById('file_upload').onchange = function(event) {
	console.log("got to function");
	let img = document.getElementById('file_upload').files[0];
	let reader = new FileReader();
	reader.onload = createImageUpload;
	reader.readAsDataURL(img); 
	if (streaming) {
		alert("it's a stream");
		videoStreamBtn.click(toggleStream);
		takePhotoBtn.disabled = false;
	}
	// document.getElementById('video').style.opacity = 0;
}

startStream();
videoStreamBtn.addEventListener('click', toggleStream);
takePhotoBtn.addEventListener('click', takePhoto);