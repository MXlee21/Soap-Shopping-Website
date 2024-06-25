document.addEventListener('DOMContentLoaded', function () {
    const backgroundContainer = document.querySelector('.hero');
    const images = ['image/backgrd1.jpg', 'image/backgrd2.jpg', 'image/backgrd3.jpg']; // List of image URLs
    let currentIndex = 0;

    function changeBackground() {
        // Change background image
        backgroundContainer.style.backgroundImage = `url('${images[currentIndex]}')`;

        // Increment index or loop back to the beginning
        currentIndex = (currentIndex + 1) % images.length;
    }

    // Call the changeBackground function initially
    changeBackground();

    // Set interval to change background every 2 seconds (2000 milliseconds)
    setInterval(changeBackground, 4000);
});




document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector(".slider");
  const prevButton = document.querySelector(".prev");
  const nextButton = document.querySelector(".next");

  // Get all product cards
  const productCards = Array.from(document.querySelectorAll(".product-card"));
  const slidesPerPage = 4;
  let slideIndex = 0;

  function showSlides() {
    // Calculate the starting and ending index for the current slide
    const startIndex = slideIndex * slidesPerPage;
    const endIndex = startIndex + slidesPerPage;
    
    // Show the product cards for the current slide
    for (let i = 0; i < productCards.length; i++) {
      if (i >= startIndex && i < endIndex) {
        productCards[i].style.display = "block";
      } else {
        productCards[i].style.display = "none";
      }
    }
    
    // Show or hide prev/next buttons based on slide index
    prevButton.style.display = slideIndex === 0 ? "none" : "block";
    nextButton.style.display = endIndex >= productCards.length ? "none" : "block";
  }

  prevButton.addEventListener("click", function () {
    slideIndex--;
    showSlides();
  });

  nextButton.addEventListener("click", function () {
    slideIndex++;
    showSlides();
  });

  showSlides();
});
