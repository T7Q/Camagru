// enable bootsrap modal box functionality

function openModal(param) {
    event.preventDefault();

    console.log("param:" + param);
    // customize the output see in image.js
    if (param != null){
        // console.log("param: " + param);
        if (param == "edit"){
            getProfileData();
            document.getElementById("profile").style.display = "block"
            document.getElementById("profile").className += "show"
        } else {
            getDetails(param);
            document.getElementById("exampleModal").style.display = "block"
            document.getElementById("exampleModal").className += "show"
        }
    }

    document.getElementById("backdrop").style.display = "block"
}
function closeModal() {
    document.getElementById("backdrop").style.display = "none"
    document.getElementById("exampleModal").style.display = "none"
    document.getElementById("exampleModal").className += document.getElementById("exampleModal").className.replace("show", "")
    if (document.getElementById("profile")) {
        document.getElementById("profile").style.display = "none";
        document.getElementById("profile").classList.remove("show");
    }
}
// Get the modal
var modal = document.getElementById('exampleModal');
const modal2 = document.getElementById('profile');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        closeModal()
    }
}