Loggedin = false;
if (!Loggedin) {
  document.getElementById("navProfilePic").innerHTML =
    '<a href="login.html">Login</a>';
}
document.getElementById("logo").addEventListener("click", () => {
  window.location.href = "index.html";
});

const dotsContainer = document.querySelector(".carousel-dots");
let timer;

function startCarouselTimer() {
  timer = setInterval(() => {
    handleCarouselNavigation("next");
  }, 5000);
}

function stopCarouselTimer() {
  clearInterval(timer);
}

function createCarouselDots(numImages) {
  for (let i = 0; i < numImages; i++) {
    const dot = document.createElement("span");
    dot.classList.add("carousel-dot");
    dot.addEventListener("click", () => {
      handleCarouselNavigation(i);
    });
    dotsContainer.appendChild(dot);
  }
}

function updateCarouselDots(activeIndex) {
  const dots = dotsContainer.querySelectorAll(".carousel-dot");
  dots.forEach((dot, index) => {
    if (index === activeIndex) {
      dot.classList.add("active");
    } else {
      dot.classList.remove("active");
    }
  });
}

// Call the createCarouselDots function with the number of images
const images = document.querySelectorAll(".carousel-image");
createCarouselDots(images.length);

function animateCarouselImage(newIndex) {
  const carousel = document.querySelector(".carousel");
  const images = carousel.querySelectorAll(".carousel-image");
  const activeImage = carousel.querySelector(".active");
  const newImage = images[newIndex];

  //using anime.js
  anime({
    targets: activeImage,
    scale: 0.8,
    opacity: 0,
    easing: "easeOutExpo",
    duration: 500,
    complete: () => {
      activeImage.classList.remove("active");
      newImage.classList.add("active");
      updateCarouselDots(newIndex);

      // Reset scale and opacity for the new active image
      anime({
        targets: newImage,
        scale: 1,
        opacity: 1,
        easing: "easeOutExpo",
        duration: 500,
      });
    },
  });
}

// Update the dots when navigating the carousel
function handleCarouselNavigation(direction) {
  const carousel = document.querySelector(".carousel");
  const images = carousel.querySelectorAll(".carousel-image");
  const activeImage = carousel.querySelector(".active");
  const activeIndex = parseInt(activeImage.dataset.index);
  let newIndex;

  if (direction === "next") {
    newIndex = (activeIndex + 1) % images.length;
  } else if (direction === "prev") {
    newIndex = (activeIndex - 1 + images.length) % images.length;
  } else {
    newIndex = direction;
  }

  animateCarouselImage(newIndex);
}

// Attach event listeners to carousel buttons
document.querySelector(".carousel-btn-prev").addEventListener("click", () => {
  stopCarouselTimer();
  handleCarouselNavigation("prev");
});

document.querySelector(".carousel-btn-next").addEventListener("click", () => {
  stopCarouselTimer();
  handleCarouselNavigation("next");
});

// Set the initial dot active
updateCarouselDots(0);
startCarouselTimer();
