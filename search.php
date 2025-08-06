<?php
include 'functions/userfunctions.php';
include 'includes/header.php';
include 'includes/navigation.php';
?>

<section id="search">
    <div class="container-lg">
        <div class="row">
            <div class="col-md"></div>

            <div class="col-md-10">
                <div class="row">
                    <?php
                    if (isset($_POST['submit'])) {
                        $search = $_POST['search'];
                        $category_ids = isset($_POST['category_ids']) ? $_POST['category_ids'] : [];

                        // Αφαίρεση της συνθήκης is_coming_soon
                        $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
                        $searchTerm = '%' . $search . '%';
                        $stmt->bind_param('s', $searchTerm);
                        $stmt->execute();
                        $regular_query = $stmt->get_result();

                        echo "<h5 class='my-4'>Αποτελέσματα για <strong>$search</strong> :</h5><div class='row'>";

                        if ($regular_query->num_rows > 0) {
                            while ($item = $regular_query->fetch_assoc()) {
                                // Έλεγχος αν το προϊόν ανήκει στις επιλεγμένες κατηγορίες
                                if (in_array($item['category_id'], $category_ids) || empty($category_ids)) {
                                    ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow-lg product-box product_data box show pt-3">
                                            <div class="card-body p-0">
                                                <div class="product-image">
                                                    <a class="text-decoration-none" href="product-view?product=<?php echo $item['slug'] ?>">
                                                        <img src="uploads/<?php echo $item['item_image'] ?>" alt="Product Image" class="w-100 p-3" style="height:300px">
                                                    </a>
                                                </div>
                                                <div class="product-price">
                                                    <p class="font-size-25 fw-bold text-center mb-1"><?php echo $item['selling_price']; ?>.00€</p>
                                                </div>
                                                <div class="product-info">
                                                    <a class="text-decoration-none" href="product-view?product=<?php echo $item['slug'] ?>">
                                                        <p class="text-center font-size-20 text-dark px-3 mb-1"><?php echo $item['name']; ?></p>
                                                    </a>
                                                    <p class="text-center"><small>Διαθέσιμα: <?php echo $item['qty']; ?></small>+</p>
                                                </div>
                                                <div class="product-btns d-flex flex-row align-items-center justify-content-around">
                                                    <a href="product-view?product=<?php echo $item['slug'] ?>" class="text-decoration-none product-btn w-100 text-center p-2">
                                                        <i class="bi bi-search text-white font-size-20"></i>
                                                    </a>
                                                    <button class="product-btn addToCartBtn w-100 text-center p-2" value="<?php echo $item['id']; ?>">
                                                        <input type="hidden" class="form-control text-center input-qty bg-white" value="1" disabled>
                                                        <i class="bi bi-cart text-white font-size-20"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }

                        echo "</div>";

                        if ($regular_query->num_rows == 0) {
                            echo "<h5 class='text-center'>Δεν βρέθηκαν αποτελέσματα</h5>";
                        }

                        $stmt->close();
                    }
                    ?>
                </div>
            </div>

            <div class="col-md"></div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
