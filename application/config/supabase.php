<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['supabase_url']         = getenv('SUPABASE_URL') ? getenv('SUPABASE_URL') : 'https://ifrdsavqzecxpzdoatga.supabase.co';
$config['supabase_service_key'] = getenv('SUPABASE_SERVICE_KEY') ? getenv('SUPABASE_SERVICE_KEY') : 'sb_secret_OUTcut7mdeT-6A14uQmiHQ_h6P8kQ8d';
$config['supabase_bucket']      = getenv('SUPABASE_BUCKET') ? getenv('SUPABASE_BUCKET') : 'newsletter-images';
