<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed Successfully</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --primary: #f8670f;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            padding: 1.5rem;
        }

        .success-card {
            width: 100%;
            max-width: 480px;
            padding: 3rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #f8fafc, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .message {
            font-size: 1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .email-display {
            display: inline-block;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            color: #ffffff;
            font-weight: 600;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="icon">🔔</div>
        <h1 class="title">Berhenti Berlangganan</h1>
        <p class="message">
            Anda telah berhasil berhenti berlangganan dari newsletter kami. Email berikut tidak akan menerima edisi berikutnya:
            <br>
            <span class="email-display"><?= htmlspecialchars($email) ?></span>
        </p>
        <p style="font-size: 0.85rem; color: var(--text-muted);">
            Jika ini adalah kesalahan, Anda dapat mendaftar kembali kapan saja di platform kami.
        </p>
    </div>
</body>
</html>
