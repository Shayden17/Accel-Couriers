

var navbar = document.querySelector('header')
var services = document.querySelector('#ourservices')
var active = document.querySelector('.active')
var contact = document.querySelector('#contactus')









window.onscroll = function() {

    navbar.classList.add('sticky')

    // pageYOffset or scrollY
  

    if (window.pageYOffset > 40) {
        navbar.classList.add('scrolled2')
    }else {
        navbar.classList.remove('scrolled2')
    }
    if (window.pageYOffset > 50) {
        navbar.classList.add('scrolled3')
    }else {
        navbar.classList.remove('scrolled3')
    }
    if (window.pageYOffset > 60) {
        navbar.classList.add('scrolled4')
    }else {
        navbar.classList.remove('scrolled4')
    }
    if (window.pageYOffset > 70) {
        navbar.classList.add('scrolled')
    }else {
        navbar.classList.remove('scrolled')
    }


    if(window.pageYOffset>650){
        services.classList.add('active')
        active.classList.remove('active')
        if(window.pageYOffset >1350){
            services.classList.remove('active')
            contact.classList.add('active')
        }else{
            contact.classList.remove('active')
            services.classList.add('active')
        }
    }else if(window.pageYOffset<550){
        active.classList.add('active')
        services.classList.remove('active')
    }
}

