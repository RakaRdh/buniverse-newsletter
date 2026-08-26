<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($search = '')
    {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
        }
        $query = $this->db->get('subscribers');
        return $query->result_array();
    }

    public function get_active()
    {
        $query = $this->db->get_where('subscribers', ['status' => 'active']);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('subscribers', ['id' => $id]);
        return $query->row_array();
    }

    public function get_by_email($email)
    {
        $query = $this->db->get_where('subscribers', ['email' => $email]);
        return $query->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert('subscribers', $data);
    }

    public function insert_batch($data)
    {
        if (empty($data)) return 0;
        return $this->db->insert_batch('subscribers', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('subscribers', $data);
    }

    public function update_by_email($email, $data)
    {
        $this->db->where('email', $email);
        return $this->db->update('subscribers', $data);
    }

    public function delete($id)
    {
        // Soft delete: set status to inactive
        $this->db->where('id', $id);
        return $this->db->update('subscribers', ['status' => 'inactive']);
    }
}
