<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_stat_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_newsletter($newsletter_id)
    {
        $this->db->where('newsletter_id', $newsletter_id);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('market_stats');
        return $query->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('market_stats', $data);
    }

    public function insert_batch($data)
    {
        if (empty($data)) return 0;
        return $this->db->insert_batch('market_stats', $data);
    }

    public function delete_by_newsletter($newsletter_id)
    {
        $this->db->where('newsletter_id', $newsletter_id);
        return $this->db->delete('market_stats');
    }
}
