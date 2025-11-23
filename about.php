<?php require 'includes/header.php'; ?>

<section class="section reveal stagger-1">
  <h2 style="font-size:1.8rem; margin-bottom:8px;">About this website</h2>
  <p style="color:var(--muted); margin-bottom:18px; max-width:820px;">
    This site is a student-built rebrand demo created to showcase: a modern responsive layout, accessible color choices,
    AI-assisted asset creation, and a simple PHP + MySQL backend for handling contact messages. The goal is to present a
    clean, mobile-first landing experience suitable for a portfolio or internship submission.
  </p>

  <div style="display:grid; grid-template-columns: 1fr 360px; gap:28px; align-items:start;">
    <div>
      <h3 style="margin-top:0;">Project goals</h3>
      <ul style="color:var(--muted);">
        <li>Deliver a minimal, fast-loading landing page and hero section.</li>
        <li>Use AI to generate and iterate brand assets (logo & hero image).</li>
        <li>Keep the codebase simple and reproducible (PHP, MySQL, static assets).</li>
        <li>Showcase accessibility considerations and responsive UI.</li>
      </ul>

      <h3>Design approach</h3>
      <p style="color:var(--muted);">
        The design emphasizes contrast, legibility, and straightforward interaction patterns. Elements are grouped into
        simple cards, with clear CTAs and an uncluttered header so reviewers focus on content and functionality.
      </p>

      <h3>How to run locally</h3>
      <ol style="color:var(--muted);">
        <li>Place the project folder inside XAMPP's <code>htdocs</code>.</li>
        <li>Import <code>sql/future_fs_03.sql</code> into phpMyAdmin to create the <code>contacts</code> table.</li>
        <li>Start Apache & MySQL in XAMPP and visit <code>http://localhost/FUTURE_FS_03/</code>.</li>
      </ol>
    </div>

    <aside style="background:var(--surface); padding:16px; border-radius:12px; border:1px solid var(--card-border); box-shadow: var(--shadow-1);">
      <div style="margin-bottom:10px;">
        <strong>Project artifacts</strong>
        <p style="margin:8px 0 0; color:var(--muted); font-size:0.95rem;">
          Exact AI prompts and asset notes are saved in <code>design-prompts.md</code> in the project root.
        </p>
      </div>

      <div style="margin-top:12px;">
        <a href="/FUTURE_FS_03/README.md" style="display:inline-block; padding:10px 12px; background:var(--primary); color:#fff; border-radius:10px; text-decoration:none;">Open README</a>
        <p style="color:var(--muted); font-size:0.9rem; margin-top:10px;">(Readme includes setup & submission notes.)</p>
      </div>
    </aside>
  </div>
</section>

<section class="section reveal stagger-2">
  <h3>Quick notes for reviewers</h3>
  <p style="color:var(--muted); max-width:900px;">
    The contact form stores messages in MySQL via prepared statements; an admin page lists those submissions. The UI uses a
    lightweight reveal-on-scroll script and an off-canvas mobile menu for a compact mobile experience.
  </p>
</section>

<?php require 'includes/footer.php'; ?>
