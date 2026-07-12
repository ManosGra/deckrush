<?php
include 'functions/userfunctions.php';

// Έλεγχος αν υπάρχει το slug
if (isset($_GET['product'])) {
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("products", $product_slug);
    $product = mysqli_fetch_array($product_data);

    if ($product) {
        $product_name = $product['name'];

        // ΔΙΟΡΘΩΣΗ SEO: Αν είναι pre-order, βάζουμε τη λέξη στον τίτλο ΜΟΝΟ για τη Google
        if (isset($product['is_preorder']) && $product['is_preorder'] == 1) {
            $page_title = $product_name . " (Pre-Order) | DeckRush";
        } else {
            $page_title = $product_name . " | DeckRush";
        }

        // ΔΙΟΡΘΩΣΗ SEO 1: Χρήση mb_substr για να μην σπάνε τα ελληνικά γράμματα
        $meta_description = mb_substr(strip_tags($product['description']), 0, 150, 'UTF-8');

        // ΔΙΟΡΘΩΣΗ SEO 2: Δυναμική διαθεσιμότητα για το Schema.org του header
        $schema_availability = ((int) $product['qty'] > 0) ? "https://schema.org" : "https://schema.org";
    } else {
        $page_title = "Άγνωστο Προϊόν | DeckRush";
        $meta_description = "Το προϊόν δεν βρέθηκε.";
        $schema_availability = "https://schema.org";
    }
} else {
    $page_title = "Σφάλμα | DeckRush";
    $meta_description = "Κάτι πήγε στραβά.";
    $schema_availability = "https://schema.org";
}

include 'includes/header.php';
include 'includes/navigation.php';
?>

<section id="product-view" class="pb-5">
    <div class="container-lg product_data">

        <?php if (isset($product) && $product) { ?>
            <div class="d-flex flex-row align-items-center">
                <a href="javascript:history.back()" aria-label="Επιστροφή στην προηγούμενη σελίδα">
                    <i class="bi bi-arrow-left-circle-fill font-size-30 me-3"></i>
                </a>
                <h1 class="m-0 w-100"><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-lg rounded-4 p-4 position-relative overflow-hidden">
                        <!-- ΜΩΒ ΔΙΑΓΩΝΙΑ ΚΟΡΔΕΛΑ ΚΑΙ ΜΕΣΑ ΣΤΗ ΣΕΛΙΔΑ ΠΡΟΪΟΝΤΟΣ -->
                        <?php if (isset($product['is_preorder']) && $product['is_preorder'] == 1): ?>
                            <span class="badge position-absolute fw-bold"
                                style="top: 16px; left: -24px; z-index: 5; padding: 6px 0; font-size: 11px; text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.15); background-color: #A444BC; color: #ffffff; transform: rotate(-45deg); width: 100px; text-align: center; border-radius: 0;">
                                Pre-Order
                            </span>
                        <?php endif; ?>

                        <img src="/uploads/<?php echo htmlspecialchars($product['item_image'], ENT_QUOTES, 'UTF-8'); ?>"
                            alt="Κάρτα <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?> - DeckRush"
                            class="w-100">
                    </div>
                </div>

                <div class="col-md-8">
                    <?php
                    $qty = (int) $product['qty'];
                    $btnDisabled = $qty === 0 ? 'disabled' : '';
                    $qtyValue = $qty === 0 ? 0 : 1;

                    // ΔΙΟΡΘΩΣΗ: Αν είναι Pre-order αλλάζει το κείμενο, το χρώμα και το icon
                    if (isset($product['is_preorder']) && $product['is_preorder'] == 1) {
                        $availabilityClass = 'text-white';
                        $availabilityStyle = 'background-color: #A444BC;';
                        $availabilityText = '⏳ Το προϊόν είναι διαθέσιμο για Προπαραγγελία (Pre-order)';
                    } elseif ($qty === 0) {
                        $availabilityClass = 'bg-danger text-white';
                        $availabilityStyle = '';
                        $availabilityText = 'Το προϊόν δεν είναι διαθέσιμο';
                    } else {
                        $availabilityClass = 'text-white';
                        $availabilityStyle = 'background-color: #28a745;';
                        $availabilityText = 'Το προϊόν είναι άμεσα διαθέσιμο';
                    }
                    ?>

                    <!-- Μήνυμα διαθεσιμότητας -->
                    <div class="card shadow rounded-4 information text-center <?php echo $availabilityClass; ?>"
                        style="<?php echo $availabilityStyle; ?>">
                        <p class="mb-0 py-2 fw-bold"><?php echo $availabilityText; ?></p>
                    </div>
                    <div class="card shadow rounded-4 p-4 mt-3">
                        <?php if (!empty($product['small_description'])): ?>
                            <p class="mx-auto d-block f-bold text-white py-2 px-4 rounded-3 has-bg">
                                <?php echo htmlspecialchars($product['small_description'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1><span
                                        class="fw-bold"><?php echo htmlspecialchars($product['selling_price'], ENT_QUOTES, 'UTF-8'); ?>€</span>
                                </h1>
                                <p class="mb-0">Η τιμή του προϊόντος περιλαμβάνει ΦΠΑ</p>
                            </div>
                        </div>

                        <!-- Επιλογή ποσότητας -->
                        <div class="products-qty my-3 d-flex align-items-center justify-content-center product_data"
                            data-id="<?php echo htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="input-group me-5" style="width:130px">
                                <button class="input-group-text decrement-btn" <?php echo $btnDisabled; ?>
                                    aria-label="Μείωση ποσότητας">-</button>
                                <input type="text" class="form-control text-center input-qty bg-white"
                                    value="<?php echo $qtyValue; ?>" min="1" max="<?php echo $qty; ?>" <?php echo $btnDisabled; ?> readonly>
                                <button class="input-group-text increment-btn" <?php echo $btnDisabled; ?>
                                    aria-label="Αύξηση ποσότητας">+</button>
                            </div>
                        </div>

                        <!-- Κουμπί Προσθήκης στο Καλάθι -->
                        <div class="product-buttons d-flex flex-row align-items-center justify-content-center mb-4">
                            <button class="cart-btn text-white font-size-16 fw-bold px-4 me-2 addToCartBtn"
                                value="<?php echo htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $btnDisabled; ?>>
                                <?php if ($qty > 0 || (isset($product['is_preorder']) && $product['is_preorder'] == 1)): ?>
                                    <i class="bi bi-cart me-2 font-size-20 fw-bold"></i>ΠΡΟΣΘΗΚΗ ΣΤΟ ΚΑΛΑΘΙ
                                <?php else: ?>
                                    XΩΡΙΣ ΔΙΑΘΕΣΙΜΟΤΗΤΑ
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>

                    <!-- Περιγραφή προϊόντος -->
                    <div class="col-md-12 mt-3">
                        <div class="card shadow-lg rounded-4">
                            <div class="card-body">
                                <h2>Περιγραφή:</h2>
                                <p><?php echo nl2br(htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="alert alert-danger mt-4">
                Το προϊόν δεν βρέθηκε.
            </div>
        <?php } ?>

        <?php
        $relatedProducts = getRelatedProducts(
            $product['category_id'],
            $product['id']
        );
        ?>

        <div class="row mt-5">

            <div class="col-md-12 mt-4 mb-5">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h2 class="f-bold mb-3">
                            Συχνές ερωτήσεις
                        </h2>

                        <?php include 'includes/accordion.php'; ?>

                    </div>
                </div>
            </div>

            <h2 class="text-center f-bold mb-4">Σχετικά προϊόντα</h2>

            <?php if (count($relatedProducts) > 0): ?>

                <?php foreach ($relatedProducts as $item): ?>

                    <div class="col-md-3 mb-3 product-col">

                        <div class="card shadow-lg product-box product_data pt-3 box show position-relative overflow-hidden">

                            <div class="card-body p-0">

                                <div class="product-image text-center">

                                    <a class="text-decoration-none"
                                        href="/product/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>">

                                        <img src="/uploads/<?php echo htmlspecialchars($item['item_image'], ENT_QUOTES, 'UTF-8'); ?>"
                                            alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?> - DeckRush"
                                            class="img-fluid p-4" loading="lazy" style="height:300px; object-fit:contain;">
                                    </a>
                                </div>

                                <div class="product-price">
                                    <p class="font-size-25 fw-bold text-center mb-1">
                                        <?php echo htmlspecialchars($item['selling_price'], ENT_QUOTES, 'UTF-8'); ?>€
                                    </p>
                                </div>

                                <div class="product-info">

                                    <a class="text-decoration-none"
                                        href="/product/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <p class="text-center font-size-20 text-dark px-3 mb-1">
                                            <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                        </p>
                                    </a>

                                    <p class="text-center">
                                        <small>
                                            <?php if ($item['qty'] > 0): ?>
                                                Διαθέσιμα:
                                                <?php echo $item['qty']; ?>
                                            <?php elseif ($item['is_preorder'] == 1): ?>
                                                Pre-Order
                                            <?php else: ?>
                                                Χωρίς απόθεμα
                                            <?php endif; ?>
                                        </small>
                                    </p>
                                </div>

                                <div class="product-btns d-flex flex-row align-items-center justify-content-around">
                                    <a href="/product/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>"
                                        class="text-decoration-none product-btn w-100 text-center p-2">

                                        <i class="bi bi-search text-white font-size-20"></i>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>