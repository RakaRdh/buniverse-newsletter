<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
}

class Admin_Controller extends MY_Controller {
    protected $admin;

    public function __construct() {
        parent::__construct();
        
        $token = $this->input->cookie('auth_token');
        if (!$token) {
            redirect('admin/login');
        }
        
        $this->load->library('jwt');
        $key = getenv('JWT_SECRET') ? getenv('JWT_SECRET') : 'b-universe-super-secret-key-12345!';
        $decoded = $this->jwt->decode($token, $key);
        
        if (!$decoded || $decoded->username !== 'admin') {
            delete_cookie('auth_token');
            redirect('admin/login');
        }
        
        $this->admin = $decoded;
    }
}
