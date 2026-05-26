<?php
include 'functions/userfunctions.php';

// Ορισμός SEO Meta Tags για τη σελίδα Τρόπων Αποστολής
$page_title = "Τρόποι Αποστολής & Κόστη Courier | DeckRush";
$meta_description = "Μάθετε για τους τρόπους αποστολής, τα κόστη Courier και τους χρόνους παράδοσης των καρτών TCG και των προϊόντων του DeckRush σε όλη την Ελλάδα.";

include 'includes/header.php';
include 'includes/navigation.php';
?>

<main id="shipping-methods" class="shipping bg-light">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Κεντρική Κάρτα Περιεχομένου -->
                <div class="card shadow rounded-4 p-4 p-md-5 bg-white border-0">
                    
                    <div class="text-center mb-5">
                        <h1 class="fw-bold font-rubik text-dark mb-3">Τρόποι Αποστολής</h1>
                        <p class="lead text-muted">Ασφαλής και γρήγορη παράδοση των συλλεκτικών σας προϊόντων σε όλη την Ελλάδα.</p>
                        <div class="mx-auto bg-danger rounded" style="width: 60px; height: 4px;"></div>
                    </div>

                    <!-- 1η Ενότητα: Γενικές Πληροφορίες -->
                    <div class="mb-5">
                        <p class="text-secondary lead">
                            Στο <strong>DeckRush</strong> γνωρίζουμε πόσο ανυπομονείτε να παραλάβετε τις νέες σας κάρτες Pokémon, One Piece και τα συλλεκτικά σας αντικείμενα! Για το λόγο αυτό, όλες οι αποστολές μας πραγματοποιούνται σε συνεργασία με τις εγκυρότερες εταιρείες <strong>Courier (Ταχυμεταφορών)</strong>, διασφαλίζοντας ότι η παραγγελία σας θα φτάσει γρήγορα και σε άριστη κατάσταση (Mint Condition) [?].
                        </p>
                    </div>

                    <!-- 2η Ενότητα: Χρόνοι Παράδοσης -->
                    <div class="row mb-5 g-4">
                        <div class="col-md-6">
                            <div class="card h-100 rounded-3 border p-3 bg-light bg-opacity-50">
                                <h3 class="h5 fw-bold text-dark mb-3">
                                    <i class="bi bi-clock-history text-danger me-2"></i>Χρόνοι Παράδοσης
                                </h3>
                                <ul class="text-secondary ps-3 mb-0">
                                    <li class="mb-2"><strong>Αττική & Χερσαίοι Προορισμοί:</strong> 1 - 3 εργάσιμες ημέρες.</li>
                                    <li class="mb-2"><strong>Νησιωτικοί Προορισμοί:</strong> 2 - 4 εργάσιμες ημέρες.</li>
                                    <li><strong>Δυσπρόσιτες Περιοχές:</strong> 3 - 5 εργάσιμες ημέρες.</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100 rounded-3 border p-3 bg-light bg-opacity-50">
                                <h3 class="h5 fw-bold text-dark mb-3">
                                    <i class="bi bi-box-seam text-danger me-2"></i>Επεξεργασία Παραγγελιών
                                </h3>
                                <p class="text-secondary small mb-0">
                                    Όλες οι παραγγελίες που καταχωρούνται τις εργάσιμες ημέρες (Δευτέρα έως Παρασκευή) έως τις 14:00, επεξεργάζονται, συσκευάζονται με προστατευτικό υλικό (bubble wrap) και παραδίδονται στην Courier την ίδια ημέρα. Παραγγελίες που καταχωρούνται Σαββατοκύριακα ή αργίες αποστέλλονται την αμέσως επόμενη εργάσιμη ημέρα.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 3η Ενότητα: Κόστη Αποστολής (SOS για Τράπεζες) -->
                    <div class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-4">Έξοδα Αποστολής</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>Περιοχή Αποστολής</th>
                                        <th>Κόστος Μεταφορικών</th>
                                        <th>Δωρεάν Αποστολή</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center text-secondary">
                                    <tr>
                                        <td class="fw-bold text-dark">Όλη η Ελλάδα</td>
                                        <td>3,50€</td>
                                        <td>Για παραγγελίες άνω των 60,00€</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-dark">Υπηρεσία Αντικαταβολής</td>
                                        <td>+3,00€ (επιπλέον των μεταφορικών)</td>
                                        <td>—</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted small mt-2">
                            * Σημείωση: Οι παραπάνω τιμές περιλαμβάνουν τον νόμιμο Φ.Π.Α. 24%. Τα έξοδα ενδέχεται να μεταβληθούν βάσει του βάρους ή του όγκου του δέματος (π.χ. μεγάλες παραγγελίες Booster Boxes), για το οποίο θα ενημερωθείτε κατά το checkout [?].
                        </p>
                    </div>

                    <!-- 4η Ενότητα: Παρακολούθηση Παραγγελίας -->
                    <div class="mb-4">
                        <h2 class="h4 fw-bold text-dark mb-3">🔍 Παρακολούθηση Αποστολής (Tracking)</h2>
                        <p class="text-secondary">
                            Μόλις η παραγγελία σας παραδοθεί στην εταιρεία Courier, θα λάβετε αυτόματα ένα **Email** (ή SMS) το οποίο θα περιλαμβάνει τον **Αριθμό Αποστολής (Voucher / Tracking Number)**. Με αυτόν τον κωδικό, μπορείτε να παρακολουθείτε την πορεία του δέματός σας ανά πάσα στιγμή μέσα από το επίσημο site της εταιρείας Courier [?].
                        </p>
                    </div>

                    <!-- 5η Ενότητα: Σημαντική Σημείωση για Συλλέκτες -->
                    <div class="p-3 bg-danger bg-opacity-10 border border-danger border-opacity-20 rounded-3">
                        <h3 class="h5 fw-bold text-danger mb-2">⚠️ Έλεγχος Κατά την Παραλαβή</h3>
                        <p class="text-secondary small mb-0">
                            Παρακαλούμε θερμά, κατά την παράδοση του δέματος από τον διανομέα, να ελέγχετε εξωτερικά τη συσκευασία. Εάν παρατηρήσετε σοβαρή αλλοίωση, σκίσιμο ή παραμόρφωση του κουτιού μεταφοράς που ενδέχεται να έχει επηρεάσει τα sealed προϊόντα σας (Booster Boxes, ETB), έχετε το δικαίωμα να αρνηθείτε την παραλαβή και να επικοινωνήσετε αμέσως μαζί μας ώστε να διευθετήσουμε την άμεση αντικατάστασή του.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
