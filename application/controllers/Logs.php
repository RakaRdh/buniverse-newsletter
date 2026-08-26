<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Send_log_model');
    }

    public function beritasatu()
    {
        $data['portal'] = 'beritasatu';
        $data['title'] = 'BeritaSatu History Logs';
        $data['logs'] = $this->Send_log_model->get_by_portal('beritasatu');
        $data['admin'] = $this->admin;
        $this->load->view('admin/logs_list', $data);
    }

    public function investor()
    {
        $data['portal'] = 'investor';
        $data['title'] = 'Investor.id History Logs';
        $data['logs'] = $this->Send_log_model->get_by_portal('investor');
        $data['admin'] = $this->admin;
        $this->load->view('admin/logs_list', $data);
    }

    public function jakartaglobe()
    {
        $data['portal'] = 'jakartaglobe';
        $data['title'] = 'Jakarta Globe History Logs';
        $data['logs'] = $this->Send_log_model->get_by_portal('jakartaglobe');
        $data['admin'] = $this->admin;
        $this->load->view('admin/logs_list', $data);
    }
}
