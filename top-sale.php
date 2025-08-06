<?php

// Παράδειγμα χρήσης για ενεργά προϊόντα
$activeProducts = [];
$result = getAllActive('products'); // Ανάκτηση όλων των προϊόντων με status 0 (ενεργά προϊόντα)

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Ελέγχει αν το προϊόν έχει top_sale 'yes'
        if ($row['top_sale'] == 'yes') {
            $activeProducts[] = $row;
        }
    }
} else {
    echo "Δεν βρέθηκαν ενεργά προϊόντα.";
}
?>

<section id="top-sale" class="top-sale-bg box show">
    <div class="container-lg ">
        <div class="owl-carousel owl-theme">
            <?php if (empty($activeProducts)): ?>
                <p class="text-center">Δεν υπάρχουν προϊόντα σε προσφορά.</p>
            <?php else: ?>
                <?php foreach ($activeProducts as $product): ?>
                    <div class="item py-3 product_data rounded-3">
                        <div class="product font-rale d-flex flex-column align-items-center">
                            <a href="product-view?product=<?php echo $product['slug'] ?>"><img
                                    data-src="uploads/<?php echo $product['item_image']; ?>"
                                    alt="<?php echo $product['name']; ?>" style="width:220px; height:220px;"></a>
                            <div class="text-center my-3">
                                <h6><?php echo $product['name']; ?></h6>
                                <p class="m-0 font-size-20  fw-bold"><?php echo $product['selling_price']; ?>€</p>
                            </div>
                            <button class="btn btn-danger fw-bold font-size-14 p-3 rounded-3 addToCartBtn"
                                value="<?php echo $product['id']; ?>">
                                <input type="hidden" class="form-control text-center input-qty bg-white" value="1" disabled>
                                Προσθήκη στο καλάθι</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="top-sale-img">
            <img class="img-fluid" src="assets/topsales.png" style="width:200px; height:150px;">
        </div>
    </div>
</section>