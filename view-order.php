<?php

include 'authenticate.php';
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



<div class="row">
    <div class="col-md-12">

        <div class="card shadow-lg">
            <div class="mb-0 card-header d-flex flex-row align-items-center bg-primary py-3">
                <h2 class="mb-0 mx-auto text-white fs-4">Δείτε την παραγγελία</h2>
                <a href="my-account.php?source=orders" class="btn btn-warning me-2 "><i
                        class="fa fa-reply me-2"></i>Πίσω</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <h4 class="text-center mb-3">Στοιχεία αποστολής</h4>
                            <hr>
                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Όνομα</label>
                                <div class="border p-1">
                                    <?php echo $data['name']; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Επώνυμο</label>
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
                                <label class="fw-bold">Τηλέφωνο</label>
                                <div class="border p-1">
                                    <?php echo $data['phone']; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Αριθμός παραγγελίας</label>
                                <div class="border p-1">
                                    <?php echo $data['tracking_no']; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Διεύθυνση</label>
                                <div class="border p-1">
                                    <?php echo $data['address']; ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="fw-bold">Ταχυδρομικός Κωδικός</label>
                                <div class="border p-1">
                                    <?php echo $data['pincode']; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="text-center mb-3">Λεπτομέρειες παραγγελίας</h4>
                        <hr>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Προϊόν</th>
                                    <th>Κόστος</th>
                                    <th>Ποσότητα</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $userId = $_SESSION['auth_user']['user_id'];

                                $order_query = "SELECT o.id as oid, o.tracking_no, o.user_id, oi.*, oi.qty as orderqty, p.* FROM orders o, order_items oi, products p WHERE o.user_id='$userId' AND oi.order_id=o.id AND p.id=oi.prod_id AND o.tracking_no='$tracking_no'";
                                $order_query_run = mysqli_query($conn, $order_query);

                                if (mysqli_num_rows($order_query_run) > 0) {
                                    foreach ($order_query_run as $item) { ?>

                                        <tr>
                                            <td class="align-middle">
                                                <img src="uploads/<?php echo $item['item_image']; ?>"
                                                    alt="<?php echo $item['name']; ?>" width="100px" height="90px">
                                            </td>
                                            <td class="align-middle">
                                                <?php echo $item['selling_price']; ?>€
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
                        <h5>Σύνολο : <span class="float-end fw-bold"><?php echo number_format((float)$data['total_price'], 2, '.', ''); ?>€</span></h5>
                        </h5>

                        <hr>

                        <label class="mb-2 fw-bold">Μέθοδος πληρωμής</label>
                        <div class="border p-1 mb-3">
                            <?php echo $data['payment_mode']; ?>
                        </div>

                        <label class="mb-2 fw-bold">Status</label>
                        <div class="border p-1 mb-3">
                            <?php

                            if ($data['status'] == 0) {
                                echo "Under Process";
                            } else if ($data['status'] == 1) {
                                echo "Completed";
                            } else if ($data['status'] == 2) {
                                echo "Canceled";
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>