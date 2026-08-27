<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($portal = NULL)
    {
        if ($portal !== NULL) {
            $this->db->where('portal', $portal);
        }
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('newsletters');
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('newsletters', ['id' => $id]);
        return $query->row_array();
    }

    public function insert($data)
    {
        $this->db->insert('newsletters', $data);
        $newsletter_id = $this->db->insert_id();

        $portal = $data['portal'];
        $articles = [];
        if ($portal === 'beritasatu') {
            $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'main', 'sort_order' => 1, 'title' => 'Main Article Title', 'excerpt' => '', 'category' => 'Fokus Topik', 'image_url' => ''];
            for ($i = 1; $i <= 4; $i++) {
                $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'grid', 'sort_order' => $i + 1, 'title' => "Grid Article $i Title", 'excerpt' => '', 'category' => 'Nasional', 'image_url' => ''];
            }
        } elseif ($portal === 'investor') {
            $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'main', 'sort_order' => 1, 'title' => 'Featured Article Title', 'excerpt' => '', 'category' => 'Market', 'image_url' => ''];
            for ($i = 1; $i <= 4; $i++) {
                $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'list', 'sort_order' => $i + 1, 'title' => "List Article $i Title", 'excerpt' => '', 'category' => 'Market', 'image_url' => ''];
            }

            // Auto-create market stats
            $stats = ['IHSG', 'USD/IDR', 'EMAS', 'BTC'];
            $stats_data = [];
            $order = 1;
            foreach ($stats as $st) {
                $stats_data[] = [
                    'newsletter_id' => $newsletter_id,
                    'label' => $st,
                    'value' => '0.0%',
                    'direction' => 'up',
                    'sort_order' => $order++
                ];
            }
            $this->db->insert_batch('market_stats', $stats_data);

        } elseif ($portal === 'jakartaglobe') {
            $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'main', 'sort_order' => 1, 'title' => 'Main Topic Title', 'excerpt' => '', 'category' => 'World', 'image_url' => ''];
            for ($i = 1; $i <= 3; $i++) {
                $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'sidebar', 'sort_order' => $i + 1, 'title' => "Sidebar Topic $i Title", 'excerpt' => '', 'category' => 'World', 'image_url' => ''];
            }
            for ($i = 1; $i <= 4; $i++) {
                $articles[] = ['newsletter_id' => $newsletter_id, 'article_type' => 'alternating', 'sort_order' => $i + 4, 'title' => "Alternating Topic $i Title", 'excerpt' => '', 'category' => 'World', 'image_url' => ''];
            }
        }

        if (!empty($articles)) {
            $this->db->insert_batch('newsletter_articles', $articles);
        }

        return $newsletter_id;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('newsletters', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('newsletters');
    }

    public function count_all()
    {
        return $this->db->count_all('newsletters');
    }
}
