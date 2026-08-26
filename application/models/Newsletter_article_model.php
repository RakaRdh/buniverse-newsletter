<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_article_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_newsletter($newsletter_id)
    {
        $this->db->where('newsletter_id', $newsletter_id);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('newsletter_articles');
        return $query->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('newsletter_articles', $data);
    }

    public function insert_batch($data)
    {
        if (empty($data)) return 0;
        return $this->db->insert_batch('newsletter_articles', $data);
    }

    public function delete_by_newsletter($newsletter_id)
    {
        $this->db->where('newsletter_id', $newsletter_id);
        return $this->db->delete('newsletter_articles');
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('newsletter_articles');
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('newsletter_articles', $data);
    }
}
