<?php
include 'functions/userfunctions.php';

// Έλεγχος αν υπάρχει το slug της κατηγορίας
if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];
    $category_data = getSlugActive("product_categories", $category_slug);
    $category = mysqli_fetch_array($category_data);

    if ($category) {
        // Ορισμός SEO Title και Description πριν το header
        $page_title = $category['category_name'] . " | Αυθεντικά Προϊόντα TCG | DeckRush";
        $meta_description = "Ανακαλύψτε σπάνιες κάρτες, booster boxes και αξεσουάρ στην κατηγορία " . $category['category_name'] . " στις καλύτερες τιμές στο DeckRush.";
        
        // ΔΙΟΡΘΩΣΗ SEO 1: Δημιουργία Breadcrumb Schema για τη Google
        $current_category_url = "https://deckrush.gr" . htmlspecialchars($category_slug, ENT_QUOTES, 'UTF-8');
        $breadcrumb_schema = '
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Αρχική",
            "item": "https://deckrush.gr"
          },{
            "@type": "ListItem",
            "position": 2,
            "name": "' . addslashes($category['category_name']) . '",
            "item": "' . $current_category_url . '"
          }]
        }
        </script>';
    } else {
        $page_title = "Άγνωστη Κατηγορία | DeckRush";
        $meta_description = "Η κατηγορία δεν βρέθηκε.";
    }
} else {
    $page_title = "Σφάλμα | DeckRush";
    $meta_description = "Κάτι πήγε στραβά.";
}

include 'includes/header.php';

// ΔΙΟΡΘΩΣΗ SEO 1 (Συνέχεια): Εκτύπωση του Breadcrumb Schema μέσα στο head μέσω του header ή απευθείας εδώ
if (isset($breadcrumb_schema)) { echo $breadcrumb_schema; }

include 'includes/navigation.php';
?>

<section id="products" class="box show">
    <div class="container-lg">

        <?php if (isset($category) && $category) { ?>
            <!-- ΔΙΟΡΘΩΣΗ SEO 2: Μετατροπή του generic Breadcrumb σε έγκυρη HTML5 δομή με nav -->
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="/">Αρχική</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8'); ?></li>
                </ol>
            </nav>

            <div class="row g-0">
                <div class="col-lg-3 col-12">
                    <?php $cid = $category['category_name']; ?>
                    <?php include 'filters.php'; ?>
                </div>

                <div class="col-md-9">
                    <h1 class="font-rubik text-center fw-bold">
                        <?php echo htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <hr>

                    <div class="row products-container">
                        <?php
                        $cid = $category['category_name'];
                        $products = getProdByCategory($cid);

                        if (mysqli_num_rows($products) > 0) {
                            foreach ($products as $item) {
                                ?>
                                <div class="col-md-4 mb-3 product-col">
                                    <!-- ΔΙΟΡΘΩΣΗ: Προστέθηκε overflow-hidden στην κάρτα για να κόβεται σωστά η διαγώνια κορδέλα -->
                                    <div class="card shadow-lg product-box product_data pt-3 box show position-relative overflow-hidden">
                                        
                                        <!-- ΜΩΒ ΔΙΑΓΩΝΙΑ ΚΟΡΔΕΛΑ PRE-ORDER -->
                                        <?php if (isset($item['is_preorder']) && $item['is_preorder'] == 1): ?>
                                            <span class="badge position-absolute fw-bold" 
                                                  style="top: 16px; left: -24px; z-index: 5; padding: 6px 0; font-size: 11px; text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.15); background-color: #A444BC; color: #ffffff; transform: rotate(-45deg); width: 100px; text-align: center; border-radius: 0;">
                                                Pre-Order
                                            </span>
                                        <?php endif; ?>

                                        <div class="card-body p-0">
                                            <div class="product-image text-center">
                                                <a class="text-decoration-none" href="/product/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <img src="/uploads/<?php echo htmlspecialchars($item['item_image'], ENT_QUOTES, 'UTF-8'); ?>"
                                                        alt="Κάρτα <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?> - DeckRush" 
                                                        class="img-fluid p-4" loading="lazy" style="height:300px; object-fit: contain;">
                                                </a>
                                            </div>
                                            <div class="product-price">
                                                <p class="font-size-25 fw-bold text-center mb-1">
                                                    <?php echo htmlspecialchars($item['selling_price'], ENT_QUOTES, 'UTF-8'); ?>€
                                                </p>
                                            </div>

                                            <div class="product-info">
                                                <a class="text-decoration-none" href="/product/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <p class="text-center font-size-20 text-dark px-3 mb-1">
                                                        <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </p>
                                                </a>

                                                <p class="text-center">
                                                    <small>Διαθέσιμα: <?php echo htmlspecialchars($item['qty'], ENT_QUOTES, 'UTF-8'); ?></small>
                                                </p>
                                            </div>

                                            <div class="product-btns d-flex flex-row align-items-center justify-content-around">
                                                <a href="/product/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>"
                                                    class="text-decoration-none product-btn w-100 text-center p-2" aria-label="Προβολή προϊόντος <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                                    <i class="bi bi-search text-white font-size-20"></i>
                                                </a>

                                                <?php
                                                $btnStyle = ((int) $item['qty'] === 0) ? 'display:none;' : '';
                                                ?>
                                                <button class="product-btn addToCartBtn w-100 text-center p-2"
                                                    value="<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?>"
                                                    style="<?php echo $btnStyle; ?>" aria-label="Προσθήκη στο καλάθι">
                                                    <input type="hidden" class="form-control text-center input-qty bg-white" value="1" disabled>
                                                    <i class="bi bi-cart text-white font-size-20"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<div class='col-12'><div class='alert alert-warning'>Δεν υπάρχουν προϊόντα σε αυτή την κατηγορία.</div></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="alert alert-danger mt-4">
                Η κατηγορία δεν βρέθηκε.
            </div>
        <?php } ?>

    </div>
</section>

<?php include 'top-sale.php'; ?>
<?php include 'includes/footer.php'; ?>
