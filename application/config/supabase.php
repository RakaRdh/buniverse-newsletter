<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['supabase_url']         = getenv('SUPABASE_URL') ? getenv('SUPABASE_URL') : 'https://ifrdsavqzecxpzdoatga.supabase.co';
$config['supabase_service_key'] = getenv('SUPABASE_SERVICE_KEY') ? getenv('SUPABASE_SERVICE_KEY') : 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlmcmRzYXZxemVjeHB6ZG9hdGdhIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc4NzY4OTMyMCwiZXhwIjoyMTAzMjY1MzIwfQ.26LkmYZU_9MCHq-zRjTQoeMHZqGyyqaSIk4dg3p9pGc';
$config['supabase_bucket']      = getenv('SUPABASE_BUCKET') ? getenv('SUPABASE_BUCKET') : 'newsletter-images';
