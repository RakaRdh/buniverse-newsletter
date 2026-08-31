<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Appwrite\Query;

class Admin_model extends CI_Model {
    protected $db_id;
    protected $databases;

    public function __construct()
    {
        parent::__construct();
        $this->databases = $this->appwrite_client->get_databases();
        $this->db_id = $this->appwrite_client->get_db_id();
    }

    public function get_by_username($username)
    {
        try {
            $res = $this->databases->listDocuments($this->db_id, 'admins', [
                Query::equal('username', $username),
                Query::limit(1)
            ]);
            $res_arr = $res->toArray();
            if (!empty($res_arr['documents'])) {
                $doc = $res_arr['documents'][0];
                $doc['id'] = $doc['$id'];
                return $doc;
            }
        } catch (\Exception $e) {
            log_message('error', 'Appwrite admins query error: ' . $e->getMessage());
        }
        // Fallback for default hardcoded admin user
        if ($username === 'admin') {
            return [
                'id' => 'default_admin',
                'username' => 'admin',
                'password' => '123',
                'name' => 'Super Admin'
            ];
        }
        return null;
    }
}
