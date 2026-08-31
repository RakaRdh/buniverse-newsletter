<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Detail: <?= htmlspecialchars($newsletter['subject']) ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        accent: {
                            50: '#FFF6F1',
                            100: '#FDE6DB',
                            500: '#F2622C',
                            600: '#E6531F',
                        },
                        ink: {
                            50: '#F7F5F2',
                            150: '#EDE9E4',
                            300: '#D8D2CC',
                            500: '#8A817B',
                            700: '#524B47',
                            900: '#231F1D',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
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
            min-height: 0;
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

        /* Right Side: Viewport Switcher Container */
        .preview-viewport-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            overflow-y: auto;
            overflow-x: auto;
            background-color: #EDE9E4;
            transition: all 0.3s ease;
            padding: 24px;
        }

        .iframe-outer-wrapper {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            box-shadow: 0 12px 32px rgba(35, 31, 29, 0.08);
            border-radius: 8px;
            border: 1px solid #D8D2CC;
            height: auto;
            width: 100%;
            max-width: 800px;
            overflow: visible;
        }

        .iframe-outer-wrapper.desktop {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 0;
            border: none;
            box-shadow: none;
            overflow: visible;
        }

        .iframe-outer-wrapper.tablet {
            width: 768px;
            max-width: 100%;
            height: auto;
            overflow: visible;
        }

        .iframe-outer-wrapper.mobile {
            width: 375px;
            max-width: 100%;
            height: auto;
            overflow: visible;
        }

        .iframe-outer-wrapper.mobile-large {
            width: 480px;
            max-width: 100%;
            height: auto;
            overflow: visible;
        }

        .iframe-outer-wrapper.fold {
            width: 600px;
            max-width: 100%;
            height: auto;
            overflow: visible;
        }

        .iframe-scale-wrapper {
            width: 100%;
            height: auto;
            position: relative;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 8px;
            display: block;
        }
        .iframe-outer-wrapper.desktop iframe {
            border-radius: 0;
        }
    </style>
</head>
<body>
    <!-- Left Sidebar: Details & Recipients -->
    <div class="detail-sidebar font-sans">
        <div class="sidebar-header">
            <span class="brand-tag brand-<?= htmlspecialchars($newsletter['portal']) ?>">
                <?php 
                if ($newsletter['portal'] === 'beritasatu') echo 'BeritaSatu';
                elseif ($newsletter['portal'] === 'investor') echo 'Investor.id';
                else echo 'JakartaGlobe';
                ?>
            </span>
            <h1 class="newsletter-subject"><?= htmlspecialchars($newsletter['subject']) ?></h1>
            <div class="newsletter-meta">
                <div class="meta-item">
                    <i class="fa-solid fa-file-invoice"></i> Edition: Vol <?= htmlspecialchars($newsletter['volume']) ?>
                </div>
                <div class="meta-item" style="font-variant-numeric: tabular-nums;">
                    <i class="fa-solid fa-calendar"></i> <?= !empty($newsletter['sent_at']) ? date('d M Y, H:i', strtotime($newsletter['sent_at'])) : 'Draft' ?>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <div class="recipients-section">
                <h2 class="section-title">
                    <span>Recipients History</span>
                    <?php if ($newsletter['status'] === 'sent' && $send_log): ?>
                        <span class="badge-count" style="font-variant-numeric: tabular-nums;"><?= htmlspecialchars($send_log['recipients_count']) ?> Sent</span>
                    <?php endif; ?>
                </h2>

                <?php if ($newsletter['status'] === 'draft'): ?>
                    <div class="draft-notice">
                        <i class="fa-solid fa-circle-info text-lg mb-2 block text-accent-500"></i>
                        Newsletter ini masih berstatus <strong>Draft</strong> dan belum pernah dikirimkan ke subscriber mana pun.
                    </div>
                <?php else: ?>
                    <div class="recipients-list-wrapper">
                        <?php if (empty($recipients)): ?>
                            <div class="p-6 text-center text-ink-500 text-xs">
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
                                                <div class="rec-name text-xs"><?= htmlspecialchars($rec['subscriber_name']) ?></div>
                                                <div class="rec-email text-[10px]"><?= htmlspecialchars($rec['subscriber_email']) ?></div>
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
        <div class="p-4 text-xs font-semibold text-ink-650 bg-ink-50 border-t border-ink-150 text-center italic">
            * Tampilan di atas adalah simulasi preview. Hasil akhir bergantung pada email client dan resolusi layar penerima masing-masing.
        </div>
    </div>

    <!-- Right Area: Live HTML Preview with Viewport Switcher -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden font-sans">
        <!-- Preview Toolbar -->
        <div class="h-14 bg-white border-b border-ink-150 px-6 flex items-center justify-between z-10">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-envelope text-ink-500"></i>
                <span class="text-xs font-bold font-jakarta text-ink-900 uppercase tracking-wider">Inbox Preview</span>
            </div>
            
            <!-- Viewport Switcher Buttons -->
            <div class="flex items-center bg-ink-50 p-1 rounded-lg border border-ink-150">
                <button onclick="setViewport('desktop')" id="tab-desktop" class="viewport-tab active flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md transition-all">
                    <i class="fa-solid fa-desktop text-[10px]"></i> Desktop
                </button>
                <button onclick="setViewport('fold')" id="tab-fold" class="viewport-tab flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md transition-all">
                    <i class="fa-solid fa-tablet text-[10px]"></i> Fold (600px)
                </button>
                <button onclick="setViewport('tablet')" id="tab-tablet" class="viewport-tab flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md transition-all">
                    <i class="fa-solid fa-tablet-screen-button text-[10px]"></i> Tablet
                </button>
                <button onclick="setViewport('mobile-large')" id="tab-mobile-large" class="viewport-tab flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md transition-all">
                    <i class="fa-solid fa-mobile-screen-button text-[10px]"></i> Mobile L (480px)
                </button>
                <button onclick="setViewport('mobile')" id="tab-mobile" class="viewport-tab flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md transition-all">
                    <i class="fa-solid fa-mobile-screen-button text-[10px]"></i> Mobile (375px)
                </button>
            </div>
        </div>
        
        <!-- Viewport Wrapper Container -->
        <div id="preview-viewport-container" class="preview-viewport-wrapper relative">
            <!-- Loading Spinner -->
            <div id="preview-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-[#EDE9E4] z-20 transition-opacity duration-300">
                <div class="flex flex-col items-center gap-3">
                    <i class="fa-solid fa-circle-notch fa-spin text-3xl text-accent-500"></i>
                    <span class="text-xs text-ink-700 font-bold font-jakarta uppercase tracking-wider">Loading Preview...</span>
                </div>
            </div>

            <div id="iframe-outer-wrapper" class="iframe-outer-wrapper desktop opacity-0 transition-opacity duration-300">
                <div id="iframe-scale-wrapper" class="iframe-scale-wrapper">
                    <iframe id="preview-iframe" src="<?= base_url('newsletters/render_html/' . $newsletter['id']) ?>" onload="onIframeLoad()"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDevice = 'desktop';

        function onIframeLoad() {
            const spinner = document.getElementById('preview-loading');
            const wrapper = document.getElementById('iframe-outer-wrapper');
            if (spinner) {
                spinner.classList.add('opacity-0');
                setTimeout(() => spinner.remove(), 300);
            }
            if (wrapper) {
                wrapper.classList.remove('opacity-0');
            }
            // Recalculate heights on load
            setViewport(currentDevice);
        }

        function setViewport(device) {
            currentDevice = device;
            
            const outer = document.getElementById('iframe-outer-wrapper');
            const scaleWrapper = document.getElementById('iframe-scale-wrapper');
            const iframe = document.getElementById('preview-iframe');
            const container = document.getElementById('preview-viewport-container');
            const tabs = document.querySelectorAll('.viewport-tab');
            
            // Remove active classes
            tabs.forEach(tab => {
                tab.className = 'viewport-tab flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md text-ink-700 hover:bg-ink-150 hover:text-ink-900 transition-all';
            });
            
            // Add active classes to clicked tab
            const activeTab = document.getElementById('tab-' + device);
            if (activeTab) {
                activeTab.className = 'viewport-tab active flex items-center gap-1.5 px-2 py-1 text-[11px] font-semibold rounded-md bg-accent-500 text-white shadow-sm transition-all';
            }
            
            // Reset iframe styles
            iframe.style.transform = '';
            iframe.style.width = '100%';
            iframe.style.height = '100%';
            iframe.style.transformOrigin = '';
            iframe.setAttribute('scrolling', 'no');
            
            scaleWrapper.style.width = '100%';
            scaleWrapper.style.height = 'auto';
            
            // Update wrapper class
            outer.className = 'iframe-outer-wrapper ' + device;
            
            // Get unscaled height of the email document
            let docHeight = 2000;
            try {
                if (iframe.contentWindow && iframe.contentWindow.document) {
                    docHeight = iframe.contentWindow.document.documentElement.scrollHeight || iframe.contentWindow.document.body.scrollHeight;
                }
            } catch (e) {}
            
            // Update container padding & style dynamically
            if (device === 'desktop') {
                container.style.padding = '0';
                container.style.backgroundColor = '#ffffff';
                
                iframe.style.width = '100%';
                iframe.style.height = docHeight + 'px';
                scaleWrapper.style.width = '100%';
                scaleWrapper.style.height = docHeight + 'px';
            } else if (device === 'fold') {
                container.style.padding = '24px';
                container.style.backgroundColor = '#EDE9E4';
                
                const targetWidth = 600;
                iframe.style.width = targetWidth + 'px';
                iframe.style.height = docHeight + 'px';
                scaleWrapper.style.width = targetWidth + 'px';
                scaleWrapper.style.height = docHeight + 'px';
            } else if (device === 'tablet') {
                container.style.padding = '24px';
                container.style.backgroundColor = '#EDE9E4';
                
                const targetWidth = 768;
                iframe.style.width = targetWidth + 'px';
                iframe.style.height = docHeight + 'px';
                scaleWrapper.style.width = targetWidth + 'px';
                scaleWrapper.style.height = docHeight + 'px';
            } else if (device === 'mobile-large') {
                container.style.padding = '24px';
                container.style.backgroundColor = '#EDE9E4';
                
                const targetWidth = 480;
                iframe.style.width = targetWidth + 'px';
                iframe.style.height = docHeight + 'px';
                scaleWrapper.style.width = targetWidth + 'px';
                scaleWrapper.style.height = docHeight + 'px';
            } else if (device === 'mobile') {
                container.style.padding = '24px';
                container.style.backgroundColor = '#EDE9E4';
                
                const targetWidth = 375;
                iframe.style.width = targetWidth + 'px';
                iframe.style.height = docHeight + 'px';
                scaleWrapper.style.width = targetWidth + 'px';
                scaleWrapper.style.height = docHeight + 'px';
            }
        }

        // Initialize state on load
        window.addEventListener('DOMContentLoaded', () => {
            setViewport('desktop');
        });
    </script>
</body>
</html>
