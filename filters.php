<section id="filters" class="mt-5 pt-3">
    <div class="row d-flex flex-column filters">
        <div class="col-md-6">
            <div class="mb-5">
                <h5 class="mb-4 fw-bold text-secondary">Διαθεσιμότητα</h5>
                <input type="checkbox" class="border border-dark form-check-input me-2" id="exampleCheck1" checked
                    disabled>
                <label class="form-check-label fw-bold">Όλα τα προϊόντα</label><br>
            </div>
        </div>

        <div class="col-md-6">
            <h5 class="mb-3 fw-bold text-secondary">Υποκατηγορία</h5>
            <?php
            // Ανάκτηση όλων των meta_title
            $titles = [];
            $products = getProdByCategory($cid);

            // Έλεγχος αν υπάρχουν προϊόντα
            if (!$products || mysqli_num_rows($products) == 0) {
                echo "<p>Δεν βρέθηκαν προϊόντα.</p>";
            } else {
                while ($item = mysqli_fetch_assoc($products)) {
                    if (!in_array($item['meta_title'], $titles)) {
                        $titles[] = $item['meta_title']; // Προσθήκη του meta_title αν δεν υπάρχει ήδη
                    }
                }

                // Δημιουργία των φίλτρων
                foreach ($titles as $title) {
                    echo '<div class="form-check mb-2">';
                    echo '<input type="checkbox" class="border border-dark form-check-input" id="filter_' . htmlspecialchars($title) . '" data-title="' . htmlspecialchars($title) . '">';
                    echo '<label class="form-check-label fw-bold" for="filter_' . htmlspecialchars($title) . '">' . htmlspecialchars($title) . '</label>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</section>