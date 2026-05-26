<?php
declare(strict_types=1);

$basePath = getenv('APP_BASE_PATH') ?: '/php_invitation_system';
$localUrl = getenv('APP_LOCAL_URL') ?: 'http://localhost' . $basePath;
$androidEmulatorUrl = getenv('APP_ANDROID_EMULATOR_URL') ?: 'http://10.0.2.2' . $basePath;
$productionUrl = getenv('APP_PRODUCTION_URL') ?: 'https://drivault.com' . $basePath;

return [
    'base_path' => $basePath,
    'base_url' => getenv('APP_BASE_URL') ?: $localUrl,
    'local_url' => $localUrl,
    'android_emulator_url' => $androidEmulatorUrl,
    'production_url' => $productionUrl,
    'api_url' => (getenv('APP_BASE_URL') ?: $localUrl) . '/api',
];
