<?php include 'functions/userfunctions.php'; ?>

<section id="categories" class="box show">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php
                    $categories =  getCategoriesActive("product_categories");

                    if (mysqli_num_rows($categories) > 0) {
                        foreach ($categories as $item) {
                            $colClass = "col-md-6"; // 2 στήλες
                            ?>
                            <div class="<?php echo $colClass; ?> mb-3">
                                <a class="text-decoration-none"
                                    href="products?category=<?php echo htmlspecialchars($item['slug']); ?>">
                                    <div class="meta-title-description">
                                        <img src="uploads/<?php echo htmlspecialchars($item['category_image']); ?>"
                                            alt="Category Image" class="rounded-4 w-100 box-shadow img-fluid category-bg"
                                            style="height:400px">
                                        <h4 class="meta-title-hashtag font-size-25 fw-bold">
                                            <?php echo htmlspecialchars($item['meta_title']); ?>
                                        </h4>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No data available";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>