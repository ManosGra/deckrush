<?php include 'includes/header.php' ?>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0" for="">Select Category</label>
                                <select name="category_id" class="form-select mb-2">
                                    <option selected>Select Category</option>
                                    <?php
                                    $categories = getAll("product_categories");
                                    if (mysqli_num_rows($categories) > 0) {
                                        foreach ($categories as $item) {
                                            ?>
                                            <option value="<?php echo $item['category_name']; ?>">
                                                <?php echo $item['category_name']; ?>
                                            </option>
                                            <?php
                                        }
                                    } else {
                                        echo "No category";
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0" for="">Discount</label>
                                <select name="discount" class="form-select mb-2">
                                    <option value="no" <?php echo isset($data['discount']) && $data['discount'] == 'no' ? 'selected' : ''; ?>>No</option>
                                    <option value="yes" <?php echo isset($data['discount']) && $data['discount'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                                </select>

                            </div>

                            <div class="col-md-6">
                                <label class="mb-0" for="">Top Sale</label>
                                <select name="top_sale" class="form-select mb-2">
                                    <option value="no" <?php echo isset($data['top_sale']) && $data['top_sale'] == 'no' ? 'selected' : ''; ?>>No</option>
                                    <option value="yes" <?php echo isset($data['top_sale']) && $data['top_sale'] == 'yes' ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0" for="">Name</label>
                                <input type="text" name="name" placeholder="Enter Product Name"
                                    class="form-control mb-2">
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0" for="">Slug</label>
                                <input type="text" name="slug" placeholder="Enter Slug" class="form-control mb-2">
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0" for="">Small Description</label>
                                <textarea rows="3" name="small_description" placeholder="Enter small description"
                                    class="form-control mb-2"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0" for="">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description"
                                    class="form-control mb-2"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0" for="">Original Price</label>
                                <input type="text" name="original_price" placeholder="Enter Original Price"
                                    class="form-control mb-2">
                            </div>

                            <div class="col-md-6">
                                <label class="mb-0" for="">Selling Price</label>
                                <input type="text" name="selling_price" placeholder="Enter Selling Price"
                                    class="form-control mb-2">
                            </div>

                            <div class="col-md-12 my-4">
                                <label class="mb-0" for="">Upload Image</label>
                                <input type="file" name="image">
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="mb-0" for="">Quantity</label>
                                    <input type="number" name="qty" placeholder="Enter Quantity"
                                        class="form-control mb-2" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-0" for="">Status</label><br>
                                    <input type="checkbox" name="status">
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-0" for="">Available</label><br>
                                    <input type="checkbox" name="trending">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label class="mb-0" for="">Meta Title</label>
                                <input type="text" name="meta_title" placeholder="Enter Meta Title"
                                    class="form-control mb-2">
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0" for="">Meta Description</label>
                                <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
                                    class="form-control mb-2"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="mb-0" for="">Meta Keywords</label>
                                <textarea rows="3" name="meta_keywords" placeholder="Enter meta keywords"
                                    class="form-control mb-2"></textarea>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php' ?>