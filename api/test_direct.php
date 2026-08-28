<?php
header('Content-Type: text/plain');

$is_vercel = (strpos(__FILE__, '/var/task') === 0)
             || (getenv('VERCEL') == '1')
             || isset($_SERVER['VERCEL']) 
             || isset($_SERVER['HTTP_X_VERCEL_DEPLOYMENT_URL']) 
             || (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && is_string($_SERVER['HTTP_X_FORWARDED_HOST']) && strpos($_SERVER['HTTP_X_FORWARDED_HOST'], 'vercel.app') !== false) 
             || (isset($_SERVER['HTTP_HOST']) && is_string($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'vercel.app') !== false);

$is_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
             || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
             || $is_vercel;

$protocol = $is_secure ? 'https' : 'http';

if ($is_vercel) {
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $http_host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    } elseif (isset($_SERVER['HTTP_X_VERCEL_DEPLOYMENT_URL'])) {
        $http_host = $_SERVER['HTTP_X_VERCEL_DEPLOYMENT_URL'];
    } elseif (isset($_SERVER['HTTP_HOST']) && is_string($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') === false) {
        $http_host = $_SERVER['HTTP_HOST'];
    } else {
        $http_host = 'buniverse-newsletter.vercel.app';
    }
    $path = '/';
} else {
    $http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8000';
    $path = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
}

echo "IS VERCEL: " . ($is_vercel ? 'YES' : 'NO') . "\n";
echo "PROTOCOL: " . $protocol . "\n";
echo "HTTP HOST: " . $http_host . "\n";
echo "PATH: " . $path . "\n";
echo "BASE URL: " . ($protocol . "://" . $http_host . $path) . "\n";
