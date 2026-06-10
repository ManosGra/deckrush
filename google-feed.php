<?php
// 1. Καθαρισμός του output buffer για να μην υπάρχει ΚΑΝΕΝΑ κενό στην αρχή
if (ob_get_length()) ob_clean();

// 2. Απενεργοποίηση εμφάνισης PHP errors στο output για ασφάλεια του XML
error_reporting(0);
ini_set('display_errors', 0);

// 3. Ορισμός των σωστών Headers για XML αρχείο
header("Content-Type: application/xml; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");

// 4. INCLUDE ΤΟ ΔΙΚΟ ΣΟΥ DB.PHP
// (Αν το db.php βρίσκεται σε άλλον φάκελο, άλλαξε το path, π.χ. 'config/db.php')
require_once 'config/db.php'; 

// 5. Έναρξη του XML Output (Η πρώτη γραμμή ξεκινάει ΑΚΡΙΒΩΣ στην αρχή του αρχείου)
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss xmlns:g="http://google.com" version="2.0">';
echo '<channel>';
echo '<title>DeckRush</title>';
echo '<link>https://deckrush.gr</link>';
echo '<description>Google Merchant Center Product Feed</description>';

// -------------------------------------------------------------------------
// 6. ΤΟ QUERY ΣΟΥ (Επίλεξε ΜΙΑ από τις δύο παρακάτω μεθόδους ανάλογα με το db.php σου)
// -------------------------------------------------------------------------

// --- ΕΠΙΛΟΓΗ Α: Αν το db.php χρησιμοποιεί PDO (Ξεσχολίασε αυτό το μπλοκ αν ισχύει) ---
/*
$stmt = $pdo->query("SELECT id, title, description, price, image_url, product_url, stock, brand FROM products WHERE active = 1");
while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
*/

// --- ΕΠΙΛΟΓΗ Β: Αν το db.php χρησιμοποιεί MySQLi (Αντικατάστησε το $conn με τη δική σου μεταβλητή) ---
$query = "SELECT id, title, description, price, image_url, product_url, stock, brand FROM products WHERE active = 1";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($product = mysqli_fetch_assoc($result)) {
        
        // Προετοιμασία δεδομένων & Escaping με CDATA για αποφυγή XML formatting errors
        $id           = $product['id'];
        $title        = '<![CDATA[' . trim($product['title']) . ']]>';
        $description  = '<![CDATA[' . trim($product['description']) . ']]>';
        $link         = trim($product['product_url']);
        $image_link   = trim($product['image_url']);
        
        // Σωστό format τιμής (π.χ. 24.99 EUR) - Απαιτείται τελεία στα δεκαδικά
        $price        = number_format($product['price'], 2, '.', '') . ' EUR';
        
        // Διαθεσιμότητα: Η Google δέχεται ΜΟΝΟ: in_stock, out_of_stock, preorder
        $availability = ($product['stock'] > 0) ? 'in_stock' : 'out_of_stock';
        
        // Brand: Αν δεν υπάρχει στη βάση, βάζει αυτόματα το όνομα του site σου
        $brand        = !empty($product['brand']) ? '<![CDATA[' . trim($product['brand']) . ']]>' : '<![CDATA[DeckRush]]>';

        // Εκτύπωση του προϊόντος σε XML format
        echo '<item>';
        echo '<g:id>' . $id . '</g:id>';
        echo '<title>' . $title . '</title>';
        echo '<link>' . $link . '</link>';
        echo '<g:price>' . $price . '</g:price>';
        echo '<g:image_link>' . $image_link . '</g:image_link>';
        echo '<g:availability>' . $availability . '</g:availability>';
        echo '<g:condition>new</g:condition>';
        echo '<g:brand>' . $brand . '</g:brand>';
        echo '</item>';
    }
}

// Κλείσιμο των XML tags
echo '</channel>';
echo '</rss>';
