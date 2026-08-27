<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_log_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_portal($portal)
    {
        $this->db->where('portal', $portal);
        $this->db->order_by('sent_at', 'DESC');
        $query = $this->db->get('newsletter_send_logs');
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('newsletter_send_logs', ['id' => $id]);
        return $query->row_array();
    }

    public function get_recent($limit = 10)
    {
        $this->db->order_by('sent_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('newsletter_send_logs');
        return $query->result_array();
    }

    public function count_all()
    {
        return $this->db->count_all('newsletter_send_logs');
    }

    public function insert($data)
    {
        $this->db->insert('newsletter_send_logs', $data);
        return $this->db->insert_id();
    }

    public function get_filtered_logs($portal = 'all', $start_date = null, $end_date = null, $sort_col = 'sent_at', $sort_order = 'desc', $limit = NULL, $offset = NULL)
    {
        if ($portal !== 'all') {
            $this->db->where('portal', $portal);
        }
        if (!empty($start_date)) {
            $this->db->where('sent_at >=', $start_date . ' 00:00:00');
        }
        if (!empty($end_date)) {
            $this->db->where('sent_at <=', $end_date . ' 23:59:59');
        }

        // Validate sorting column
        $allowed_cols = ['sent_at', 'recipients_count'];
        $sort_col_db = 'sent_at';
        if ($sort_col === 'recipients') {
            $sort_col_db = 'recipients_count';
        } elseif (in_array($sort_col, $allowed_cols)) {
            $sort_col_db = $sort_col;
        }

        // Validate sort order
        $sort_order = strtolower($sort_order) === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_col_db, $sort_order);

        if ($limit !== NULL && $offset !== NULL) {
            $this->db->limit($limit, $offset);
        } elseif ($limit !== NULL) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('newsletter_send_logs');
        return $query->result_array();
    }

    public function count_filtered_logs($portal = 'all', $start_date = null, $end_date = null)
    {
        if ($portal !== 'all') {
            $this->db->where('portal', $portal);
        }
        if (!empty($start_date)) {
            $this->db->where('sent_at >=', $start_date . ' 00:00:00');
        }
        if (!empty($end_date)) {
            $this->db->where('sent_at <=', $end_date . ' 23:59:59');
        }
        return $this->db->count_all_results('newsletter_send_logs');
    }
}
