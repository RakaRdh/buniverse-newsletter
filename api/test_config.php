<?php
header('Content-Type: text/plain');
define('BASEPATH', '1');
define('APPPATH', __DIR__ . '/../application/');
include __DIR__ . '/../application/config/config.php';
echo "BASE URL: " . $config['base_url'] . "\n";
echo "IS VERCEL: " . ($is_vercel ? 'YES' : 'NO') . "\n";
echo "PROTOCOL: " . $protocol . "\n";
echo "HTTP HOST: " . $http_host . "\n";
echo "PATH: " . $path . "\n";
echo "FILE PATH: " . __FILE__ . "\n";
