// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// Navbar background on scroll
window.addEventListener("scroll", function () {
  const navbar = document.querySelector(".navbar");
  if (window.scrollY > 50) {
    navbar.style.background = "rgba(255, 255, 255, 0.98)";
    navbar.style.boxShadow = "0 2px 20px rgba(0,0,0,0.1)";
  } else {
    navbar.style.background = "rgba(255, 255, 255, 0.95)";
    navbar.style.boxShadow = "none";
  }
});

// Counter animation for stats
function animateCounter(element, target, duration = 2000) {
  const start = 0;
  const startTime = Date.now();

  function updateCounter() {
    const elapsed = Date.now() - startTime;
    const progress = Math.min(elapsed / duration, 1);

    let current;
    if (target.includes("M")) {
      current = Math.floor(progress * parseFloat(target) * 1000000);
      if (current >= 1000000) {
        element.textContent = (current / 1000000).toFixed(1) + "M+";
      } else {
        element.textContent = Math.floor(current / 1000) + "K+";
      }
    } else if (target.includes("K") || target.includes(",")) {
      const numTarget = parseInt(target.replace(/[^0-9]/g, ""));
      current = Math.floor(progress * numTarget);
      element.textContent = current.toLocaleString() + "+";
    } else if (target.includes(".")) {
      current = (progress * parseFloat(target)).toFixed(1);
      element.textContent = current + "/5";
    } else {
      current = Math.floor(progress * parseInt(target));
      element.textContent = current + "+";
    }

    if (progress < 1) {
      requestAnimationFrame(updateCounter);
    }
  }

  updateCounter();
}

// Start counter animation when stats section is visible
const statsObserver = new IntersectionObserver(
  function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const statNumbers = entry.target.querySelectorAll(".stat-number");
        statNumbers.forEach((stat) => {
          const target = stat.textContent;
          animateCounter(stat, target);
        });
        statsObserver.unobserve(entry.target);
      }
    });
  },
  {
    threshold: 0.5,
  }
);

const statsSection = document.querySelector(".stats");
if (statsSection) {
  statsObserver.observe(statsSection);
}
// Add click handlers for buttons
document
  .querySelectorAll(".btn-primary, .btn-secondary, .btn-white, .btn-outline")
  .forEach((btn) => {
    btn.addEventListener("click", function (e) {
      if (this.getAttribute("href") === "#") {
        e.preventDefault();
        // Add a subtle pulse effect
        this.style.transform = "scale(0.95)";
        setTimeout(() => {
          this.style.transform = "";
        }, 150);
      }
    });
  });

// // Mobile menu toggle (if needed)
// const signInBtn = document.querySelector(".sign-in-btn");
// signInBtn.addEventListener("click", function () {
// 	alert("Sign In functionality would be implemented here!");
// });
