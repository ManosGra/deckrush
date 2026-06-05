<nav class="text-white navigation <?php echo isset($is_main_page); ?>">
  <!---<p class="mb-0 text-center f-bold font-size-20" style="background-color: #44d62b; color:black;">Παρέλαβε με <img class="img-fluid" src="assets/boxnowlogo.png" style="width:68px; height:45px;"> </p>-----!-->
  <div class="mx-5">
    <div class="row align-items-center justify-content-between">

      <div class="col-2 col-md-auto">
        <a class="navbar-brand text-white font-rubik" href="http://deckrush.local">
          <img class="img-fluid" src="/assets/logo2.png" style="width:150px; height:140px;" alt="Logo">
        </a>
      </div>

      <div class="col-10 col-md-9">
        <ul class="nav-items d-flex align-items-center justify-content-center font-rubik m-0 p-0">
          <?php
          // Εκτέλεση του ερωτήματος για να πάρουμε τις κατηγορίες προϊόντων
          $query = "SELECT * FROM product_categories ORDER BY id LIMIT 6";
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
                <!-- ΑΛΛΑΓΗ: Το href τώρα δείχνει απευθείας στο slug της κατηγορίας -->
                <a class="nav-link mt-3 d-flex align-items-center text-center"
                  href="/<?php echo htmlspecialchars($item['slug']); ?>">

                  <?php
                  $svg_path = __DIR__ . '/../uploads/' . $item['category_svg'];  // διαδρομή αρχείου SVG
              
                  if (!empty($item['category_svg']) && file_exists($svg_path)) {
                    $svg_content = file_get_contents($svg_path);

                    echo '<span class="svg-icon me-2">' . $svg_content . '</span>';
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
            <!-- ΔΙΟΡΘΩΘΗΚΕ: type="button" και προσθήκη onclick συμβάντος -->
            <button type="button" id="openSearch" class="search-button p-0 me-2" onclick="togglePopup(true)">
              <i class="bi bi-search font-size-30 search-icon"></i>
            </button>
          </div>

          <div class="col-auto">
            <!-- ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στο href -->
            <a href="/my-account" class="text-white text-decoration-none me-2">
              <i class="font-size-30 profile bi bi-person-circle"></i>
            </a>
          </div>

          <div class="col-auto">
            <form action="" class="font-size-14 font-rale">
              <!-- ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στο href -->
              <a href="/cart" class="text-decoration-none" id="cart-link">
                <div class="cart-object">
                  <span class="font-size-30 text-white"><i class="bi bi-cart cart-icon"></i></span>
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
      <!-- ΔΙΟΡΘΩΘΗΚΕ: Προσθήκη onclick συμβάντος για το κλείσιμο -->
      <span id="closePopup" class="close" onclick="togglePopup(false)">&times;</span>

      <!-- Το search container που θες να κάνεις popup -->
      <div class="search-container">
        <!-- ΔΙΟΡΘΩΘΗΚΕ: Η μέθοδος έγινε GET και το action /search -->
        <form class="d-flex align-items-center" action="/search" method="GET">
          <input type="text" placeholder="Αναζήτηση..." name="search" class="search-input" required>
          <button type="submit" name="submit" hidden>Search</button>
        </form>
      </div>
    </div>
  </div>

</nav>

<div class="responsive-nav py-2 px-2 d-md-none">
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
              <!-- ΔΙΟΡΘΩΘΗΚΕ: Αλλαγή και στο responsive μενού σε καθαρό URL /slug -->
              <a class="nav-link mt-3" href="/<?php echo htmlspecialchars($item['slug']); ?>">
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
      <!-- ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στο src του logo στα κινητά -->
      <a class="navbar-brand text-white font-rubik" href="http://deckrush.local">
        <img class="img-fluid" src="/assets/logo2.png" style="width:100px; height:90px;" alt="Logo Mobile">
      </a>
    </div>

    <div class="col-3">
      <div class="row align-items-center justify-content-end g-0 font-size-22">
        <div class="col-auto">
          <!-- ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στο href στα κινητά -->
          <a href="/my-account" class="text-white text-decoration-none ">
            <i class="profile bi bi-person-circle"></i>
          </a>
        </div>
        <div class="col-auto">
          <form action="" class="font-rale">
            <!-- ΔΙΟΡΘΩΘΗΚΕ: Προστέθηκε το / στο href στα κινητά -->
            <a href="/cart" class="text-decoration-none" id="cart-link">
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

<!-- ΝΕΟ: Εγγυημένος inline κώδικας JavaScript για τη διαχείριση του Popup -->
<script>
function togglePopup(show) {
    var popup = document.getElementById('searchPopup');
    if (popup) {
        if (show) {
            popup.style.display = 'block'; // Ή 'flex' ανάλογα με το CSS σας (συνήθως block ή flex)
            // Αν το CSS σας χρησιμοποιεί κλάση .show, ξεσχολιάστε την επόμενη γραμμή:
            // popup.classList.add('show');
        } else {
            popup.style.display = 'none';
            // Αν το CSS σας χρησιμοποιεί κλάση .show, ξεσχολιάστε την επόμενη γραμμή:
            // popup.classList.remove('show');
        }
    }
}
</script>
