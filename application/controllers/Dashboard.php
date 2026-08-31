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

        // Statistics Cache to speed up localhost and Vercel loads
        $this->load->driver('cache', array('adapter' => 'file'));
        if ( ! $cached_stats = $this->cache->get('dashboard_stats')) {
            $cached_stats = [
                'total_newsletters' => $this->Newsletter_model->count_all(),
                'total_subscribers' => $this->Subscriber_model->count_all(),
                'total_logs' => $this->Send_log_model->count_all(),
                'recent_logs' => $this->Send_log_model->get_recent(10),
                'recent_subscribers' => $this->Subscriber_model->get_recent(10)
            ];
            // Cache for 60 seconds (1 minute)
            $this->cache->save('dashboard_stats', $cached_stats, 60);
        }

        foreach ($cached_stats as $key => $val) {
            $data[$key] = $val;
        }

        $this->load->view('admin/dashboard', $data);
    }
}
