<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Appwrite\Query;
use Appwrite\ID;

class Send_log_model extends CI_Model {

    protected $db_id;
    protected $databases;

    public function __construct()
    {
        parent::__construct();
        $this->databases = $this->appwrite_client->get_databases();
        $this->db_id = $this->appwrite_client->get_db_id();
    }

    public function get_by_portal($portal)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletter_send_logs', [
                Query::equal('portal', $portal),
                Query::orderDesc('sent_at'),
                Query::limit(100)
            ]);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_by_portal logs error: ' . $e->getMessage());
            return [];
        }
    }

    public function get_by_id($id)
    {
        try {
            $doc_obj = $this->databases->getDocument($this->db_id, 'newsletter_send_logs', (string)$id);
            $doc = $doc_obj->toArray();
            $doc['id'] = $doc['$id'];
            return $doc;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_by_id log error: ' . $e->getMessage());
            return NULL;
        }
    }

    public function get_recent($limit = 10)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletter_send_logs', [
                Query::orderDesc('sent_at'),
                Query::limit((int)$limit)
            ]);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_recent logs error: ' . $e->getMessage());
            return [];
        }
    }

    public function count_all()
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletter_send_logs', [
                Query::limit(1)
            ]);
            $res_arr = $res->toArray();
            return $res_arr['total'] ?? 0;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite count_all logs error: ' . $e->getMessage());
            return 0;
        }
    }

    public function insert($data)
    {
        try {
            if (!isset($data['sent_at'])) {
                $data['sent_at'] = date('c');
            }
            unset($data['id']);
            if (isset($data['volume'])) {
                $data['volume'] = (int)$data['volume'];
            }
            if (isset($data['recipients_count'])) {
                $data['recipients_count'] = (int)$data['recipients_count'];
            }
            $doc_id = ID::unique();
            $doc_obj = $this->databases->createDocument($this->db_id, 'newsletter_send_logs', $doc_id, $data);
            $doc = $doc_obj->toArray();
            return $doc['$id'];
        } catch (\Exception $e) {
            log_message('error', 'Appwrite insert log error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function get_filtered_logs($portal = 'all', $start_date = null, $end_date = null, $sort_col = 'sent_at', $sort_order = 'desc', $limit = NULL, $offset = NULL)
    {
        $queries = [];

        if ($portal !== 'all') {
            $queries[] = Query::equal('portal', $portal);
        }
        if (!empty($start_date)) {
            $queries[] = Query::greaterThanEqual('sent_at', $start_date . 'T00:00:00Z');
        }
        if (!empty($end_date)) {
            $queries[] = Query::lessThanEqual('sent_at', $end_date . 'T23:59:59Z');
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
        if (strtolower($sort_order) === 'asc') {
            $queries[] = Query::orderAsc($sort_col_db);
        } else {
            $queries[] = Query::orderDesc($sort_col_db);
        }

        if ($limit !== NULL) {
            $queries[] = Query::limit((int)$limit);
        }
        if ($offset !== NULL) {
            $queries[] = Query::offset((int)$offset);
        }

        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletter_send_logs', $queries);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_filtered_logs error: ' . $e->getMessage());
            return [];
        }
    }

    public function count_filtered_logs($portal = 'all', $start_date = null, $end_date = null)
    {
        $queries = [
            Query::limit(1)
        ];

        if ($portal !== 'all') {
            $queries[] = Query::equal('portal', $portal);
        }
        if (!empty($start_date)) {
            $queries[] = Query::greaterThanEqual('sent_at', $start_date . 'T00:00:00Z');
        }
        if (!empty($end_date)) {
            $queries[] = Query::lessThanEqual('sent_at', $end_date . 'T23:59:59Z');
        }

        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletter_send_logs', $queries);
            $res_arr = $res->toArray();
            return $res_arr['total'] ?? 0;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite count_filtered_logs error: ' . $e->getMessage());
            return 0;
        }
    }
}
