<?php session_start();
// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (isset($_SESSION['auth_user'])) {
    // Αν ο χρήστης είναι συνδεδεμένος, ανακατεύθυνε σε άλλη σελίδα
    header('Location: index.php'); // Αντικατάστησε με τη σωστή διεύθυνση για την κύρια σελίδα σου
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navigation.php'; ?>


<section id="login-register">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php if (isset($_SESSION['message'])) { ?>
                    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                        <strong>Holy guacamole!</strong> <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message']); // Καθαρισμός του μηνύματος μετά την εμφάνιση ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if (!isset($_SESSION['username'])) {
        // Αν ο χρήστης δεν είναι συνδεδεμένος, εμφάνιση της φόρμας σύνδεσης και εγγραφής
        ?>
        <div class="container-lg">
            <div class="row py-5">
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">Εγγραφή</h2>
                            <?php include 'registration.php' ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <?php include 'login.php' ?>
                </div>
            </div>
        </div>
        <?php
    } ?>

</section>

<?php include 'includes/footer.php'; ?>