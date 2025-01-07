let currentIndex = 0;
const slides = document.querySelectorAll('.slider img');
const totalSlides = slides.length;

function moveToNextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides; // Loop back to the first slide
    const slideWidth = slides[0].clientWidth; // Get the width of each image
    document.querySelector('.slider').style.transform = `translateX(-${slideWidth * currentIndex}px)`;
}

// Set interval to move the slider every 3 seconds (you can adjust this time as needed)
setInterval(moveToNextSlide, 3000);
