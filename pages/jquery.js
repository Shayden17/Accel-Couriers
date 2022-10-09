

var navbar = document.querySelector('header')
var active = document.querySelector('.active')









window.onscroll = function() {

    navbar.classList.add('sticky')

    // pageYOffset or scrollY
  

    if (window.pageYOffset > 60) {
        navbar.classList.add('scrolled2')
    }else {
        navbar.classList.remove('scrolled2')
    }
    if (window.pageYOffset > 80) {
        navbar.classList.add('scrolled3')
    }else {
        navbar.classList.remove('scrolled3')
    }
    if (window.pageYOffset > 100) {
        navbar.classList.add('scrolled4')
    }else {
        navbar.classList.remove('scrolled4')
    }
    if (window.pageYOffset > 120) {
        navbar.classList.add('scrolled')
    }else {
        navbar.classList.remove('scrolled')
    }

}

