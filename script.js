// Interactive enhancements for Roaming Soul
(function() {
  'use strict';

  const doc = document;

  /* ===== Scroll Reveal ===== */
  const revealEls = [].slice.call(doc.querySelectorAll('.reveal'));
  if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => io.observe(el));
  } else {
    // Fallback: show all
    revealEls.forEach(el => el.classList.add('visible'));
  }

  /* ===== Back To Top Button ===== */
  const backBtn = doc.getElementById('backToTop');
  if (backBtn) {
    const toggleBackBtn = () => {
      if (window.scrollY > 500) backBtn.classList.add('show'); else backBtn.classList.remove('show');
    };
    window.addEventListener('scroll', toggleBackBtn, { passive: true });
    toggleBackBtn();
    backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  }

  /* ===== Active Nav Link on Scroll ===== */
  const navLinks = [].slice.call(doc.querySelectorAll('.nav-link[href^="#"]'));
  const sections = navLinks.map(l => doc.querySelector(l.getAttribute('href'))).filter(Boolean);
  if ('IntersectionObserver' in window && sections.length) {
    const highlight = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = '#' + entry.target.id;
            navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('href') === id));
        }
      });
    }, { threshold: 0.5 });
    sections.forEach(s => highlight.observe(s));
  }

  /* ===== Modal (Login) ===== */
  const modalTriggers = doc.querySelectorAll('[data-open-modal]');
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', e => {
      e.preventDefault();
      const targetId = trigger.getAttribute('data-open-modal');
      openModal(targetId);
    });
  });

  function openModal(id) {
    const modal = doc.getElementById(id);
    if (!modal) return;
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    modal.setAttribute('aria-modal', 'true');
    // Focus first input
    const firstInput = modal.querySelector('input, button, [tabindex]:not([tabindex="-1"])');
    if (firstInput) setTimeout(() => firstInput.focus(), 120);
    doc.body.style.overflow = 'hidden';
  }

  function closeModal(modal) {
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    modal.setAttribute('aria-modal', 'false');
    doc.body.style.overflow = '';
  }

  doc.addEventListener('click', e => {
    const closeAttr = e.target.closest('[data-close-modal]');
    if (closeAttr) {
      const modal = e.target.closest('.modal');
      if (modal) closeModal(modal);
    }
  });

  doc.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      const openModalEl = doc.querySelector('.modal.open');
      if (openModalEl) closeModal(openModalEl);
    }
  });

  // Close if click outside dialog area
  doc.addEventListener('mousedown', e => {
    const modal = e.target.closest('.modal');
    if (!modal) return;
    const dialog = e.target.closest('.modal-dialog');
    if (!dialog && modal.classList.contains('open')) closeModal(modal);
  });
})();
