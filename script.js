const iconPaths = {
  "arrow-right": '<path d="M5 12h14"></path><path d="m13 6 6 6-6 6"></path>',
  "move-down": '<path d="M12 4v16"></path><path d="m6 14 6 6 6-6"></path>',
  "arrow-up-right": '<path d="M7 17 17 7"></path><path d="M9 7h8v8"></path>',
  send: '<path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path>',
  check: '<path d="m20 6-11 11-5-5"></path>',
  "chevron-left": '<path d="m15 18-6-6 6-6"></path>',
  "chevron-right": '<path d="m9 18 6-6-6-6"></path>',
  "chevron-down": '<path d="m6 9 6 6 6-6"></path>',
  play: '<path d="m8 5 11 7-11 7Z"></path>',
  map: '<path d="M9 18 3 21V6l6-3 6 3 6-3v15l-6 3-6-3Z"></path><path d="M9 3v15"></path><path d="M15 6v15"></path>',
  "map-pin": '<path d="M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z"></path><circle cx="12" cy="10" r="2"></circle>',
  mail: '<path d="M4 6h16v12H4Z"></path><path d="m4 7 8 6 8-6"></path>',
  phone: '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7l.4 2.5a2 2 0 0 1-.6 1.8L7.8 9.1a16 16 0 0 0 7.1 7.1l1.1-1.1a2 2 0 0 1 1.8-.6l2.5.4a2 2 0 0 1 1.7 2Z"></path>',
  linkedin: '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6Z"></path><path d="M2 9h4v12H2Z"></path><circle cx="4" cy="4" r="2"></circle>',
  facebook: '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3Z"></path>',
  instagram: '<rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17" cy="7" r="1"></circle>',
  target: '<circle cx="12" cy="12" r="8"></circle><circle cx="12" cy="12" r="3"></circle><path d="M12 2v3"></path><path d="M12 19v3"></path><path d="M2 12h3"></path><path d="M19 12h3"></path>',
  eye: '<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="3"></circle>',
  headphones: '<path d="M3 14v-2a9 9 0 0 1 18 0v2"></path><path d="M5 14h3v6H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2Z"></path><path d="M16 14h3a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-3Z"></path>',
  wrench: '<path d="M14.7 6.3a4 4 0 0 0-5 5L3 18l3 3 6.7-6.7a4 4 0 0 0 5-5l-2.8 2.8-3-3Z"></path>',
  "user-check": '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="m16 11 2 2 4-4"></path>',
  database: '<ellipse cx="12" cy="5" rx="8" ry="3"></ellipse><path d="M4 5v6c0 1.7 3.6 3 8 3s8-1.3 8-3V5"></path><path d="M4 11v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path>',
  "file-text": '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path><path d="M8 13h8"></path><path d="M8 17h6"></path>',
  "message-square": '<path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"></path>',
  "share-2": '<circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><path d="m8.6 13.5 6.8 4"></path><path d="m15.4 6.5-6.8 4"></path>',
  "trending-up": '<path d="m3 17 6-6 4 4 8-8"></path><path d="M14 7h7v7"></path>',
  calendar: '<path d="M8 2v4"></path><path d="M16 2v4"></path><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M3 10h18"></path>',
  "users-round": '<path d="M18 21a6 6 0 0 0-12 0"></path><circle cx="12" cy="11" r="4"></circle><path d="M22 21a5 5 0 0 0-4-4.9"></path><path d="M2 21a5 5 0 0 1 4-4.9"></path>',
  "dollar-sign": '<path d="M12 2v20"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"></path>',
  "clock-3": '<circle cx="12" cy="12" r="10"></circle><path d="M12 6v6h5"></path>',
  shield: '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path>',
  "layers-3": '<path d="m12 2 10 5-10 5L2 7Z"></path><path d="m2 17 10 5 10-5"></path><path d="m2 12 10 5 10-5"></path>',
  "badge-check": '<path d="M3.8 8.7 5 6.3l2.6-.4L9.4 4l2.6.8 2.6-.8 1.8 1.9 2.6.4 1.2 2.4L22 11l-1.2 2.3L19.6 16l-2.6.4-1.8 1.9-2.6-.8-2.6.8-1.8-1.9-2.6-.4-1.2-2.7L2 11Z"></path><path d="m8.5 12 2.5 2.5 5-5"></path>',
  heart: '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"></path>',
  "shopping-cart": '<circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L23 6H6"></path>',
  home: '<path d="m3 11 9-8 9 8"></path><path d="M5 10v11h14V10"></path><path d="M9 21v-6h6v6"></path>',
  "bar-chart-3": '<path d="M3 3v18h18"></path><path d="M8 17V9"></path><path d="M13 17V5"></path><path d="M18 17v-4"></path>',
  cpu: '<rect x="6" y="6" width="12" height="12" rx="2"></rect><path d="M9 1v3"></path><path d="M15 1v3"></path><path d="M9 20v3"></path><path d="M15 20v3"></path><path d="M20 9h3"></path><path d="M20 14h3"></path><path d="M1 9h3"></path><path d="M1 14h3"></path>',
  "graduation-cap": '<path d="m22 10-10-5-10 5 10 5 10-5Z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path>',
  truck: '<path d="M10 17h4V5H2v12h3"></path><path d="M14 17h1"></path><path d="M15 7h4l3 4v6h-3"></path><circle cx="7" cy="17" r="2"></circle><circle cx="17" cy="17" r="2"></circle>',
  store: '<path d="M4 10h16l-1-6H5Z"></path><path d="M5 10v10h14V10"></path><path d="M9 20v-6h6v6"></path>',
  coffee: '<path d="M17 8h1a4 4 0 0 1 0 8h-1"></path><path d="M3 8h14v5a6 6 0 0 1-6 6H9a6 6 0 0 1-6-6Z"></path><path d="M6 2v2"></path><path d="M10 2v2"></path>',
  "briefcase-business": '<path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"></path><rect x="3" y="6" width="18" height="14" rx="2"></rect><path d="M3 12h18"></path>',
  default: '<circle cx="12" cy="12" r="9"></circle><path d="M8 12h8"></path><path d="M12 8v8"></path>',
};

const initIcons = () => {
  document.querySelectorAll("i[data-lucide]").forEach((icon) => {
    const name = icon.dataset.lucide;
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("viewBox", "0 0 24 24");
    svg.setAttribute("fill", "none");
    svg.setAttribute("stroke", "currentColor");
    svg.setAttribute("stroke-width", "2");
    svg.setAttribute("stroke-linecap", "round");
    svg.setAttribute("stroke-linejoin", "round");
    svg.setAttribute("aria-hidden", "true");
    svg.classList.add("lucide", `lucide-${name}`);
    svg.innerHTML = iconPaths[name] || iconPaths.default;
    icon.replaceWith(svg);
  });
};

const navToggle = document.querySelector(".nav-toggle");
const navLinks = document.querySelector(".nav-links");
const navActions = document.querySelector(".nav-actions");
const siteHeader = document.querySelector(".site-header");

initIcons();

const syncHeader = () => {
  siteHeader?.classList.toggle("is-scrolled", window.scrollY > 24);
};

syncHeader();
window.addEventListener("scroll", syncHeader, { passive: true });

navToggle?.addEventListener("click", () => {
  const isOpen = navLinks.classList.toggle("open");
  navActions?.classList.toggle("open", isOpen);
  navToggle.setAttribute("aria-expanded", String(isOpen));
});

document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", () => {
    navLinks.classList.remove("open");
    navActions?.classList.remove("open");
    navToggle?.setAttribute("aria-expanded", "false");
  });
});

const revealElements = document.querySelectorAll(".reveal");

if ("IntersectionObserver" in window) {
  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.14 }
  );

  revealElements.forEach((element) => revealObserver.observe(element));
} else {
  revealElements.forEach((element) => element.classList.add("in-view"));
}

const animateCounter = (counter) => {
  const target = Number(counter.dataset.count);
  const duration = 1200;
  const start = Date.now();
  const raf = window.requestAnimationFrame || ((callback) => setTimeout(callback, 16));

  const tick = () => {
    const now = Date.now();
    const progress = Math.min((now - start) / duration, 1);
    const eased = 1 - Math.pow(1 - progress, 3);
    counter.textContent = Math.floor(target * eased).toLocaleString();

    if (progress < 1) {
      raf(tick);
    }
  };

  raf(tick);
};

const counters = document.querySelectorAll("[data-count]");

if ("IntersectionObserver" in window) {
  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.55 }
  );

  counters.forEach((counter) => counterObserver.observe(counter));
} else {
  counters.forEach((counter) => {
    counter.textContent = Number(counter.dataset.count).toLocaleString();
  });
}

const testimonials = Array.from(document.querySelectorAll(".testimonial"));
let activeTestimonial = 0;

const showTestimonial = (index) => {
  if (testimonials.length === 0) return;
  testimonials[activeTestimonial].classList.remove("active");
  activeTestimonial = (index + testimonials.length) % testimonials.length;
  testimonials[activeTestimonial].classList.add("active");
};

document.querySelector(".next")?.addEventListener("click", () => showTestimonial(activeTestimonial + 1));
document.querySelector(".prev")?.addEventListener("click", () => showTestimonial(activeTestimonial - 1));

if (testimonials.length > 1) {
  setInterval(() => showTestimonial(activeTestimonial + 1), 5200);
}

const navItems = Array.from(document.querySelectorAll(".nav-links a"));
const sections = navItems
  .map((link) => document.querySelector(link.getAttribute("href")))
  .filter(Boolean);

const syncActiveNav = () => {
  const scrollPosition = window.scrollY + 140;
  const visibleSections = sections.filter((section) => section.offsetTop <= scrollPosition);
  const activeSection = visibleSections[visibleSections.length - 1];

  navItems.forEach((link) => {
    link.classList.toggle("active", activeSection && link.getAttribute("href") === `#${activeSection.id}`);
  });
};

syncActiveNav();
window.addEventListener("scroll", syncActiveNav, { passive: true });

document.querySelectorAll(".btn").forEach((button) => {
  button.addEventListener("pointermove", (event) => {
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    const rect = button.getBoundingClientRect();
    const x = event.clientX - rect.left - rect.width / 2;
    const y = event.clientY - rect.top - rect.height / 2;
    button.style.transform = `translate(${x * 0.08}px, ${y * 0.12}px) scale(1.02)`;
  });

  button.addEventListener("pointerleave", () => {
    button.style.transform = "";
  });

  button.addEventListener("click", (event) => {
    const rect = button.getBoundingClientRect();
    const ripple = document.createElement("span");
    const size = Math.max(rect.width, rect.height);

    ripple.className = "ripple";
    ripple.style.width = `${size}px`;
    ripple.style.height = `${size}px`;
    ripple.style.left = `${event.clientX - rect.left - size / 2}px`;
    ripple.style.top = `${event.clientY - rect.top - size / 2}px`;

    button.appendChild(ripple);
    ripple.addEventListener("animationend", () => ripple.remove(), { once: true });
  });
});

const cursorGlow = document.createElement("div");
cursorGlow.className = "cursor-glow";
document.body.appendChild(cursorGlow);

window.addEventListener(
  "pointermove",
  (event) => {
    if (event.pointerType !== "mouse") return;
    document.body.classList.add("has-pointer");
    cursorGlow.style.transform = `translate3d(${event.clientX - 140}px, ${event.clientY - 140}px, 0)`;
  },
  { passive: true }
);

window.addEventListener("pointerleave", () => {
  document.body.classList.remove("has-pointer");
});

const parallaxTargets = document.querySelectorAll(".hero-media, .story-image img, .advantage-copy img, .culture-banner img");

const syncParallax = () => {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
  const offset = window.scrollY * 0.018;

  parallaxTargets.forEach((target, index) => {
    target.style.setProperty("--parallax-offset", `${offset * (index % 2 === 0 ? 1 : -0.6)}px`);
  });
};

window.addEventListener("scroll", syncParallax, { passive: true });
syncParallax();

document.querySelector(".contact-form")?.addEventListener("submit", (event) => {
  event.preventDefault();
  const form = event.currentTarget;
  const button = form.querySelector("button");
  const original = button.innerHTML;

  const endpoint = window.location.port === "5500"
    ? "http://127.0.0.1/cancare-connect/submit_contact.php"
    : "submit_contact.php";

  button.disabled = true;
  button.innerHTML = 'Sending <i data-lucide="send"></i>';
  initIcons();

  fetch(endpoint, {
    method: "POST",
    body: new FormData(form),
  })
    .then((response) => response.json())
    .then((data) => {
      if (!data.ok) throw new Error(data.message || "Unable to save message.");
      button.innerHTML = 'Message Ready <i data-lucide="check"></i>';
      initIcons();
      form.reset();
    })
    .catch(() => {
      button.innerHTML = 'Please Try Again <i data-lucide="arrow-right"></i>';
      initIcons();
    })
    .finally(() => {
      setTimeout(() => {
        button.disabled = false;
        button.innerHTML = original;
        initIcons();
      }, 1800);
    });
});

window.addEventListener("DOMContentLoaded", initIcons);
window.addEventListener("load", initIcons);
