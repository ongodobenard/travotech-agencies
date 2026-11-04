/* Trovatech Agencies — main.js */

// ─── HERO SLIDER (exact from prototype) ───────
let cur = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots   = document.querySelectorAll('.hero-dot');

function goTo(n) {
  if (!slides.length) return;
  slides[cur].classList.remove('active');
  dots[cur].classList.remove('active');
  cur = (n + slides.length) % slides.length;
  slides[cur].classList.add('active');
  dots[cur].classList.add('active');
}

const hNext = document.getElementById('hNext');
const hPrev = document.getElementById('hPrev');
if (hNext) hNext.addEventListener('click', () => goTo(cur + 1));
if (hPrev) hPrev.addEventListener('click', () => goTo(cur - 1));
dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.s)));
if (slides.length) setInterval(() => goTo(cur + 1), 5000);

// ─── REVEAL ON SCROLL (exact from prototype) ──
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      obs.unobserve(e.target);
    }
  });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// ─── PRODUCT TABS (AJAX filter by category) ───
const tabBtns = document.querySelectorAll('.tab-btn');
const prodGrid = document.getElementById('prodGrid');

tabBtns.forEach(btn => {
  btn.addEventListener('click', function () {
    tabBtns.forEach(b => b.classList.remove('active'));
    this.classList.add('active');

    const cat = this.dataset.cat || '';
    if (!prodGrid) return;

    // Show loading state
    prodGrid.style.opacity = '0.5';
    prodGrid.style.pointerEvents = 'none';

    const formData = new FormData();
    formData.append('action', 'trovatech_filter_products');
    formData.append('cat', cat);
    formData.append('nonce', (typeof medicareData !== 'undefined') ? medicareData.nonce : '');

    fetch((typeof medicareData !== 'undefined') ? medicareData.ajaxUrl : '/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: formData,
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          prodGrid.innerHTML = data.data;
          // Re-observe new reveal elements
          prodGrid.querySelectorAll('.reveal').forEach(el => obs.observe(el));
        }
        prodGrid.style.opacity = '1';
        prodGrid.style.pointerEvents = '';
      })
      .catch(() => {
        prodGrid.style.opacity = '1';
        prodGrid.style.pointerEvents = '';
      });
  });
});

// ─── CART COUNT UPDATE ────────────────────────
document.addEventListener('click', function (e) {
  const addBtn = e.target.closest('.add-to-cart-btn');
  if (!addBtn) return;
  const badge = document.querySelector('.act-badge');
  if (badge) {
    const n = (parseInt(badge.textContent) || 0) + 1;
    badge.textContent = n;
    badge.style.transform = 'scale(1.4)';
    setTimeout(() => { badge.style.transform = ''; }, 200);
  }
});

// ─── CONTACT FORM (fallback, no CF7) ─────────
const contactForm = document.getElementById('medicareContact');
if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const btn = this.querySelector('.form-submit');
    const orig = btn.textContent;
    btn.textContent = 'Sending…';
    btn.disabled = true;

    const fd = new FormData(this);
    fd.append('action', 'trovatech_contact');

    fetch((typeof medicareData !== 'undefined') ? medicareData.ajaxUrl : '/wp-admin/admin-ajax.php', {
      method: 'POST', body: fd,
    })
      .then(r => r.json())
      .then(d => {
        btn.textContent = d.success ? 'Sent! ✓' : 'Error — try WhatsApp';
        btn.style.background = d.success ? '#1e8a54' : '#e53935';
        if (d.success) contactForm.reset();
        setTimeout(() => { btn.textContent = orig; btn.disabled = false; btn.style.background = ''; }, 3000);
      })
      .catch(() => {
        btn.textContent = orig;
        btn.disabled = false;
      });
  });
}
