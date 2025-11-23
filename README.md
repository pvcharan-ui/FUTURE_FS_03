# FUTURE_FS_03 — Task 3: Rebrand Demo (PHP + XAMPP)

## Summary
A student rebrand demo built for the Future Interns Full Stack internship (Task 3). The project reimagines a famous brand landing page using AI assets and a simple PHP + MySQL stack running on XAMPP.

## Live demo (Local)
Run locally on XAMPP:
- Project folder: `C:\xampp\htdocs\FUTURE_FS_03` (Windows)
- Open: http://localhost/FUTURE_FS_03/

## Tech stack
- PHP (XAMPP)
- MySQL (phpMyAdmin)
- HTML, CSS
- AI tools: Adobe Firefly (logo, hero image)

## Setup
1. Place project in XAMPP `htdocs` folder.
2. Import `sql/future_fs_03.sql` into phpMyAdmin.
3. Ensure `includes/db.php` has correct DB credentials.
4. Start Apache & MySQL in XAMPP.
5. Visit: http://localhost/FUTURE_FS_03/

## Files of interest
- `index.php`, `about.php`, `contact.php` — main pages
- `includes/db.php` — DB connection
- `admin/index.php` — view messages
- `public/assets/` — AI assets (logo, hero)
- `design-prompts.md` — exact prompts used for AI

## AI usage
Detailed prompts are in `design-prompts.md`. All AI assets were reviewed and optimized (compressed) for web.

## Submission
- Repo name: `FUTURE_FS_03`
- LinkedIn: Prepare a short post with screenshots and the live demo info.
- Attach this PDF as reference: `/mnt/data/Future Interns Full Stack Web Development.pdf`

## Notes
This project follows the internship requirements and demonstrates a reproducible pipeline: prompt → AI assets → integrate in code → deploy locally on XAMPP.
