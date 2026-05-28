<?php 
include 'functions/userfunctions.php'; 

// Ορισμός SEO Meta Tags για τη σελίδα Επικοινωνίας
$page_title = "Επικοινωνία με το DeckRush | Εξυπηρέτηση Πελατών TCG";
$meta_description = "Έχετε ερωτήσεις για κάρτες Pokémon, One Piece ή την παραγγελία σας; Επικοινωνήστε μαζί με την ομάδα του DeckRush.";

include 'includes/header.php'; 
include 'includes/navigation.php'; 
?>

<section id="contact" class="bg-light">
    <div class="container">
        
        <!-- Κεντρικός Τίτλος -->
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5 text-dark">Επικοινωνία</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Έχετε ερωτήσεις για κάρτες Pokémon, One Piece ή την παραγγελία σας; Είμαστε εδώ για να βοηθήσουμε!
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <!-- Πληροφορίες Επικοινωνίας (Αριστερή Στήλη) -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-dark text-white">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="fw-bold mb-4 text-warning">DeckRush Info</h3>
                            <p class="text-light opacity-75 mb-4">Μπορείτε να επικοινωνήσετε μαζί μας συμπληρώνοντας τη φόρμα ή απευθείας στα παρακάτω στοιχεία.</p>
                            
                            <!-- Email -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                    <svg xmlns="http://w3.org" width="20" height="20" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm5.436-.03L16 11.801V4.697z"/>
                                    </svg>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase font-monospace" style="font-size: 0.75rem;">Email</small>
                                    <a href="mailto:manosgrammos9@gmail.com" class="text-white text-decoration-none fw-semibold">manosgrammos9@gmail.com</a>
                                </div>
                            </div>

                            <!-- Ωράριο -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                    <svg xmlns="http://w3.org" width="20" height="20" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                    </svg>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase font-monospace" style="font-size: 0.75rem;">Υποστήριξη</small>
                                    <span class="fw-semibold">Δευτέρα - Παρασκευή: 09:00 - 18:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-secondary text-center">
                            <span class="small text-white font-monospace">⚡ Powered by DeckRush.gr</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Φόρμα Επικοινωνίας (Δεξιά Στήλη) -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="card-body">
                        
                        <!-- PHP Λογική και Ειδοποιήσεις -->
                        <?php
                        if (isset($_POST['submit'])) {
                            $to = "manosgrammos9@gmail.com";
                            $subject = filter_var($_POST['subject'], FILTER_DEFAULT);
                            $body = filter_var($_POST['body'], FILTER_DEFAULT);
                            
                            $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                            // LIVE ΑΛΛΑΓΗ: Το domain άλλαξε επίσημα σε deckrush.gr
                            $headers = "From: DeckRush Contact <no-reply@deckrush.gr>\r\n";
                            $headers .= "Reply-To: " . $user_email . "\r\n";
                            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                            $body = wordwrap($body, 70);

                            if (mail($to, $subject, $body, $headers)) {
                                echo "<div class='alert alert-success border-0 rounded-3 shadow-sm text-center mb-4 d-flex align-items-center justify-content-center' role='alert'>
                                        <svg xmlns='http://w3.org' width='20' height='20' fill='currentColor' class='bi bi-check-circle-fill me-2' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/></svg>
                                        Το μήνυμά σας στάλθηκε με επιτυχία!
                                      </div>";
                            } else {
                                echo "<div class='alert alert-danger border-0 rounded-3 shadow-sm text-center mb-4' role='alert'>Αποτυχία αποστολής. Παρακαλώ δοκιμάστε ξανά.</div>";
                            }
                        }
                        ?>

                        <form action="" method="post">
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label font-monospace text-muted small text-uppercase">Email Address</label>
                                <input type="email" name="email" class="form-control border-light-subtle rounded-3 py-2" id="email" placeholder="π.χ. name@example.com" required>
                            </div>

                            <!-- Θέμα -->
                            <div class="mb-3">
                                <label for="subject" class="form-label font-monospace text-muted small text-uppercase">Τίτλος Μηνύματος</label>
                                <input type="text" name="subject" class="form-control border-light-subtle rounded-3 py-2" id="subject" placeholder="π.χ. Ερώτηση για παραγγελία κάρτας" required>
                            </div>

                            <!-- Μήνυμα -->
                            <div class="mb-4">
                                <label for="body" class="form-label font-monospace text-muted small text-uppercase">Το Μήνυμά σας</label>
                                <textarea class="form-control border-light-subtle rounded-3" name="body" id="body" rows="6" placeholder="Γράψτε το μήνυμά σας εδώ..." required></textarea>
                            </div>

                            <!-- Κουμπί Υποβολής -->
                            <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold py-3 rounded-3 shadow-sm transition-all text-uppercase font-monospace tracking-wide">
                                Αποστολή Μηνύματος 🚀
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php' ?>
