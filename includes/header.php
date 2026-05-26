<?php 
ob_start(); 
include 'config/db.php'; 

// ΔΙΟΡΘΩΣΗ SEO: Καθαρισμός των Query Strings από το Canonical URL
$canonical_parts = explode('?', $_SERVER['REQUEST_URI']);
$clean_uri = $canonical_parts[0];
$canonical_url = "https://www.deckrush.gr" . $clean_uri;
?>
<!doctype html>
<html lang="el">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- SEO Βασικά Tags -->
  <title><?php echo isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : 'DeckRush | TCG Cards'; ?></title>
  
  <!-- ΔΙΟΡΘΩΣΗ SEO: Φυσικό Meta Description χωρίς Keyword Stuffing -->
  <meta name="description" content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') : 'Βρείτε σπάνιες συλλεκτικές κάρτες TCG και αξεσουάρ στην Ελλάδα! Μεγάλη ποικιλία σε Pokémon, One Piece, Yu-Gi-Oh!, Magic: The Gathering και φιγούρες Funko Pop στο DeckRush.'; ?>" />
  <link rel="canonical" href="<?php echo $canonical_url; ?>" />

  <!-- Cookiebot script (Πρώτο στο head για GDPR) -->
  <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="1832e3c1-27d6-41b1-8781-281918582468" data-blockingmode="auto" type="text/javascript"></script>

  <!-- Open Graph Tags (Social Media SEO) -->
  <meta property="og:title" content="<?php echo isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : 'DeckRush | TCG Cards Ελλάδα'; ?>" />
  
  <!-- ΔΙΟΡΘΩΣΗ SEO: Ευθυγράμμιση του Open Graph Description με το νέο Meta Description -->
  <meta property="og:description" content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') : 'Βρείτε σπάνιες συλλεκτικές κάρτες TCG και αξεσουάρ στην Ελλάδα! Μεγάλη ποικιλία σε Pokémon, One Piece, Yu-Gi-Oh!, Magic: The Gathering και φιγούρες Funko Pop στο DeckRush.'; ?>" />
  <meta property="og:image" content="https://www.deckrush.gr/assets/logo3.png" />
  <meta property="og:url" content="<?php echo $canonical_url; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="DeckRush" />

  <!-- CSS Libraries -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" />

  <!-- Custom CSS & Favicons -->
  <link rel="stylesheet" href="/style.css" />
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png" />
  <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png" />

  <!-- Google Tag Manager - ΜΠΛΟΚΑΡΙΣΜΕΝΟ για GDPR -->
  <script type="text/plain" data-cookieconsent="marketing">
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NXTBPTBV');
  </script>
  <!-- End Google Tag Manager -->

  <!-- Ασφαλές Product Schema.org με json_encode -->
  <?php if (isset($product) && $product): ?>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": <?php echo json_encode($product_name, JSON_UNESCAPED_UNICODE); ?>,
        "image": "https://www.deckrush.gr/uploads/<?php echo htmlspecialchars($product['item_image'], ENT_QUOTES, 'UTF-8'); ?>",
        "description": <?php echo json_encode(strip_tags($product['description']), JSON_UNESCAPED_UNICODE); ?>,
        "sku": "<?php echo htmlspecialchars($product['id'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>",
        "offers": {
          "@type": "Offer",
          "priceCurrency": "EUR",
          "price": "<?php echo htmlspecialchars($product['selling_price'], ENT_QUOTES, 'UTF-8'); ?>",
          "priceValidUntil": "<?php echo date('Y-12-31'); ?>",
          "availability": "https://schema.org/InStock",
          "url": "<?php echo $canonical_url; ?>"
        }
      }
    </script>
  <?php endif; ?>
</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXTBPTBV" height="0" width="0" style="display:none;visibility:hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- Scroll Back to Top Button με βελτίωση προσβασιμότητας -->
  <a href="#" class="text-decoration-none scroll-up text-center" aria-label="Scroll to top" style="width:60px; height:60px; display: inline-block;">
    <span class="visually-hidden">Scroll to top</span>
    <span class="mb-0 h-100 w-100 d-block"><?php include 'assets/arrow.svg'; ?></span>
  </a>
