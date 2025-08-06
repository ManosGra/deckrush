<?php include 'includes/header.php'; ?>
<?php include '../functions/myfunctions.php'; ?>

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
                    <h4>Categories</h4>
                </div>
                <div class="card-body" id="category_table">
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
                            $category = getAll("product_categories");

                            if ($category) {
                                if (mysqli_num_rows($category) > 0) {
                                    while ($item = mysqli_fetch_assoc($category)) { ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td><?php echo $item['category_name']; ?></td>
                                            <td>
                                                <img src="../uploads/<?php echo $item['category_image']; ?>"
                                                    alt="<?php echo $item['category_name']; ?>" width="155" height="50">
                                            </td>
                                            <td><?php echo $item['status'] == '0' ? "Visible" : "Hidden"; ?></td>
                                            
                                            <td><a href="edit-category.php?category_id=<?php echo $item['id']; ?>"
                                                    class="btn btn-primary btn-sm">Edit</a></td>

                                            <!-------<form action="code.php" method="post">
                                                <input type="hidden" name="category_id" value="<?php echo $item['id']?>">
                                                <td><button type="submit" name="delete_category_btn" class="btn btn-warning btn-sm">Delete</button></td>
                                            </form> !--->
                                            <td><button type="button"
                                                    class="btn btn-sm btn-warning delete_category_btn" value="<?php echo $item['id']; ?>">Delete</button></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="5">No categories found</td>
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