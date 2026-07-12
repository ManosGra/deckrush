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
include 'includes/newsletter_section.php'; 
include 'includes/footer.php';
?>

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