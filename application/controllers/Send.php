<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Newsletter_model');
        $this->load->model('Newsletter_article_model');
        $this->load->model('Market_stat_model');
        $this->load->model('Subscriber_model');
        $this->load->library('newsletter_mailer');
    }

    public function newsletter($id)
    {
        $newsletter = $this->Newsletter_model->get_by_id($id);
        if (!$newsletter) {
            $this->session->set_flashdata('error', 'Newsletter tidak ditemukan.');
            redirect('newsletters');
        }

        if ($newsletter['status'] === 'sent') {
            $this->session->set_flashdata('error', 'Newsletter ini sudah pernah dikirim sebelumnya.');
            redirect('newsletters');
        }

        // If GET request, show confirmation page with subscriber checklist
        if ($this->input->method() === 'get') {
            $data['title'] = 'Confirm & Send Newsletter';
            $data['newsletter'] = $newsletter;
            $data['subscribers'] = $this->Subscriber_model->get_all(); // Get all subscribers
            $data['admin'] = $this->admin;
            
            $this->load->view('admin/send_confirm', $data);
            return;
        }

        // POST Request: Process sending
        $selected_ids = $this->input->post('subscribers');
        if (empty($selected_ids)) {
            $this->session->set_flashdata('error', 'Silakan pilih minimal satu subscriber untuk dikirimi newsletter.');
            redirect('send/newsletter/' . $id);
        }

        $articles = $this->Newsletter_article_model->get_by_newsletter($id);
        $stats = $this->Market_stat_model->get_by_newsletter($id);
        $subscribers = $this->Subscriber_model->get_by_ids($selected_ids);

        if (empty($subscribers)) {
            $this->session->set_flashdata('error', 'Subscriber yang dipilih tidak valid atau tidak aktif.');
            redirect('send/newsletter/' . $id);
        }

        // Trigger compilation & send email
        $result = $this->newsletter_mailer->send($newsletter, $articles, $stats, $subscribers);

        if ($result['success'] > 0) {
            // Update status in DB
            $this->Newsletter_model->update($id, [
                'status' => 'sent',
                'sent_at' => date('Y-m-d H:i:s')
            ]);

            // Create Content Summary for logs
            $main_article = null;
            $grid_articles = [];
            $list_articles = [];
            $sidebar_articles = [];
            $alternating_articles = [];

            foreach ($articles as $art) {
                switch ($art['article_type']) {
                    case 'main': $main_article = $art; break;
                    case 'grid': $grid_articles[] = $art; break;
                    case 'list': $list_articles[] = $art; break;
                    case 'sidebar': $sidebar_articles[] = $art; break;
                    case 'alternating': $alternating_articles[] = $art; break;
                }
            }

            $summary = "Main Article:\n- " . (!empty($main_article) ? $main_article['title'] : 'None') . "\n\n";
            if (!empty($grid_articles)) {
                $summary .= "Grid Articles:\n";
                foreach ($grid_articles as $art) {
                    $summary .= "- " . $art['title'] . " (" . $art['category'] . ")\n";
                }
                $summary .= "\n";
            }
            if (!empty($list_articles)) {
                $summary .= "List Articles:\n";
                foreach ($list_articles as $art) {
                    $summary .= "- " . $art['title'] . " (" . $art['category'] . ")\n";
                }
                $summary .= "\n";
            }
            if (!empty($sidebar_articles)) {
                $summary .= "Sidebar Articles:\n";
                foreach ($sidebar_articles as $art) {
                    $summary .= "- " . $art['title'] . "\n";
                }
                $summary .= "\n";
            }
            if (!empty($alternating_articles)) {
                $summary .= "Alternating Articles:\n";
                foreach ($alternating_articles as $art) {
                    $summary .= "- " . $art['title'] . "\n";
                }
                $summary .= "\n";
            }
            if (!empty($stats)) {
                $summary .= "Market Tickers:\n";
                foreach ($stats as $st) {
                    $summary .= "- " . $st['label'] . ": " . $st['value'] . " (" . $st['direction'] . ")\n";
                }
            }

            $this->load->model('Send_log_model');
            $log_id = $this->Send_log_model->insert([
                'newsletter_id' => $id,
                'portal' => $newsletter['portal'],
                'subject' => $newsletter['subject'],
                'volume' => $newsletter['volume'],
                'recipients_count' => $result['success'],
                'content_summary' => trim($summary)
            ]);

            // Save individual recipients to DB
            if (!empty($result['recipients'])) {
                $recipients_data = [];
                foreach ($result['recipients'] as $rec) {
                    $recipients_data[] = [
                        'send_log_id' => $log_id,
                        'subscriber_name' => $rec['name'],
                        'subscriber_email' => $rec['email'],
                        'status' => $rec['status'],
                        'error_message' => $rec['error_message']
                    ];
                }
                $this->db->insert_batch('newsletter_send_recipients', $recipients_data);
            }

            $msg = "Newsletter berhasil dikirim ke {$result['success']} subscriber.";
            if ($result['fail'] > 0) {
                $msg .= " Gagal mengirim ke {$result['fail']} subscriber (silakan cek log).";
            }
            $this->session->set_flashdata('success', $msg);
        } else {
            $this->session->set_flashdata('error', 'Gagal mengirim email: ' . implode('<br>', $result['errors']));
        }

        redirect('newsletters');
    }
}
