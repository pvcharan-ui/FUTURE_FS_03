<?php require 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero" style="padding-top:40px; padding-bottom:46px;">
  <div class="hero-left reveal stagger-1" style="max-width:720px;">
    <div class="kicker">Student project</div>
    <h1 style="margin-top:8px; margin-bottom:14px; font-size:3rem; line-height:1.03;">Nike — Reimagined</h1>
    <p style="color:var(--muted); font-size:1.05rem; margin-bottom:18px;">
      Minimal, accessible and performance-first rebrand built as a student project.
      Focus on mobile-first UI, fast load times, and clear content hierarchy for reviewers.
    </p>

    <div style="display:flex; gap:14px; align-items:center;">
      <a href="#features" class="cta" title="Explore features">Explore</a>
      <a href="/FUTURE_FS_03/products.php" style="padding:10px 14px; border-radius:10px; text-decoration:none; font-weight:600; color:var(--primary); border:1px solid rgba(11,74,111,0.06);">Shop</a>
    </div>

    <ul style="margin-top:22px; color:var(--muted); list-style:none; padding:0; display:flex; gap:18px;">
      <li style="display:flex; gap:8px; align-items:center;"><strong style="color:var(--primary);">✔</strong> Responsive</li>
      <li style="display:flex; gap:8px; align-items:center;"><strong style="color:var(--primary);">✔</strong> Accessible</li>
      <li style="display:flex; gap:8px; align-items:center;"><strong style="color:var(--primary);">✔</strong> Clean code</li>
    </ul>
  </div>

  <div class="hero-right reveal stagger-2" style="display:flex; justify-content:center;">
    <!-- Constrain hero image to a professional width -->
    <img src="/FUTURE_FS_03/public/assets/hero.jpg" alt="Hero" style="max-width:520px; width:100%; height:auto; border-radius:var(--radius-lg); box-shadow:var(--shadow-2); object-fit:cover;">
  </div>
</section>

<!-- FEATURES -->
<section id="features" class="section reveal stagger-1" style="padding-top:6px;">
  <h2 style="font-size:1.6rem; margin-bottom:12px;">Core highlights</h2>

  <div class="cards" style="margin-top:18px;">
    <div class="card reveal stagger-2">
      <h3>Performance & Simplicity</h3>
      <p>Optimized assets, minimal DOM, and simple PHP + MySQL backend to keep the site fast and reproducible.</p>
    </div>

    <div class="card reveal stagger-3">
      <h3>AI-assisted design</h3>
      <p>Logo and hero imagery were created with AI and refined manually to meet accessibility and contrast goals.</p>
    </div>

    <div class="card reveal stagger-1">
      <h3>Accessible UI</h3>
      <p>High contrast, keyboard-friendly alerts, clear focus states, and semantic HTML make the site reviewer-friendly.</p>
    </div>
  </div>
</section>

<!-- SHOWCASE / FEATURES 2 -->
<section class="section reveal stagger-2" style="padding-top:6px;">
  <div style="display:grid; grid-template-columns: 1fr 340px; gap:28px; align-items:start;">
    <div>
      <h3 style="margin-top:0;">Design decisions — quick</h3>
      <p style="color:var(--muted);">
        The layout prioritizes hero messaging and a clear call to action. Components are intentionally simple
        so the code is easy to inspect and reproduce for internship review. Images are constrained to avoid layout shifts.
      </p>

      <ol style="color:var(--muted); margin-top:12px;">
        <li><strong>Constrain large imagery</strong> to fixed max-width for balance.</li>
        <li><strong>Use reveal animations</strong> to guide attention without distractions.</li>
        <li><strong>Make forms accessible</strong> with clear focus states and alerts.</li>
      </ol>
    </div>

    <!-- Removed Project files / README aside as requested.
         The page now focuses on product messaging and the CTA only. -->
    <aside style="background:transparent; border:none;"></aside>
  </div>
</section>

<!-- TESTIMONIAL / CTA STRIP -->
<section class="section reveal stagger-3" style="padding:26px 0;">
  <div style="background:linear-gradient(180deg, rgba(11,74,111,0.04), rgba(255,255,255,0.02)); border-radius:12px; padding:20px;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:18px; flex-wrap:wrap;">
      <div style="max-width:820px;">
        <strong style="font-size:1.05rem;">Ready to review</strong>
        <p style="margin:6px 0 0; color:var(--muted);">This submission is optimized for easy inspection by mentors: clear file structure, simple backend, and documented AI prompts.</p>
      </div>

      <div>
        <a href="/FUTURE_FS_03/products.php" class="cta" style="display:inline-block;">Shop the demo</a>
      </div>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
