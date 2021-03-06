// enable bootsrap modal box functionality

function openModal(param) {
    event.preventDefault();

    // get the content of the modal box
    if (param != null) {
        if (param == "edit"){
            getProfileData();
            document.getElementById("profile").style.display = "block"
            document.getElementById("profile").className += "show"
        } else if (param == "modalfollowing" || param == "modalfollowers" ){
            getFollowersData(param);
            document.getElementById("follow").style.display = "block"
            document.getElementById("follow").className += "show"
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
    if (document.getElementById("follow")) {
        document.getElementById("follow").style.display = "none";
        document.getElementById("follow").classList.remove("show");
    } 
}
// Get the modal
var modal = document.getElementById('exampleModal');
const modal2 = document.getElementById('profile');
const modal3 = document.getElementById('follow');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal || event.target == modal2 || event.target == modal3){
        closeModal()
    }
}