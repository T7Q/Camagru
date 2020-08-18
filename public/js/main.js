// set up work of navigation menu on mobile screen
const burger = document.querySelector('.navbar-toggler');
const nav = document.querySelector(burger.dataset.target);

burger.addEventListener('click', function () { nav.classList.toggle('collapse'); })

// the folder of the app
const firstPath = window.location.pathname.split('/')[1];
