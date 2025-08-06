<?php
include 'includes/header.php';
include '../functions/myfunctions.php';
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
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Products</h4>
                </div>
                <div class="card-body" id="products_table">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Call the getAll function with the correct table name
                            $products = getAll(table: "products");

                            if ($products) {
                                if (mysqli_num_rows(result: $products) > 0) {
                                    foreach ($products as $item) { ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td><?php echo $item['name']; ?></td>
                                            <td>
                                                <img src="../uploads/<?php echo $item['item_image']; ?>"
                                                    alt="<?php echo $item['name']; ?>" width="50" height="50">
                                            </td>
                                            <td><?php echo $item['status'] == '0' ? "Visible" : "Hidden"; ?></td>

                                            <td> <a href="edit-product.php?id=<?php echo $item['id']; ?>"
                                                    class="btn btn-primary btn-sm">Edit</a></td>
                                            <td><button type="button"
                                                    class="btn btn-sm btn-warning delete_product_btn" value="<?php echo $item['id']; ?>">Delete</button></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="5">No products found</td>
                                    </tr>
                                <?php }
                            } else {
                                // Display error message if $category is false
                                echo "<tr><td colspan='5'>Error: Could not retrieve data.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>