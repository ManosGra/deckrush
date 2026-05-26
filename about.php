<?php
include 'functions/userfunctions.php';

// Ορισμός SEO Meta Tags για τη σελίδα Σχετικά με Εμάς
$page_title = "Σχετικά με Εμάς | Η Ομάδα του DeckRush";
$meta_description = "Μάθετε την ιστορία του DeckRush. Το κορυφαίο ελληνικό e-shop από συλλέκτες για συλλέκτες TCG. Αυθεντικές κάρτες Pokémon, One Piece και Funko Pop.";

include 'includes/header.php';
include 'includes/navigation.php';
?>

<main id="about-us" class="about bg-light">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Κεντρική Κάρτα Περιεχομένου -->
                <div class="card shadow rounded-4 p-4 p-md-5 bg-white border-0">
                    
                    <div class="text-center mb-5">
                        <h1 class="fw-bold font-rubik text-dark mb-3">Σχετικά με Εμάς</h1>
                        <p class="lead text-muted">Από συλλέκτες, για συλλέκτες! Καλώς ήρθατε στον κόσμο του DeckRush.</p>
                        <div class="mx-auto bg-danger rounded" style="width: 60px; height: 4px;"></div>
                    </div>
                    
                    <!-- 1η Ενότητα: Η Ιστορία μας -->
                    <div class="row align-items-center mb-5">
                        <div class="col-md-12">
                            <h2 class="h4 fw-bold text-dark mb-3">Ποιοι Είμαστε</h2>
                            <p class="text-secondary">
                                Το <strong>DeckRush</strong> γεννήθηκε μέσα από το πάθος και την αγάπη για τα Trading Card Games (TCG) και τα συλλεκτικά αντικείμενα. Ξεκινήσαμε ως απλοί συλλέκτες και παίκτες, ανοίγοντας booster packs και αναζητώντας τις πιο σπάνιες κάρτες. Σήμερα, μετατρέψαμε αυτό το πάθος σε ένα σύγχρονο ηλεκτρονικό κατάστημα, με στόχο να προσφέρουμε στην ελληνική κοινότητα άμεση πρόσβαση στις πιο πρόσφατες και σπάνιες κυκλοφορίες της αγοράς.
                            </p>
                        </div>
                    </div>

                    <!-- 2η Ενότητα: Οι 3 Πυλώνες μας (Grid με Εικονίδια) -->
                    <div class="row text-center my-4 g-4">
                        <!-- Πυλώνας 1 -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <i class="bi bi-shield-check text-danger font-size-30 mb-2 d-block"></i>
                                <h3 class="h5 fw-bold text-dark">100% Αυθεντικά</h3>
                                <p class="text-muted small mb-0">Όλα μας τα προϊόντα (Sealed Boxes, Tins, Packs) προέρχονται αποκλειστικά από επίσημους και πιστοποιημένους διανομείς.</p>
                            </div>
                        </div>
                        <!-- Πυλώνας 2 -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <i class="bi bi-box-seam text-danger font-size-30 mb-2 d-block"></i>
                                <h3 class="h5 fw-bold text-dark">Ασφαλής Συσκευασία</h3>
                                <p class="text-muted small mb-0">Ως συλλέκτες, γνωρίζουμε καλά την αξία του "Mint Condition". Κάθε παραγγελία συσκευάζεται με τη μέγιστη δυνατή προστασία.</p>
                            </div>
                        </div>
                        <!-- Πυλώνας 3 -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <i class="bi bi-lightning-charge text-danger font-size-30 mb-2 d-block"></i>
                                <h3 class="h5 fw-bold text-dark">Άμεση Εξυπηρέτηση</h3>
                                <p class="text-muted small mb-0">Φροντίζουμε για την ταχύτατη επεξεργασία και αποστολή των δεμάτων σας, ώστε να έχετε τις κάρτες στα χέρια σας χωρίς καθυστερήσεις.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3η Ενότητα: Τι θα βρείτε σε εμάς -->
                    <div class="mt-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Η Συλλογή Μας</h2>
                        <p class="text-secondary mb-4">
                            Στο e-shop μας θα βρείτε μια τεράστια ποικιλία από κάρτες και συλλεκτικά είδη που ανανεώνεται συνεχώς με όλες τις νέες κυκλοφορίες:
                        </p>
                        <div class="row g-2">
                            <div class="col-sm-6"><i class="bi bi-check2-circle text-danger me-2"></i> Pokémon TCG (Booster Packs, ETB, Booster Boxes)</div>
                            <div class="col-sm-6"><i class="bi bi-check2-circle text-danger me-2"></i> One Piece Card Game</div>
                            <div class="col-sm-6"><i class="bi bi-check2-circle text-danger me-2"></i> Yu-Gi-Oh! & Magic: The Gathering</div>
                            <div class="col-sm-6"><i class="bi bi-check2-circle text-danger me-2"></i> Αυθεντικές Φιγούρες Funko Pop!</div>
                            <div class="col-sm-6"><i class="bi bi-check2-circle text-danger me-2"></i> Αξεσουάρ Προστασίας (Sleeves, Toploaders, Άλμπουμ)</div>
                        </div>
                    </div>

                    <!-- 4η Ενότητα: Call to Action -->
                    <div class="text-center mt-5 p-4 bg-dark rounded-4 text-white">
                        <h3 class="fw-bold mb-3">Γίνε μέλος της κοινότητας του DeckRush!</h3>
                        <p class="mb-4 text-white-50">Ακολουθήστε μας στα social media για να μαθαίνετε πρώτοι για pre-orders, giveaways και νέες παραλαβές.</p>
                        <a href="/index" class="btn btn-danger btn-lg px-4 fw-bold rounded-3">Δείτε τα Προϊόντα</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
