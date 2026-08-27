<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Send_log_model');
    }

    private function render_logs($portal)
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $sort_col = $this->input->get('sort_col') ?: 'sent_at';
        $sort_order = $this->input->get('sort_order') ?: 'desc';

        $data['portal'] = $portal;
        
        if ($portal === 'all') {
            $data['title'] = 'All History Logs';
        } elseif ($portal === 'beritasatu') {
            $data['title'] = 'BeritaSatu History Logs';
        } elseif ($portal === 'investor') {
            $data['title'] = 'Investor.id History Logs';
        } else {
            $data['title'] = 'Jakarta Globe History Logs';
        }

        $data['logs'] = $this->Send_log_model->get_filtered_logs($portal, $start_date, $end_date, $sort_col, $sort_order);
        $data['admin'] = $this->admin;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['sort_col'] = $sort_col;
        $data['sort_order'] = $sort_order;

        $this->load->view('admin/logs_list', $data);
    }

    public function index()
    {
        $this->render_logs('all');
    }

    public function beritasatu()
    {
        $this->render_logs('beritasatu');
    }

    public function investor()
    {
        $this->render_logs('investor');
    }

    public function jakartaglobe()
    {
        $this->render_logs('jakartaglobe');
    }
}
