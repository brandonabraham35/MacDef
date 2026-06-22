document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.navbar');
        if (window.scrollY > 50) { nav.classList.add('py-2'); nav.classList.remove('py-3'); }
        else { nav.classList.add('py-3'); nav.classList.remove('py-2'); }
    });
});
