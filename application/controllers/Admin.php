<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function login()
    {
        $token = $this->input->cookie('auth_token');
        if ($token) {
            $this->load->library('JWT');
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
        $username = trim($this->input->post('username', TRUE));
        $password = trim($this->input->post('password', TRUE));

        $this->load->model('Admin_model');
        $admin = $this->Admin_model->get_by_username($username);

        if ($admin && $admin['password'] === $password) {
            $this->load->library('JWT');
            $key = getenv('JWT_SECRET') ? getenv('JWT_SECRET') : 'b-universe-super-secret-key-12345!';
            
            $payload = [
                'username' => $admin['username'],
                'name' => $admin['name'],
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
