<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = getenv('SMTP_HOST') !== FALSE ? getenv('SMTP_HOST') : 'sandbox.smtp.mailtrap.io';
$config['smtp_port']   = getenv('SMTP_PORT') !== FALSE ? getenv('SMTP_PORT') : 2525;
$config['smtp_user']   = getenv('SMTP_USER') !== FALSE ? getenv('SMTP_USER') : '';
$config['smtp_pass']   = getenv('SMTP_PASS') !== FALSE ? getenv('SMTP_PASS') : '';
$config['smtp_crypto'] = getenv('SMTP_CRYPTO') !== FALSE ? getenv('SMTP_CRYPTO') : '';
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['crlf']        = "\r\n";

$config['default_recipient_name'] = 'Sahabat B-Universe';
