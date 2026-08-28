<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Appwrite\Query;
use Appwrite\ID;

class Newsletter_model extends CI_Model {

    protected $db_id;
    protected $databases;

    public function __construct()
    {
        parent::__construct();
        $this->databases = $this->appwrite_client->get_databases();
        $this->db_id = $this->appwrite_client->get_db_id();
    }

    public function get_all($portal = NULL, $limit = NULL, $offset = NULL)
    {
        $queries = [
            Query::orderDesc('created_at')
        ];
        if ($portal !== NULL) {
            $queries[] = Query::equal('portal', $portal);
        }
        if ($limit !== NULL) {
            $queries[] = Query::limit((int)$limit);
        }
        if ($offset !== NULL) {
            $queries[] = Query::offset((int)$offset);
        }

        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletters', $queries);
            $res_arr = $res->toArray();
            $docs = $res_arr['documents'] ?? [];
            foreach ($docs as &$doc) {
                $doc['id'] = $doc['$id'];
            }
            return $docs;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_all error: ' . $e->getMessage());
            return [];
        }
    }

    public function get_by_id($id)
    {
        try {
            $doc_obj = $this->databases->getDocument($this->db_id, 'newsletters', (string)$id);
            $doc = $doc_obj->toArray();
            $doc['id'] = $doc['$id'];
            return $doc;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite get_by_id error: ' . $e->getMessage());
            return NULL;
        }
    }

    public function insert($data)
    {
        try {
            $doc_id = ID::unique();
            
            if (!isset($data['created_at'])) {
                $data['created_at'] = date('c');
            }

            unset($data['id']);

            if (isset($data['volume'])) {
                $data['volume'] = (int)$data['volume'];
            }

            $doc_obj = $this->databases->createDocument($this->db_id, 'newsletters', $doc_id, $data);
            $doc = $doc_obj->toArray();
            $newsletter_id = $doc['$id'];

            $portal = $data['portal'];
            $articles = [];
            if ($portal === 'beritasatu') {
                $articles = [
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'main', 'sort_order' => 1, 'title' => 'Main Article Title', 'excerpt' => '', 'category' => 'Fokus Topik', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'grid', 'sort_order' => 2, 'title' => 'Grid Article 1 Title', 'excerpt' => '', 'category' => 'Nasional', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'grid', 'sort_order' => 3, 'title' => 'Grid Article 2 Title', 'excerpt' => '', 'category' => 'Nasional', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'grid', 'sort_order' => 4, 'title' => 'Grid Article 3 Title', 'excerpt' => '', 'category' => 'Nasional', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'grid', 'sort_order' => 5, 'title' => 'Grid Article 4 Title', 'excerpt' => '', 'category' => 'Nasional', 'image_url' => '']
                ];
            } elseif ($portal === 'investor') {
                $articles = [
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'main', 'sort_order' => 1, 'title' => 'Featured Article Title', 'excerpt' => '', 'category' => 'Market', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'list', 'sort_order' => 2, 'title' => 'List Article 1 Title', 'excerpt' => '', 'category' => 'Market', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'list', 'sort_order' => 3, 'title' => 'List Article 2 Title', 'excerpt' => '', 'category' => 'Market', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'list', 'sort_order' => 4, 'title' => 'List Article 3 Title', 'excerpt' => '', 'category' => 'Market', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'list', 'sort_order' => 5, 'title' => 'List Article 4 Title', 'excerpt' => '', 'category' => 'Market', 'image_url' => '']
                ];

                $stats = ['IHSG', 'USD/IDR', 'EMAS', 'BTC'];
                $order = 1;
                foreach ($stats as $st) {
                    $this->databases->createDocument($this->db_id, 'market_stats', ID::unique(), [
                        'newsletter_id' => $newsletter_id,
                        'label' => $st,
                        'value' => '0.0%',
                        'direction' => 'up',
                        'sort_order' => $order++
                    ]);
                }
            } elseif ($portal === 'jakartaglobe') {
                $articles = [
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'main', 'sort_order' => 1, 'title' => 'Main Topic Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'sidebar', 'sort_order' => 2, 'title' => 'Sidebar Topic 1 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'sidebar', 'sort_order' => 3, 'title' => 'Sidebar Topic 2 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'sidebar', 'sort_order' => 4, 'title' => 'Sidebar Topic 3 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'sidebar', 'sort_order' => 5, 'title' => 'Sidebar Topic 4 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'sidebar', 'sort_order' => 6, 'title' => 'Sidebar Topic 5 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'alternating', 'sort_order' => 7, 'title' => 'Alternating Topic 1 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'alternating', 'sort_order' => 8, 'title' => 'Alternating Topic 2 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'alternating', 'sort_order' => 9, 'title' => 'Alternating Topic 3 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''],
                    ['newsletter_id' => $newsletter_id, 'article_type' => 'alternating', 'sort_order' => 10, 'title' => 'Alternating Topic 4 Title', 'excerpt' => '', 'category' => 'World', 'image_url' => '']
                ];
            }

            if (!empty($articles)) {
                foreach ($articles as $art) {
                    $this->databases->createDocument($this->db_id, 'newsletter_articles', ID::unique(), $art);
                }
            }

            return $newsletter_id;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite insert error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function update($id, $data)
    {
        try {
            unset($data['id']);
            unset($data['$id']);
            if (isset($data['volume'])) {
                $data['volume'] = (int)$data['volume'];
            }
            $this->databases->updateDocument($this->db_id, 'newsletters', (string)$id, $data);
            return TRUE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite update error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function delete($id)
    {
        try {
            // Delete related articles
            $res = $this->databases->listDocuments($this->db_id, 'newsletter_articles', [
                Query::equal('newsletter_id', (string)$id),
                Query::limit(100)
            ]);
            $res_arr = $res->toArray();
            foreach (($res_arr['documents'] ?? []) as $art) {
                $this->databases->deleteDocument($this->db_id, 'newsletter_articles', $art['$id']);
            }

            // Delete market stats
            $res_stats = $this->databases->listDocuments($this->db_id, 'market_stats', [
                Query::equal('newsletter_id', (string)$id),
                Query::limit(100)
            ]);
            $res_stats_arr = $res_stats->toArray();
            foreach (($res_stats_arr['documents'] ?? []) as $st) {
                $this->databases->deleteDocument($this->db_id, 'market_stats', $st['$id']);
            }

            $this->databases->deleteDocument($this->db_id, 'newsletters', (string)$id);
            return TRUE;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite delete error: ' . $e->getMessage());
            return FALSE;
        }
    }

    public function count_all($portal = NULL)
    {
        $queries = [
            Query::limit(1)
        ];
        if ($portal !== NULL) {
            $queries[] = Query::equal('portal', $portal);
        }
        try {
            $res = $this->databases->listDocuments($this->db_id, 'newsletters', $queries);
            $res_arr = $res->toArray();
            return $res_arr['total'] ?? 0;
        } catch (\Exception $e) {
            log_message('error', 'Appwrite count_all error: ' . $e->getMessage());
            return 0;
        }
    }
}
