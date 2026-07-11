<?php 
ob_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email");
    }

    // εδώ αργότερα μπαίνει το Brevo API

    header("Location: index.php?subscribed=1");
    exit;

}

header("Location: index.php");
exit;