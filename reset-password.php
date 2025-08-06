<?php
include "config/db.php";
include "includes/header.php";
include "includes/navigation.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Βήμα 1: Επαλήθευση του token στην βάση δεδομένων
    $query = "SELECT * FROM user WHERE reset_token = ?";
    $stmt = $conn->prepare($query);
    
    // Έλεγχος αν το prepare απέτυχε
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (isset($_POST['new-password'])) {
            $newPassword = $_POST['new-password'];
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);  // Κρυπτογράφηση του νέου κωδικού

            // Βήμα 2: Ενημέρωση του κωδικού στη βάση δεδομένων και μηδενισμός του token
            $query = "UPDATE user SET user_password = ?, reset_token = NULL WHERE reset_token = ?";
            $stmt = $conn->prepare($query);
            
            // Έλεγχος αν το prepare απέτυχε
            if ($stmt === false) {
                die('MySQL prepare error: ' . $conn->error);
            }

            $stmt->bind_param('ss', $hashedPassword, $token);
            $stmt->execute();

            // Εμφάνιση του μηνύματος επιτυχίας μέσα στο card και ανακατεύθυνση μετά από 2 δευτερόλεπτα
            echo "
                <script>
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'block';
                        setTimeout(function() {
                            window.location.href = 'my-account.php';
                        }, 2000);  // Ανακατεύθυνση μετά από 2 δευτερόλεπτα
                    }, 0);
                </script>
            ";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Invalid or expired token.</div>";
    }
} else {
    echo "<div class='alert alert-warning mt-3'>No token provided.</div>";
}
?>

<section id="reset">
    <div class="container-lg">
        <div class="card shadow-lg mx-auto" style="max-width:400px;">
            <div class="card-body">
                <form action="reset-password.php?token=<?php echo $_GET['token']; ?>" method="post">
                    <div class="form-group">
                        <input type="password" name="new-password" placeholder="Enter your new password"
                            class="form-control" required>
                    </div>
                    <div class="form-group mt-4">
                        <input type="submit" name="new-password-submit" value="Reset Password"
                            class="btn w-100 text-center btn-primary">
                    </div>
                </form>

                <!-- Μήνυμα επιτυχίας που θα εμφανιστεί μετά το reset -->
                <div id="success-message" style="display:none; color: green; font-weight: bold; text-align: center;">
                    <p>Your password has been successfully reset. You will be redirected shortly...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
