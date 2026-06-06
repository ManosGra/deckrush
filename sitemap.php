<?php
// 1. Σύνδεση με τη βάση δεδομένων
include 'config/db.php';

// Αυτόματος εντοπισμός σύνδεσης mysqli
$database_link = null;

foreach (get_defined_vars() as $var) {
    if ($var instanceof mysqli) {
        $database_link = $var;
        break;
    }
}

// Αυτόματος εντοπισμός Domain
$base_url = "https://" . $_SERVER['HTTP_HOST'] . "/";

// XML Header
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <!-- Αρχική -->
    <url>
        <loc><?= $base_url ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Contact -->
    <url>
        <loc><?= $base_url ?>contact</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <!-- About -->
    <url>
        <loc><?= $base_url ?>about</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <!-- Pre-orders -->
    <url>
        <loc>
            <?= $base_url ?>pre-orders
        </loc>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>

    <?php
    if ($database_link) {

        $query = "SELECT slug FROM products WHERE status='0'";
        $result = mysqli_query($database_link, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $slug = htmlspecialchars($row['slug'], ENT_QUOTES, 'UTF-8');

                echo "
    <url>
        <loc>{$base_url}product/{$slug}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>";
            }
        }
    }
    ?>

</urlset>