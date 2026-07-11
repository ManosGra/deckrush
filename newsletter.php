<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index");
    exit;
}

$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index");
    exit;
}

// εδώ αργότερα μπαίνει Brevo API

header("Location: index.php?subscribed=1");
exit;