<?php
declare(strict_types=1);

session_start();

use PHPMailer\PHPMailer\Exception as MailerException;
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/../config/db.php';
require __DIR__ . '/../vendor/autoload.php';

$mailConfig = require __DIR__ . '/../config/mail.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function formatDatabaseErrorMessage(mysqli_sql_exception $exception): string
{
    $errorCode = (int) $exception->getCode();
    $errorMessage = strtolower($exception->getMessage());

    if ($errorCode === 1932 || str_contains($errorMessage, "doesn't exist in engine")) {
        return 'The users table is unavailable in MySQL. Repair or recreate the users table and try again.';
    }

    if ($errorCode === 1406 || str_contains($errorMessage, 'data too long')) {
        return 'One of the invitation values is too long to save. Shorten the entered details and try again.';
    }

    if ($errorCode === 1062 || str_contains($errorMessage, 'duplicate entry')) {
        return 'This email already belongs to another account record. Use a different email or update the existing user first.';
    }

    return 'Unable to save the invitation. Check the database configuration.';
}

function buildPublicUrl(string $path): string
{
    $https = (
        (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') ||
        (int) ($_SERVER['SERVER_PORT'] ?? 80) === 443
    );
    $scheme = $https ? 'https' : 'http';
    $host = 'localhost';

    return sprintf('%s://%s/%s', $scheme, $host, ltrim($path, '/'));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$sessionInviterEmail = trim((string) ($_SESSION['admin_email'] ?? ''));
$inviter_email = trim((string) ($_POST['inviter_email'] ?? $sessionInviterEmail));

if ($name === '' || $email === '' || $phone === '') {
    http_response_code(422);
    exit('Name, email, and mobile number are required.');
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    http_response_code(422);
    exit('Invalid email address.');
}

if (preg_match('/^[0-9+\-\s()]{7,20}$/', $phone) !== 1) {
    http_response_code(422);
    exit('Invalid mobile number.');
}

$token = bin2hex(random_bytes(32));
$scriptDir = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/php_invitation_system/api/send_invite.php')));
$projectBasePath = preg_replace('#/api$#', '', $scriptDir) ?: '/php_invitation_system';
$verificationLink = buildPublicUrl(
    sprintf('%s/api/generate_otp.php?token=%s', rtrim($projectBasePath, '/'), urlencode($token))
);

$smtpHost = (string) ($mailConfig['host'] ?? '');
$smtpPort = (int) ($mailConfig['port'] ?? 0);
$smtpEncryption = (string) ($mailConfig['encryption'] ?? '');
$smtpUsername = trim((string) ($mailConfig['username'] ?? ''));
$smtpPassword = trim((string) ($mailConfig['password'] ?? ''));
$smtpFromName = trim((string) ($mailConfig['from_name'] ?? 'Team Drivault'));
$sessionInviterName = trim((string) ($_SESSION['admin_name'] ?? ''));
$inviterName = trim((string) ($_POST['inviter_name'] ?? ($sessionInviterName !== '' ? $sessionInviterName : ($mailConfig['inviter_name'] ?? $smtpFromName))));
$websiteUrl = trim((string) ($mailConfig['website_url'] ?? 'https://drivault.example.com'));
$supportEmail = trim((string) ($mailConfig['support_email'] ?? 'support@drivault.example.com'));
$googlePlayLink = trim((string) ($mailConfig['google_play_link'] ?? 'https://play.google.com/store'));
$appStoreLink = trim((string) ($mailConfig['app_store_link'] ?? 'https://www.apple.com/app-store/'));
$brandIconPath = __DIR__ . '/../assets/Photos/icon-192.png';
$googlePlayImagePath = __DIR__ . '/../assets/Photos/googlePlay.png';

if (
    $smtpHost === '' ||
    $smtpPort <= 0 ||
    $smtpUsername === '' ||
    $smtpPassword === '' ||
    strtolower($smtpUsername) === 'your_email@gmail.com' ||
    $smtpPassword === 'your_app_password'
) {
    http_response_code(500);
    exit('SMTP is not configured. Update config/mail.php with your real mail credentials.');
}

try {
    $transactionStarted = false;
    $conn->set_charset('utf8mb4');
    $conn->begin_transaction();
    $transactionStarted = true;

    // $statement = $conn->prepare(
    //     'INSERT INTO users (name, email, phone, invite_token, otp, otp_expiry, is_verified, role, inviter, invite_accepted)
    //      VALUES (?, ?, ?, ?, NULL, NULL, 0, ?, ?, ?)
    //      ON DUPLICATE KEY UPDATE
    //         name = VALUES(name),
    //         phone = VALUES(phone),
    //         invite_token = VALUES(invite_token),
    //         otp = NULL,
    //         otp_expiry = NULL,
    //         is_verified = 0,
    //         role = VALUES(role),
    //         inviter = VALUES(inviter),
    //         invite_accepted = VALUES(invite_accepted)'
    // );
    // $userRole = 'user';
    // $inviteAccepted = 'no';
    // $statement->bind_param('sssssss', $name, $email, $phone, $token, $userRole, $inviterName, $inviteAccepted);

$statement = $conn->prepare(
    'INSERT INTO users (
        name,
        email,
        phone,
        invite_token,
        otp,
        otp_expiry,
        is_verified,
        role,
        inviter,
        inviter_email,
        invite_accepted
    )
    VALUES (?, ?, ?, ?, NULL, NULL, 0, ?, ?, ?, ?)

    ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        phone = VALUES(phone),
        invite_token = VALUES(invite_token),
        otp = NULL,
        otp_expiry = NULL,
        is_verified = 0,
        role = VALUES(role),
        inviter = VALUES(inviter),
        inviter_email = VALUES(inviter_email),
        invite_accepted = VALUES(invite_accepted)'
);

$userRole = 'user';
$inviteAccepted = 'no';

$statement->bind_param(
    'ssssssss',
    $name,
    $email,
    $phone,
    $token,
    $userRole,
    $inviterName,
    $inviter_email,
    $inviteAccepted
);

    $statement->execute();
    $statement->close();

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = $smtpEncryption === 'ssl'
        ? PHPMailer::ENCRYPTION_SMTPS
        : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $smtpPort;
    $mail->setFrom($smtpUsername, $smtpFromName);
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    if (is_file($brandIconPath)) {
        $mail->addEmbeddedImage($brandIconPath, 'drivault-brand-icon', 'icon-192.png');
    }
    if (is_file($googlePlayImagePath)) {
        $mail->addEmbeddedImage($googlePlayImagePath, 'google-play-badge', 'googlePlay.png');
    }
    $mail->Subject = "You've Been Invited to Join Drivault";
    $mail->Body = sprintf(
        '<div style="font-family:Arial,sans-serif;line-height:1.6;color:#1f2937;max-width:640px;margin:0 auto;">'
        . '<div style="text-align:center;margin-bottom:24px;">%9$s</div>'
        . '<h2 style="color:#111827;">You&rsquo;ve Been Invited to Join Drivault &#128640;</h2>'
        . '<p>Hello %1$s,</p>'
        . '<p>You have been invited by <strong>%2$s</strong> to join Drivault - your secure cloud storage and file management platform.</p>'
        . '<p>With Drivault, you can:</p>'
        . '<ul>'
        . '<li>Securely store and manage your files</li>'
        . '<li>Access your data anytime, anywhere</li>'
        . '<li>Share files safely with your team and friends</li>'
        . '<li>Get additional free storage through referrals</li>'
        . '</ul>'
        . '<p>To activate your account and set your password, click the button below:</p>'
        . '<p style="margin:24px 0;">'
        . '<a href="%3$s" style="background:#43E08B;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:6px;display:inline-block;font-weight:600;">Accept</a>'
        . '</p>'
        . '<p><strong>Your login details:</strong><br>'
        . 'Username: %6$s</p>'
        . '<p><strong>Important:</strong></p>'
        . '<ul>'
        . '<li>This invitation link is valid for a limited time.</li>'
        . '<li>Please verify your mobile number using OTP during registration.</li>'
        . '</ul>'
        . '<div style="margin-top:28px;padding-top:24px;border-top:1px solid #e5e7eb;text-align:center;">'
        . '<p style="margin:0 0 14px;"><strong>Download the Drivault mobile app</strong></p>'
        . '<table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto 8px;border-collapse:separate;border-spacing:12px 0;">'
        . '<tr>'
        . '<td style="vertical-align:middle;">'
        . '<a href="%4$s" style="display:inline-block;text-decoration:none;">%10$s</a>'
        . '</td>'
        . '<td style="vertical-align:middle;">'
        . '<a href="%5$s" style="display:inline-block;background:#111827;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:8px;font-weight:600;">Download on the App Store</a>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</div>'
        . '<p>If you did not expect this invitation, you can safely ignore this email.</p>'
        . '<p>Thanks,<br>Team Drivault<br><a href="%7$s">%7$s</a><br><a href="mailto:%8$s">%8$s</a></p>'
        . '</div>',
        htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($inviterName, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($verificationLink, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($googlePlayLink, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($appStoreLink, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($websiteUrl, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($supportEmail, ENT_QUOTES, 'UTF-8'),
        is_file($brandIconPath)
            ? '<img src="cid:drivault-brand-icon" alt="Drivault" style="display:inline-block;width:72px;height:72px;border:0;">'
            : '<strong style="font-size:20px;color:#111827;">Drivault</strong>',
        is_file($googlePlayImagePath)
            ? '<img src="cid:google-play-badge" alt="Get it on Google Play" style="display:block;width:180px;max-width:100%;border:0;">'
            : 'Android: <span style="color:#0d6efd;">' . htmlspecialchars($googlePlayLink, ENT_QUOTES, 'UTF-8') . '</span>'
    );
    $mail->AltBody = sprintf(
        "Subject: You've Been Invited to Join Drivault\n\n"
        . "Hello %s,\n\n"
        . "You have been invited by %s to join Drivault - your secure cloud storage and file management platform.\n\n"
        . "With Drivault, you can:\n"
        . "- Securely store and manage your files\n"
        . "- Access your data anytime, anywhere\n"
        . "- Share files safely with your team and friends\n"
        . "- Get additional free storage through referrals\n\n"
        . "To activate your account and set your password, open this link:\n%s\n\n"
        . "Download the mobile app:\n"
        . "Android: %s\n"
        . "iPhone/iPad: %s\n\n"
        . "Your login details:\n"
        . "Username: %s\n"
        . "Password: The password you create during setup\n\n"
        . "Important:\n"
        . "- This invitation link is valid for a limited time.\n"
        . "- Please verify your mobile number using OTP during registration.\n\n"
        . "If you did not expect this invitation, you can safely ignore this email.\n\n"
        . "Thanks,\nTeam Drivault\n%s\n%s",
        $name,
        $inviterName,
        $verificationLink,
        $googlePlayLink,
        $appStoreLink,
        $phone,
        $websiteUrl,
        $supportEmail
    );
    $mail->send();

    $conn->commit();
    exit('Invitation sent successfully.');
} catch (mysqli_sql_exception $exception) {
    if (!empty($transactionStarted)) {
        $conn->rollback();
    }

    error_log(
        sprintf(
            '[send_invite] Database error: %s in %s on line %d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        )
    );

    http_response_code(500);
    exit(formatDatabaseErrorMessage($exception));
} catch (MailerException $exception) {
    if (!empty($transactionStarted)) {
        $conn->rollback();
    }

    error_log(
        sprintf(
            '[send_invite] Mailer error: %s in %s on line %d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        )
    );

    http_response_code(500);
    exit('Unable to send invitation email: ' . $exception->getMessage());
} catch (Throwable $exception) {
    if (!empty($transactionStarted)) {
        $conn->rollback();
    }

    error_log(
        sprintf(
            '[send_invite] Unhandled error: %s in %s on line %d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        )
    );

    http_response_code(500);
    exit('Unable to process the invitation request.');
}
