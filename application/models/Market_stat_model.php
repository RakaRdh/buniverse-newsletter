<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Appwrite\Query;
use Appwrite\ID;

class Market_stat_model extends CI_Model {

    protected $db_id;
    protected $databases;

    public function __construct()
    {
        parent::__construct();
        $this->databases = $this->appwrite_client->get_databases();
        $this->db_id = $this->appwrite_client->get_db_id();
    }

    public function get_by_newsletter($newsletter_id)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'market_stats', [
                Query::equal('newsletter_id', (string)$newsletter_id),
                Query::orderAsc('sort_order'),
                Query::limit(50)
            ]);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_by_newsletter stats error: ' . $e->getMessage());
            return [];
        }
    }

    public function insert($data)
    {
        try {
            unset($data['id']);
            if (isset($data['sort_order'])) {
                $data['sort_order'] = (int)$data['sort_order'];
            }
            $this->databases->createDocument($this->db_id, 'market_stats', ID::unique(), $data);
            return TRUE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite insert stat error: ' . $e->getMessage());
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

    public function delete_by_newsletter($newsletter_id)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'market_stats', [
                Query::equal('newsletter_id', (string)$newsletter_id),
                Query::limit(50)
            ]);
            $res_arr = $res->toArray();
            foreach (($res_arr['documents'] ?? []) as $doc) {
                $this->databases->deleteDocument($this->db_id, 'market_stats', $doc['$id']);
            }
            return TRUE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite delete_by_newsletter stats error: ' . $e->getMessage());
            return FALSE;
        }
    }
}
