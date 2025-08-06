<?php
session_start();
include 'config/db.php'; // Σύνδεση στη βάση δεδομένων

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Έλεγχος αν το token υπάρχει στη βάση δεδομένων
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE activation_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ενεργοποίηση του χρήστη
        $stmt = $conn->prepare("UPDATE user SET user_status = 1 WHERE activation_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $_SESSION['message'] = "Ο λογαριασμός σας έχει ενεργοποιηθεί με επιτυχία!";
        header('Location: ../login-register');
    } else {
        $_SESSION['message'] = "Το token δεν είναι έγκυρο!";
        header('Location: ../login-register');
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "Δεν βρέθηκε token για ενεργοποίηση.";
    header('Location: ../login-register');
}
$conn->close();