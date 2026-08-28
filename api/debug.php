<?php
header('Content-Type: text/plain');
echo "=== SERVER ===\n";
print_r($_SERVER);
echo "\n=== GETENV ===\n";
print_r(getenv());

echo "\n=== REDIRECT LOG ===\n";
$log_file = sys_get_temp_dir() . '/debug_redirect.log';
if (file_exists($log_file)) {
    echo file_get_contents($log_file);
} else {
    echo "No redirect log file found at: " . $log_file . "\n";
}
