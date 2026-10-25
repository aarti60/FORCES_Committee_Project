FORCES COMMITTEE WEBSITE - SETUP GUIDE

Requirements:
- XAMPP with Apache, PHP and MySQL
- Windows computer

INSTALL:
1. Extract this folder into C:\xampp\htdocs\
   Final path should be C:\xampp\htdocs\FORCES_Committee_Project\
   Recommended: rename folder to forces_committee for the URLs below.
2. Start Apache and MySQL in XAMPP.
3. Open http://localhost/phpmyadmin
4. Click Import, choose database/forces.sql from this folder, then click Import/Go.
5. Check includes/db.php. Default XAMPP settings are database forces_db, username root, blank password.
6. Open http://localhost/forces_committee/ (if you renamed the folder to forces_committee).
   If you keep the original folder name, use http://localhost/FORCES_Committee_Project/

FILES:
- index.php: homepage styled to match the supplied screenshot
- assets/css/style.css: responsive layout and styles
- registration.php: stores registration submissions in MySQL
- notices.php, events.php, faculty.php, members.php, past_members.php, certificates.php: website pages
- database/forces.sql: database tables and demo records
- assets/images/: generated dummy placeholder images

IMPORTANT:
- The photos and committee names are placeholders. Replace them with approved actual content.
- This package does not include a secure admin dashboard yet; do not assume notices can be edited from the website. Notices/events/faculty can be managed through phpMyAdmin for now.
- Before public deployment, add authenticated admin management, CSRF protection, and appropriate database/user permissions.
