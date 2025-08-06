<?php
include 'functions/userfunctions.php';

// Έλεγχος αν υπάρχει το slug της κατηγορίας
if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];
    $category_data = getSlugActive("product_categories", $category_slug);
    $category = mysqli_fetch_array($category_data);

    if ($category) {
        // Ορισμός SEO Title και Description πριν το header
        $page_title = $category['category_name'] . " | DeckRush";
        $meta_description = "Δείτε όλα τα προϊόντα στην κατηγορία " . $category['category_name'] . " στο DeckRush.";
    } else {
        $page_title = "Άγνωστη Κατηγορία | DeckRush";
        $meta_description = "Η κατηγορία δεν βρέθηκε.";
    }
} else {
    $page_title = "Σφάλμα | DeckRush";
    $meta_description = "Κάτι πήγε στραβά.";
}

include 'includes/header.php';
include 'includes/navigation.php';
?>

<section id="products" class="box show">
    <div class="container-lg">

    <?php if (isset($category) && $category) { ?>
        <h6>
            <a class="text-decoration-none" href="index">Αρχική / </a>
            <?php echo htmlspecialchars($category['category_name']); ?>
        </h6>

        <div class="row g-0">
            <div class="col-lg-3 col-12">
               <?php $cid = $category['category_name']; ?>
                <?php include 'filters.php'; ?>
            </div>

            <div class="col-md-9">
                <h1 class="font-rubik text-center">
                    <?php echo htmlspecialchars($category['category_name']); ?>
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
                        <div class="card shadow-lg product-box product_data pt-3">
                            <div class="card-body p-0">
                                <div class="product-image text-center">
                                    <a class="text-decoration-none"
                                        href="product-view?product=<?php echo htmlspecialchars($item['slug']); ?>">
                                        <img src="uploads/<?php echo htmlspecialchars($item['item_image']); ?>"
                                            alt="Product Image"
                                            class="img-fluid p-4" style="height:300px">
                                    </a>
                                </div>

                                <div class="product-price">
                                    <p class="font-size-25 fw-bold text-center mb-1">
                                        <?php echo htmlspecialchars($item['selling_price']); ?>€
                                    </p>
                                </div>

                                <div class="product-info">
                                    <a class="text-decoration-none"
                                        href="product-view?product=<?php echo htmlspecialchars($item['slug']); ?>">
                                        <p class="text-center font-size-20 text-dark px-3 mb-1">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </p>
                                    </a>

                                    <p class="text-center">
                                        <small>Διαθέσιμα: <?php echo htmlspecialchars($item['qty']); ?>+</small>
                                    </p>
                                </div>

                                <div class="product-btns d-flex flex-row align-items-center justify-content-around">
                                    <a href="product-view?product=<?php echo htmlspecialchars($item['slug']); ?>"
                                        class="text-decoration-none product-btn w-100 text-center p-2">
                                        <i class="bi bi-search text-white font-size-20"></i>
                                    </a>

                                    <button class="product-btn addToCartBtn w-100 text-center p-2"
                                        value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <input type="hidden"
                                            class="form-control text-center input-qty bg-white" value="1" disabled>
                                        <i class="bi bi-cart text-white font-size-20"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    } else {
                        echo "<div class='alert alert-warning'>Δεν υπάρχουν προϊόντα σε αυτή την κατηγορία.</div>";
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

<?php include 'includes/footer.php'; ?>
