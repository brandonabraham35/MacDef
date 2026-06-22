MACDEF Enhanced PHP Version
1. Put folder in C:\xampp\htdocs\MACDEF
2. Start Apache and MySQL.
3. Import database/macdef.sql in phpMyAdmin.
4. Check includes/config.php. DB_PORT is currently 4000 because your XAMPP screenshot showed MySQL on port 4000. Change it to 3306 if your MySQL uses 3306.
5. Open http://localhost/MACDEF/
6. Admin: http://localhost/MACDEF/admin/login.php
Email: admin@macdef.org
Password: admin123
Mailing: configure SMTP in Admin > Settings / Mailing. Until SMTP is set, emails may fail but are logged in Email Logs.
