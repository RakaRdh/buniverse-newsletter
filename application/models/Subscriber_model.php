<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($search = '', $sort_order = 'normal', $limit = NULL, $offset = NULL)
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }

        if ($sort_order === 'asc') {
            $this->db->order_by('created_at', 'ASC');
        } elseif ($sort_order === 'desc') {
            $this->db->order_by('created_at', 'DESC');
        }

        if ($limit !== NULL && $offset !== NULL) {
            $this->db->limit($limit, $offset);
        } elseif ($limit !== NULL) {
            $this->db->limit($limit);
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

    public function get_recent($limit = 10)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('subscribers');
        return $query->result_array();
    }

    public function count_all($search = '')
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('subscribers');
    }

    public function get_by_ids($ids)
    {
        if (empty($ids)) return [];
        $this->db->where_in('id', $ids);
        $query = $this->db->get('subscribers');
        return $query->result_array();
    }
}
