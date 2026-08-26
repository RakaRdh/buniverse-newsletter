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

    public function insert($data)
    {
        return $this->db->insert('newsletter_send_logs', $data);
    }
}
