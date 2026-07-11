<?php
ob_start();

// ΟΡΙΣΜΟΣ SEO TAGS ΓΙΑ ΤΗΝ ΑΡΧΙΚΗ ΣΕΛΙΔΑ (Πριν το Header)
$page_title = "DeckRush | Αυθεντικές Κάρτες TCG & Συλλεκτικά είδη στην Ελλάδα";
$meta_description = "Το απόλυτο e-shop για συλλέκτες! Βρείτε σπάνιες κάρτες Pokémon, One Piece, Yu-Gi-Oh!, Magic: The Gathering, αξεσουάρ TCG και φιγούρες Funko Pop.";

include 'includes/header.php';

$is_main_page = true;

include 'includes/navigation.php';
include 'includes/hero.php';
include 'categories.php';
include 'collectors_vault.php';
include 'top-sale.php';
?>

<section class="newsletter my-5">
    <div class="container-lg">
        <div class="newsletter-container shadow-sm">
            <img class="img-fluid rounded shadow" src="assets/newsletter.jpg">
            <button class="newsletter-btn btn btn-danger buy-now" onclick="openModal()">SUBSCRIBE</button>
        </div>
    </div>
</section>

<div class="newsletter-modal" id="newsletterModal">
    <div class="modal-content rounded border border-warning">

        <span class="close" onclick="closeModal()">&times;</span>

        <h3>Join our newsletter</h3>

        <form action="newsletter.php" method="POST">
            <input type="email" name="email" placeholder="Το email σας" required>

            <button type="submit" class="btn btn-danger">
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

        <h3>Thanks for subscribing!</h3>
        <p>You are now on our newsletter list.</p>

        <button class="btn btn-danger px-4 f-bold" onclick="closeThanks()">
            OK
        </button>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    function openModal() {
        document.getElementById("newsletterModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("newsletterModal").style.display = "none";
    }

    function closeThanks() {
        document.getElementById("thanksModal").style.display = "none";
    }

    window.onclick = function (event) {

        let modal = document.getElementById("newsletterModal");

        if (event.target === modal) {
            modal.style.display = "none";
        }

    }

    <?php if (isset($_GET['subscribed'])): ?>
        document.getElementById("thanksModal").style.display = "flex";
    <?php endif; ?>
</script>