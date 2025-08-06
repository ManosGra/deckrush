<?php
include 'includes/header.php';
include '../middleware/adminMiddleware.php';
?>

<?php

// Έλεγχος αν η συνεδρία είναι ενεργή και ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_role'])) {
    // Αν δεν είναι συνδεδεμένος, ανακατεύθυνση στη σελίδα login
    header("Location: ../login.php");
    exit();
}

// Αρχικοποίηση της μεταβλητής search
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

?>

<div class="container-lg">
    <div class="row pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h4 class="text-white">Orders</h4>
                        <a href="orders-history.php" class="btn btn-warning mb-0">Orders History</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Φόρμα αναζήτησης -->
                    <form method="POST" class="d-flex mb-3">
                        <input type="text" class="form-control ms-auto" style="width:200px;" name="search"
                            placeholder="Search..." value="<?php echo $search; ?>">
                    </form>

                    <!-- Πίνακας παραγγελιών -->
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr class="py-2">
                                <th class="py-2">ID</th>
                                <th class="py-2">User</th>
                                <th class="py-2">Order Number</th>
                                <th class="py-2">Price</th>
                                <th class="py-2">Date</th>
                                <th class="py-2">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Συνάρτηση για την αναζήτηση παραγγελιών
                            function searchOrders($search)
                            {
                                global $conn;

                                $searchTerm = '%' . $search . '%';

                                // Εκτέλεση query για αναζήτηση σε name, lastname και tracking_no
                                $stmt = $conn->prepare("SELECT * FROM orders WHERE tracking_no LIKE ? OR name LIKE ? OR lastname LIKE ?");
                                $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                                $stmt->execute();
                                return $stmt->get_result();
                            }

                            // Αν υπάρχει αναζήτηση
                            if ($search) {
                                $orders = searchOrders($search);
                            } else {
                                // Αν δεν υπάρχει αναζήτηση, επιστρέφει όλες τις παραγγελίες
                                $orders = getAllOrders(); // Στην περίπτωση που δεν κάνουμε αναζήτηση
                            }

                            if (mysqli_num_rows($orders) > 0) {
                                while ($item = mysqli_fetch_assoc($orders)) { ?>

                                    <tr class="align-middle">
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo $item['tracking_no']; ?></td>
                                        <td><?php echo $item['total_price']; ?></td>
                                        <td><?php echo $item['created_at']; ?></td>
                                        <td><a href="view-order.php?t=<?php echo $item['tracking_no']; ?>"
                                                class="btn btn-primary my-2">View Details</a></td>
                                    </tr>

                                <?php }
                            } else {
                                ?>

                                <tr>
                                    <td colspan="6">No orders found</td>
                                </tr>

                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>