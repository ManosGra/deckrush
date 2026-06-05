<?php include 'functions/userfunctions.php'; ?>

<section id="categories" class="box show py-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php
                    $categories = getCategoriesActive("product_categories");

                    if (mysqli_num_rows($categories) > 0) {
                        foreach ($categories as $item) {
                            $colClass = "col-md-6"; // 2 στήλες
                    
                            // Καθαρισμός ονόματος για το ALT tag
                            $category_name = !empty($item['meta_title']) ? $item['meta_title'] : "TCG";
                            ?>
                            <div class="<?php echo $colClass; ?> mb-3">
                                <!-- Το href δείχνει απευθείας στο /slug της κατηγορίας -->
                                <a class="text-decoration-none"
                                    href="/<?php echo htmlspecialchars($item['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="meta-title-description">

                                        <!-- SEO ΔΙΟΡΘΩΣΗ: Δυναμικό ALT Tag για τα Google Images -->
                                        <img src="/uploads/<?php echo htmlspecialchars($item['category_image'], ENT_QUOTES, 'UTF-8'); ?>"
                                            alt="Κατηγορία <?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?> - DeckRush"
                                            width="800" height="400" loading="lazy"
                                            class="rounded-4 w-100 box-shadow img-fluid category-bg"
                                            style="height:400px; object-fit: cover;">


                                        <!-- SEO ΔΙΟΡΘΩΣΗ: Σωστή ιεραρχία επικεφαλίδας (H2/H3 ανάλογα με την κύρια σελίδα) -->
                                        <h3 class="meta-title-hashtag font-size-25 fw-bold mt-2">
                                            <?php echo htmlspecialchars($item['meta_title'], ENT_QUOTES, 'UTF-8'); ?>
                                        </h3>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='col-12'><p class='alert alert-warning'>No data available</p></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>