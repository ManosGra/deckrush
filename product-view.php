<?php
include 'functions/userfunctions.php';

// Έλεγχος αν υπάρχει το slug
if (isset($_GET['product'])) {
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("products", $product_slug);
    $product = mysqli_fetch_array($product_data);

    if ($product) {
        $product_name = $product['name'];
        $page_title = $product_name . " | DeckRush";
        $meta_description = substr(strip_tags($product['description']), 0, 150) . "...";
    } else {
        $page_title = "Άγνωστο Προϊόν | DeckRush";
        $meta_description = "Το προϊόν δεν βρέθηκε.";
    }
} else {
    $page_title = "Σφάλμα | DeckRush";
    $meta_description = "Κάτι πήγε στραβά.";
}

include 'includes/header.php';
include 'includes/navigation.php';
?>

<section id="product-view" class="pb-5">
    <div class="container-lg product_data">

        <?php if (isset($product) && $product) { ?>
            <div class="d-flex flex-row align-items-center">
                <a href="javascript:history.back()">
                    <i class="bi bi-arrow-left-circle-fill font-size-30 me-3"></i>
                </a>
                <h1 class="m-0 w-100"><?php echo htmlspecialchars($product['name']); ?></h1>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-lg rounded-4 p-4">
                        <img src="uploads/<?php echo htmlspecialchars($product['item_image']); ?>" alt="Product Image" class="w-100">
                    </div>
                </div>

                <div class="col-md-8">
                    <?php
                    $qty = (int) $product['qty'];
                    $btnDisabled = $qty === 0 ? 'disabled' : '';
                    $qtyValue = $qty === 0 ? 0 : 1;
                   $availabilityClass = $qty === 0 ? 'bg-danger text-white' : 'text-white';
$availabilityStyle = $qty === 0 ? '' : 'background-color: #28a745;'; // φωτεινό πράσινο
                    $availabilityText = $qty === 0 ? 'Προϊόν εξαντλήθηκε' : 'Το προϊόν είναι άμεσα διαθέσιμο';
                    ?>

                    <!-- Μήνυμα διαθεσιμότητας -->
                    <div class="card shadow rounded-4 information text-center <?php echo $availabilityClass; ?>">
                        <p class="mb-0"><?php echo $availabilityText; ?></p>
                    </div>

                    <div class="card shadow rounded-4 p-4 mt-3">
                        <p><?php echo htmlspecialchars($product['small_description']); ?></p>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1><span class="fw-bold"><?php echo htmlspecialchars($product['selling_price']); ?>€</span></h1>
                                <p class="mb-0">Η τιμή του προϊόντος περιλαμβάνει ΦΠΑ</p>
                            </div>
                        </div>

                        <!-- Επιλογή ποσότητας -->
                        <div class="products-qty my-3 d-flex align-items-center justify-content-center product_data" data-id="<?php echo htmlspecialchars($product['id']); ?>">
                            <div class="input-group me-5" style="width:130px">
                                <button class="input-group-text decrement-btn" <?php echo $btnDisabled; ?>>-</button>
                                <input type="text" class="form-control text-center input-qty bg-white"
                                       value="<?php echo $qtyValue; ?>" min="1" max="<?php echo $qty; ?>" <?php echo $btnDisabled; ?>>
                                <button class="input-group-text increment-btn" <?php echo $btnDisabled; ?>>+</button>
                            </div>
                        </div>

                        <!-- Κουμπί Προσθήκης στο Καλάθι -->
                        <div class="product-buttons d-flex flex-row align-items-center justify-content-center mb-4">
                            <button class="cart-btn text-white font-size-16 fw-bold px-4 me-2 addToCartBtn"
                                    value="<?php echo htmlspecialchars($product['id']); ?>" <?php echo $btnDisabled; ?>>
                                <?php if ($qty > 0): ?>
                                    <i class="bi bi-cart me-2 font-size-20 fw-bold"></i>ΠΡΟΣΘΗΚΗ ΣΤΟ ΚΑΛΑΘΙ
                                <?php else: ?>
                                    ΧΩΡΙΣ ΔΙΑΘΕΣΙΜΟΤΗΤΑ
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>

                    <!-- Περιγραφή προϊόντος -->
                    <div class="col-md-12 mt-3">
                        <div class="card shadow-lg rounded-4">
                            <div class="card-body">
                                <h4>Περιγραφή:</h4>
                                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
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

    </div>
</section>

<?php include 'top-sale.php'; ?>
<?php include 'includes/footer.php'; ?>
