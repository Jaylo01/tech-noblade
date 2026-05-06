// Responsive JS Slideshow Logic
let currentSlideIndex = 0;
let slideInterval;

function showSlide(n) {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.nav-dot');
    
    if (!slides.length) return;
    
    slides.forEach(slide => {
        slide.classList.remove('active');
        const video = slide.querySelector('video');
        if (video) video.pause();
    });
    
    dots.forEach(dot => dot.classList.remove('active'));
    
    currentSlideIndex = (n + slides.length) % slides.length;
    slides[currentSlideIndex].classList.add('active');
    if (dots[currentSlideIndex]) dots[currentSlideIndex].classList.add('active');

    const activeVideo = slides[currentSlideIndex].querySelector('video');
    if (activeVideo) {
        activeVideo.play().catch(e => console.log("Video autoplay blocked"));
    }
}

function moveSlide(n) {
    showSlide(currentSlideIndex + n);
    resetInterval();
}

function currentSlide(n) {
    showSlide(n);
    resetInterval();
}

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(() => moveSlide(1), 5000);
}

document.addEventListener('DOMContentLoaded', () => {
    showSlide(0);
    resetInterval();
});
