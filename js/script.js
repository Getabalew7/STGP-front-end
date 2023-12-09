document.getElementById('navbarToggle').addEventListener('click', function () {
    document.getElementById('navbarNav').classList.toggle('show');
});
let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(index) {
    const percentage = -100 * index;
    document.querySelector('.carousel').style.transform = `translateX(${percentage}%)`;
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    showSlide(currentIndex);
}
$('.carousel').carousel()
