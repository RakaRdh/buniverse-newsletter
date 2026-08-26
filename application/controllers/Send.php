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

        $articles = $this->Newsletter_article_model->get_by_newsletter($id);
        $stats = $this->Market_stat_model->get_by_newsletter($id);
        $subscribers = $this->Subscriber_model->get_active();

        if (empty($subscribers)) {
            $this->session->set_flashdata('error', 'Tidak ada subscriber aktif untuk dikirimi newsletter.');
            redirect('newsletters');
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
            $this->Send_log_model->insert([
                'newsletter_id' => $id,
                'portal' => $newsletter['portal'],
                'subject' => $newsletter['subject'],
                'volume' => $newsletter['volume'],
                'recipients_count' => $result['success'],
                'content_summary' => trim($summary)
            ]);

            $msg = "Newsletter berhasil dikirim ke {$result['success']} subscriber aktif.";
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
