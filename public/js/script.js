// Hamburger icon function for navigation bar  
const navIcon = document.querySelector('.nav-icon');

navIcon.addEventListener('click', () => {
    let navEl = document.querySelector('#myTopnav div.menus');
    navEl.classList.toggle('active');
});