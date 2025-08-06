<footer id="footer" class=" text-white pb-4">
  <div class="container-lg">
    <div class="row footer align-items-center">

      <div class="col-lg-2 col-12 mb-2 ">
        <h4 class="fw-bold  font-size-20">Πληροφορίες</h4>
        <div class="d-flex flex-column flex-wrap">
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">Σχετικά με εμάς</a>
          <a href="contact" class="text-decoration-none  font-size-14 text-white-50 mb-4 pb-1">Φόρμα Επικοινωνίας</a>
        </div>
      </div>

      <div class="col-lg-3 col-12 mb-2">
        <h4 class="fw-bold font-size-20">Χρήσιμα</h4>
        <div class="d-flex flex-column flex-wrap">
          <a href="payments" class="text-decoration-none  font-size-14 text-white-50 pb-1">Τρόποι πληρωμής</a>
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">Τρόποι αποστολής</a>
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">'Οροι χρήσης</a>
        </div>
      </div>

      <div class="col-lg-3 col-12 mb-2">
        <div class="h-100 ">
          <a href="http://deckrush.local/" class="d-block h-100"><img class="img-fluid" src="assets/logo5.png"
              style="width:200px; height:250px;"></a>
        </div>

      </div>

      <div class="col-lg-2 col-12 mb-2">
        <h4 class="fw-bold font-size-20">Λογαριασμός</h4>
        <div class="d-flex flex-column flex-wrap">
          <a href="my-account" class="text-decoration-none  font-size-14 text-white-50 pb-1">Ο λογαριασμός μου</a>
          <a href="my-account?source=orders"
            class="text-decoration-none  font-size-14 text-white-50 pb-1">Παραγγελίες</a>
          <a href="my-account?source=edit-profile"
            class="text-decoration-none  font-size-14 text-white-50 pb-1">Διευθύνσεις</a>
        </div>
      </div>

      <div class="col-lg-2 col-12 mb-2">
        <h4 class="fw-bold font-size-20">Επικοινωνία</h4>
        <div class="d-flex flex-column flex-wrap">
          <p class=" font-size-14 text-white-50 pb-1 text-decoration-none mb-5">Email: info@gmail.com</p>
        </div>
      </div>
    </div>
  </div>

  <div class="copyright text-center">
    <p class="font-rale font-size-14 pt-4 m-0">&copy; 2025 DeckRush Store. All Rights Reserved</p>
  </div>
</footer>

<!-- jQuery (Must be loaded first) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"
  integrity="sha512-k2WPPrSgRFI6cTaHHhJdc8kAXaRM4JBFEDo1pPGGlYiOyv4vnA0Pp0G5XMYYxgAPmtmv/IIaQA6n5fLAyJaFMA=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!----ALLERTIFY JS --->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>

    <?php

    if (isset($_SESSION['message'])) { ?>

    alertify.alert('<?php echo $_SESSION['message']; ?>');
    alertify.success('<?php echo $_SESSION['message']; ?>');

    <?php unset($_SESSION['message']);
    } ?>
</script>

<!-- Your Custom JS -->
<script src="index.js"></script>

<script>
    $(document).ready(function () {
      $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 1
      });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>