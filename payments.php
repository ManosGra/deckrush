<?php include 'includes/header.php'; ?>

<?php include 'includes/navigation.php'; ?>

<section id="payments" class="bg-light">
    <div class="container">
        <!-- Κεντρικός Τίτλος -->
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5 text-dark">Τρόποι Πληρωμής</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Η πληρωμή των προϊόντων που αγοράζετε στο DeckRush.gr μπορεί να γίνει με τους εξής ασφαλείς τρόπους:
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- 1. Αντικαταβολή -->
            <div class="col-md-6 col-lg-5">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                <!-- Εικονίδιο Μετρητών/Παράδοσης -->
                                <svg xmlns="http://w3.org" width="28" height="28" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="h4 card-title fw-bold m-0">Αντικαταβολή</h3>
                        </div>
                        <p class="card-text text-muted flex-grow-1">
                            Πληρωμή με μετρητά την ώρα της παράδοσης των προϊόντων στο άτομο της μεταφορικής εταιρείας (Courier).
                        </p>
                        <div class="mt-3 p-3 bg-light rounded-3">
                            <span class="fw-semibold text-dark d-block">📦 Κόστος Υπηρεσίας:</span>
                            <small class="text-secondary">• Ελλάδα: <strong>3€</strong> | • Κύπρος: <strong>5€</strong></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. PayPal / Κάρτες -->
            <div class="col-md-6 col-lg-5">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                                <!-- Εικονίδιο Πιστωτικής Κάρτας / PayPal -->
                                <svg xmlns="http://w3.org" width="28" height="28" fill="currentColor" class="bi bi-credit-card-2-front" viewBox="0 0 16 16">
                                    <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/>
                                    <path d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m7 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </div>
                            <h3 class="h4 card-title fw-bold m-0">PayPal & Κάρτες</h3>
                        </div>
                        <p class="card-text text-muted flex-grow-1">
                            Μια απόλυτα ασφαλής και εύκολη μέθοδος. Συνδεθείτε στον λογαριασμό σας PayPal ή χρησιμοποιήστε απευθείας την πιστωτική/χρεωστική σας κάρτα χωρίς να απαιτείται δημιουργία λογαριασμού.
                        </p>
                        <div class="mt-3 p-3 bg-light rounded-3 text-center">
                            <span class="small fw-semibold text-success">🔒 100% Κρυπτογραφημένη & Ασφαλής Συναλλαγή</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
