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
        // 1. Truncate existing data to prevent duplicate seeds
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->truncate('market_stats');
        $this->db->truncate('newsletter_articles');
        $this->db->truncate('newsletters');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // ----------------------------------------------------
        // SEED 1: BERITASATU
        // ----------------------------------------------------
        $this->db->insert('newsletters', [
            'portal' => 'beritasatu',
            'subject' => 'Daily digest - Edisi 01: Asap Karhutla Ganggu Penerbangan',
            'volume' => 1,
            'greeting_title' => 'Sahabat Beritasatu, [Nama Subscriber]',
            'greeting_body' => "Banyak hal terjadi hari ini dan kami sudah merangkumnya untuk Anda. Simak berita-berita pilihan berikut, lengkap dengan sudut pandang yang tajam dan terpercaya.\n\nJangan lewatkan juga artikel eksklusif kami di bagian bawah newsletter ini.",
            'status' => 'draft',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $nl1_id = $this->db->insert_id();

        $articles_bs = [
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'main',
                'title' => 'Asap Karhutla Ganggu Penerbangan, Sejumlah Rute di Kalimantan Terdampak',
                'excerpt' => 'Jakarta, Beritasatu.com - Kebakaran hutan dan lahan (karhutla) di sejumlah wilayah Kalimantan mulai berdampak terhadap operasional penerbangan. Asap tebal menyebabkan gangguan penerbangan di Bandara Singkawang, Kalimantan Barat, serta keterlambatan penerbangan di Bandara Iskandar, Pangkalan Bun, Kalimantan Tengah.',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art1.png',
                'sort_order' => 1
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => 'Karhutla di Tengah El Nino Bisa Picu Kerugian Ekonomi Berantai',
                'excerpt' => 'Kebakaran hutan dan lahan (karhutla) di tengah perkembangan El Nino berpotensi menimbulkan dampak ekonomi yang jauh lebih besar',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art2.png',
                'sort_order' => 2
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => '1.923 Hotspot Karhutla Kepung Papua Tengah, Nabire Paling Banyak',
                'excerpt' => 'Badan Meteorologi, Klimatologi dan Geofisika (BMKG) mencatat 1.923 titik panas atau hotspot kebakaran hutan dan lahan (karhutla) terdeteksi',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art3.png',
                'sort_order' => 3
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => 'Karhutla Way Kambas Padam, Kemenhut Pastikan Tak Berdampak ke Gajah',
                'excerpt' => 'Kebakaran hutan dan lahan di kawasan Taman Nasional Way Kambas (TNWK), Lampung Timur, Lampung, akhirnya berhasil dipadamkan',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art4.png',
                'sort_order' => 4
            ],
            [
                'newsletter_id' => $nl1_id,
                'article_type' => 'grid',
                'title' => 'Prabowo Rapat Bahas Penanganan Karhutla dan Gempa NTT di Hambalang',
                'excerpt' => 'Presiden Prabowo Subianto memimpin rapat terbatas (ratas) di kediaman pribadinya di Hambalang, Bogor, Jawa Barat, Minggu',
                'category' => 'Nasional',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-art5.png',
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
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/investor-art1.png',
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
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art1.png',
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
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art2.png',
                'sort_order' => 7
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'Syria Foreign Minister Met Mossad Chief in Jordan on Sunday: Sources',
                'excerpt' => "The Syrian foreign minister met the head of Israel's Mossad intelligence agency in Jordan on Sunday, according to sources, days after an Isr…",
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art3.png',
                'sort_order' => 8
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'Thick Haze Forces Two Jakarta-Jambi Flights to Divert',
                'excerpt' => 'Two flights from Jakarta to Jambi were diverted to Batam and Palembang on Sunday after thick haze sharply reduced visibility around Sultan Th…',
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art4.png',
                'sort_order' => 9
            ],
            [
                'newsletter_id' => $nl3_id,
                'article_type' => 'alternating',
                'title' => 'Cilacap Native Builds Successful Indonesian Restaurant in Taipei',
                'excerpt' => 'Difficulty finding halal Indonesian food in Taiwan inspired Cilacap native Sri Purwanti to open her own restaurant in Taipei, a venture that has sinc…',
                'category' => 'World',
                'image_url' => 'https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-art5.png',
                'sort_order' => 10
            ],
        ];
        $this->db->insert_batch('newsletter_articles', $articles_jg);

        echo "<h1>Seeding Completed Successfully!</h1>";
        echo "<p>3 Portal default newsletters (BeritaSatu, Investor, JakartaGlobe) have been seeded into the database with Cloud URL paths.</p>";
        echo "<a href='" . base_url('newsletters') . "'>Back to Dashboard</a>";
    }
}
