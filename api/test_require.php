<?php
header('Content-Type: text/plain');
define('FCPATH', __DIR__ . '/../');

function test_include() {
    static $config;
    define('BASEPATH', '1');
    require __DIR__ . '/../application/config/config.php';
    echo "=== INSIDE FUNCTION ===\n";
    print_r($config);
}

test_include();
