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
                    <?php 
                        // BUG FIX: Έλεγχος αν το προϊόν είναι εξαντλημένο
                        $qty = (int)$product['qty'];
                        $is_out_of_stock = ($qty <= 0);
                        $btn_disabled = $is_out_of_stock ? 'disabled' : '';
                        $btn_text = $is_out_of_stock ? 'Μη Διαθέσιμο' : 'Προσθήκη στο καλάθι';
                        $btn_class = $is_out_of_stock ? 'btn btn-secondary' : 'btn btn-danger';
                    ?>
                    <div class="item py-3 product_data rounded-3">
                        <div class="product font-rale d-flex flex-column align-items-center">
                            
                            <a href="/product/<?php echo htmlspecialchars($product['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                <img src="/uploads/<?php echo htmlspecialchars($product['item_image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                     loading="lazy"
                                     alt="Κάρτα <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?> - DeckRush" 
                                     style="width:220px; height:220px; object-fit: contain;">
                            </a>
                            
                            <div class="text-center my-3">
                                <!-- SEO Βελτίωση: 🛠️ Σωστή ιεραρχία τίτλου με εμφάνιση h6 -->
                                <h3 class="h6 font-weight-bold"><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="m-0 font-size-20 fw-bold"><?php echo htmlspecialchars($product['selling_price'], ENT_QUOTES, 'UTF-8'); ?>€</p>
                            </div>
                            
                            <!-- BUG FIX: Προσθήκη $btn_disabled και δυναμικού $btn_text / $btn_class -->
                            <button class="<?php echo $btn_class; ?> fw-bold font-size-14 p-3 rounded-3 addToCartBtn"
                                value="<?php echo htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                                <?php echo $btn_disabled; ?>
                                aria-label="<?php echo $btn_text; ?>">
                                <input type="hidden" class="form-control text-center input-qty bg-white" value="1" disabled>
                                <?php echo $btn_text; ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="top-sale-img">
            <img class="img-fluid" loading="lazy" src="/assets/topsales.png" alt="Top Sales Banner - DeckRush" style="width:200px; height:150px;">
        </div>
    </div>
</section>
