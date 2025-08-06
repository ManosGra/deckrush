<?php

$user_id = $_SESSION['auth_user']['user_id']; // Χρησιμοποίησε το user_id από τη συνεδρία

// Έλεγχος αν το user_id είναι σωστό
if (empty($user_id)) {
    die("User ID is not set in session.");
}

// Επεξεργασία φόρμας
if (isset($_POST['submit'])) {
    // Λάβετε τα νέα δεδομένα από τη φόρμα
    $new_username = $_POST['name'];
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $new_phone = $_POST['phone'];
    $new_pincode = $_POST['pincode'];

    // Ενημέρωση της βάσης δεδομένων
    $update_query = "UPDATE user SET username=?, user_email=?, user_phone=?, address=?, pincode=? WHERE user_id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $new_username, $new_email, $new_phone, $new_address, $new_pincode, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Τα στοιχεία σας ενημερώθηκαν επιτυχώς!";
    } else {
        $_SESSION['message'] = "Σφάλμα κατά την ενημέρωση: " . $stmt->error;
    }
}

// Ερώτηση για τα στοιχεία χρήστη
$user_query = "SELECT username, user_email, user_phone, address, pincode FROM user WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Συνδυασμός Δεδομένων
$order_name = $user_data['username'] ?? '';
$order_email = $user_data['user_email'] ?? '';
$order_address = $user_data['address'] ?? '';
$order_phone = $user_data['user_phone'] ?? '';
$order_pincode = $user_data['pincode'] ?? '';
?>

<h5 class="mb-3 text-center">Στοιχεία λογαριασμού</h5>
<div class="card shadow-lg">
    <div class="card-body primary">
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Όνομα χρήστη</label>
                    <input type="text" name="name" class="form-control form-control-lg border-primary"
                        placeholder="Πλήρες όνομα" value="<?php echo htmlspecialchars($order_name); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg border-primary"
                        placeholder="example@email.com" value="<?php echo htmlspecialchars($order_email); ?>">
                </div>

                <div class="col-md-12">
                    <label class="form-label mt-3 fw-bold">Διεύθυνση</label>
                    <input type="text" name="address" class="form-control form-control-lg border-primary"
                        placeholder="Διεύθυνση" value="<?php echo htmlspecialchars($order_address); ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label mt-3 fw-bold">Τηλέφωνο</label>
                    <input type="tel" name="phone" class="form-control form-control-lg border-primary"
                        placeholder="Τηλέφωνο" value="<?php echo htmlspecialchars($order_phone); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label mt-3 fw-bold">Ταχυδρομικός Κωδικός</label>
                    <input type="text" name="pincode" class="form-control form-control-lg border-primary"
                        placeholder="Ταχυδρομικός Κωδικός" value="<?php echo htmlspecialchars($order_pincode); ?>" required>
                </div>

                <button class="btn btn-primary mt-3" name="submit">Update</button>
            </div>
        </form>
    </div>
</div>
