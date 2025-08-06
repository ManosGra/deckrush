<nav class="text-white navigation <?php echo isset($is_main_page); ?>">
  <div class="mx-5">
    <div class="row align-items-center justify-content-between">

      <div class="col-2 col-md-auto">
        <a class="navbar-brand text-white font-rubik" href="http://deckhub.local/"><img class="img-fluid"
            src="assets/logo5.png" style="width:150px; height:133px;"></a>
      </div>

      <div class="col-10 col-md-9">
        <ul class="nav-items d-flex align-items-center justify-content-center font-rubik m-0 p-0">
          <?php
          // Εκτέλεση του ερωτήματος για να πάρουμε τις κατηγορίες προϊόντων
          $query = "SELECT * FROM product_categories ORDER BY id";
          $select_categories_query = mysqli_query($conn, $query);

          // Έλεγχος αν η ερώτηση εκτελέστηκε επιτυχώς
          if (!$select_categories_query) {
            die("QUERY FAILED: " . mysqli_error($conn));
          }

          // Εμφάνιση των κατηγοριών
          if (mysqli_num_rows($select_categories_query) > 0) {
            // Επαναλαμβάνει τις γραμμές από το αποτέλεσμα της ερώτησης
            while ($item = mysqli_fetch_assoc($select_categories_query)) {
              ?>
              <li class="nav-item list-unstyled mx-5 font-rubik font-size-16 f-bold">
                <a class="nav-link mt-3 d-flex align-items-center text-center"
                  href="products?category=<?php echo htmlspecialchars($item['slug']); ?>">
                  <?php
                  $svg_path = __DIR__ . '/../uploads/' . $item['category_svg'];  // διαδρομή αρχείου SVG
              
                  if (!empty($item['category_svg']) && file_exists($svg_path)) {
                    $svg_content = file_get_contents($svg_path);

                    echo '<span class="svg-icon">' . $svg_content . '</span>';
                  }
                  ?>
                  <?php echo htmlspecialchars($item['category_name']); ?>
                </a>
              </li>
              <?php
            }
          } else {
            echo "<li class='nav-item list-unstyled mx-3'>Δεν βρέθηκαν κατηγορίες</li>";
          }
          ?>
        </ul>
      </div>

      <div class="col-2 col-md-auto">
        <div class="row align-items-center justify-content-end g-0">

          <div class="col-auto">
            <button type="submit" id="openSearch" name="submit" class="search-button p-0 me-2">
              <i class="bi bi-search font-size-25 search-icon"></i>
            </button>
          </div>

          <div class="col-auto">
            <a href="my-account" class="text-white text-decoration-none me-2">
              <i class="font-size-25 profile bi bi-person-circle"></i>
            </a>
          </div>

          <div class="col-auto">
            <form action="" class="font-size-14 font-rale">
              <a href="cart" class="text-decoration-none" id="cart-link">
                <div class="cart-object">
                  <span class="font-size-25 text-white"><i class="bi bi-cart cart-icon"></i></span>
                  <span class="pill text-white bg-danger" id="cart-empty">0</span>
                </div>
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div id="searchPopup" class="popup">
    <div class="popup-content">
      <span id="closePopup" class="close">&times;</span>

      <!-- Το search container που θες να κάνεις popup -->
      <div class="search-container">
        <form class="d-flex align-items-center" action="search" method="POST">
          <input type="text" placeholder="Αναζήτηση..." name="search" class="search-input" required>
          <button type="submit" name="submit" hidden>Search</button>
        </form>
      </div>
    </div>
  </div>

</nav>

<div class="responsive-nav py-3 px-2 d-md-none">
  <div class="row align-items-center justify-content-between">
    <div class="col-3">
      <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>
      <ul class="nav-items nav-menu p-0">
        <?php
        // Εκτέλεση του ερωτήματος για να πάρουμε τις κατηγορίες προϊόντων
        $query = "SELECT * FROM product_categories";
        $select_categories_query = mysqli_query($conn, $query);

        if (!$select_categories_query) {
          die("QUERY FAILED: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($select_categories_query) > 0) {
          while ($item = mysqli_fetch_assoc($select_categories_query)) {
            ?>
            <li class="nav-item list-unstyled font-rubik fw-bold font-size-14">
              <a class="nav-link mt-3" href="products?category=<?php echo htmlspecialchars($item['slug']); ?>">
                <?php echo htmlspecialchars($item['category_name']); ?>
              </a>
            </li>
            <?php
          }
        } else {
          echo "<li class='nav-item list-unstyled mx-3'>Δεν βρέθηκαν κατηγορίες</li>";
        }
        ?>
      </ul>
    </div>

    <div class="col-3">
      <a class="navbar-brand text-white font-rubik" href="http://deckhub.local/"><img class="img-fluid"
          src="assets/logo5.png" style="width:100px; height:90px;"></a>
    </div>

    <div class="col-3">
      <div class="row align-items-center justify-content-end g-0 font-size-25">
        <div class="col-auto">
          <a href="my-account" class="text-white text-decoration-none ">
            <i class="profile bi bi-person-circle"></i>
          </a>
        </div>
        <div class="col-auto">
          <form action="" class="font-rale">
            <a href="cart" class="text-decoration-none" id="cart-link">
              <div class="cart-object">
                <span class="px-2 text-white"><i class="bi bi-cart cart-icon ms-2"></i></span>
              </div>
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>