<?php
header('Content-Type: text/plain');
chdir(dirname(__DIR__));
define('BASEPATH', __DIR__ . '/../system/');
define('APPPATH', __DIR__ . '/../application/');
define('ENVIRONMENT', 'development');
define('VIEWPATH', __DIR__ . '/../application/views/');
define('FCPATH', __DIR__ . '/../');

require_once BASEPATH . 'core/Common.php';

$config =& get_config();
echo "COMMON CONFIG BASE_URL: " . ($config['base_url'] ?? 'NOT SET') . "\n";

require_once BASEPATH . 'core/Config.php';
$ci_config = new CI_Config();
echo "CI_CONFIG BASE_URL: " . $ci_config->item('base_url') . "\n";
