<?php ob_start();
session_start(); // Ξεκινάμε τη συνεδρία

// Έλεγχος αν ο χρήστης δεν είναι συνδεδεμένος
if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
    header("Location: login-register.php");
    exit(); // Σταματάμε την εκτέλεση του υπόλοιπου κώδικα
}
?>

<?php include 'functions/userfunctions.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navigation.php'; ?>
<?php include 'authenticate.php'; ?>

<section id="cart">
    <div class="container-lg">
        <div id="mycart">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover shadow">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Εικόνα</th>
                                <th>Προϊόν</th>
                                <th>Τιμή</th>
                                <th>Ποσότητα</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $items = getCartItems();
                            if (mysqli_num_rows($items) > 0) {
                                foreach ($items as $citem) { ?>
                                    <tr class="product_data align-items-center">
                                        <td class="align-middle text-center">
                                            <img src="uploads/<?php echo $citem['item_image']; ?>" alt="Image" width="100px">
                                        </td>
                                        <td class="align-middle text-center"><?php echo $citem['name']; ?></td>
                                        <td class="align-middle text-center"><?php echo $citem['selling_price']; ?>€</td>
                                        <td class="align-middle text-center">
                                            <input type="hidden" class="prodId" value="<?php echo $citem['prod_id']; ?>">
                                            <div class="input-group mb-3" style="width:130px; margin: 0 auto;">
                                                <button class="input-group-text decrement-btn updateQty">-</button>
                                                <input type="text" class="form-control text-center input-qty bg-white"
                                                    value="<?php echo $citem['prod_qty']; ?>" disabled>
                                                <button class="input-group-text increment-btn updateQty">+</button>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-danger btn-sm deleteItem"
                                                value="<?php echo $citem['cid']; ?>"><i class="fa fa-trash me-2"></i>Αφαίρεση από το καλάθι </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">Το καλάθι σας είναι άδειο.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <!-- Checkout button below the table -->
                    <?php if (mysqli_num_rows($items) > 0) { ?>
                        <div class="text-center">
                            <a href="checkout" class="btn btn-outline-primary">Συνέχεια<i class="bi bi-arrow-right-circle ms-2 align-middle fw-bold"></i></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
