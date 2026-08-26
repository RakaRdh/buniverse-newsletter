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
      .hero-image, .grid-image {
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
      }
      .headline-text {
        font-size: 13px !important;
      }
      .body-text {
        font-size: 11px !important;
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
          
          <!-- 1. Header & Overlap Container (336px height) -->
          <tr>
            <td background="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-header.png" height="336" valign="top" style="background-image: url('https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-header.png'); background-repeat: no-repeat; background-position: top; background-color: #ffffff; height: 336px; padding: 0;">
              <!--[if gte mso 9]>
              <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;height:288px;">
                <v:fill type="tile" src="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-header.png" color="#1a1a1a" />
                <v:textbox inset="0,0,0,0">
              <![endif]-->
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                
                <!-- Logo & Date row (Logo: 122x22, Padding Top: 22px) -->
                <tr>
                  <td style="padding: 22px 20px 0 21px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <!-- Logo (122x22) -->
                        <td valign="middle" width="122" style="width: 122px;">
                          <img src="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/beritasatu-logo.png" width="122" height="22" alt="BERITA SATU" style="display: block; border: 0; width: 122px; height: 22px;" />
                        </td>
                        <!-- Date Info (Arial, Regular 12px, line-height 100%) -->
                        <td valign="middle" align="right" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 100%;">
                          <?= isset($date) ? $date : date('l, d F Y') ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- Daily Digest block -->
                <tr>
                  <td style="padding: 22px 20px 0 21px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="559" height="75" style="border-top: 1px solid rgba(255,255,255,0.3); border-bottom: 1px solid rgba(255,255,255,0.3); width: 559px; height: 75px;">
                      <tr>
                        <td valign="top" style="padding-top: 5px; color: #ffffff; text-shadow: 0 1px 3px rgba(0,0,0,0.8); font-family: Arial, sans-serif;">
                          <!-- Daily Digest & Headline -->
                          <div class="headline-text" style="width: 100%; height: 40px; overflow: hidden; font-size: 14px; font-weight: bold; line-height: 18px; margin-bottom: 5px;">
                            Daily digest - Edisi <?= isset($volume) ? sprintf('%02d', $volume) : '01' ?><br />
                            <?= isset($main_article['title']) ? htmlspecialchars($main_article['title']) : '' ?>
                          </div>
                          <!-- 1 Fokus Topik -->
                          <div style="width: 100%; height: 20px; font-size: 11px; font-weight: bold; color: #cccccc; line-height: 20px;">
                            1 Fokus Topik
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- Spacer to push the greeting card to the overlap position (height: 85px) -->
                <tr>
                  <td style="height: 85px; font-size: 1px; line-height: 1px;">&nbsp;</td>
                </tr>

                <!-- Floating Greeting Box nested inside the header block -->
                <tr>
                  <td style="padding: 0 20px;">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%" style="background-color: #323232; border-radius: 10px; width: 100%; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                      <tr>
                        <td valign="top" style="padding: 15px; color: #ffffff; font-family: Arial, sans-serif;">
                          <?php if (!empty($greeting_title)): ?>
                            <div style="font-family: Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 100%; display: block; margin-bottom: 10px;"><?= htmlspecialchars($greeting_title) ?></div>
                          <?php endif; ?>
                          
                          <div class="body-text" style="font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 140%; color: #e5e5e5;">
                            <?= nl2br(htmlspecialchars($greeting_body)) ?>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

              </table>
              <!--[if gte mso 9]>
                </v:textbox>
              </v:rect>
              <![endif]-->
            </td>
          </tr>

          <!-- 2. Main Content -->
          <?php if (!empty($main_article)): ?>
          <tr>
            <td style="padding: 23px 20px 0 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <!-- Image -->
                <?php if (!empty($main_article['image_url'])): ?>
                <tr>
                  <td style="padding-bottom: 15px;">
                    <img class="hero-image" src="<?= $main_article['image_url'] ?>" width="560" height="315" alt="<?= htmlspecialchars($main_article['title']) ?>" style="display: block; width: 100%; max-width: 100%; height: auto; border-radius: 6px; border: 0;" />
                  </td>
                </tr>
                <?php endif; ?>
                <!-- Title -->
                <tr>
                  <td style="padding-bottom: 8px;">
                    <h2 style="margin: 0; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 20px; color: #111111;">
                      <a href="#" style="text-decoration: none; color: #111111;"><?= htmlspecialchars($main_article['title']) ?></a>
                    </h2>
                  </td>
                </tr>
                <!-- Excerpt -->
                <tr>
                  <td style="color: #555555; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 20px; padding-bottom: 8px;">
                    <?= htmlspecialchars($main_article['excerpt']) ?>
                  </td>
                </tr>
                <!-- Tag Kategori -->
                <tr>
                  <td style="padding-bottom: 30px;">
                    <span style="font-family: Arial, sans-serif; font-size: 10px; font-weight: 400; line-height: 20px; color: #797878;"><?= htmlspecialchars($main_article['category']) ?></span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <?php endif; ?>
 
          <!-- 3. Rectangle Divider -->
          <tr>
            <td align="center" style="padding: 0 20px 30px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #323232; width: 100%; height: 52px; text-align: center;">
                <tr>
                  <td style="vertical-align: middle;">
                    <span style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 100%;">
                      Pilihan lainnya untuk anda
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
 
          <!-- 4. Secondary Grid 2x2 -->
          <tr>
            <td style="padding: 0 20px 30px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <?php 
                $chunks = array_chunk($grid_articles, 2);
                foreach ($chunks as $rowIndex => $row): 
                ?>
                <tr>
                  <?php foreach ($row as $colIndex => $art): ?>
                  <td width="48%" style="width: 48%;" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <?php if (!empty($art['image_url'])): ?>
                      <tr>
                        <td style="padding-bottom: 12px;">
                          <img class="grid-image" src="<?= $art['image_url'] ?>" width="270" height="152" alt="<?= htmlspecialchars($art['title']) ?>" style="display: block; width: 100%; max-width: 100%; height: auto; border-radius: 4px; border: 0;" />
                        </td>
                      </tr>
                      <?php endif; ?>
                      <tr>
                        <td style="padding-bottom: 8px;">
                          <h3 style="margin: 0; font-family: Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 20px; color: #111111;">
                            <a href="#" style="text-decoration: none; color: #111111;"><?= htmlspecialchars($art['title']) ?></a>
                          </h3>
                        </td>
                      </tr>
                      <tr>
                        <td style="color: #555555; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 20px; padding-bottom: 8px;">
                          <?= htmlspecialchars($art['excerpt']) ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding-bottom: 15px;">
                          <span style="font-family: Arial, sans-serif; font-size: 10px; font-weight: 400; line-height: 20px; color: #797878;"><?= htmlspecialchars($art['category']) ?></span>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <?php if ($colIndex === 0): ?>
                    <td width="4%" style="width: 4%;">&nbsp;</td>
                  <?php endif; ?>
                  <?php endforeach; ?>
                  
                  <?php if (count($row) < 2): ?>
                    <td width="4%" style="width: 4%;">&nbsp;</td>
                    <td width="48%" style="width: 48%;">&nbsp;</td>
                  <?php endif; ?>
                </tr>
                <?php if ($rowIndex < count($chunks) - 1): ?>
                <tr>
                  <td colspan="3" style="height: 20px;">&nbsp;</td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
              </table>
            </td>
          </tr>
 
          <!-- 5. Footer -->
          <tr>
            <td align="center" style="background-color: #323232; border-top: 3px solid #FF1B1B; padding: 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 561px; text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: 700; line-height: 20px; color: #ffffff;">
                <tr>
                  <td style="text-align: center;">
                    Email ini dikirim ke <a href="mailto:<?= htmlspecialchars($subscriber_email) ?>" style="color: #ffffff; text-decoration: underline;"><?= htmlspecialchars($subscriber_email) ?></a> oleh beritasatu.com — bagian dari B-Universe Media Group.<br />
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
