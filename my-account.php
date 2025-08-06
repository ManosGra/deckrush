<?php
session_start(); // Ξεκινάμε τη συνεδρία

// Έλεγχος αν ο χρήστης δεν είναι συνδεδεμένος
if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
    header("Location: login-register.php");
    exit(); // Σταματάμε την εκτέλεση του υπόλοιπου κώδικα
}
include 'functions/userfunctions.php';
include 'includes/header.php';
include 'includes/navigation.php';
?>

<main class="main-site">

    <div class="container-lg">

        <div class="row my-account">
            <h1 class="mb-5">Ο λογαριασμός μου</h1>
            <div class="col-md-3">
                <ul class="p-0">
                    <li class="list-unstyled"><a href="my-account" class="text-decoration-none">Πίνακας ελέγχου</a>
                    </li>
                    <li class="list-unstyled"><a href="my-account?source=orders"
                            class="text-decoration-none">Παραγγελίες</a></li>
                    <li class="list-unstyled"><a href="my-account?source=edit-profile"
                            class="text-decoration-none">Στοιχεία λογαριασμού</a></li>
                    <li class="list-unstyled"><a href="logout" class="text-decoration-none">Αποσύνδεση</a></li>
                </ul>
            </div>

            <div class="col-md-9">
                <?php
                if (isset($_GET['source'])) {
                    $source = $_GET['source'];
                } else {
                    $source = 'account'; // Default source
                }

                switch ($source) {
                    case 'account':
                        include 'includes/account.php';
                        break;

                    case 'orders':
                        include 'orders.php';
                        break;

                    case 'view-order':
                        include 'view-order.php';
                        break;

                    case 'edit-profile':
                        include 'edit-profile.php';
                        break;

                    default:
                        include 'my-account.php';
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>