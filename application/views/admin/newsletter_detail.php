<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Detail: <?= htmlspecialchars($newsletter['subject']) ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #F7F5F2;
            color: #231F1D;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Side: Newsletter Info & Recipients */
        .detail-sidebar {
            width: 420px;
            min-width: 420px;
            background-color: #ffffff;
            border-right: 1px solid #EDE9E4;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #EDE9E4;
        }

        .brand-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .brand-beritasatu { background: #FBE6E2; color: #C4432E; border: 1px solid rgba(196, 67, 46, 0.2); }
        .brand-investor { background: #E7EFF7; color: #3A6FA8; border: 1px solid rgba(58, 111, 168, 0.2); }
        .brand-jakartaglobe { background: #FBEFDD; color: #B8791A; border: 1px solid rgba(184, 121, 26, 0.2); }

        .newsletter-subject {
            font-size: 1.1rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            line-height: 1.4;
            color: #231F1D;
            margin-bottom: 0.5rem;
        }

        .newsletter-meta {
            font-size: 0.8rem;
            color: #8A817B;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .recipients-section {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0; /* Important for nested scroll */
        }

        .section-title {
            font-size: 0.8rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #8A817B;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge-count {
            background: #F7F5F2;
            color: #231F1D;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.7rem;
            border: 1px solid #EDE9E4;
        }

        .recipients-list-wrapper {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #EDE9E4;
            border-radius: 8px;
            background: #ffffff;
        }

        .recipients-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            text-align: left;
        }

        .recipients-table th {
            padding: 8px 12px;
            background: #F7F5F2;
            border-bottom: 1px solid #EDE9E4;
            font-weight: 600;
            color: #524B47;
        }

        .recipients-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #EDE9E4;
            vertical-align: middle;
        }

        .recipients-table tr:hover {
            background: #FFF6F1/30;
        }

        .rec-name {
            font-weight: 600;
            color: #231F1D;
        }

        .rec-email {
            color: #8A817B;
            font-size: 0.7rem;
            margin-top: 2px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-success { background: #E4F3EC; color: #2E7D5B; }
        .status-failed { background: #FBE6E2; color: #C4432E; }

        .draft-notice {
            background: #FBEFDD;
            border: 1px dashed #D8D2CC;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            color: #B8791A;
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .sidebar-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #EDE9E4;
            display: flex;
            gap: 10px;
            background-color: #ffffff;
        }

        .btn-action {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            color: white;
            text-align: center;
        }

        .btn-close {
            background: #F7F5F2;
            border: 1px solid #D8D2CC;
            color: #231F1D;
        }
        .btn-close:hover {
            background: #EDE9E4;
        }

        .btn-send {
            background: #F2622C;
        }
        .btn-send:hover {
            background: #E6531F;
        }

        /* Right Side: Iframe Preview Container */
        .preview-viewport-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            overflow: auto;
            background-color: #EDE9E4; /* darker neutral tone to make email template pop */
        }

        .iframe-wrapper {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            box-shadow: 0 12px 32px rgba(35, 31, 29, 0.08);
            border-radius: 8px;
            border: 1px solid #D8D2CC;
            height: 100%;
            width: 100%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
        }

        .iframe-wrapper.desktop {
            width: 100%;
            max-width: 800px;
            height: 100%;
        }

        .iframe-wrapper.tablet {
            width: 768px;
            height: 100%;
            max-height: 1024px;
        }

        .iframe-wrapper.mobile {
            width: 375px;
            height: 100%;
            max-height: 667px;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Left Sidebar: Details & Recipients -->
    <div class="detail-sidebar">
        <div class="sidebar-header">
            <span class="brand-tag brand-<?= htmlspecialchars($newsletter['portal']) ?>">
                <?php 
                if ($newsletter['portal'] === 'beritasatu') echo 'BeritaSatu';
                elseif ($newsletter['portal'] === 'investor') echo 'Investor.id';
                else echo 'Jakarta Globe';
                ?>
            </span>
            <h1 class="newsletter-subject"><?= htmlspecialchars($newsletter['subject']) ?></h1>
            <div class="newsletter-meta">
                <div class="meta-item">
                    <i class="fa-solid fa-file-invoice"></i> Edition: Vol <?= htmlspecialchars($newsletter['volume']) ?>
                </div>
                <div class="meta-item">
                    <i class="fa-solid fa-calendar"></i> <?= !empty($newsletter['sent_at']) ? date('d M Y, H:i', strtotime($newsletter['sent_at'])) : 'Draft' ?>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <div class="recipients-section">
                <h2 class="section-title">
                    <span>Recipients History</span>
                    <?php if ($newsletter['status'] === 'sent' && $send_log): ?>
                        <span class="badge-count"><?= htmlspecialchars($send_log['recipients_count']) ?> Sent</span>
                    <?php endif; ?>
                </h2>

                <?php if ($newsletter['status'] === 'draft'): ?>
                    <div class="draft-notice">
                        <i class="fa-solid fa-circle-info text-lg mb-2 block"></i>
                        Newsletter ini masih berstatus <strong>Draft</strong> dan belum pernah dikirimkan ke subscriber mana pun.
                    </div>
                <?php else: ?>
                    <div class="recipients-list-wrapper">
                        <?php if (empty($recipients)): ?>
                            <div class="p-6 text-center text-slate-400 text-xs">
                                Tidak ada log penerima detail untuk pengiriman ini.
                            </div>
                        <?php else: ?>
                            <table class="recipients-table">
                                <thead>
                                    <tr>
                                        <th>Subscriber</th>
                                        <th style="text-align: right;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recipients as $rec): ?>
                                        <tr>
                                            <td>
                                                <div class="rec-name"><?= htmlspecialchars($rec['subscriber_name']) ?></div>
                                                <div class="rec-email"><?= htmlspecialchars($rec['subscriber_email']) ?></div>
                                            </td>
                                            <td style="text-align: right;">
                                                <span class="status-badge status-<?= $rec['status'] ?>">
                                                    <?= $rec['status'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="sidebar-footer">
            <?php if ($newsletter['status'] === 'draft'): ?>
                <a href="<?= base_url('send/newsletter/' . $newsletter['id']) ?>" class="btn-action btn-send">
                    <i class="fa-solid fa-paper-plane"></i> Send Newsletter
                </a>
            <?php endif; ?>
            <button onclick="window.close()" class="btn-action btn-close">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </button>
        </div>
    </div>

    <!-- Right Area: Live HTML Preview with Viewport Switcher -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Preview Toolbar -->
        <div class="h-14 bg-white border-b border-ink-150 px-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-envelope text-ink-500"></i>
                <span class="text-xs font-bold font-jakarta text-ink-900 uppercase tracking-wider">Inbox Preview</span>
            </div>
            
            <!-- Viewport Switcher Buttons -->
            <div class="flex items-center bg-ink-50 p-1 rounded-lg border border-ink-150">
                <button onclick="setViewport('desktop')" id="tab-desktop" class="viewport-tab active flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md border-b-2 border-accent-500 text-ink-900 bg-accent-50/50 transition-all">
                    <i class="fa-solid fa-desktop"></i> Desktop
                </button>
                <button onclick="setViewport('tablet')" id="tab-tablet" class="viewport-tab flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md text-ink-500 hover:bg-ink-50 hover:text-ink-900 transition-all">
                    <i class="fa-solid fa-tablet-screen-button"></i> Tablet
                </button>
                <button onclick="setViewport('mobile')" id="tab-mobile" class="viewport-tab flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md text-ink-500 hover:bg-ink-50 hover:text-ink-900 transition-all">
                    <i class="fa-solid fa-mobile-screen-button"></i> Mobile
                </button>
            </div>
        </div>
        
        <!-- Viewport Wrapper Container -->
        <div class="preview-viewport-wrapper">
            <div id="iframe-wrapper" class="iframe-wrapper desktop">
                <iframe src="<?= base_url('newsletters/render_html/' . $newsletter['id']) ?>"></iframe>
            </div>
        </div>
    </div>

    <script>
        function setViewport(device) {
            const wrapper = document.getElementById('iframe-wrapper');
            const tabs = document.querySelectorAll('.viewport-tab');
            
            // Remove active classes
            tabs.forEach(tab => {
                tab.className = 'viewport-tab flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md text-ink-500 hover:bg-ink-50 hover:text-ink-900 transition-all';
            });
            
            // Add active classes to clicked tab
            const activeTab = document.getElementById('tab-' + device);
            activeTab.className = 'viewport-tab active flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-md border-b-2 border-accent-500 text-ink-900 bg-accent-50/50 transition-all';
            
            // Update wrapper class
            wrapper.className = 'iframe-wrapper ' + device;
        }
    </script>
</body>
</html>
