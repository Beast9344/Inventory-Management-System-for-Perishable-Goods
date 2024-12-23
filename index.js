// Smooth Scrolling for Navigation Links
document.querySelectorAll('header nav ul li a').forEach(link => {
  link.addEventListener('click', e => {
      e.preventDefault();
      const targetId = link.getAttribute('href').substring(1); // Remove '#' from href
      const targetSection = document.getElementById(targetId);
      if (targetSection) {
          window.scrollTo({
              top: targetSection.offsetTop - 60, // Adjust for header height
              behavior: 'smooth'
          });
      }
  });
});

// Image Slider Functionality
const slides = document.querySelector('.slides');
const slideImages = slides.children;
const totalSlides = slideImages.length;
let currentSlide = 0;

function moveSlide(direction) {
  currentSlide = (currentSlide + direction + totalSlides) % totalSlides; // Wrap-around logic
  slides.style.transform = `translateX(-${currentSlide * 100}%)`;
}

// Slider controls
document.querySelector('.slider-overlay.left').addEventListener('click', () => moveSlide(-1));
document.querySelector('.slider-overlay.right').addEventListener('click', () => moveSlide(1));

// Dynamic Content Update for Pricing Section
const pricingCardsData = [
  {
      title: "Starter",
      description: "Perfect for small businesses",
      price: "$10/month"
  },
  {
      title: "Professional",
      description: "Ideal for medium enterprises",
      price: "$25/month"
  },
  {
      title: "Enterprise",
      description: "Best for large-scale operations",
      price: "$50/month"
  }
];

function updatePricingSection() {
  const pricingSection = document.querySelector('.pricing-cards');
  pricingSection.innerHTML = ''; // Clear existing content
  pricingCardsData.forEach(plan => {
      const card = document.createElement('div');
      card.className = 'pricing-card';
      card.innerHTML = `
          <h3>${plan.title}</h3>
          <p>${plan.description}</p>
          <p class="price">${plan.price}</p>
      `;
      pricingSection.appendChild(card);
  });
}

updatePricingSection(); // Initialize pricing section

// Sticky Header Effect
window.addEventListener('scroll', () => {
  const header = document.querySelector('header');
  if (window.scrollY > 50) {
      header.classList.add('sticky');
  } else {
      header.classList.remove('sticky');
  }
});

// Toggle Mobile Navigation Menu
const navToggle = document.createElement('button');
navToggle.className = 'nav-toggle';
navToggle.innerHTML = '☰';
document.querySelector('header').appendChild(navToggle);

navToggle.addEventListener('click', () => {
  const navMenu = document.querySelector('header nav ul');
  navMenu.classList.toggle('show');
});

// Hero Section Animation
const heroContent = document.querySelector('.hero-content');
window.addEventListener('load', () => {
  heroContent.style.opacity = 0;
  heroContent.style.transition = 'opacity 2s ease';
  heroContent.style.opacity = 1;
});

// Additional Initialization for Hero Buttons
const heroButtons = document.querySelectorAll('.cta-buttons .btn');
heroButtons.forEach(button => {
  button.addEventListener('mouseover', () => {
      button.style.transform = 'scale(1.05)';
      button.style.transition = 'transform 0.2s ease';
  });
  button.addEventListener('mouseout', () => {
      button.style.transform = 'scale(1)';
  });
});
