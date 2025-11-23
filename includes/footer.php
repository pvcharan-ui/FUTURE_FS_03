</main>

<footer class="site-footer">
  <div class="footer-inner">
    <div>
      <strong>Rebrand Demo</strong>
      <div style="color:var(--muted); font-size:0.95rem;">© <?= date('Y') ?> Rebrand Demo — Built by a B.Tech student</div>
    </div>

    <div class="small-links">
      <a href="/FUTURE_FS_03/about.php">About</a>
      <a href="/FUTURE_FS_03/contact.php">Contact</a>
      <a href="/FUTURE_FS_03/README.md">Readme</a>
    </div>
  </div>
</footer>

<!-- Mobile menu & reveal JS -->
<script>
  // Mobile menu toggling
  (function(){
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('menu-overlay');
    const mobileClose = document.getElementById('mobile-close');

    function openMenu(){
      hamburger.classList.add('active');
      hamburger.setAttribute('aria-expanded','true');
      mobileMenu.classList.add('open');
      overlay.classList.add('show');
      mobileMenu.setAttribute('aria-hidden','false');
    }
    function closeMenu(){
      hamburger.classList.remove('active');
      hamburger.setAttribute('aria-expanded','false');
      mobileMenu.classList.remove('open');
      overlay.classList.remove('show');
      mobileMenu.setAttribute('aria-hidden','true');
    }

    window.openMenu = openMenu;
    window.closeMenu = closeMenu;

    hamburger && hamburger.addEventListener('click', function(){
      const expanded = this.classList.contains('active');
      if (expanded) closeMenu(); else openMenu();
    });
    overlay && overlay.addEventListener('click', closeMenu);
    mobileClose && mobileClose.addEventListener('click', closeMenu);
  })();

  // Reveal on scroll (small, dependency-free)
  (function(){
    const reveals = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) {
      // fallback: just activate all
      reveals.forEach(r => r.classList.add('active'));
      return;
    }
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    reveals.forEach(r => io.observe(r));
  })();
</script>

</body>
</html>
