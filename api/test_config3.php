<?php
header('Content-Type: text/plain');
define('BASEPATH', '1');
define('APPPATH', __DIR__ . '/../application/');
define('FCPATH', __DIR__ . '/../');

include __DIR__ . '/../application/config/config.php';

echo "BASE URL VALUE: " . (isset($config['base_url']) ? $config['base_url'] : 'NOT SET') . "\n";
echo "CONFIG KEYS:\n";
print_r(array_keys($config));
