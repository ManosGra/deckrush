<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '512M');

while (ob_get_level()) { ob_end_clean(); }
header('Content-Type: application/xml; charset=UTF-8');

require_once 'config/db.php';
$db = null;
foreach (get_defined_vars() as $v) {
    if ($v instanceof mysqli) { $db = $v; break; }
}
if (!$db) { die("DB connection failed"); }

$base_url = "https://deckrush.gr";

function xml($v) {
    // Απλό, ασφαλές escape για XML. Το ENT_XML1 μετατρέπει σωστά τα &, <, >, ", '
    return htmlspecialchars((string)$v, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

// Τυπώνουμε τα headers και το root element χωρίς να κλείνουμε το PHP tag
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
echo '<channel>' . "\n";
echo '<title>DeckRush</title>' . "\n";
echo '<link>https://deckrush.gr</link>' . "\n";
echo '<description>Google Merchant Feed</description>' . "\n";

$sql = "SELECT * FROM products WHERE selling_price > 0 ORDER BY id DESC";
$result = mysqli_query($db, $sql);
if (!$result) { die(mysqli_error($db)); }

while ($p = mysqli_fetch_assoc($result)) {
    $id = $p['id'] ?? 0;
    $title = $p['name'] ?? 'Product';
    
    // Καθαρισμός description
    $description = strip_tags($p['description'] ?? '');
    if (empty($description)) { 
        $description = $title . " - Official sealed product from DeckRush.gr"; 
    }

    $priceRaw = floatval($p['selling_price'] ?? 0);
    $qty = intval($p['qty'] ?? 0);
    if ($priceRaw <= 0) continue;

    // Διαθεσιμότητα
    $availability = ($qty > 0) ? "in_stock" : "out_of_stock";
    $availability_date = null;
    
    if (!empty($p['is_preorder']) && $p['is_preorder'] == 1) {
        $availability = "preorder";
        // Google Format: YYYY-MM-DDThh:mm+hhmm
        $availability_date = ($id == 163) 
            ? "2026-07-17T09:00+02:00" 
            : date('Y-m-d\TH:iO', strtotime('+30 days'));
    }

    // Links & Εικόνες
    $slug = $p['slug'] ?? '';
    $link = rtrim($base_url, '/') . '/product/' . ltrim($slug, '/');

    $image = $p['item_image'] ?? '';
    if (!empty($image) && !preg_match('/^https?:\/\//', $image)) {
        $image = rtrim($base_url, '/') . '/uploads/' . ltrim($image, '/');
    }

    $price = number_format($priceRaw, 2, '.', '') . " EUR";
    
    // Προσδιορισμός Brand
    $brand = "DeckRush";
    if (stripos($title, 'pokemon') !== false) $brand = "Pokemon";
    elseif (stripos($title, 'funko') !== false) $brand = "Funko";
    elseif (stripos($title, 'one piece') !== false) $brand = "Bandai";

    // Output του Item
    echo "<item>\n";
    echo "<g:id>" . xml($id) . "</g:id>\n";
    echo "<title>" . xml($title) . "</title>\n";
    echo "<description>" . xml($description) . "</description>\n";
    echo "<link>" . xml($link) . "</link>\n";
    if (!empty($image)) {
        echo "<g:image_link>" . xml($image) . "</g:image_link>\n";
    }
    echo "<g:price>" . xml($price) . "</g:price>\n";
    echo "<g:availability>" . xml($availability) . "</g:availability>\n";
    if ($availability === "preorder" && $availability_date) {
        echo "<g:availability_date>" . xml($availability_date) . "</g:availability_date>\n";
    }
    echo "<g:condition>new</g:condition>\n";
    echo "<g:age_group>adult</g:age_group>\n";
    echo "<g:material>Paper</g:material>\n";
    // Διορθώθηκαν τα διαχωριστικά κατηγοριών για το Google Merchant
    echo "<g:google_product_category>Toys &amp; Games &gt; Toys &gt; Trading Card Games</g:google_product_category>\n";
    echo "<g:product_type>Trading Cards &gt; Pokemon TCG</g:product_type>\n";
    echo "<g:product_highlight>Official sealed product</g:product_highlight>\n";
    echo "<g:brand>" . xml($brand) . "</g:brand>\n";
    echo "<g:identifier_exists>no</g:identifier_exists>\n";
    echo "</item>\n";
}

echo '</channel>' . "\n";
echo '</rss>' . "\n";
?>
