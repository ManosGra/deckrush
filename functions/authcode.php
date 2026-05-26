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
                
                // ΔΙΟΡΘΩΘΗΚΕ: Δυναμική παραγωγή του link που καταλαβαίνει αυτόματα αν είμαστε τοπικά ή live
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
                
                // Επίσης αφαιρέθηκε το .php από το activate.php για να ταιριάζει με το .htaccess
                $activation_link = $base_url . "/activate?token=$activation_token";

                // Εδώ ξεκινά ο κώδικας για την αποστολή του email ενεργοποίησης
                $mail = new PHPMailer(true);
                try {
                    // --- Ρυθμίσεις του SMTP ---
                    $mail->isSMTP();
                    
                    // Δυναμικές ρυθμίσεις mail server (Τοπικά Papercut, Live πραγματικό SMTP)
                    if ($_SERVER['HTTP_HOST'] == 'deckhub.local' || $_SERVER['HTTP_HOST'] == 'deckrush.local') {
                        // Τοπικό περιβάλλον (Papercut)
                        $mail->Host = 'localhost';  
                        $mail->SMTPAuth = false;  
                        $mail->Port = 25;  
                        $mail->setFrom('noreply@deckrush.local', 'DeckRush Local');
                    } else {
                        // LIVE ΠΕΡΙΒΑΛΛΟΝ (deckrush.gr)
                        // ΣΗΜΕΙΩΣΗ: Αντικαταστήστε τα παρακάτω με τα πραγματικά στοιχεία του live hosting σας
                        $mail->Host = 'mail.deckrush.gr';            // Ο SMTP server του hosting σας
                        $mail->SMTPAuth = true;                       // Ενεργοποίηση αυθεντικοποίησης
                        $mail->Username = 'noreply@deckrush.gr';      // Το live εταιρικό σας email
                        $mail->Password = 'ΤΟ_PASSWORD_ΣΑΣ';         // Το password του email
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Ασφάλεια TLS
                        $mail->Port = 587;                            // Θύρα για TLS
                        $mail->setFrom('noreply@deckrush.gr', 'DeckRush Store');
                    }

                    // Ρυθμίσεις email
                    $mail->addAddress($email, $name); // Αποδέκτης
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8'; // Διασφαλίζει ότι τα ελληνικά θα φαίνονται σωστά
                    $mail->Subject = 'Ενεργοποίηση Λογαριασμού';
                    $mail->Body = "Παρακαλώ κάντε κλικ στο παρακάτω σύνδεσμο για να ενεργοποιήσετε το λογαριασμό σας:<br><br><a href='$activation_link'>$activation_link</a>";

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
