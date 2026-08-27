<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Detail: <?= htmlspecialchars($newsletter['subject']) ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #334155;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Side: Newsletter Info & Recipients */
        .detail-sidebar {
            width: 420px;
            min-width: 420px;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .brand-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .brand-beritasatu { background: rgba(227, 6, 19, 0.15); color: #EC1C24; border: 1px solid rgba(227, 6, 19, 0.3); }
        .brand-investor { background: rgba(10, 61, 145, 0.15); color: #2563eb; border: 1px solid rgba(10, 61, 145, 0.3); }
        .brand-jakartaglobe { background: rgba(255, 122, 0, 0.15); color: #ea580c; border: 1px solid rgba(255, 122, 0, 0.3); }

        .newsletter-subject {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.4;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .newsletter-meta {
            font-size: 0.8rem;
            color: #64748b;
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
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge-count {
            background: #f1f5f9;
            color: #0f172a;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.7rem;
            border: 1px solid #e2e8f0;
        }

        .recipients-list-wrapper {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }

        .recipients-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            text-align: left;
        }

        .recipients-table th {
            padding: 8px 12px;
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #64748b;
        }

        .recipients-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .recipients-table tr:hover {
            background: #f1f5f9/30;
        }

        .rec-name {
            font-weight: 600;
            color: #1e293b;
        }

        .rec-email {
            color: #64748b;
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

        .status-success { background: rgba(16, 185, 129, 0.15); color: #059669; }
        .status-failed { background: rgba(239, 68, 68, 0.15); color: #dc2626; }

        .draft-notice {
            background: #fef9c3;
            border: 1px dashed #fef08a;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            color: #713f12;
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .sidebar-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #e2e8f0;
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
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        .btn-close:hover {
            background: #e2e8f0;
        }

        .btn-send {
            background: #EC1C24;
        }
        .btn-send:hover {
            background: #c9121a;
        }

        /* Right Side: Iframe Preview Container */
        .preview-container {
            flex: 1;
            display: flex;
            justify-content: center;
            background-color: #0f172a;
            padding: 24px;
            overflow: hidden;
            height: 100%;
        }

        iframe {
            width: 100%;
            max-width: 680px;
            height: 100%;
            border: none;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            background-color: #ffffff;
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

    <!-- Right Area: Live HTML Iframe -->
    <div class="preview-container">
        <iframe src="<?= base_url('newsletters/render_html/' . $newsletter['id']) ?>"></iframe>
    </div>
</body>
</html>
