<?php
header('Content-Type: text/plain');
echo "=== SERVER ===\n";
print_r($_SERVER);
echo "\n=== GETENV ===\n";
print_r(getenv());
