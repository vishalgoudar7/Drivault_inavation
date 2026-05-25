PHP Invitation System

Project Path
- C:\xampp\htdocs\php_invitation_system

Requirements
- XAMPP
- PHP from XAMPP
- MySQL from XAMPP
- Composer / composer.phar

How To Start In Localhost

1. Open XAMPP Control Panel
```powershell
Start-Process "C:\xampp\xampp-control.exe"
```

2. Start these services in XAMPP
- Apache
- MySQL

3. Open the project in browser
```powershell
Start-Process "http://localhost/php_invitation_system/pages/invite.php"
```

Useful Localhost Links
- Invite page:
  http://localhost/php_invitation_system/pages/invite.php
- User login:
  http://localhost/php_invitation_system/pages/login.php
- Admin create:
  http://localhost/php_invitation_system/admin/admin-create.php
- Admin login:
  http://localhost/php_invitation_system/admin/admin-login.php
- Admin dashboard:
  http://localhost/php_invitation_system/admin/admin-dashboard.php
- phpMyAdmin:
  http://localhost/phpmyadmin

Useful Terminal Commands

Check PHP
```powershell
C:\xampp\php\php.exe -v
```

Check syntax
```powershell
C:\xampp\php\php.exe -l C:\xampp\htdocs\php_invitation_system\api\send_invite.php
C:\xampp\php\php.exe -l C:\xampp\htdocs\php_invitation_system\api\set_password.php
C:\xampp\php\php.exe -l C:\xampp\htdocs\php_invitation_system\api\verify_otp.php
C:\xampp\php\php.exe -l C:\xampp\htdocs\php_invitation_system\pages\set-password.php
```

Open phpMyAdmin
```powershell
Start-Process "http://localhost/phpmyadmin"
```

Composer Setup

If vendor/autoload.php is missing, run:
```powershell
cd C:\xampp\htdocs\php_invitation_system
Invoke-WebRequest -UseBasicParsing https://getcomposer.org/installer -OutFile composer-setup.php
$env:COMPOSER_HOME="$PWD\.composer-home"
C:\xampp\php\php.exe .\composer-setup.php --install-dir=. --filename=composer.phar
C:\xampp\php\php.exe .\composer.phar install --no-interaction
```

Database Setup

1. Create database:
- invitation_system

2. Import:
- database\schema.sql

3. Check DB config file:
- config\db.php

Mail Setup

Update SMTP values in:
- config\mail.php

Important files:
- host
- port
- encryption
- username
- password
- from_name
- google_play_link
- app_store_link

Main Flow

1. Admin creates account:
- http://localhost/php_invitation_system/admin/admin-create.php

2. Admin logs in:
- http://localhost/php_invitation_system/admin/admin-login.php

3. Admin sends invite from:
- http://localhost/php_invitation_system/pages/invite.php

4. User clicks Accept in email

5. System generates OTP and opens verify page

6. User verifies OTP

7. User sets password

8. System creates Drivault account using:
- config\drivault.php

Current Dummy Testing Values

Configured in:
- config\testing.php

Current values:
- Dummy phone: 9876543210
- Dummy OTP: 123456

Password Rules
- Minimum 8 characters
- At least 1 uppercase letter
- At least 1 lowercase letter
- At least 1 number
- At least 1 special character

Built-in PHP Server Alternative

If you do not want to use Apache, run:
```powershell
cd C:\xampp\htdocs\php_invitation_system
C:\xampp\php\php.exe -S localhost:8000
```

Then open:
```powershell
Start-Process "http://localhost:8000/pages/invite.php"
```

Recommended Start Method
- Use XAMPP Apache
- Use XAMPP MySQL
- Open:
  http://localhost/php_invitation_system/pages/invite.php
