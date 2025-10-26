<?php

$all_ok = true;

echo 'PHP Environment Check for CI4 Boilerplate' . PHP_EOL;
echo '-------------------------------------------' . PHP_EOL;
echo 'PHP Version: ' . phpversion() . PHP_EOL;

if (version_compare(phpversion(), '8.1.0', '<')) {
    echo '[ERROR] Your PHP version is older than 8.1. Please upgrade.' . PHP_EOL . PHP_EOL;
    $all_ok = false;
} else {
    echo '[OK] PHP version is sufficient.' . PHP_EOL . PHP_EOL;
}

$writable_path = __DIR__ . '/writable';

$required_extensions = [
    'intl',
    'mbstring',
    'mysqli', // As specified in your .env example
    'json',
    'curl',
];

echo 'Checking required PHP extensions:' . PHP_EOL;
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "[OK] '{$ext}' extension is loaded." . PHP_EOL;
    } else {
        echo "[ERROR] '{$ext}' extension is NOT loaded. Please enable it in your php.ini." . PHP_EOL;
        $all_ok = false;
    }
}
echo PHP_EOL;

echo 'Checking directory permissions:' . PHP_EOL;
if (is_writable($writable_path)) {
    echo "[OK] The '{$writable_path}' directory is writable." . PHP_EOL;
} else {
    echo "[ERROR] The '{$writable_path}' directory is NOT writable. Please check its permissions." . PHP_EOL;
    $all_ok = false;
}
echo PHP_EOL;

echo 'Check complete.' . PHP_EOL;

exit($all_ok ? 0 : 1);