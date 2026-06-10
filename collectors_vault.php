

<section id="collectors-vault" class="box show py-3">
    <div class="container-lg">

        <div class="vault-banner">
            <h1 class="f-bold">The Collector's Vault</h1>
            <p>Premium, σπάνια και exclusive προϊόντα για αληθινούς συλλέκτες.</p>
        </div>

        <?php
        $products = getCollectorsVaultProducts();
        ?>

        <div class="row">

            <?php if (mysqli_num_rows($products) > 0): ?>

                <?php foreach ($products as $item): ?>

                    <div class="col-md-3 mb-4">
                        <!-- 1. Μετατροπή της κάρτας σε σύνδεσμο (<a>) -->
                        <a href="product-view.php?product=<?= $item['slug']; ?>"
                            class="product-card d-block text-decoration-none text-reset">

                            <div class="product-image-placeholder">
                                <img src="uploads/<?= $item['item_image']; ?>" alt="<?= htmlspecialchars($item['name']); ?>"
                                    style="width:100%;height:250px;object-fit:cover;border-radius:8px;">
                            </div>

                            <div class="product-title">
                                <?= htmlspecialchars($item['name']); ?>
                            </div>

                            <div class="product-price">
                                <?= number_format($item['selling_price'], 2); ?>€
                            </div>

                            <!-- 2. Αφαίρεση των εσωτερικών <a> και μετατροπή σε <span> -->
                            <?php if ($item['qty'] <= 0): ?>
                                <span class="btn-vault badge-display d-block">
                                  Μη Διαθέσιμο
                                </span>

                            <?php elseif ($item['qty'] == 1): ?>
                                <span class="btn-vault badge-limited text-white d-block">
                                    1 Διαθέσιμο
                                </span>

                            <?php else: ?>
                                <span class="btn-vault badge-exclusive d-block">
                                    Vault Item
                                </span>
                            <?php endif; ?>

                        </a> <!-- Κλείσιμο κάρτας -->
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12 text-center text-muted">
                    Δεν υπάρχουν προϊόντα στο Collector's Vault.
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>