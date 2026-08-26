<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="id">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($subject) ?></title>
  <style type="text/css">
    @media only screen and (max-width: 600px) {
      .container {
        width: 100% !important;
        max-width: 600px !important;
      }
      .responsive-img {
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
      }
    }
  </style>
</head>
<body style="margin: 0; padding: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #f5f5f7; font-family: Arial, Helvetica, sans-serif;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f5f5f7; padding: 20px 0;">
    <tr>
      <td align="center">
        <!-- Main Email Container (600px wide) -->
        <table border="0" cellpadding="0" cellspacing="0" width="600" class="container" style="background-color: #ffffff; border-collapse: collapse; overflow: hidden;">
          
          <!-- 1. Logo & Briefing Info -->
          <tr>
            <td style="padding: 22px 20px 30px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <!-- Logo (width: 160) -->
                  <td width="40%" style="width: 40%;" valign="middle">
                    <img src="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/investor-logo.png" width="160" alt="INVESTOR.ID" style="display: block; border: 0; max-width: 100%; height: auto;" />
                  </td>
                  <!-- Date Info -->
                  <td width="60%" style="width: 60%;" valign="middle" align="right" style="color: #333333; font-family: Arial, sans-serif; font-size: 12px; line-height: 100%;">
                    <strong style="font-family: Arial, sans-serif; font-weight: 700; font-size: 12px;">Investor briefing Vol <?= isset($volume) ? $volume : '1' ?></strong><span style="font-family: Arial, sans-serif; font-weight: 400; font-size: 12px;"> - <?= isset($date) ? $date : date('l, d F Y') ?></span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- 2. Header Banner Image -->
          <tr>
            <td style="padding: 0 20px 30px 20px;">
              <img class="responsive-img" src="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/investor-header.png" width="560" height="233" alt="Investor Briefing Banner" style="display: block; width: 100%; max-width: 100%; height: auto; border: 0; border-radius: 8px;" />
            </td>
          </tr>

          <!-- 3. Market Stats Section -->
          <?php if (!empty($market_stats)): ?>
          <tr>
            <td align="center" style="padding: 0 20px 30px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="563" height="72" style="background-color: #E8F5FF; border-top: 0.5px dashed #1E6CA1; border-bottom: 0.5px dashed #1E6CA1; width: 563px; height: 72px;">
                <tr>
                  <td style="padding: 15px 10px; padding-top: 15px; padding-bottom: 15px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <?php 
                        $widthPercent = floor(100 / count($market_stats)) . '%';
                        foreach ($market_stats as $stat): 
                          $color = ($stat['direction'] === 'up') ? '#1a8a3c' : '#d32f2f';
                          $symbol = ($stat['direction'] === 'up') ? '+' : '';
                          // If value already contains + or -, don't double it
                          $valStr = $stat['value'];
                          if ($stat['direction'] === 'up' && strpos($valStr, '+') !== 0 && strpos($valStr, '-') !== 0) {
                              $valStr = '+' . $valStr;
                          }
                        ?>
                        <td width="<?= $widthPercent ?>" align="center" style="font-family: Arial, sans-serif; font-size: 12px; text-align: center; width: <?= $widthPercent ?>;">
                          <div style="font-family: Arial, sans-serif; font-weight: 700; font-size: 12px; line-height: 100%; color: #1e6ca1; margin-bottom: 2px;"><?= htmlspecialchars($stat['label']) ?></div>
                          <div style="font-family: Arial, sans-serif; font-weight: 700; font-size: 14px; line-height: 100%; color: <?= $color ?>;"><?= htmlspecialchars($valStr) ?></div>
                        </td>
                        <?php endforeach; ?>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <?php endif; ?>

          <!-- 4. Morning Insight -->
          <tr>
            <td style="padding: 0 20px 30px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td>
                    <h2 style="margin: 0; font-family: Arial, sans-serif; font-weight: 700; font-size: 12px; line-height: 20px; color: #111111;"><?= htmlspecialchars($greeting_title ? $greeting_title : 'Morning insight') ?></h2>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 11px; color: #333333; font-family: Arial, sans-serif; font-weight: 400; font-size: 12px; line-height: 20px;">
                    <?= nl2br(htmlspecialchars($greeting_body)) ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- 5. News List -->
          <tr>
            <td style="padding: 0 20px 35px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                
                <!-- Row 1: Featured (with image left, right text) -->
                <?php if (!empty($main_article)): ?>
                <tr>
                  <td style="padding: 15px 0; border-top: 1px dashed #323232; border-bottom: 1px dashed #323232;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <!-- Image Left -->
                        <?php if (!empty($main_article['image_url'])): ?>
                        <td width="45%" style="width: 45%;" valign="top">
                          <img class="responsive-img" src="<?= $main_article['image_url'] ?>" width="267" height="178" alt="<?= htmlspecialchars($main_article['title']) ?>" style="display: block; width: 100%; max-width: 100%; height: auto; border-radius: 6px; border: 0;" />
                        </td>
                        <?php endif; ?>
                        <!-- Content Right -->
                        <td width="<?= !empty($main_article['image_url']) ? '52%' : '100%' ?>" style="width: <?= !empty($main_article['image_url']) ? '52%' : '100%' ?>; padding-left: <?= !empty($main_article['image_url']) ? '3%' : '0' ?>;" valign="top" style="font-family: Arial, sans-serif;">
                          <h3 style="margin: 0 0 8px 0; font-family: Arial, sans-serif; font-weight: 700; font-size: 14px; line-height: 20px; color: #111111;">
                            <a href="#" style="color: #111111; text-decoration: none;"><?= htmlspecialchars($main_article['title']) ?></a>
                          </h3>
                          <p style="margin: 0; font-family: Arial, sans-serif; font-weight: 400; font-size: 12px; line-height: 20px; color: #555555;">
                            <?= htmlspecialchars($main_article['excerpt']) ?>
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <?php endif; ?>

                <!-- List Articles -->
                <?php foreach ($list_articles as $art): ?>
                <tr>
                  <td style="padding: 15px 0; border-bottom: 1px dashed #323232; font-family: Arial, sans-serif; font-weight: 700; font-size: 14px; line-height: 20px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td>
                          <a href="#" style="color: #111111; text-decoration: none;"><?= htmlspecialchars($art['title']) ?> - <span style="font-weight: 400; font-style: italic; color: #777;"><?= htmlspecialchars($art['category']) ?></span></a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <?php endforeach; ?>

              </table>
            </td>
          </tr>

          <!-- 6. Footer -->
          <tr>
            <td align="center" style="background-color: #323232; border-top: 3px solid #1E6CA1; padding: 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 561px; text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: 700; line-height: 20px; color: #ffffff;">
                <tr>
                  <td style="text-align: center;">
                    Email ini dikirim ke <a href="mailto:<?= htmlspecialchars($subscriber_email) ?>" style="color: #ffffff; text-decoration: underline;"><?= htmlspecialchars($subscriber_email) ?></a> oleh Investor.id — bagian dari B-Universe Media Group.<br />
                    TOKYO HUB PANTAI INDAH KAPUK 2, Tower K #BS-K.1, #K.1, #K2.1, Tangerang, Banten, 15510.<br />
                    Telepon 021 3972 2988<br />
                    <a href="<?= base_url('subscribers/unsubscribe?email=' . urlencode($subscriber_email)) ?>" style="color: #ffffff; text-decoration: underline;">Berhenti Berlangganan</a> | <a href="#" style="color: #ffffff; text-decoration: underline;">Kebijakan Privasi</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
