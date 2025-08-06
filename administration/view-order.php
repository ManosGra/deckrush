<?php

include 'includes/header.php';
include '../middleware/adminMiddleware.php';

if (isset($_GET['t'])) {
    $tracking_no = $_GET['t'];

    $orderData = checkTrackingNoValid($tracking_no);
    if (mysqli_num_rows($orderData) < 0) { ?>
        <h4>Something went wrong</h4>
        <?php
        die();
    }
} else { ?>
    <h4>Something went wrong</h4>
    <?php die();
}

$data = mysqli_fetch_array($orderData);
?>

<?php 

// Έλεγχος αν η συνεδρία είναι ενεργή και ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_role'])) {
    // Αν δεν είναι συνδεδεμένος, ανακατεύθυνση στη σελίδα login
    header("Location: ../login.php");
    exit();
}

?>

<div class="container-lg">
    <div class="row pt-3">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="mb-0 card-header d-flex flex-row align-items-center bg-primary py-3">
                    <h2 class="mb-0 mx-auto text-white fs-4">View Order</h2>
                    <a href="orders.php" class="btn btn-warning mb-0"><i class="fa fa-reply me-2"></i>Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <h4 class="text-center mb-3">Delivery Details</h4>
                                <hr>
                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Name</label>
                                    <div class="border p-1">
                                        <?php echo $data['name']; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Lastname</label>
                                    <div class="border p-1">
                                        <?php echo $data['lastname']; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Email</label>
                                    <div class="border p-1">
                                        <?php echo $data['email']; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Phone</label>
                                    <div class="border p-1">
                                        <?php echo $data['phone']; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Order Number</label>
                                    <div class="border p-1">
                                        <?php echo $data['tracking_no']; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Address</label>
                                    <div class="border p-1">
                                        <?php echo $data['address']; ?>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="fw-bold">Pin Code</label>
                                    <div class="border p-1">
                                        <?php echo $data['pincode']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4 class="text-center mb-3">Order Details</h4>
                            <hr>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $order_query = "SELECT o.id as oid, o.tracking_no, o.user_id, oi.*, oi.qty as orderqty, p.* FROM orders o, order_items oi, products p WHERE oi.order_id=o.id AND p.id=oi.prod_id AND o.tracking_no='$tracking_no'";
                                    $order_query_run = mysqli_query($conn, $order_query);

                                    if (mysqli_num_rows($order_query_run) > 0) {
                                        foreach ($order_query_run as $item) { ?>

                                            <tr>
                                                <td class="align-middle">
                                                    <img src="../uploads/<?php echo $item['item_image']; ?>"
                                                        alt="<?php echo $item['name']; ?>" width="50px" height="50px">
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $item['selling_price']; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $item['orderqty']; ?>
                                                </td>
                                            </tr>

                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <hr>
                            <h5>Total Price : <span
                                    class="float-end fw-bold"><?php echo $data['total_price']; ?>€</span>
                            </h5>

                            <hr>

                            <label class="mb-2 fw-bold">Payment Method</label>
                            <div class="border p-1 mb-3">
                                <?php echo $data['payment_mode']; ?>
                            </div>

                            <label class="mb-2 fw-bold">Status</label>
                            <div class="mb-3">
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="tracking_no" value="<?php echo $data['tracking_no']; ?>">
                                    <select name="order_status" id="" class="form-select">
                                        <option value="0" <?php echo ($data['status'] == 0) ? "selected" : ""; ?>>Under
                                            Process</option>
                                        <option value="1" <?php echo ($data['status'] == 1) ? "selected" : ""; ?>>
                                            Completed</option>
                                        <option value="2" <?php echo ($data['status'] == 2) ? "selected" : ""; ?>>
                                            Cancelled</option>
                                    </select>

                                    <button type="submit" name="update_order_btn"
                                        class="btn btn-primary mt-2 w-100">Update Status</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>