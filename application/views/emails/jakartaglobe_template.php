<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($subject) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
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
      .header-text-table {
        width: 90% !important;
      }
      .stack-col {
        display: block !important;
        width: 100% !important;
        box-sizing: border-box;
      }
      .stack-spacer {
        display: none !important;
      }
      .stack-col-padding {
        padding-top: 20px !important;
      }
    }
  </style>
</head>
<body style="margin: 0; padding: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #f7f7f7; font-family: 'Inter', Arial, Helvetica, sans-serif;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f7f7f7; padding: 20px 0;">
    <tr>
      <td align="center">
        <!-- Main Email Container (600px wide) -->
        <table border="0" cellpadding="0" cellspacing="0" width="600" class="container" style="background-color: #ffffff; border-collapse: collapse; overflow: hidden;">
          
          <!-- 1. Header & Hero Banner with Overlay Text -->
          <tr>
            <td background="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-header.jpg" height="297" valign="top" style="background-image: url('https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-header.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-color: #4a4a4a; height: 297px;">
              <!--[if gte mso 9]>
              <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;height:297px;">
                <v:fill type="tile" src="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-header.jpg" color="#4a4a4a" />
                <v:textbox inset="0,0,0,0">
              <![endif]-->
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <!-- Logo Row -->
                <tr>
                  <td align="right" style="padding: 26px 20px 0 20px;">
                    <img src="https://ifrdsavqzecxpzdoatga.supabase.co/storage/v1/object/public/newsletter-images/jakartaglobe-logo.png" width="165" alt="JAKARTA GLOBE" loading="lazy" style="display: inline-block; border: 0; max-width: 100%; height: auto;" />
                  </td>
                </tr>

                <!-- Spacer -->
                <tr>
                  <td style="height: 95px; font-size: 1px; line-height: 1px;">&nbsp;</td>
                </tr>

                <!-- Paragraph Row -->
                <tr>
                  <td style="padding: 0 20px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="50%" class="header-text-table">
                      <tr>
                        <td style="color: #ffffff; font-family: 'Inter', Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 100%;">
                          <span style="font-family: 'Inter', Arial, sans-serif; font-size: 12px; display: block; margin-bottom: 15px; font-weight: 700; line-height: 100%;"><?= htmlspecialchars($greeting_title ? $greeting_title : 'Dear Reader,') ?></span>
                          <span style="font-family: 'Inter', Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 18px; color: #ffffff;">
                            <?= nl2br(htmlspecialchars($greeting_body)) ?>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding-top: 15px; color: #cccccc; font-family: 'Inter', Arial, sans-serif; font-size: 8px; font-weight: 400; line-height: 100%; letter-spacing: 0px;">
                          Vol <?= isset($volume) ? $volume : '1' ?> - <?= isset($date) ? $date : date('l, d F Y') ?>
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
          <tr>
            <td style="padding: 34px 20px 25px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <!-- Left column: Main Topic -->
                  <?php if (!empty($main_article)): ?>
                  <td class="stack-col" width="45%" style="width: 45%;" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <?php if (!empty($main_article['image_url'])): ?>
                      <tr>
                        <td style="padding-bottom: 12px;">
                          <a href="<?= !empty($main_article['url']) ? $main_article['url'] : '#' ?>" style="text-decoration: none;"><img class="responsive-img" src="<?= $main_article['image_url'] ?>" width="267" height="178" alt="<?= htmlspecialchars($main_article['title']) ?>" loading="lazy" style="display: block; width: 100%; max-width: 100%; height: auto; border-radius: 10px; border: 0;" /></a>
                        </td>
                      </tr>
                      <?php endif; ?>
                      <tr>
                        <td style="padding-bottom: 8px;">
                          <h2 style="margin: 0; font-family: 'Inter', Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 20px; color: #111111;">
                            <a href="<?= !empty($main_article['url']) ? $main_article['url'] : '#' ?>" style="color: #111111; text-decoration: none;"><?= htmlspecialchars($main_article['title']) ?></a>
                          </h2>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; color: #555555; line-height: 20px; padding-bottom: 10px;">
                          <?= htmlspecialchars($main_article['excerpt']) ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <?php endif; ?>

                  <!-- Spacer -->
                  <td class="stack-spacer" width="3%" style="width: 3%;">&nbsp;</td>

                  <!-- Right column: Sidebar story list -->
                  <td class="stack-col stack-col-padding" width="52%" style="width: 52%; padding-left: 0;" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <?php 
                      $totalSidebar = count($sidebar_articles);
                      foreach ($sidebar_articles as $sIndex => $art): 
                        $borderBottom = ($sIndex === $totalSidebar - 1) ? '1px dashed #ffffff' : '1px dashed #000000';
                        $borderTop = ($sIndex === 0) ? '1px dashed #ffffff' : '';
                      ?>
                      <tr>
                        <td style="padding: 10px 0; border-bottom: <?= $borderBottom ?>; <?= $borderTop ? 'border-top: ' . $borderTop . ';' : '' ?>">
                          <a href="<?= !empty($art['url']) ? $art['url'] : '#' ?>" style="font-family: 'Inter', Arial, sans-serif; font-size: 14px; font-weight: 700; color: #222222; text-decoration: none; line-height: 20px; display: block;">
                            <?= htmlspecialchars($art['title']) ?>
                          </a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- 3. Another Topic Divider -->
          <tr>
            <td align="center" style="padding: 20px 20px 10px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border-top: 1px dashed #dddddd; border-bottom: 1px dashed #dddddd;">
                <tr>
                  <td align="center" style="padding: 17px 10px;">
                    <span style="color: #777777; font-family: 'Inter', Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 100%; letter-spacing: 1px;">
                      Another Topic
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- 4. Alternating Articles -->
          <tr>
            <td style="padding: 10px 20px 25px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <?php foreach ($alternating_articles as $index => $art): ?>
                <tr>
                  <td style="padding: 35px 0 0 0;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <?php if (empty($art['image_url'])): ?>
                          <!-- Full width text -->
                          <td width="100%" valign="middle" style="font-family: 'Inter', sans-serif;">
                            <h3 style="margin: 0 0 8px 0; font-family: 'Inter', Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 20px; color: #111111;">
                              <a href="<?= !empty($art['url']) ? $art['url'] : '#' ?>" style="color: #111111; text-decoration: none;"><?= htmlspecialchars($art['title']) ?></a>
                            </h3>
                            <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; color: #555555; line-height: 20px;">
                              <?= htmlspecialchars($art['excerpt']) ?>
                            </p>
                          </td>
                        <?php elseif ($index % 2 === 0): ?>
                          <!-- Left Image, Right Text -->
                          <td width="45%" style="width: 45%; padding-right: 20px;" valign="middle">
                            <a href="<?= !empty($art['url']) ? $art['url'] : '#' ?>" style="text-decoration: none;"><img class="responsive-img" src="<?= $art['image_url'] ?>" width="267" height="178" alt="<?= htmlspecialchars($art['title']) ?>" loading="lazy" style="display: block; width: 100%; max-width: 100%; height: auto; border-radius: 10px; border: 0;" /></a>
                          </td>
                          <td width="52%" valign="middle" style="width: 52%; font-family: 'Inter', sans-serif;">
                            <h3 style="margin: 0 0 8px 0; font-family: 'Inter', Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 20px; color: #111111;">
                              <a href="<?= !empty($art['url']) ? $art['url'] : '#' ?>" style="color: #111111; text-decoration: none;"><?= htmlspecialchars($art['title']) ?></a>
                            </h3>
                            <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; color: #555555; line-height: 20px;">
                              <?= htmlspecialchars($art['excerpt']) ?>
                            </p>
                          </td>
                        <?php else: ?>
                          <!-- Right Image, Left Text -->
                          <td width="52%" valign="middle" style="width: 52%; padding-right: 20px; font-family: 'Inter', sans-serif;">
                            <h3 style="margin: 0 0 8px 0; font-family: 'Inter', Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 20px; color: #111111;">
                              <a href="<?= !empty($art['url']) ? $art['url'] : '#' ?>" style="color: #111111; text-decoration: none;"><?= htmlspecialchars($art['title']) ?></a>
                            </h3>
                            <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; font-weight: 400; color: #555555; line-height: 20px;">
                              <?= htmlspecialchars($art['excerpt']) ?>
                            </p>
                          </td>
                          <td width="45%" style="width: 45%;" valign="middle">
                            <a href="<?= !empty($art['url']) ? $art['url'] : '#' ?>" style="text-decoration: none;"><img class="responsive-img" src="<?= $art['image_url'] ?>" width="267" height="178" alt="<?= htmlspecialchars($art['title']) ?>" loading="lazy" style="display: block; width: 100%; max-width: 100%; height: auto; border-radius: 10px; border: 0;" /></a>
                          </td>
                        <?php endif; ?>
                      </tr>
                    </table>
                  </td>
                </tr>
                <?php endforeach; ?>
              </table>
            </td>
          </tr>

          <!-- 5. Footer -->
          <tr>
            <td align="center" style="background-color: #323232; border-top: 3px solid #F8670F; padding: 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 561px; text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: 700; line-height: 20px; color: #ffffff;">
                <tr>
                  <td style="text-align: center;">
                    This email was sent to <a href="mailto:<?= htmlspecialchars($subscriber_email) ?>" style="color: #ffffff; text-decoration: underline;"><?= htmlspecialchars($subscriber_email) ?></a> by jakartaglobe.id — part of B-Universe Media Group.<br />
                    TOKYO HUB PANTAI INDAH KAPUK 2, Tower K #BS-K.1, #K.1, #K2.1, Tangerang, Banten, 15510.<br />
                    Phone: 021 3972 2988<br />
                    <a href="<?= base_url('subscribers/unsubscribe?email=' . urlencode($subscriber_email)) ?>" style="color: #ffffff; text-decoration: underline;">Unsubscribe</a> | <a href="#" style="color: #ffffff; text-decoration: underline;">Privacy Policy</a>
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
