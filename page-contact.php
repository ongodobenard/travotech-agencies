<?php
/**
 * Template Name: Contact
 */
get_header(); ?>

<style>
/* ── WhatsApp Button ── */
.wa-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  background: var(--green);
  color: white;
  padding: 13px 28px;
  border-radius: 50px;
  font-size: .92rem;
  font-weight: 800;
  font-family: 'Nunito', sans-serif;
  text-decoration: none;
  transition: all .3s;
  box-shadow: 0 6px 20px rgba(46,175,110,.3);
  white-space: nowrap;
  border: none;
  cursor: pointer;
}
.wa-cta-btn:hover {
  background: var(--green-dark);
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(46,175,110,.4);
}

/* ── Form Field Groups ── */
.fg { position: relative; }
.fg label {
  display: block;
  font-size: .78rem;
  font-weight: 800;
  color: var(--text-mid);
  margin-bottom: 5px;
  transition: color .2s;
}
.fg label .req { color: var(--green); margin-left: 2px; }
.fg input,
.fg select,
.fg textarea {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid var(--green-light);
  border-radius: 8px;
  font-size: .83rem;
  font-family: 'Nunito', sans-serif;
  color: var(--text);
  outline: none;
  transition: border-color .2s, box-shadow .2s;
  background: white;
  box-sizing: border-box;
}
.fg input:focus,
.fg select:focus,
.fg textarea:focus {
  border-color: var(--green);
  box-shadow: 0 0 0 3px rgba(46,175,110,.1);
}

/* Invalid */
.fg.invalid label,
.fg.invalid .req { color: #e53935; }
.fg.invalid input,
.fg.invalid select,
.fg.invalid textarea {
  border-color: #e53935 !important;
  box-shadow: 0 0 0 3px rgba(229,57,53,.1) !important;
  background: #fff8f8;
}
.fg .error-msg {
  font-size: .7rem;
  color: #e53935;
  font-weight: 700;
  margin-top: 4px;
  display: none;
}
.fg.invalid .error-msg { display: block; }

/* Valid */
.fg.valid input,
.fg.valid select,
.fg.valid textarea { border-color: var(--green) !important; }

/* ── Feedback Toast ── */
.cv-toast {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  border-radius: 12px;
  padding: 0 18px;
  font-size: .85rem;
  font-weight: 700;
  font-family: 'Nunito', sans-serif;
  margin-top: 0;
  border: 1.5px solid transparent;
  line-height: 1.45;
  opacity: 0;
  max-height: 0;
  overflow: hidden;
  pointer-events: none;
  transition: opacity .35s ease, max-height .45s ease, padding .45s ease, margin-top .45s ease;
}
.cv-toast.show {
  opacity: 1;
  max-height: 160px;
  padding: 14px 18px;
  margin-top: 16px;
  pointer-events: auto;
}
.cv-toast svg { flex-shrink: 0; margin-top: 2px; }
.cv-toast.cv-success {
  background: #edfaf3;
  color: #1a6e44;
  border-color: #6fcf97;
}
.cv-toast.cv-error {
  background: #fff0f0;
  color: #b71c1c;
  border-color: #ef9a9a;
}

/* ── Responsive ── */
@media (max-width: 768px) {
  .contact-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
  .wa-cta-btn {
    font-size: .78rem;
    padding: 11px 18px;
    gap: 7px;
    white-space: normal;
    text-align: center;
    max-width: 280px;
    width: 100%;
  }
  .wa-cta-btn svg { width: 16px; height: 16px; flex-shrink: 0; }
}
@media (max-width: 480px) {
  .wa-cta-btn { font-size: .72rem; padding: 10px 14px; gap: 6px; max-width: 260px; }
  .wa-cta-btn svg { width: 14px; height: 14px; }
  .form-row { grid-template-columns: 1fr !important; }
  .cv-toast { font-size: .78rem; gap: 8px; }
}
</style>

<!-- Hero -->
<section style="background:var(--green-pale);padding:56px 5%;text-align:center;">
  <div class="sec-tag sec-tag-outline reveal">Get In Touch</div>
  <h1 class="sec-title reveal rd1">Contact <span>Trovatech Agencies</span></h1>
  <p class="sec-desc reveal rd2" style="margin:0 auto;">Have a question or need help? We're always available via WhatsApp, phone or email.</p>
</section>

<!-- Main -->
<section style="background:white;padding:56px 5%;">
  <div class="contact-grid" style="display:grid;grid-template-columns:1fr 1.4fr;gap:56px;align-items:start;">

    <!-- Contact Info -->
    <div>
      <div class="sec-tag sec-tag-solid reveal">Contact Info</div>
      <h2 class="sec-title reveal rd1">Reach Us <span>Anytime</span></h2>
      <div class="why-feats" style="margin-top:24px;">

        <div class="why-feat reveal">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg></div>
          <div>
            <div class="wf-title">Phone / WhatsApp</div>
            <div class="wf-desc"><a href="https://wa.me/WHATSAPP_NUMBER_HERE" style="color:var(--green);font-weight:700;" target="_blank">+254 790 007616</a></div>
          </div>
        </div>

        <div class="why-feat reveal rd1">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
          <div>
            <div class="wf-title">Email Address</div>
            <div class="wf-desc"><a href="mailto:<?php echo esc_attr(trovatech_email()); ?>" style="color:var(--green);font-weight:700;"><?php echo esc_html(trovatech_email()); ?></a></div>
          </div>
        </div>

        <div class="why-feat reveal rd2">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
          <div>
            <div class="wf-title">Our Location</div>
            <div class="wf-desc"><?php echo esc_html(trovatech_address()); ?></div>
          </div>
        </div>

        <div class="why-feat reveal rd3">
          <div class="wf-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
          <div>
            <div class="wf-title">Working Hours</div>
            <div class="wf-desc">Mon – Fri: 8:00 AM – 6:00 PM<br>Sat: 8:30 AM – 1:00 PM<br>Sunday &amp; Holidays: Closed</div>
          </div>
        </div>

      </div>

      <div style="margin-top:28px;">
        <div style="font-size:.82rem;font-weight:800;color:var(--text);margin-bottom:12px;">Follow Us:</div>
        <div style="display:flex;gap:9px;">
          <a href="<?php echo esc_url(get_option('trovatech_facebook','#')); ?>" class="foot-soc" target="_blank">f</a>
          <a href="<?php echo esc_url(get_option('trovatech_instagram','#')); ?>" class="foot-soc" target="_blank">▶</a>
          <a href="<?php echo esc_url(get_option('trovatech_twitter','#')); ?>" class="foot-soc" target="_blank">𝕏</a>
          <a href="https://wa.me/WHATSAPP_NUMBER_HERE" class="foot-soc" target="_blank">W</a>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <!-- data-cvform="1" is our private hook — main.js cannot find this -->
    <div class="cta-form reveal rd1">
      <div class="cta-form-title">Send Us a Message</div>
      <form data-cvform="contact" method="post" novalidate>
        <?php wp_nonce_field('trovatech_nonce','nonce'); ?>
        <input type="hidden" name="action" value="trovatech_contact">

        <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
          <div class="fg" id="fg-name">
            <label for="cv_name">Full Name <span class="req">*</span></label>
            <input type="text" id="cv_name" name="contact_name" placeholder="e.g. James Kamau">
            <div class="error-msg">Please enter your full name</div>
          </div>
          <div class="fg" id="fg-email">
            <label for="cv_email">Email Address <span class="req">*</span></label>
            <input type="email" id="cv_email" name="contact_email" placeholder="e.g. james@email.com">
            <div class="error-msg">Please enter a valid email</div>
          </div>
        </div>

        <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
          <div class="fg" id="fg-phone">
            <label for="cv_phone">Phone / WhatsApp <span class="req">*</span></label>
            <input type="tel" id="cv_phone" name="contact_phone" placeholder="e.g. 0790 007616">
            <div class="error-msg">Please enter your phone number</div>
          </div>
          <div class="fg" id="fg-dept">
            <label for="cv_dept">Department <span class="req">*</span></label>
            <select id="cv_dept" name="contact_dept">
              <option value="">Select department...</option>
              <option value="Prescription">Prescription</option>
              <option value="Product Enquiry">Product Enquiry</option>
              <option value="Delivery">Delivery</option>
              <option value="General">General</option>
            </select>
            <div class="error-msg">Please select a department</div>
          </div>
        </div>

        <div class="fg" id="fg-msg" style="margin-bottom:16px;">
          <label for="cv_msg">Your Message <span class="req">*</span></label>
          <textarea id="cv_msg" name="contact_msg" placeholder="How can we help you?" style="min-height:120px;resize:vertical;"></textarea>
          <div class="error-msg">Please enter your message (min 5 characters)</div>
        </div>

        <button type="button" class="form-submit" id="cvSubmitBtn">Send Message →</button>

        <!-- ✅ Success Toast -->
        <div class="cv-toast cv-success" id="cvSuccess" role="alert" aria-live="polite">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Thanks for contacting Trovatech! Message received successfully. Our professional pharmacist will get back to you shortly. For urgent enquiries, call or WhatsApp us directly on <a href="https://wa.me/WHATSAPP_NUMBER_HERE" style="color:inherit;text-decoration:underline;font-weight:900;" target="_blank">+254 790 007616</a>.</span>
        </div>

        <!-- ❌ Error Toast -->
        <div class="cv-toast cv-error" id="cvError" role="alert" aria-live="polite">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
          <span id="cvErrorText"></span>
        </div>

      </form>
    </div>

  </div>
</section>

<!-- WhatsApp CTA -->
<section style="background:var(--green-pale);padding:48px 5%;text-align:center;">
  <div class="sec-tag sec-tag-solid reveal">Fastest Response</div>
  <h2 class="sec-title reveal rd1">Chat With Us on <span>WhatsApp</span></h2>
  <p class="sec-desc reveal rd2" style="margin:0 auto 28px;">Get instant responses from our pharmacists, available 24/7.</p>
  <a href="https://wa.me/WHATSAPP_NUMBER_HERE?text=<?php echo urlencode('Hello Trovatech Agencies! I have an enquiry.'); ?>"
     class="wa-cta-btn reveal rd3"
     target="_blank"
     rel="noopener">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
    Open WhatsApp Chat: +254 790 007616
  </a>
</section>

<script>
/* Runs after ALL other scripts including main.js / jQuery */
window.addEventListener('load', function () {

  var form      = document.querySelector('[data-cvform="contact"]');
  if (!form) return;

  /* ── Strip every listener main.js may have attached by cloning ── */
  var fresh = form.cloneNode(true);
  form.parentNode.replaceChild(fresh, form);
  form = fresh; // work with the clean copy from here on

  var successEl  = document.getElementById('cvSuccess');
  var errorEl    = document.getElementById('cvError');
  var errorText  = document.getElementById('cvErrorText');
  var btn        = document.getElementById('cvSubmitBtn');
  var toastTimer = null;
  var isSending  = false;

  /* ── Field definitions ── */
  var fields = [
    { id: 'fg-name',  input: 'cv_name',  check: function(v){ return v.trim().length >= 2; } },
    { id: 'fg-email', input: 'cv_email', check: function(v){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); } },
    { id: 'fg-phone', input: 'cv_phone', check: function(v){ return v.trim().replace(/\s/g,'').length >= 9; } },
    { id: 'fg-dept',  input: 'cv_dept',  check: function(v){ return v !== ''; } },
    { id: 'fg-msg',   input: 'cv_msg',   check: function(v){ return v.trim().length >= 5; } }
  ];

  /* ── Toast helpers ── */
  function showToast(el, ms) {
    clearTimeout(toastTimer);
    if (successEl) successEl.classList.remove('show');
    if (errorEl)   errorEl.classList.remove('show');
    el.classList.add('show');
    toastTimer = setTimeout(function(){ el.classList.remove('show'); }, ms || 6000);
  }

  /* ── Button helpers ── */
  function btnLoading() { btn.textContent = 'Sending…'; btn.disabled = true;  isSending = true;  }
  function btnReset()   { btn.textContent = 'Send Message →'; btn.disabled = false; isSending = false; }

  /* ── Field validation ── */
  function validateField(f, el, fg) {
    var pass = f.check(el.value);
    fg.classList.toggle('valid',   pass);
    fg.classList.toggle('invalid', !pass);
    return pass;
  }

  function validateAll() {
    var ok = true;
    fields.forEach(function(f) {
      var el = document.getElementById(f.input);
      var fg = document.getElementById(f.id);
      if (el && fg && !validateField(f, el, fg)) ok = false;
    });
    return ok;
  }

  function resetForm() {
    btnReset();           // button first — before form.reset() fires any events
    form.reset();
    fields.forEach(function(f) {
      var fg = document.getElementById(f.id);
      if (fg) fg.classList.remove('valid', 'invalid');
    });
  }

  /* ── Live validation ── */
  fields.forEach(function(f) {
    var el = document.getElementById(f.input);
    var fg = document.getElementById(f.id);
    if (!el || !fg) return;
    el.addEventListener('blur',   function(){ if (!isSending) validateField(f, el, fg); });
    el.addEventListener('input',  function(){ if (!isSending && fg.classList.contains('invalid')) validateField(f, el, fg); });
    el.addEventListener('change', function(){ if (!isSending && fg.classList.contains('invalid')) validateField(f, el, fg); });
  });

  /* ── Button click (type="button" — form submit event is never fired) ── */
  btn.addEventListener('click', function () {
    if (isSending) return;

    // Validate — only show field errors, nothing else
    if (!validateAll()) {
      var first = form.querySelector('.fg.invalid');
      if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return; // hard stop — no toast, no fetch
    }

    btnLoading();

    var formData = new FormData(form);

    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
      method: 'POST',
      body:   formData
    })
    .then(function(r){ return r.text(); })
    .then(function(raw) {
      var clean = raw.trim();
      var s = clean.indexOf('{');
      if (s > 0) clean = clean.substring(s);
      var data;
      try { data = JSON.parse(clean); }
      catch(e) {
        btnReset();
        errorText.textContent = 'Server error. Please contact us via WhatsApp on +254 790 007616.';
        showToast(errorEl, 8000);
        return;
      }
      if (data.success) {
        resetForm();                  // resets button + clears fields
        showToast(successEl, 7000);
      } else {
        btnReset();
        errorText.textContent = (data.data && data.data.msg)
          ? data.data.msg
          : 'Mail delivery failed. Please contact us via WhatsApp on +254 790 007616.';
        showToast(errorEl, 7000);
      }
    })
    .catch(function() {
      btnReset();
      errorText.textContent = 'Network error. Please check your connection and try again.';
      showToast(errorEl, 7000);
    });
  });

});
</script>

<?php get_footer(); ?>