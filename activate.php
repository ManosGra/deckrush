<?php
session_start();
include 'config/db.php'; // Σύνδεση στη βάση δεδομένων

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // 1. Έλεγχος αν το token υπάρχει στη βάση δεδομένων
    $stmt_select = $conn->prepare("SELECT user_id FROM user WHERE activation_token = ?");
    $stmt_select->bind_param("s", $token);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        // 2. Ενεργοποίηση του χρήστη (Χρήση διαφορετικής μεταβλητής stmt_update)
        $stmt_update = $conn->prepare("UPDATE user SET user_status = 1 WHERE activation_token = ?");
        $stmt_update->bind_param("s", $token);
        $stmt_update->execute();
        
        // Κλείνουμε τα πάντα ΠΡΙΝ το exit για να μην είναι unreachable ο κώδικας
        $stmt_update->close();
        $stmt_select->close();
        $conn->close();

        $_SESSION['message'] = "Ο λογαριασμός σας έχει ενεργοποιηθεί με επιτυχία!";
        header('Location: /login-register');
        exit(); 
    } else {
        $_SESSION['message'] = "Το token δεν είναι έγκυρο!";
        
        // Κλείνουμε τα πάντα ΠΡΙΝ το exit
        $stmt_select->close();
        $conn->close();

        header('Location: /login-register');
        exit();
    }
} else {
    $_SESSION['message'] = "Δεν βρέθηκε token για ενεργοποίηση.";
    
    // Κλείνουμε τη σύνδεση ΠΡΙΝ το exit
    $conn->close();

    header('Location: /login-register');
    exit();
}
?>
