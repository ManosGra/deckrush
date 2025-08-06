<?php
session_start();
include '../config/db.php'; // Σύνδεση στη βάση δεδομένων
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// Συνάρτηση για την ανακατεύθυνση με μήνυμα
function redirectWithMessage($message, $location = '../login-register')
{
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}

// Εγγραφή χρήστη
if (isset($_POST['register_btn'])) {
    // Λήψη δεδομένων από τη φόρμα εγγραφής
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Προεπιλεγμένος ρόλος
    $default_role = '0';

    // Δημιουργία του token για ενεργοποίηση
    $activation_token = md5(rand());  // Δημιουργία μοναδικού token

    // Έλεγχος αν το email υπάρχει ήδη στη βάση δεδομένων
    $stmt = $conn->prepare("SELECT user_email FROM user WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "Αυτό το email χρησιμοποιείται ήδη.";
        header('Location: ../login-register');
        exit();
    } else {
        // Έλεγχος αν οι κωδικοί ταιριάζουν
        if ($password === $cpassword) {
            // Χρήση προετοιμασμένων εντολών για την εισαγωγή χρήστη
            $stmt = $conn->prepare("INSERT INTO user (username, user_email, user_password, user_role, activation_token) VALUES (?, ?, ?, ?, ?)");
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Κρυπτογράφηση κωδικού
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $default_role, $activation_token);

            if ($stmt->execute()) {
                // Δημιουργία του σύνδεσμου ενεργοποίησης
                $activation_link = "http://deckhub.local/activate.php?token=$activation_token";
                //$activation_link = "http://deckhub.gr/activate.php?token=$activation_token";

                // Εδώ ξεκινά ο κώδικας για την αποστολή του email ενεργοποίησης
                $mail = new PHPMailer(true);
                try {
                    // Ρυθμίσεις του SMTP
                    $mail->isSMTP();
                    $mail->Host = 'localhost';  // Ή 127.0.0.1 αν είναι έτσι τοποθετημένο το Papercut
                    $mail->SMTPAuth = false;  // Χωρίς αυθεντικοποίηση
                    $mail->Port = 25;  // Θύρα του Papercut (ή 587 αν χρησιμοποιείς TLS)

                    // Ρυθμίσεις email
                    $mail->setFrom('infodeckhub@example.com'); // Το email μπορεί να είναι οποιοδήποτε για δοκιμές
                    $mail->addAddress($email, $name); // Αποδέκτης
                    $mail->isHTML(true);
                    $mail->Subject = 'Ενεργοποίηση Λογαριασμού';
                    $mail->Body = "Παρακαλώ κάντε κλικ στο παρακάτω σύνδεσμο για να ενεργοποιήσετε το λογαριασμό σας:<a href='$activation_link'>$activation_link</a>";

                    // Στείλτε το email
                    $mail->send();
                    $_SESSION['message'] = "Επιτυχής εγγραφή! Ένα email ενεργοποίησης στάλθηκε.";
                } catch (Exception $e) {
                    $_SESSION['message'] = "Το email ενεργοποίησης δεν μπόρεσε να αποσταλεί. Σφάλμα: {$mail->ErrorInfo}";
                }

                header('Location: ../login-register');
                exit();
            } else {
                $_SESSION['message'] = "Κάτι πήγε στραβά: " . $stmt->error;
                header('Location: ../login-register');
                exit();
            }
        } else {
            $_SESSION['message'] = "Οι κωδικοί δεν ταιριάζουν.";
            header('Location: ../login-register');
            exit();
        }
    }

    $stmt->close();
}
// Σύνδεση χρήστη
if (isset($_POST['login_btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Προετοιμασία του SQL query
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userdata = $result->fetch_assoc();

        // Έλεγχος αν το password είναι σωστό
        if (password_verify($password, $userdata['user_password'])) {
            // Έλεγχος αν ο λογαριασμός είναι ενεργοποιημένος
            if ($userdata['user_status'] == 0) {
                redirectWithMessage("Ο λογαριασμός σας δεν έχει ενεργοποιηθεί ακόμα. Παρακαλώ ελέγξτε το email σας για τον σύνδεσμο ενεργοποίησης.");
            }

            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $userdata['user_id'],
                'username' => $userdata['username'],
                'email' => $userdata['user_email']
            ];

            $_SESSION['user_role'] = $userdata['user_role'];

            // Έλεγχος ρόλου χρήστη
            if ($userdata['user_role'] == '1') {
                redirectWithMessage("Καλώς ήρθατε στον Πίνακα Ελέγχου", '../administration/index.php');
            } else {
                redirectWithMessage("Σύνδεση με επιτυχία", '../my-account');
            }
        } else {
            redirectWithMessage("Μη έγκυρες διαπιστεύσεις");
        }
    } else {
        redirectWithMessage("Μη έγκυρο όνομα χρήστη");
    }

    $stmt->close();
}

$conn->close();