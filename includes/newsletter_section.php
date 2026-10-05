<section class="newsletter my-5">
    <div class="container-lg">
        <div class="newsletter-container shadow-sm">
            <img class="img-fluid rounded shadow" src="/assets/newsletter.jpg">
            <button class="newsletter-btn btn btn-danger buy-now" onclick="openModal()">SUBSCRIBE</button>
        </div>
    </div>
</section>

<div class="newsletter-modal" id="newsletterModal">
    <div class="modal-content rounded border border-warning">

        <span class="close" onclick="closeModal()">&times;</span>

        <h3 class="f-bold">Join our newsletter</h3>
        <img class="img-fluid w-100" src="/assets/logo2.png" style="max-height:330px;">

        <form action="newsletter.php" method="POST">
            <input type="email" name="email" placeholder="Το email σας" required>

            <button type="submit" class="btn text-white w-100 f-bold" style=" background-color: #0b1e3d;">
                Εγγραφή στο Newsletter
            </button>

            <label class="gdpr-check d-flex align-items-center mt-3">
                <div class="row g-0 justify-content-center">
                    <div class="col-md-auto">
                        <input type="checkbox" name="consent" required>
                    </div>
                    <div class="col-md-10 text-center">
                        <p>Συμφωνώ να λαμβάνω νέα, προσφορές και newsletters από το DeckRush.</p>
                    </div>
                </div>
            </label>
        </form>

    </div>
</div>

<div class="thanks-modal" id="thanksModal">
    <div class="thanks-content rounded border border-warning">

        <span class="close" onclick="closeThanks()">&times;</span>

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

        <button class="btn btn-danger px-4 f-bold" onclick="closeThanks()">
            OK
        </button>

    </div>
</div>