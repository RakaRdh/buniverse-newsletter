<?php
header('Content-Type: text/plain');
define('BASEPATH', '1');
define('APPPATH', __DIR__ . '/../application/');
define('FCPATH', __DIR__ . '/../');

$config_file = __DIR__ . '/../application/config/config.php';
echo "FILE EXISTS: " . (file_exists($config_file) ? "YES" : "NO") . "\n";
echo "FILE CONTENT PREVIEW:\n";
echo substr(file_get_contents($config_file), 0, 1000) . "\n";

include $config_file;

echo "\n=== DUMP CONFIG ===\n";
print_r($config);
