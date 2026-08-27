<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Newsletter_model');
        $this->load->model('Subscriber_model');
        $this->load->model('Send_log_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['admin'] = $this->admin;

        // Statistics
        $data['total_newsletters'] = $this->Newsletter_model->count_all();
        $data['total_subscribers'] = $this->Subscriber_model->count_all();
        $data['total_logs'] = $this->Send_log_model->count_all();

        // Recent tables
        $data['recent_logs'] = $this->Send_log_model->get_recent(10);
        $data['recent_subscribers'] = $this->Subscriber_model->get_recent(10);

        $this->load->view('admin/dashboard', $data);
    }
}
