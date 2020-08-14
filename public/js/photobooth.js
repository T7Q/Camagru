// Older browsers might not implement mediaDevices at all, so we set an empty object first
if (navigator.mediaDevices === undefined) {
    navigator.mediaDevices = {};
}

// Some browsers partially implement mediaDevices. We can't just assign an object
// with getUserMedia as it would overwrite existing properties.
// Here, we will just add the getUserMedia property if it's missing.
if (navigator.mediaDevices.getUserMedia === undefined) {
    navigator.mediaDevices.getUserMedia = function (constraints) {

        // First get ahold of the legacy getUserMedia, if present
        var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

        // Some browsers just don't implement it - return a rejected promise with an error
        // to keep a consistent interface
        if (!getUserMedia) {
            return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
        }

        // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
        return new Promise(function (resolve, reject) {
            getUserMedia.call(navigator, constraints, resolve, reject);
        });
    }
}



// all manupalitons on photo page
// ajax to send saved images to the server 
// on page reload everything not saved disappears

// initialize video element 
const video = document.getElementById("video");
const canvas = document.createElement("canvas");
let isVideoLoaded = false;
let streaming = false;
const constraints = { 
	audio: false,
	video: true
};
// standard definition television pic is 640px x 480px (4:3 aspect ratio)
let width = 640; // We will scale the photo width to this
let height = 0; // This will be computed based on the input stream

const videoStreamBtn = document.getElementById('stream_button');
const takePhotoBtn = document.getElementById('take_photo');
const uploadImageBtn = document.getElementById("upload_photo");
const camera = document.getElementById('camera');
let displayingImage = false;
let appliedFilters = [];
let instructions = true;
let previewImgCount = 0;

// starts video stream
const startStream = function () {
	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia(constraints)
			.then(function (stream) {
				video.srcObject = stream; // set stream to video element srcObject property
				video.play(); // ??? added from another source
				isVideoLoaded = false;
			})
			.catch(function (err0r) {
				alertBox("failure", "Oops smth went wrong, check if you enabled camera..", "alert-body");
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
		showInstructions ()
		}
	}, false);
}

// Enable/disable video stream
const toggleStream = function () {
	let stream = video.srcObject;
    if (stream) {
		// "Stop video" button was pressed
        let tracks = stream.getTracks();
        for (let i = 0; i < tracks.length; i++) {
            let track = tracks[i];
            track.stop();
        }
        video.srcObject = null;
        videoStreamBtn.innerHTML = "Start video";
		takePhotoBtn.disabled = true;
		streaming = false;
		showInstructions ()
    } else {
		// "Start stream" button was pressed
        if (video.srcObject === null) {
			if (displayingImage) {
				uploadImageBtn.click(toggleUploadImage);
			}
            startStream();
        }
        videoStreamBtn.innerHTML = "Stop video";
		takePhotoBtn.disabled = false;
    }
}

// takes a picture and sends to server that returns mixed image
function takePhoto(){
	let data = {};
	let target = streaming ? video : document.getElementById("uploaded_photo");
	canvas.getContext('2d').drawImage(target, 0, 0, width, height);
	data.img_data = canvas.toDataURL('image/png');
	data.filters = appliedFilters;
	canvas.remove(); // ADDED
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			let previewList = document.getElementById ("preview-list");
			previewList.appendChild(createImageContainer(JSON.parse(this.responseText)));
			alertBox("success", "Check result in Preview are", "alert-body");
			
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/images/create", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

const deleteImageContainer = function (div) { this.parentElement.remove(); }

const saveImage = function (id) {
	let img_src = document.getElementById("div_" + id).childNodes[0].src;
	data = {};
	data.img_src = img_src;
	let xmlhtt = new XMLHttpRequest();
	xmlhtt.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			// let previewList = document.getElementById ("preview-list");
			// previewList.appendChild(createImageContainer(JSON.parse(this.responseText)));
			temp = JSON.parse(this.responseText);
			// alert("response recieved from SAVE" + temp['res']);
			document.getElementById("div_" + id).remove();
			// alert("response recieved from SAVE: " + temp['message']);
			alertBox("success", "Photo successfuly saved, check it in the Gallery", "alert-body");
		}
	}
	xmlhtt.open('POST', "/" + firstPath + "/images/save", true);
	xmlhtt.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhtt.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xmlhtt.send('data=' + JSON.stringify(data));
}

const zoomImageContainer = function (div) { 
	alert("zoome image") }

const createImageContainer = function (img) {
	let div = document.createElement("div");
	div.setAttribute("class", "mb-2 border");
	div.setAttribute("id", "div_img_" + previewImgCount);
	div.innerHTML = "<img src='" + img['photo'] + "' class=\"embed-responsive-item img-preview\" id=\'src_img_"+previewImgCount + "'></img>\
	<button type=\"button\" class=\"btn btn-outline-success btn-sm img-preview-btn mt-1 mb-1\" onclick=\"saveImage(this.id)\" id='img_" + previewImgCount + "'>Save</button>\
	<button type=\"button\" class=\"btn btn-outline-danger btn-sm img-preview-btn mt-1 mb-1\">Delete</button>";
	div.childNodes[0].addEventListener('click', zoomImageContainer);
	div.lastElementChild.addEventListener('click', deleteImageContainer);
	previewImgCount++;
	return div;
}

// Apply/remove filter
function toggleFilter(selected_filter_id) {
	// get (un)checked filter and its <img> source
	let checkbox = document.getElementById(selected_filter_id);
	let	filter_src = document.getElementById("img_" + selected_filter_id).src;

	if (checkbox.checked == true) {
		// Create filter <img> element
		let new_filter = new Image();
		new_filter.id = "added_" + selected_filter_id;
		new_filter.src = filter_src;
		new_filter.className = 'video-overlay embed-responsive-item';

		// update appliedFilters array
		updated_source = filter_src.split(firstPath)[1];
		appliedFilters.push(updated_source);
		// update DOM
		camera.appendChild(new_filter);
		showInstructions ();
	} else if (checkbox.checked != true) {
		// Remove unchecked filters from DOM
		let element = document.getElementById("added_" + selected_filter_id);
		for (let i = 0; i < appliedFilters.length; i++) {
			// find folder path img
			img_src = element.src.split(firstPath)[1];
			// if path matches remove from appliedFilters array
			if (appliedFilters[i] === img_src) { 
				appliedFilters.splice(i, 1);
				break;
			}
		}
		element.remove();
		showInstructions ();
	}
}

// show/hide instructions
function showInstructions () {
	// Remove instructions
	// alert("instructions:" + instructions);
	if (displayingImage || streaming || appliedFilters.length > 0){
		if (!document.getElementById('instructions').classList.contains("d-none")){
			// alert("REMOVE instructions");
			document.getElementById('instructions').classList.add("d-none");
			instructions = false;
		}
	// Add instructions
	} else if (!displayingImage && !streaming){
		if (document.getElementById('instructions').classList.contains("d-none")){
			// alert("ADD instructions");
			document.getElementById('instructions').classList.remove("d-none");
			instructions = true;
		}
	}
}

// Upload/remove image
const toggleUploadImage = function () {
    if (displayingImage) {
		// "Delete image" btn has been pressed
		document.getElementById("uploaded_photo").remove();
		document.getElementById('upload').value = '';
		uploadImageBtn.value = "Upload Image";
		displayingImage = false;
		showInstructions ();
		takePhotoBtn.disabled = true;
	} else if (!displayingImage) {
		// "Upload image" btn has been pressed
		if (streaming)
			videoStreamBtn.click(toggleStream);
		// Trigger hidden 'upload' btn to upload image to the DOM, update button text to "Delete image", set displyaing_image to true
		document.getElementById('upload').click();
		document.getElementById('upload').onchange = function(event) {
			displayingImage = true;
			showInstructions ();
			let img = document.getElementById("upload").files[0];
			let reader = new FileReader();
			reader.onload = function(event) {
				img = new Image();
				img.onload = function() {
					let img = document.createElement('img');
					img.src = this.src;
					img.classList.add("video_overlay");
					img.classList.add("embed-responsive-item");
					img.id = "uploaded_photo";
					camera.insertBefore(img, camera.firstChild);
				};
				img.src = this.result;
			}
			height = 480;
			canvas.setAttribute('height', height);
			canvas.setAttribute('width', width);
			reader.readAsDataURL(img); 
			uploadImageBtn.value = "Delete Image";
			takePhotoBtn.disabled = false;
		}
		// alert("child count: " + document.getElementById("test").childElementCount);
	}
}

// startStream(); // REMOVE
// takePhotoBtn.disabled = false; // REMOVE
takePhotoBtn.addEventListener('click', takePhoto);
videoStreamBtn.addEventListener('click', toggleStream);
uploadImageBtn.addEventListener('click', toggleUploadImage);