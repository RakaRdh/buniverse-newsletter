<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletters extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Newsletter_model');
        $this->load->model('Newsletter_article_model');
        $this->load->model('Market_stat_model');
    }

    public function index()
    {
        $portal = $this->input->get('portal');
        $allowed_portals = ['beritasatu', 'investor', 'jakartaglobe'];
        if ($portal !== NULL && !in_array($portal, $allowed_portals)) {
            show_404();
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('newsletters');
        $config['total_rows'] = $this->Newsletter_model->count_all($portal);
        $config['per_page'] = 20;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        // Tailwind styling for pagination
        $config['full_tag_open'] = '<div class="flex items-center gap-1 mt-4 justify-end font-sans">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['first_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['last_tag_close'] = '</span>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['next_tag_close'] = '</span>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<span class="px-2.5 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="px-3 py-1.5 bg-accent-500 text-white rounded-md text-xs font-bold shadow-sm">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="px-3 py-1.5 border border-ink-150 rounded-md text-xs text-ink-700 bg-white hover:bg-ink-50">';
        $config['num_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $config['per_page'];

        $data['newsletters'] = $this->Newsletter_model->get_all($portal, $config['per_page'], $offset);
        $data['pagination_links'] = $this->pagination->create_links();
        $start_num = $config['total_rows'] > 0 ? ($offset + 1) : 0;
        $end_num = min($offset + $config['per_page'], $config['total_rows']);
        $data['showing_counter'] = "Menampilkan $start_num - $end_num dari {$config['total_rows']}";
        $data['portal'] = $portal;
        $data['admin'] = $this->admin;

        // Title
        if ($portal === 'beritasatu') {
            $data['title'] = 'BeritaSatu Newsletters';
        } elseif ($portal === 'investor') {
            $data['title'] = 'Investor Daily Newsletters';
        } elseif ($portal === 'jakartaglobe') {
            $data['title'] = 'JakartaGlobe Newsletters';
        } else {
            $data['title'] = 'All Newsletters';
        }

        $this->load->view('admin/newsletter_list', $data);
    }

    public function templates()
    {
        $data['title'] = 'Preview Templates';
        $data['admin'] = $this->admin;
        $this->load->view('admin/templates_preview', $data);
    }

    public function create($portal = 'beritasatu')
    {
        redirect('newsletters/add/' . $portal);
    }

    public function add($portal = 'beritasatu')
    {
        $allowed_portals = ['beritasatu', 'investor', 'jakartaglobe'];
        if (!in_array($portal, $allowed_portals)) {
            show_404();
        }

        $data['action'] = 'create';
        $data['newsletter'] = ['portal' => $portal];
        $data['admin'] = $this->admin;
        $this->load->view('admin/newsletter_create', $data);
    }

    public function edit($id)
    {
        $data['action'] = 'edit';
        $data['newsletter'] = $this->Newsletter_model->get_by_id($id);
        
        if (!$data['newsletter']) {
            show_404();
        }

        $portal = $data['newsletter']['portal'];
        $data['articles'] = $this->Newsletter_article_model->get_by_newsletter($id);
        $stats = $this->Market_stat_model->get_by_newsletter($id);
        
        $data['stats_map'] = [];
        foreach ($stats as $s) {
            $data['stats_map'][$s['label']] = $s;
        }

        $data['admin'] = $this->admin;
        $this->load->view('admin/' . $portal . '_form', $data);
    }

    public function save()
    {
        $id = $this->input->post('id');
        $portal = $this->input->post('portal');
        $volume = $this->input->post('volume');
        $subject = $this->input->post('subject');
        $greeting_title = $this->input->post('greeting_title');
        $greeting_body = $this->input->post('greeting_body');

        $db_data = [
            'portal' => $portal,
            'volume' => $volume,
            'subject' => $subject,
            'greeting_title' => $greeting_title,
            'greeting_body' => $greeting_body,
        ];

        if ($id) {
            $this->Newsletter_model->update($id, $db_data);

            // Update articles dynamically
            $articles_post = $this->input->post('articles');
            if (!empty($articles_post)) {
                foreach ($articles_post as $art) {
                    if (isset($art['id'])) {
                        $this->Newsletter_article_model->update($art['id'], [
                            'title' => $art['title'],
                            'excerpt' => isset($art['excerpt']) ? $art['excerpt'] : '',
                            'category' => isset($art['category']) ? $art['category'] : '',
                            'image_url' => isset($art['image_url']) ? $art['image_url'] : '',
                            'url' => isset($art['url']) ? $art['url'] : ''
                        ]);
                    }
                }
            }
            
            if ($portal === 'investor') {
                $this->Market_stat_model->delete_by_newsletter($id);
                $stats = $this->input->post('stats');
                if (!empty($stats)) {
                    $stats_to_insert = [];
                    $order = 1;
                    foreach ($stats as $label => $val) {
                        if (!empty($val['value'])) {
                            $stats_to_insert[] = [
                                'newsletter_id' => $id,
                                'label' => $label,
                                'value' => $val['value'],
                                'direction' => $val['direction'],
                                'sort_order' => $order++
                            ];
                        }
                    }
                    if (!empty($stats_to_insert)) {
                        $this->Market_stat_model->insert_batch($stats_to_insert);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Newsletter berhasil diperbarui.');
            redirect('newsletters?portal=' . $portal);
        } else {
            $new_id = $this->Newsletter_model->insert($db_data);

            // Update newly created placeholder articles
            $articles_post = $this->input->post('articles');
            if (!empty($articles_post)) {
                $inserted_articles = $this->Newsletter_article_model->get_by_newsletter($new_id);
                foreach ($articles_post as $idx => $art) {
                    if (isset($inserted_articles[$idx])) {
                        $this->Newsletter_article_model->update($inserted_articles[$idx]['id'], [
                            'title' => $art['title'],
                            'excerpt' => isset($art['excerpt']) ? $art['excerpt'] : '',
                            'category' => isset($art['category']) ? $art['category'] : '',
                            'image_url' => isset($art['image_url']) ? $art['image_url'] : '',
                            'url' => isset($art['url']) ? $art['url'] : ''
                        ]);
                    }
                }
            }

            // If Investor, update IHSG/USD tickers
            if ($portal === 'investor') {
                $this->Market_stat_model->delete_by_newsletter($new_id);
                $stats = $this->input->post('stats');
                if (!empty($stats)) {
                    $stats_to_insert = [];
                    $order = 1;
                    foreach ($stats as $label => $val) {
                        if (!empty($val['value'])) {
                            $stats_to_insert[] = [
                                'newsletter_id' => $new_id,
                                'label' => $label,
                                'value' => $val['value'],
                                'direction' => $val['direction'],
                                'sort_order' => $order++
                            ];
                        }
                    }
                    if (!empty($stats_to_insert)) {
                        $this->Market_stat_model->insert_batch($stats_to_insert);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Newsletter berhasil dibuat.');
            redirect('logs/' . $portal);
        }
    }

    public function add_article()
    {
        $newsletter_id = $this->input->post('newsletter_id');
        $article_type = $this->input->post('article_type');
        $title = $this->input->post('title');
        $excerpt = $this->input->post('excerpt');
        $image_url = $this->input->post('image_url');
        $category = $this->input->post('category');
        $sort_order = $this->input->post('sort_order');

        $art_data = [
            'newsletter_id' => $newsletter_id,
            'article_type' => $article_type,
            'title' => $title,
            'excerpt' => $excerpt,
            'image_url' => $image_url,
            'category' => $category,
            'sort_order' => $sort_order ? $sort_order : 0
        ];

        $this->Newsletter_article_model->insert($art_data);
        $this->session->set_flashdata('success', 'Artikel berhasil ditambahkan.');
        redirect('newsletters/edit/' . $newsletter_id);
    }

    public function delete_article($id, $newsletter_id)
    {
        $this->Newsletter_article_model->delete($id);
        $this->session->set_flashdata('success', 'Artikel berhasil dihapus.');
        redirect('newsletters/edit/' . $newsletter_id);
    }

    public function delete($id)
    {
        $this->Newsletter_model->delete($id);
        $this->session->set_flashdata('success', 'Newsletter berhasil dihapus.');
        redirect('newsletters');
    }

    public function reset_status($id)
    {
        $this->Newsletter_model->update($id, [
            'status' => 'draft',
            'sent_at' => NULL
        ]);
        $this->session->set_flashdata('success', 'Status newsletter berhasil direset kembali ke draft.');
        redirect('newsletters');
    }

    public function detail($id)
    {
        $data['newsletter'] = $this->Newsletter_model->get_by_id($id);
        if (!$data['newsletter']) {
            show_404();
        }

        $this->load->model('Send_log_model');
        $send_log = $this->db->get_where('newsletter_send_logs', ['newsletter_id' => $id])->row_array();
        
        $data['recipients'] = [];
        $data['send_log'] = $send_log;
        if ($send_log) {
            $data['recipients'] = $this->db->get_where('newsletter_send_recipients', ['send_log_id' => $send_log['id']])->result_array();
        }

        $this->load->view('admin/newsletter_detail', $data);
    }

    public function render_html($id)
    {
        $newsletter = $this->Newsletter_model->get_by_id($id);
        if (!$newsletter) {
            show_404();
        }

        $articles = $this->Newsletter_article_model->get_by_newsletter($id);
        $stats = $this->Market_stat_model->get_by_newsletter($id);

        $main_article = null;
        $grid_articles = [];
        $list_articles = [];
        $sidebar_articles = [];
        $alternating_articles = [];

        foreach ($articles as $art) {
            switch ($art['article_type']) {
                case 'main':
                    $main_article = $art;
                    break;
                case 'grid':
                    $grid_articles[] = $art;
                    break;
                case 'list':
                    $list_articles[] = $art;
                    break;
                case 'sidebar':
                    $sidebar_articles[] = $art;
                    break;
                case 'alternating':
                    $alternating_articles[] = $art;
                    break;
            }
        }

        $portal = $newsletter['portal'];
        $subject = $newsletter['subject'];
        $volume = $newsletter['volume'];
        $greeting_title = $newsletter['greeting_title'];
        $greeting_body = $newsletter['greeting_body'];
        
        $days = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $months = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];

        $timestamp = !empty($newsletter['sent_at']) ? strtotime($newsletter['sent_at']) : strtotime($newsletter['created_at']);
        $dayName = $days[date('l', $timestamp)];
        $monthName = $months[date('F', $timestamp)];
        $dateStr = "$dayName, " . date('d', $timestamp) . " $monthName " . date('Y', $timestamp);
        
        if ($portal === 'jakartaglobe') {
            $dateStr = date('l, d M Y', $timestamp);
        }

        $default_name = $this->config->item('default_recipient_name') ?: 'Sahabat B-Universe';
        $viewData = [
            'subject' => $subject,
            'date' => $dateStr,
            'volume' => $volume,
            'greeting_title' => str_replace('[Nama Subscriber]', $default_name, $greeting_title),
            'greeting_body' => str_replace('[Nama Subscriber]', $default_name, $greeting_body),
            'main_article' => $main_article,
            'grid_articles' => $grid_articles,
            'list_articles' => $list_articles,
            'sidebar_articles' => $sidebar_articles,
            'alternating_articles' => $alternating_articles,
            'market_stats' => $stats,
            'subscriber_email' => 'helpdeskonit007@gmail.com',
            'subscriber_name' => $default_name
        ];

        $this->load->view('emails/' . $portal . '_template', $viewData);
    }
}
