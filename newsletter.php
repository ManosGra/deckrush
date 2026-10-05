<?php

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$email = $_POST['email'] ?? '';
$consent = $_POST['consent'] ?? '';
$return_url = $_POST['return_url'] ?? '/';

// Έλεγχος email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php");
    exit;
}

// Έλεγχος συγκατάθεσης GDPR
if (!$consent) {
    header("Location: index.php");
    exit;
}

// Ασφάλεια: επιτρέπουμε μόνο URLs του δικού μας site
if (
    empty($return_url) ||
    $return_url[0] !== '/' ||
    strpos($return_url, '//') === 0
) {
    $return_url = '/';
}

// BREVO API

$data = [
    "email" => $email,
    "listIds" => [3],
    "updateEnabled" => true
];

$ch = curl_init("https://api.brevo.com/v3/contacts");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "accept: application/json",
    "api-key: " . $brevoApiKey,
    "content-type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

curl_close($ch);

// Επιστροφή στη σελίδα από όπου έγινε η εγγραφή
if (strpos($return_url, '?') !== false) {
    $return_url .= '&subscribed=1';
} else {
    $return_url .= '?subscribed=1';
}

header("Location: " . $return_url);
exit;