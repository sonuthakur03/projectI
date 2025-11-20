// Counter animation for stats (scaled to smaller numbers)
function animateCounter(element, target, duration = 2000) {
  const start = 0;
  const startTime = Date.now();

  // Normalize target to max ~100
  let normalizedTarget = parseFloat(target.replace(/[^0-9.]/g, ""));
  if (normalizedTarget > 100)
    normalizedTarget = Math.floor(Math.random() * 50) + 50; // random 50-100
  if (isNaN(normalizedTarget) || normalizedTarget <= 0)
    normalizedTarget = Math.floor(Math.random() * 50) + 20; // fallback 20-70

  function updateCounter() {
    const elapsed = Date.now() - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const current = Math.floor(progress * normalizedTarget);
    element.textContent = current;

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
