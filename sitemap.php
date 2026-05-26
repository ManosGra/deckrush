<?php
// 1. Σύνδεση με τη βάση δεδομένων
include 'config/db.php'; 

// Αυτόματος εντοπισμός σύνδεσης (Ανεξαρτήτως ονόματος μεταβλητής)
$database_link = null;
foreach (get_defined_vars() as $var) {
    if ($var instanceof mysqli) {
        $database_link = $var;
        break;
    }
}

// Αυτόματος εντοπισμός του Domain (π.χ. deckrush.local ή www.deckrush.gr)
$base_url = "https://" . $_SERVER['HTTP_HOST'] . "/";

// 2. Απενεργοποίηση Cache για να βλέπετε αμέσως τις αλλαγές
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 3. Ενημέρωση του browser ότι αυτό είναι XML
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://sitemaps.org">

  <!-- 🏠 Αρχική Σελίδα -->
  <url>
    <loc><?php echo $base_url; ?></loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>

  <!-- 📞 Σταθερές Σελίδες -->
  <url>
    <loc><?php echo $base_url; ?>contact</loc>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>

  <!-- 🃏 ΔΥΝΑΜΙΚΕΣ ΣΕΛΙΔΕΣ: Προϊόντα -->
  <?php
  if ($database_link) {
      $query = "SELECT slug FROM products WHERE trending = 1"; 
      $result = mysqli_query($database_link, $query);

      if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              // Δημιουργία σωστού URL με κάθετο
              $product_url = $base_url . "products/" . htmlspecialchars($row['slug'], ENT_QUOTES, 'UTF-8');
              
              echo "  <url>\n";
              echo "    <loc>{$product_url}</loc>\n";
              echo "    <changefreq>weekly</changefreq>\n";
              echo "    <priority>0.8</priority>\n";
              echo "  </url>\n";
          }
      }
  }
  ?>

</urlset>
