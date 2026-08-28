<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Appwrite\Query;
use Appwrite\ID;

class Subscriber_model extends CI_Model {

    protected $db_id;
    protected $databases;

    public function __construct()
    {
        parent::__construct();
        $this->databases = $this->appwrite_client->get_databases();
        $this->db_id = $this->appwrite_client->get_db_id();
    }

    public function get_all($search = '', $sort_order = 'normal', $limit = NULL, $offset = NULL)
    {
        $queries = [];

        if (!empty($search)) {
            $queries[] = Query::or([
                Query::search('name', $search),
                Query::search('email', $search)
            ]);
        }

        if ($sort_order === 'asc') {
            $queries[] = Query::orderAsc('created_at');
        } elseif ($sort_order === 'desc') {
            $queries[] = Query::orderDesc('created_at');
        }

        if ($limit !== NULL) {
            $queries[] = Query::limit((int)$limit);
        }
        if ($offset !== NULL) {
            $queries[] = Query::offset((int)$offset);
        }

        try {
            $res = $this->databases->listDocuments($this->db_id, 'subscribers', $queries);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_all subscribers error: ' . $e->getMessage());
            return [];
        }
    }

    public function get_active()
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'subscribers', [
                Query::equal('status', 'active'),
                Query::limit(100)
            ]);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_active subscribers error: ' . $e->getMessage());
            return [];
        }
    }

    public function get_by_id($id)
    {
        try {
            $doc_obj = $this->databases->getDocument($this->db_id, 'subscribers', (string)$id);
            $doc = $doc_obj->toArray();
            $doc['id'] = $doc['$id'];
            return $doc;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_by_id subscriber error: ' . $e->getMessage());
            return NULL;
        }
    }

    public function get_by_email($email)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'subscribers', [
                Query::equal('email', $email),
                Query::limit(1)
            ]);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            if (!empty($docs)) {
                $doc = $docs[0];
                $doc['id'] = $doc['$id'];
                return $doc;
            }
            return NULL;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_by_email subscriber error: ' . $e->getMessage());
            return NULL;
        }
    }

    public function insert($data)
    {
        try {
            if (!isset($data['created_at'])) {
                $data['created_at'] = date('c');
            }
            unset($data['id']);
            $this->databases->createDocument($this->db_id, 'subscribers', ID::unique(), $data);
            return TRUE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite insert subscriber error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function insert_batch($data)
    {
        if (empty($data)) return 0;
        $count = 0;
        foreach ($data as $row) {
            if ($this->insert($row)) {
                $count++;
            }
        }
        return $count;
    }

    public function update($id, $data)
    {
        try {
            unset($data['id']);
            unset($data['$id']);
            $this->databases->updateDocument($this->db_id, 'subscribers', (string)$id, $data);
            return TRUE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite update subscriber error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function update_by_email($email, $data)
    {
        try {
            $sub = $this->get_by_email($email);
            if ($sub) {
                return $this->update($sub['id'], $data);
            }
            return FALSE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite update_by_email subscriber error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function delete($id)
    {
        // Soft delete: set status to inactive
        return $this->update($id, ['status' => 'inactive']);
    }

    public function get_recent($limit = 10)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'subscribers', [
                Query::orderDesc('created_at'),
                Query::limit((int)$limit)
            ]);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_recent subscribers error: ' . $e->getMessage());
            return [];
        }
    }

    public function count_all($search = '')
    {
        $queries = [Query::limit(1)];
        if (!empty($search)) {
            $queries[] = Query::or([
                Query::search('name', $search),
                Query::search('email', $search)
            ]);
        }
        try {
            $res = $this->databases->listDocuments($this->db_id, 'subscribers', $queries);
            $res_arr = $res->toArray();
            return $res_arr['total'] ?? 0;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite count_all subscribers error: ' . $e->getMessage());
            return 0;
        }
    }

    public function get_by_ids($ids)
    {
        if (empty($ids)) return [];
        $docs = [];
        foreach ($ids as $id) {
            $sub = $this->get_by_id($id);
            if ($sub) {
                $docs[] = $sub;
            }
        }
        return $docs;
    }
}
