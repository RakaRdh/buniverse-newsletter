<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seeder extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index()
    {
        // 1. Delete existing data to prevent duplicate seeds
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->query('DELETE FROM market_stats');
        $this->db->query('DELETE FROM newsletter_articles');
        $this->db->query('DELETE FROM newsletters');
        $this->db->query('DELETE FROM newsletter_send_recipients');
        $this->db->query('DELETE FROM newsletter_send_logs');
        $this->db->query('DELETE FROM subscribers');
        
        $this->db->query('ALTER TABLE market_stats AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE newsletter_articles AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE newsletters AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE newsletter_send_recipients AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE newsletter_send_logs AUTO_INCREMENT = 1');
        $this->db->query('ALTER TABLE subscribers AUTO_INCREMENT = 1');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // Seed Subscribers with custom join dates
        $subscribers = [
            [
                'id' => 1,
                'name' => 'Raka Herdika',
                'email' => 'raka.herdika.ramadhan.tik23@stu.pnj.ac.id',
                'status' => 'active',
                'created_at' => '2025-06-15 10:00:00'
            ],
            [
                'id' => 2,
                'name' => 'Raka Ramadhan',
                'email' => 'rakaramadh15@gmail.com',
                'status' => 'active',
                'created_at' => '2026-02-10 14:30:00'
            ],
            [
                'id' => 3,
                'name' => 'Dapa Opodapa',
                'email' => 'opodapanur@gmail.com',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'id' => 4,
                'name' => 'Kikil Masdapa',
                'email' => 'kikilmasdapa@gmail.com',
                'status' => 'active',
                'created_at' => '2025-09-20 11:15:00'
            ],
            [
                'id' => 5,
                'name' => 'Ayam Bakar Masdapa',
                'email' => 'ayambakarmasdapa@gmail.com',
                'status' => 'active',
                'created_at' => '2026-01-05 09:45:00'
            ],
            [
                'id' => 6,
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@yahoo.com',
                'status' => 'active',
                'created_at' => '2025-11-12 16:20:00'
            ],
            [
                'id' => 7,
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@hotmail.com',
                'status' => 'active',
                'created_at' => '2026-04-18 10:30:00'
            ],
            [
                'id' => 8,
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@outlook.com',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            [
                'id' => 9,
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'id' => 10,
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@gmail.com',
                'status' => 'inactive',
                'created_at' => '2025-07-01 08:00:00'
            ],
            [
                'id' => 11,
                'name' => 'Fajar Nugraha',
                'email' => 'fajar.nugraha@gmail.com',
                'status' => 'active',
                'created_at' => '2026-05-12 14:00:00'
            ],
            [
                'id' => 12,
                'name' => 'Gita Permata',
                'email' => 'gita.permata@yahoo.com',
                'status' => 'active',
                'created_at' => '2026-06-01 11:20:00'
            ],
            [
                'id' => 13,
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@outlook.com',
                'status' => 'active',
                'created_at' => '2026-07-10 09:15:00'
            ],
            [
                'id' => 14,
                'name' => 'Indah Lestari',
                'email' => 'indah.lestari@gmail.com',
                'status' => 'active',
                'created_at' => '2026-07-22 16:45:00'
            ],
            [
                'id' => 15,
                'name' => 'Joko Susilo',
                'email' => 'joko.susilo@hotmail.com',
                'status' => 'inactive',
                'created_at' => '2026-08-05 13:30:00'
            ],
        ];
        $this->db->insert_batch('subscribers', $subscribers);

        // ----------------------------------------------------
        // SEED 1: BERITASATU
        // ----------------------------------------------------
        $this->db->insert('newsletters', [
            'portal' => 'beritasatu',
            'subject' => 'Daily digest - Edisi 01: Asap Karhutla Ganggu Penerbangan',
            'volume' => 1,
            'greeting_title' => 'Sahabat Beritasatu, [Nama Subscriber]',
            'greeting_body' => "Banyak hal terjadi hari ini dan kami sudah merangkumnya untuk Anda. Simak berita-berita pilihan berikut, lengkap dengan sudut pandang yang tajam dan terpercaya.\n\nJangan lewatkan juga artikel eksklusif kami di bagian bawah newsletter ini.",
            'status' => 'sent',
            'sent_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ]);
        $nl1_id = $this->db->insert_id();

        // Seed History Log for Seed 1
        $this->db->insert('newsletter_send_logs', [
            'id' => 1,
            'newsletter_id' => $nl1_id,
            'portal' => 'beritasatu',
            'subject' => 'Daily digest - Edisi 01: Asap Karhutla Ganggu Penerbangan',
            'volume' => 1,
            'sent_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'recipients_count' => 4,
            'content_summary' => 'Main Article: Asap Karhutla Ganggu Penerbangan'
        ]);
        $log1_id = $this->db->insert_id();

        $recipients = [
            [
                'send_log_id' => $log1_id,
                'subscriber_name' => 'Raka Herdika',
                'subscriber_email' => 'raka.herdika.ramadhan.tik23@stu.pnj.ac.id',
                'status' => 'success',
                'error_message' => NULL
            ],
            [
                'send_log_id' => $log1_id,
                'subscriber_name' => 'Raka Ramadhan',
                'subscriber_email' => 'rakaramadh15@gmail.com',
                'status' => 'success',
                'error_message' => NULL
            ],
            [
                'send_log_id' => $log1_id,
                'subscriber_name' => 'Kikil Masdapa',
                'subscriber_email' => 'kikilmasdapa@gmail.com',
                'status' => 'success',
                'error_message' => NULL
            ],
            [
                'send_log_id' => $log1_id,
                'subscriber_name' => 'Ayam Bakar Masdapa',
                'subscriber_email' => 'ayambakarmasdapa@gmail.com',
                'status' => 'success',
                'error_message' => NULL
            ]
        ];
        $this->db->insert_batch('newsletter_send_recipients', $recipients);

        $articles_bs = [
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'main',
                'title' => 'Asap Karhutla Ganggu Penerbangan, Sejumlah Rute di Kalimantan Terdampak',
                'excerpt' => 'Jakarta, Beritasatu.com - Kebakaran hutan dan lahan (karhutla) di sejumlah wilayah Kalimantan mulai berdampak terhadap operasional penerbangan. Asap tebal menyebabkan gangguan penerbangan di Bandara Singkawang, Kalimantan Barat, serta keterlambatan penerbangan di Bandara Iskandar, Pangkalan Bun, Kalimantan Tengah.',
                'category' => '1 Fokus Topik',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art1.jpg',
                'sort_order' => 1
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => 'Karhutla di Tengah El Nino Bisa Picu Kerugian Ekonomi Berantai',
                'excerpt' => 'Kebakaran hutan dan lahan (karhutla) di tengah perkembangan El Nino berpotensi menimbulkan dampak ekonomi yang jauh lebih besar',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art2.jpg',
                'sort_order' => 2
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => '1.923 Hotspot Karhutla Kepung Papua Tengah, Nabire Paling Banyak',
                'excerpt' => 'Badan Meteorologi, Klimatologi dan Geofisika (BMKG) mencatat 1.923 titik panas atau hotspot kebakaran hutan dan lahan (karhutla) terdeteksi',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art3.jpg',
                'sort_order' => 3
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => 'Karhutla Way Kambas Padam, Kemenhut Pastikan Tak Berdampak ke Gajah',
                'excerpt' => 'Kebakaran hutan dan lahan di kawasan Taman Nasional Way Kambas (TNWK), Lampung Timur, Lampung, akhirnya berhasil dipadamkan',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art4.jpg',
                'sort_order' => 4
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => 'Prabowo Rapat Bahas Penanganan Karhutla dan Gempa NTT di Hambalang',
                'excerpt' => 'Presiden Prabowo Subianto memimpin rapat terbatas (ratas) di kediaman pribadinya di Hambalang, Bogor, Jawa Barat, Minggu',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art5.jpg',
                'sort_order' => 5
            ]
        ];
        $this->db->insert_batch('newsletter_articles', $articles_bs);


        // ----------------------------------------------------
        // SEED 2: INVESTOR.ID
        // ----------------------------------------------------
        $this->db->insert('newsletters', [
            'portal' => 'investor',
            'subject' => 'Investor briefing Vol 1',
            'volume' => 1,
            'greeting_title' => '',
            'greeting_body' => 'Pasar bergerak positif pagi ini. IHSG menguat 0,5% didorong sentimen global yang membaik, sementara rupiah sedikit tertekan 0,2% terhadap dolar AS. Emas dan Bitcoin kompak menghijau, mencerminkan minat investor yang masih tinggi terhadap aset safe haven maupun kripto.',
            'status' => 'draft',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $nl2_id = $this->db->insert_id();

        $stats_inv = [
            ['newsletter_id' => $nl2_id, 'label' => 'IHSG', 'value' => '+0.5%', 'direction' => 'up', 'sort_order' => 1],
            ['newsletter_id' => $nl2_id, 'label' => 'USD/IDR', 'value' => '-0.2%', 'direction' => 'down', 'sort_order' => 2],
            ['newsletter_id' => $nl2_id, 'label' => 'EMAS', 'value' => '+0.3%', 'direction' => 'up', 'sort_order' => 3],
            ['newsletter_id' => $nl2_id, 'label' => 'BTC', 'value' => '+2.1%', 'direction' => 'up', 'sort_order' => 4],
        ];
        $this->db->insert_batch('market_stats', $stats_inv);

        $articles_inv = [
            [
                'newsletter_id' => $nl2_id,
                'article_type' => 'main',
                'title' => 'IHSG Menanjak Lagi, 5 Saham Melejit Tinggi',
                'excerpt' => 'Lima saham mencatatkan kenaikan tajam pada perdagangan Senin (24/8), dipimpin oleh PICO yang melonjak lebih dari 15%. Penguatan ini tur…',
                'category' => 'Market',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/investor-art1.jpg',
                'sort_order' => 1
            ],
            [
                'newsletter_id' => $nl2_id,
                'article_type' => 'list',
                'title' => 'Rupiah Melemah Tipis ke Rp15.720 per USD - Market',
                'excerpt' => '',
                'category' => 'Market',
                'image_url' => '',
                'sort_order' => 2
            ],
            [
                'newsletter_id' => $nl2_id,
                'article_type' => 'list',
                'title' => 'Harga Emas Antam Naik Rp6.000 per Gram - Market',
                'excerpt' => '',
                'category' => 'Market',
                'image_url' => '',
                'sort_order' => 3
            ],
            [
                'newsletter_id' => $nl2_id,
                'article_type' => 'list',
                'title' => '3 Saham Masuk Radar UMA BEI - Market',
                'excerpt' => '',
                'category' => 'Market',
                'image_url' => '',
                'sort_order' => 4
            ],
            [
                'newsletter_id' => $nl2_id,
                'article_type' => 'list',
                'title' => 'Bitcoin Nyaris Tembus US$80.000 - Kripto',
                'excerpt' => '',
                'category' => 'Kripto',
                'image_url' => '',
                'sort_order' => 5
            ]
        ];
        $this->db->insert_batch('newsletter_articles', $articles_inv);


        // ----------------------------------------------------
        // SEED 3: JAKARTA GLOBE
        // ----------------------------------------------------
        $this->db->insert('newsletters', [
            'portal' => 'jakartaglobe',
            'subject' => 'Jakarta Globe Digest',
            'volume' => 1,
            'greeting_title' => 'Dear Reader,',
            'greeting_body' => "Indonesia's political and economic landscape can be hard to follow from the outside. That's where we come in this newsletter gives you the essential context behind today's biggest story, plus a curated look at what else matters.",
            'status' => 'draft',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $nl3_id = $this->db->insert_id();

        $articles_jg = [
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'main',
                'title' => 'More than 2,600 Hotspots Detected across Sumatra as Haze Worsens',
                'excerpt' => "Indonesia's Meteorology, Climatology, and Geophysics Agency (BMKG) detected 2,610 hotspots across Sumatra as of Sunday morning,…",
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art1.jpg',
                'sort_order' => 1
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'sidebar',
                'title' => 'Kalimantan Burns: Prabowo Takes Charge of Worsening Forest Fires',
                'excerpt' => '',
                'category' => 'World',
                'image_url' => '',
                'sort_order' => 2
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'sidebar',
                'title' => '\'You Have Plantations Here Too\': Lawmaker Hits Back at Malaysia, Sin...',
                'excerpt' => '',
                'category' => 'World',
                'image_url' => '',
                'sort_order' => 3
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'sidebar',
                'title' => 'Forest and Land Fires Burn More than 64,000 Hectares across Indonesia',
                'excerpt' => '',
                'category' => 'World',
                'image_url' => '',
                'sort_order' => 4
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'sidebar',
                'title' => 'Bromo Wildfire Burns 520 Hectares, Forces Closure of Tourist Area',
                'excerpt' => '',
                'category' => 'World',
                'image_url' => '',
                'sort_order' => 5
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'sidebar',
                'title' => 'Wildfire Smoke Disrupts Flights at Airports Across Kalimantan',
                'excerpt' => '',
                'category' => 'World',
                'image_url' => '',
                'sort_order' => 6
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'UI Economists Clash over \'Worst-Ever\' Investment Climate Claim',
                'excerpt' => "Two economists from the University of Indonesia (UI) have offered sharply different assessments of the country's investment climate, with Fithra Fai…",
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art2.jpg',
                'sort_order' => 7
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'Syria Foreign Minister Met Mossad Chief in Jordan on Sunday: Sources',
                'excerpt' => "The Syrian foreign minister met the head of Israel's Mossad intelligence agency in Jordan on Sunday, according to sources, days after an Isr…",
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art3.jpg',
                'sort_order' => 8
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'Thick Haze Forces Two Jakarta-Jambi Flights to Divert',
                'excerpt' => 'Two flights from Jakarta to Jambi were diverted to Batam and Palembang on Sunday after thick haze sharply reduced visibility around Sultan Th…',
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art4.jpg',
                'sort_order' => 9
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'Cilacap Native Builds Successful Indonesian Restaurant in Taipei',
                'excerpt' => 'Difficulty finding halal Indonesian food in Taiwan inspired Cilacap native Sri Purwanti to open her own restaurant in Taipei, a venture that has sinc…',
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art5.jpg',
                'sort_order' => 10
            ],
        ];
        $this->db->insert_batch('newsletter_articles', $articles_jg);

        // Seed 22 more newsletters to bring total to 25 (varying statuses)
        $portals_list = ['beritasatu', 'investor', 'jakartaglobe'];
        for ($k = 4; $k <= 25; $k++) {
            $portal = $portals_list[$k % 3];
            $status = ($k % 2 === 0) ? 'sent' : 'draft';
            $sent_at = ($status === 'sent') ? date('Y-m-d H:i:s', strtotime("-$k days")) : NULL;
            
            $this->db->insert('newsletters', [
                'id' => $k,
                'portal' => $portal,
                'subject' => ucfirst($portal === 'jakartaglobe' ? 'JakartaGlobe' : $portal) . " Seeded Newsletter Vol $k",
                'volume' => $k,
                'greeting_title' => "Dear Subscriber [Nama Subscriber],",
                'greeting_body' => "This is automatically seeded newsletter content for volume $k.",
                'status' => $status,
                'sent_at' => $sent_at,
                'created_at' => date('Y-m-d H:i:s', strtotime("-$k days"))
            ]);
            
            // Seed a main article for each new newsletter so preview works
            $this->db->insert('newsletter_articles', [
                'newsletter_id' => $k,
                'article_type' => 'main',
                'title' => "Main Headline Article for Volume $k",
                'excerpt' => "Excerpt/Summary description for volume $k. This is seeded to test layout and content.",
                'category' => ($portal === 'beritasatu' ? 'Nasional' : ($portal === 'investor' ? 'Market' : 'World')),
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/' . $portal . '-art1.jpg',
                'url' => 'https://example.com/article-' . $k,
                'sort_order' => 1
            ]);

            // Also seed other placeholders based on brand
            if ($portal === 'beritasatu') {
                // 4 grid articles
                $grid_arts = [];
                for ($g = 1; $g <= 4; $g++) {
                    $grid_arts[] = [
                        'newsletter_id' => $k,
                        'article_type' => 'grid',
                        'title' => "BeritaSatu Grid Article $g of Vol $k",
                        'excerpt' => "Seeded grid excerpt $g",
                        'category' => 'Nasional',
                        'image_url' => "https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art" . ($g + 1) . ".jpg",
                        'url' => "https://example.com/grid-$g",
                        'sort_order' => $g + 1
                    ];
                }
                $this->db->insert_batch('newsletter_articles', $grid_arts);
            } elseif ($portal === 'investor') {
                // 4 list articles
                $list_arts = [];
                for ($l = 1; $l <= 4; $l++) {
                    $list_arts[] = [
                        'newsletter_id' => $k,
                        'article_type' => 'list',
                        'title' => "Investor List Article $l of Vol $k",
                        'excerpt' => "",
                        'category' => 'Market',
                        'image_url' => '',
                        'url' => "https://example.com/list-$l",
                        'sort_order' => $l + 1
                    ];
                }
                $this->db->insert_batch('newsletter_articles', $list_arts);
            } else {
                // jakartaglobe: 5 sidebars, 4 alternating
                $jg_arts = [];
                // 5 sidebars
                for ($s = 1; $s <= 5; $s++) {
                    $jg_arts[] = [
                        'newsletter_id' => $k,
                        'article_type' => 'sidebar',
                        'title' => "JakartaGlobe Sidebar $s of Vol $k",
                        'excerpt' => "",
                        'category' => 'World',
                        'image_url' => '',
                        'url' => "https://example.com/sidebar-$s",
                        'sort_order' => $s + 1
                    ];
                }
                // 4 alternating
                for ($a = 1; $a <= 4; $a++) {
                    $jg_arts[] = [
                        'newsletter_id' => $k,
                        'article_type' => 'alternating',
                        'title' => "JakartaGlobe Alternating $a of Vol $k",
                        'excerpt' => "Seeded alternating excerpt $a",
                        'category' => 'World',
                        'image_url' => "https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art" . ($a + 1) . ".jpg",
                        'url' => "https://example.com/alt-$a",
                        'sort_order' => $a + 6
                    ];
                }
                $this->db->insert_batch('newsletter_articles', $jg_arts);
            }
        }

        // Seed 40 History Logs
        $logs = [];
        $recipients = [];
        $portals = ['beritasatu', 'investor', 'jakartaglobe'];
        $subjects = [
            'beritasatu' => 'Daily digest - Edisi ',
            'investor' => 'Investor briefing Vol ',
            'jakartaglobe' => 'Jakarta Globe Digest Vol '
        ];

        for ($i = 11; $i <= 40; $i++) {
            $portal = $portals[$i % 3];
            $vol = ceil($i / 3);
            $logs[] = [
                'id' => $i,
                'newsletter_id' => ($portal === 'beritasatu' ? 1 : ($portal === 'investor' ? 2 : 3)),
                'portal' => $portal,
                'subject' => $subjects[$portal] . $vol,
                'volume' => $vol,
                'sent_at' => date('Y-m-d H:i:s', strtotime("-$i days")),
                'recipients_count' => rand(1, 3),
                'content_summary' => "Auto seeded content summary for volume $vol of $portal."
            ];

            // Seed 1-3 recipients per log
            $num_recipients = rand(1, 3);
            for ($j = 1; $j <= $num_recipients; $j++) {
                $recipients[] = [
                    'send_log_id' => $i,
                    'subscriber_name' => "Recipient $j for Log $i",
                    'subscriber_email' => "recipient{$j}.log{$i}@example.com",
                    'status' => ($j === 3 ? 'failed' : 'success'),
                    'error_message' => ($j === 3 ? 'SMTP connection timeout' : NULL)
                ];
            }
        }
        $this->db->insert_batch('newsletter_send_logs', $logs);
        $this->db->insert_batch('newsletter_send_recipients', $recipients);

        echo "<h1>Seeding Completed Successfully!</h1>";
        echo "<p>3 Portal default newsletters (BeritaSatu, Investor, JakartaGlobe) and 40 history logs have been seeded into the database with Cloud URL paths.</p>";
        echo "<a href='" . base_url('newsletters') . "'>Back to Dashboard</a>";
    }
}
