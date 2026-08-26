<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_mailer {

    protected $CI;
    protected $smtp_user;
    protected $smtp_host;
    protected $smtp_from;

    public function __construct()
    {
        $this->CI =& get_instance();
        // Load email library with custom config
        $this->CI->load->config('email');
        $this->CI->load->library('email');
        $this->smtp_user = $this->CI->config->item('smtp_user');
        $this->smtp_host = $this->CI->config->item('smtp_host');
        $this->smtp_from = getenv('SMTP_FROM') !== FALSE ? getenv('SMTP_FROM') : 'newsletter@b-universe.id';
    }

    public function send($newsletter, $articles, $stats, $subscribers)
    {
        // 1. Prepare dynamic data
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

        $success_count = 0;
        $fail_count = 0;
        $errors = [];

        $is_simulated = empty($this->smtp_user) || (strpos($this->smtp_host, 'mailtrap') !== false && empty($this->smtp_user));

        if (!$is_simulated) {
            $this->CI->email->initialize([
                'protocol' => 'smtp',
                'smtp_host' => $this->smtp_host,
                'smtp_port' => $this->CI->config->item('smtp_port'),
                'smtp_user' => $this->smtp_user,
                'smtp_pass' => $this->CI->config->item('smtp_pass'),
                'smtp_crypto' => $this->CI->config->item('smtp_crypto'),
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'crlf' => "\r\n"
            ]);
        }

        foreach ($subscribers as $sub) {
            $default_name = $this->CI->config->item('default_recipient_name') ?: 'Sahabat B-Universe';
            $sub_name = !empty($sub['name']) ? $sub['name'] : $default_name;

            $viewData = [
                'subject' => $subject,
                'date' => $dateStr,
                'volume' => $volume,
                'greeting_title' => str_replace('[Nama Subscriber]', $sub_name, $greeting_title),
                'greeting_body' => str_replace('[Nama Subscriber]', $sub_name, $greeting_body),
                'main_article' => $main_article,
                'grid_articles' => $grid_articles,
                'list_articles' => $list_articles,
                'sidebar_articles' => $sidebar_articles,
                'alternating_articles' => $alternating_articles,
                'market_stats' => $stats,
                'subscriber_email' => $sub['email'],
                'subscriber_name' => $sub_name
            ];

            $html = $this->CI->load->view('emails/' . $portal . '_template', $viewData, TRUE);

            if ($is_simulated) {
                $dir = APPPATH . 'cache/simulated_emails/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $safe_email = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $sub['email']);
                $filename = $dir . "{$portal}_vol{$volume}_{$safe_email}_" . time() . ".html";
                file_put_contents($filename, $html);
                $success_count++;
            } else {
                $this->CI->email->clear();
                $this->CI->email->from($this->smtp_from, strtoupper($portal) . ' Newsletter');
                $this->CI->email->to($sub['email']);
                $this->CI->email->subject($subject);
                $this->CI->email->message($html);

                if ($this->CI->email->send()) {
                    $success_count++;
                } else {
                    $fail_count++;
                    $errors[] = "Failed to send to {$sub['email']}: " . $this->CI->email->print_debugger(['headers']);
                }
            }
        }

        return [
            'success' => $success_count,
            'fail' => $fail_count,
            'errors' => $errors
        ];
    }
}
