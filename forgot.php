<?php
include "config/db.php";
include "includes/header.php";
include "includes/navigation.php";

?>

<!-- Page Content -->
<section id="forgot">
    <div class="container-lg">
        <div class="form-gap"></div>
        <div class="card d-block w-50 mx-auto shadow-lg">
            <div class="card-body">
                <div class="text-center">
                    <h3><i class="fa fa-lock fa-4x"></i></h3>
                    <h2 class="text-center">Forgot Password?</h2>
                    <p>You can reset your password here.</p>

                    <!-- Φόρμα Επαναφοράς Κωδικού -->
                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                        <div class="form-group">
                            <div class="input-group mx-auto rounded" style="max-width:300px;">
                                <i class="bi bi-envelope font-size-25 px-2 border"></i>
                                <input id="email" name="email" placeholder="email address" class="form-control ps-2" type="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input name="recover-submit" class="btn btn-lg btn-primary mt-3" style="min-width:300px;" value="Reset Password" type="submit">
                        </div>

                        <?php
                        if (isset($_POST['recover-submit'])) {
                            $email = $_POST['email'];

                            // Βήμα 1: Επαλήθευση του email στην βάση δεδομένων
                            $query = "SELECT * FROM user WHERE user_email = ?";
                            $stmt = $conn->prepare($query);

                            // Έλεγχος αν το prepare() απέτυχε
                            if ($stmt === false) {
                                die('MySQL prepare error: ' . $conn->error);
                            }

                            $stmt->bind_param('s', $email);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                // Βήμα 2: Δημιουργία token για την επαναφορά
                                $user = $result->fetch_assoc();
                                $token = bin2hex(random_bytes(50));  // Δημιουργία μοναδικού token

                                // Αποθήκευση του token στη βάση δεδομένων
                                $query = "UPDATE user SET reset_token = ? WHERE user_email = ?";
                                $stmt = $conn->prepare($query);
                                
                                // Έλεγχος αν το prepare() απέτυχε
                                if ($stmt === false) {
                                    die('MySQL prepare error: ' . $conn->error);
                                }

                                $stmt->bind_param('ss', $token, $email);
                                $stmt->execute();

                                // Βήμα 3: Αποστολή email με το link επαναφοράς
                                $resetLink = "http://deckhub.local/reset-password.php?token=" . $token;
                                $subject = "Password Reset Request";
                                $message = "Hello, \n\nTo reset your password, click the following link: \n$resetLink\n\nIf you did not request this change, please ignore this email.";
                                $headers = "From: no-reply@yourdomain.com";

                                // Αποστολή του email
                                if (mail($email, $subject, $message, $headers)) {
                                    echo "<div class='alert alert-success mt-3'>Please check your email to reset your password!</div>";
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>There was an error sending the email. Please try again later.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-warning mt-3'>No user found with that email address.</div>";
                            }
                        }
                        ?>
                    </form>
                </div> <!-- /text-center -->
            </div> <!-- /card-body -->
        </div> <!-- /card -->
    </div> <!-- /container -->
</section>

<?php include "includes/footer.php"; ?>
