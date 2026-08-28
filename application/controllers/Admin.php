<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function login()
    {
        $token = $this->input->cookie('auth_token');
        if ($token) {
            $this->load->library('jwt');
            $key = getenv('JWT_SECRET') ? getenv('JWT_SECRET') : 'b-universe-super-secret-key-12345!';
            $decoded = $this->jwt->decode($token, $key);
            if ($decoded && $decoded->username === 'admin') {
                redirect('dashboard');
            }
        }

        $this->load->view('admin/login');
    }

    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username === 'admin' && $password === '123') {
            $this->load->library('jwt');
            $key = getenv('JWT_SECRET') ? getenv('JWT_SECRET') : 'b-universe-super-secret-key-12345!';
            
            $payload = [
                'username' => 'admin',
                'exp' => time() + 7200 // 2 hours expiration
            ];
            
            $token = $this->jwt->encode($payload, $key);
            
            $cookie = [
                'name'   => 'auth_token',
                'value'  => $token,
                'expire' => '7200',
                'path'   => '/',
                'secure' => FALSE
            ];
            $this->input->set_cookie($cookie);

            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau Password salah!');
            redirect('admin/login');
        }
    }

    public function logout()
    {
        delete_cookie('auth_token');
        redirect('admin/login');
    }
}
