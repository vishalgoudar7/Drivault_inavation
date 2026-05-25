<?php
declare(strict_types=1);

$testingConfig = require __DIR__ . '/../config/testing.php';
$token = (string) ($_GET['token'] ?? '');
$dummyPhone = (string) ($testingConfig['dummy_phone'] ?? '');
$useDummyValues = (bool) ($testingConfig['use_dummy_values'] ?? false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Phone</title>
<link rel="icon" type="image/x-icon" href="/php_invitation_system/assets/Photos/favicon.ico">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    background:#f5f7f9;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

.container{
    width:100%;
    max-width:460px;
}

.card{
    background:#ffffff;
    border-radius:24px;
    padding:40px;
    box-shadow:0 4px 20px rgba(0,0,0,0.05);
}

.brand{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:24px;
}

.brand-badge{
    width:52px;
    height:52px;
    border-radius:16px;
    background:#ecfdf5;
    border:1px solid #d1fae5;
    box-shadow:0 10px 24px rgba(74,222,128,0.18);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:8px;
}

.brand-badge img{
    width:100%;
    height:100%;
    object-fit:contain;
}

.brand span{
    font-size:24px;
    color:#0f172a;
    font-weight:700;
}

h2{
    font-size:30px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:10px;
}

.subtitle{
    color:#64748b;
    margin-bottom:30px;
    font-size:15px;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    color:#0f172a;
    font-weight:500;
}

input{
    width:100%;
    padding:14px 16px;
    border:1px solid #e2e8f0;
    border-radius:14px;
    outline:none;
    font-size:15px;
}

input:focus{
    border-color:#4ade80;
    box-shadow:0 0 0 4px rgba(74,222,128,0.15);
}

.helper{
    background:#dcfce7;
    color:#15803d;
    padding:12px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
}

button{
    width:100%;
    padding:15px;
    border:none;
    border-radius:14px;
    background:#4ade80;
    color:#ffffff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

button:hover{
    background:#22c55e;
}
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="brand">
            <div class="brand-badge">
                <img src="/php_invitation_system/assets/Photos/icon-192.png" alt="Drivault logo">
            </div>
            <span>Drivault</span>
        </div>

        <h2>Phone Verification</h2>
        <p class="subtitle">Confirm your phone number to receive the OTP.</p>

        <form action="../api/generate_otp.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input id="phone" type="text" name="phone" value="<?php echo htmlspecialchars($dummyPhone, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <?php if ($useDummyValues) { ?>
            <div class="helper">Using dummy phone number for localhost testing.</div>
            <?php } ?>

            <button type="submit">Generate OTP</button>
        </form>
    </div>
</div>
</body>
</html>
