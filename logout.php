<?php
session_start(); 

// Καθαρισμός των συνεδριών
$_SESSION['username'] = null;
$_SESSION['email'] = null;
$_SESSION['firstname'] = null;
$_SESSION['user_role'] = null;

// Καταστροφή της συνεδρίας
session_unset();
session_destroy();

// Ανακατεύθυνση στην αρχική σελίδα
header("Location: ../login-register");
exit();
