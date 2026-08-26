<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Newsletter: <?= htmlspecialchars($newsletter['subject']) ?></title>
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
            background-color: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .preview-header {
            background-color: #1e293b;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .newsletter-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-tag {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .brand-beritasatu { background: rgba(227, 6, 19, 0.15); color: #ff4d4d; border: 1px solid rgba(227, 6, 19, 0.3); }
        .brand-investor { background: rgba(10, 61, 145, 0.15); color: #38bdf8; border: 1px solid rgba(10, 61, 145, 0.3); }
        .brand-jakartaglobe { background: rgba(255, 122, 0, 0.15); color: #fb923c; border: 1px solid rgba(255, 122, 0, 0.3); }

        .newsletter-title {
            font-size: 1.1rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 500px;
        }

        .controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            color: white;
        }

        .btn-close {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .btn-close:hover {
            background: rgba(255,255,255,0.1);
        }

        .btn-send {
            background: #10b981;
        }
        .btn-send:hover {
            background: #059669;
        }

        .preview-container {
            flex: 1;
            display: flex;
            justify-content: center;
            background-color: #0f172a;
            padding: 20px;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            max-width: 680px;
            height: 100%;
            border: none;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="preview-header">
        <div class="newsletter-info">
            <span class="brand-tag brand-<?= htmlspecialchars($newsletter['portal']) ?>">
                <?= htmlspecialchars($newsletter['portal']) ?>
            </span>
            <div class="newsletter-title">
                <?= htmlspecialchars($newsletter['subject']) ?> (Vol <?= htmlspecialchars($newsletter['volume']) ?>)
            </div>
        </div>

        <div class="controls">
            <?php if ($newsletter['status'] === 'draft'): ?>
                <a href="<?= base_url('send/newsletter/' . $newsletter['id']) ?>" class="btn-action btn-send" onclick="return confirm('Apakah Anda yakin ingin mengirim newsletter ini?')">
                    <i class="fa-solid fa-paper-plane"></i> Send Newsletter
                </a>
            <?php endif; ?>
            <button onclick="window.close()" class="btn-action btn-close">
                <i class="fa-solid fa-xmark"></i> Close Preview
            </button>
        </div>
    </div>

    <div class="preview-container">
        <!-- Render template dynamic inside iframe -->
        <iframe src="<?= base_url('newsletters/render_html/' . $newsletter['id']) ?>"></iframe>
    </div>
</body>
</html>
