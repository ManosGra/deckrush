<?php
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php");
    exit;
}


// BREVO API

$apiKey = $brevoApiKey;

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
    "api-key: " . $apiKey,
    "content-type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


$response = curl_exec($ch);

curl_close($ch);


// επιστροφή στο site
header("Location: index.php?subscribed=1");
exit;