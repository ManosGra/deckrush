<?php ob_start(); ?>
<?php include 'config/db.php'; ?>

<!doctype html>
<html lang="el">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'DeckRush - TCG Cards'; ?></title>
  <meta name="description"
    content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description) : 'Pokemon, One Piece, Funko Pop!, Funko, Yu-Gi-Oh!, Magic: The Gathering κάρτες στην Ελλάδα. Σπάνιες συλλεκτικές κάρτες & αξεσουάρ TCG.'; ?>" />

  <link rel="canonical" href="<?php echo "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />

  <!-- Cookiebot script -->
  <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="1832e3c1-27d6-41b1-8781-281918582468"
    data-blockingmode="auto" type="text/javascript">
    </script>
  <!-- Open Graph Tags -->
  <meta property="og:title"
    content="<?php echo isset($page_title) ? htmlspecialchars($page_title) : 'DeckRush | TCG Cards Ελλάδα'; ?>" />
  <meta property="og:description"
    content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description) : 'Pokemon, One Piece, Funko Pop!, Funko, Yu-Gi-Oh!, Magic: The Gathering κάρτες στην Ελλάδα. Σπάνιες συλλεκτικές κάρτες & αξεσουάρ TCG.'; ?>" />
  <meta property="og:image" content="https://www.deckrush.gr/assets/logo3.png" />
  <meta property="og:url" content="https://www.deckrush.gr<?php echo $_SERVER['REQUEST_URI']; ?>" />
  <meta property="og:type" content="website" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- AlertifyJS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />

  <!-- Bootstrap Icons -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="assets/favicon-32x32.png" />

  <!-- Google Tag Manager - ΜΠΛΟΚΑΡΙΣΜΕΝΟ -->
  <script type="text/plain" data-cookieconsent="marketing">
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NXTBPTBV');
  </script>
  <!-- End Google Tag Manager -->

  <?php if (isset($product) && $product): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "<?php echo addslashes($product_name); ?>",
      "image": "https://www.deckrush.gr/uploads/<?php echo htmlspecialchars($product['item_image']); ?>",
      "description": "<?php echo addslashes(strip_tags($product['description'])); ?>",
      "offers": {
        "@type": "Offer",
        "priceCurrency": "EUR",
        "price": "<?php echo htmlspecialchars($product['selling_price']); ?>",
        "availability": "https://schema.org/InStock"
      }
    }
    </script>
  <?php endif; ?>
</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXTBPTBV" height="0" width="0"
      style="display:none;visibility:hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->

  <a href="#" class="text-decoration-none scroll-up text-center" aria-label="Scroll to top" style="width:60px; height:60px;"><p class="mb-0 h-100 w-100"><?php include 'assets/arrow.svg'; ?></p></a>