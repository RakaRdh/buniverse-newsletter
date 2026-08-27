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

        $this->load->library('pagination');

        // Build base URL for the active page route
        $config['base_url'] = base_url('logs/' . $portal);
        $config['total_rows'] = $this->Send_log_model->count_filtered_logs($portal, $start_date, $end_date);
        $config['per_page'] = 30;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        // Tailwind styling for pagination
        $config['full_tag_open'] = '<div class="flex items-center gap-1 mt-4 justify-end font-sans">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['first_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['last_tag_close'] = '</span>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['next_tag_close'] = '</span>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="px-3 py-1.5 bg-accent-500 text-white rounded-md text-xs font-bold shadow-sm">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="px-3 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['num_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $config['per_page'];

        $data['portal'] = $portal;
        
        if ($portal === 'all') {
            $data['title'] = 'All History Logs';
        } elseif ($portal === 'beritasatu') {
            $data['title'] = 'BeritaSatu History Logs';
        } elseif ($portal === 'investor') {
            $data['title'] = 'Investor.id History Logs';
        } else {
            $data['title'] = 'JakartaGlobe History Logs';
        }

        $data['logs'] = $this->Send_log_model->get_filtered_logs($portal, $start_date, $end_date, $sort_col, $sort_order, $config['per_page'], $offset);
        $data['pagination_links'] = $this->pagination->create_links();
        $start_num = $config['total_rows'] > 0 ? ($offset + 1) : 0;
        $end_num = min($offset + $config['per_page'], $config['total_rows']);
        $data['showing_counter'] = "Menampilkan $start_num - $end_num dari {$config['total_rows']}";
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

    public function all()
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
