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

# =====================================================================
# 1. ΕΓΓΡΑΦΗ ΧΡΗΣΤΗ (REGISTER)
# =====================================================================
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
                
                // Δυναμική παραγωγή του link που καταλαβαίνει αυτόματα αν είμαστε τοπικά ή live
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                $base_url = $protocol . "://" . $_SERVER['HTTP_HOST'];
                
                // Αφαιρέθηκε το .php από το activate.php για να ταιριάζει με το .htaccess
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
                        $mail->Host = 'mail.deckrush.gr';            // Ο SMTP server του hosting σας
                        $mail->SMTPAuth = true;                       // Ενεργοποίηση αυθεντικοποίησης
                        $mail->Username = 'noreply@deckrush.gr';      // Το live εταιρικό σας email
                        $mail->Password = 'MyStrongPass123!';         // Το password του email
                        
                        // ΣΗΜΕΙΩΣΗ ΓΙΑ TOPHOST: Αν δεν στέλνει με STARTTLS/587, αλλάξτε σε ENCRYPTION_SMTPS και 465
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                        $mail->Port = 587;                            
                        
                        $mail->setFrom('noreply@deckrush.gr', 'DeckRush Store');
                    }

                    // Ρυθμίσεις email αποδέκτη
                    $mail->addAddress($email, $name); 
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8'; // Διασφαλίζει ότι τα ελληνικά θα φαίνονται σωστά
                    $mail->Subject = 'Ενεργοποίηση Λογαριασμού';
                    
                    // Εμφανίσιμο HTML σώμα email
                    $mail->Body = "<h3>Καλώς ορίσατε στο DeckRush!</h3>
                                   Παρακαλώ κάντε κλικ στο παρακάτω σύνδεσμο για να ενεργοποιήσετε το λογαριασμό σας:<br><br>
                                   <a href='$activation_link' style='background:#0d6efd; color:#fff; padding:10px 15px; text-decoration:none; border-radius:5px; display:inline-block;'>Ενεργοποίηση Λογαριασμού</a><br><br>
                                   Αν το κουμπί δεν λειτουργεί, αντιγράψτε αυτό το link στον browser σας:<br> $activation_link";

                    // Αποστολή
                    $mail->send();
                    $_SESSION['message'] = "Επιτυχής εγγραφή! Ένα email ενεργοποίησης στάλθηκε.";
                } catch (Exception $e) {
                    // Στο live κρύβουμε τις τεχνικές λεπτομέρειες για λόγους ασφαλείας
                    if ($_SERVER['HTTP_HOST'] == 'deckhub.local' || $_SERVER['HTTP_HOST'] == 'deckrush.local') {
                        $_SESSION['message'] = "Το email δεν στάλθηκε. Σφάλμα: {$mail->ErrorInfo}";
                    } else {
                        $_SESSION['message'] = "Υπήρξε πρόβλημα με την αποστολή του email ενεργοποίησης. Παρακαλώ επικοινωνήστε μαζί μας.";
                    }
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

# =====================================================================
# 2. ΣΥΝΔΕΣΗ ΧΡΗΣΤΗ (LOGIN)
# =====================================================================
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

            // Αποθήκευση στοιχείων στο Session
            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $userdata['user_id'],
                'username' => $userdata['username'],
                'email' => $userdata['user_email']
            ];

            $_SESSION['user_role'] = $userdata['user_role'];

            // Έλεγχος ρόλου χρήστη (1 = Admin, 0 = Πελάτης)
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

// Κλείσιμο της σύνδεσης με τη βάση
$conn->close();
?>
