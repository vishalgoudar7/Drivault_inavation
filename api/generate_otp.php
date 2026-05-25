<?php
declare(strict_types=1);

require __DIR__ . '/../config/db.php';

$testingConfig = require __DIR__ . '/../config/testing.php';

$isGetRequest = $_SERVER['REQUEST_METHOD'] === 'GET';
$phone = trim((string) ($_POST['phone'] ?? ''));
$token = trim((string) ($_POST['token'] ?? $_GET['token'] ?? ''));

if ($token === '') {
    http_response_code(422);
    exit('Token is required.');
}

if ($isGetRequest) {
    $userStatement = $conn->prepare('SELECT phone FROM users WHERE invite_token = ? LIMIT 1');
    $userStatement->bind_param('s', $token);
    $userStatement->execute();
    $userResult = $userStatement->get_result();
    $user = $userResult->fetch_assoc();
    $userStatement->close();

    if (!$user) {
        http_response_code(404);
        exit('Invitation token not found.');
    }

    $phone = trim((string) ($user['phone'] ?? ''));
}

if ($phone === '') {
    http_response_code(422);
    exit('Phone number is required.');
}

$useDummyValues = (bool) ($testingConfig['use_dummy_values'] ?? false);
$otp = $useDummyValues
    ? (string) ($testingConfig['dummy_otp'] ?? '123456')
    : (string) random_int(100000, 999999);

$statement = $conn->prepare(
    'UPDATE users
     SET phone = ?, otp = ?, otp_expiry = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
     WHERE invite_token = ?'
);
$statement->bind_param('sss', $phone, $otp, $token);
$statement->execute();
$statement->close();

header("Location: ../pages/verify-otp.php?token=" . urlencode($token));
exit;
