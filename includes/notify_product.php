<section class="notify-me my-3">
    <button
        type="button"
        class="notify-btn btn f-bold rounded-1 text-white d-flex flex-row align-items-center justify-content-center mx-auto"
        onclick="openProductNotifyModal()"
        style="width:300px; min-height:50px; background-color:#7C3AED;">

        <i class="bi bi-bell font-size-25 me-2"></i>
       ΕΙΔΟΠΟΙΗΣΕ ΜΕ ΠΡΩΤΟ

    </button>
</section>

<div class="newsletter-modal" id="productNotifyModal">

    <div class="modal-content rounded border border-warning">

        <span class="close" onclick="closeProductNotifyModal()">&times;</span>

        <h3 class="f-bold" style="color:#0b1e3d;">
            Ενημέρωσέ με όταν γίνει διαθέσιμο
        </h3>

        <img
            class="img-fluid w-100"
            src="/assets/logo2.png"
            style="max-height:330px;">

        <form action="/newsletter.php" method="POST">

            <input
                type="hidden"
                name="return_url"
                value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>">

            <input
                type="email"
                name="email"
                placeholder="Το email σας"
                required>

            <button
                type="submit"
                class="btn text-white w-100 f-bold"
                style="background-color:#0b1e3d;">

                Εγγραφή στο Newsletter

            </button>

            <label class="gdpr-check d-flex align-items-center mt-3">

                <div class="row g-0 justify-content-center">

                    <div class="col-md-auto">
                        <input type="checkbox" name="consent" required>
                    </div>

                    <div class="col-md-10 text-center">
                        <p>
                            Συμφωνώ να λαμβάνω νέα, προσφορές και newsletters από το DeckRush.
                        </p>
                    </div>

                </div>

            </label>

        </form>

    </div>

</div>

<script>
function openProductNotifyModal() {
    document.getElementById("productNotifyModal").style.display = "flex";
}

function closeProductNotifyModal() {
    document.getElementById("productNotifyModal").style.display = "none";
}
</script>

<?php if (isset($_GET['subscribed'])): ?>

<div class="newsletter-modal" id="productThanksModal" style="display:flex;">

    <div class="modal-content rounded border border-warning">

        <span class="close"
            onclick="document.getElementById('productThanksModal').style.display='none';">
            &times;
        </span>

        <img
            class="img-fluid w-100"
            src="/assets/logo2.png"
            style="max-height:330px;">
            
        <h3 class="f-bold" style="color:#0b1e3d;">
            Ευχαριστούμε!
        </h3>

        <p>
            Η εγγραφή σου στο newsletter ολοκληρώθηκε με επιτυχία.
        </p>

        <button
            type="button"
            class="btn text-white w-100 f-bold"
            style="background-color:#0b1e3d;"
            onclick="document.getElementById('productThanksModal').style.display='none';">

            OK

        </button>

    </div>

</div>
<script>
    // Αφαιρούμε το ?subscribed=1 από το URL
    // ώστε στο refresh να μην ξανανοίξει το popup.
    const url = new URL(window.location.href);
    url.searchParams.delete('subscribed');

    window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
</script>


<?php endif; ?>