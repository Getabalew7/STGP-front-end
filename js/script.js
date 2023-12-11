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

// Ensure the first answer is visible by default
document.addEventListener("DOMContentLoaded", function () {
    const defaultAnswer = document.querySelector('.faq-item .answer');
    defaultAnswer.classList.remove('hidden');
});

function toggleAnswer(question) {
    // Hide all answers
    const allAnswers = document.querySelectorAll('.faq-item .answer');
    allAnswers.forEach(answer => answer.classList.add('hidden'));

    // Show the clicked answer
    const answer = question.nextElementSibling;
    answer.classList.remove('hidden');

    // Update arrow icons for all questions
    const allArrows = document.querySelectorAll('.faq-item .arrow');
    allArrows.forEach(arrow => arrow.textContent = '\u25BC');

    // Update the clicked question's arrow
    const arrow = question.querySelector('.arrow');
    arrow.textContent = answer.classList.contains('hidden') ? '\u25BC' : '\u25B2';
}
