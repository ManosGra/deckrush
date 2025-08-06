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
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $product = getById("products", $id);

                if (mysqli_num_rows($product) > 0) {
                    $data = mysqli_fetch_array($product);
                    ?>

                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product</h4>
                            <a href="products.php" class="btn btn-primary float-end">Back</a>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="mb-0" for="category_id">Select Category</label>
                                        <select name="category_id" id="category_id" class="form-select mb-2">
                                            <option value="">Select Category</option>
                                            <?php
                                            // Παίρνουμε όλες τις κατηγορίες
                                            $categories = getAll("product_categories");
                                            if (mysqli_num_rows($categories) > 0) {
                                                while ($item = mysqli_fetch_assoc($categories)) {
                                                    // Ελέγχουμε αν το category_name από τη βάση ταιριάζει με το category_id (όνομα της κατηγορίας) που έχει το προϊόν
                                                    ?>
                                                    <option value="<?php echo $item['category_name']; ?>" <?php echo $data['category_id'] == $item['category_name'] ? 'selected' : ''; ?>>
                                                        <?php echo $item['category_name']; ?>
                                                    </option>
                                                    <?php
                                                }
                                            } else {
                                                echo "<option>No categories available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-0" for="discount">Discount</label>
                                        <select name="discount" id="discount" class="form-select mb-2">
                                            <option value="none" <?php echo $data['discount'] == 'none' ? 'selected' : ''; ?>>
                                                Select Discount</option>
                                            <option value="yes" <?php echo $data['discount'] == 'yes' ? 'selected' : ''; ?>>Yes
                                            </option>
                                            <option value="no" <?php echo $data['discount'] == 'no' ? 'selected' : ''; ?>>No
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-0" for="top_sale">Top Sale</label>
                                        <select name="top_sale" id="top_sale" class="form-select mb-2">
                                            <option value="none" <?php echo $data['top_sale'] == 'none' ? 'selected' : ''; ?>>
                                                Select Top Sale</option>
                                            <option value="yes" <?php echo $data['top_sale'] == 'yes' ? 'selected' : ''; ?>>Yes
                                            </option>
                                            <option value="no" <?php echo $data['top_sale'] == 'no' ? 'selected' : ''; ?>>No
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo htmlspecialchars($data['id'], ENT_QUOTES); ?>">
                                        <label class="mb-0" for="name">Name</label>
                                        <input type="text" id="name" name="name"
                                            value="<?php echo htmlspecialchars($data['name'], ENT_QUOTES); ?>"
                                            placeholder="Enter Product Name" class="form-control mb-2">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-0" for="slug">Slug</label>
                                        <input type="text" id="slug" name="slug"
                                            value="<?php echo htmlspecialchars($data['slug'], ENT_QUOTES); ?>"
                                            placeholder="Enter Slug" class="form-control mb-2">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="mb-0" for="small_description">Small Description</label>
                                        <textarea id="small_description" rows="3" name="small_description"
                                            placeholder="Enter small description"
                                            class="form-control mb-2"><?php echo htmlspecialchars($data['small_description'], ENT_QUOTES); ?></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="mb-0" for="description">Description</label>
                                        <textarea id="description" rows="3" name="description" placeholder="Enter Description"
                                            class="form-control mb-2"><?php echo ($data['description']); ?></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-0" for="original_price">Original Price</label>
                                        <input type="text" id="original_price" name="original_price"
                                            value="<?php echo htmlspecialchars($data['original_price'], ENT_QUOTES); ?>"
                                            placeholder="Enter Original Price" class="form-control mb-2">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mb-0" for="selling_price">Selling Price</label>
                                        <input type="text" id="selling_price" name="selling_price"
                                            value="<?php echo htmlspecialchars($data['selling_price'], ENT_QUOTES); ?>"
                                            placeholder="Enter Selling Price" class="form-control mb-2">
                                    </div>

                                    <div class="col-md-12 my-4">
                                        <label class="mb-0" for="image">Upload Image</label>
                                        <input type="hidden" name="old_image"
                                            value="<?php echo htmlspecialchars($data['item_image'], ENT_QUOTES); ?>">
                                        <input type="file" id="image" name="image">
                                        <label class="mb-0">Current Image</label>
                                        <?php if (!empty($data['item_image'])): ?>
                                            <img src="../uploads/<?php echo htmlspecialchars($data['item_image'], ENT_QUOTES); ?>"
                                                alt="Product Image" width="50px" height="50px">
                                        <?php endif; ?>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <label class="mb-0" for="qty">Quantity</label>
                                            <input type="number" id="qty" name="qty"
                                                value="<?php echo htmlspecialchars($data['qty'], ENT_QUOTES); ?>"
                                                placeholder="Enter Quantity" class="form-control mb-2" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="mb-0" for="status">Status</label><br>
                                            <input type="checkbox" id="status" name="status" <?php echo $data['status'] == '1' ? 'checked' : ''; ?>>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="mb-0" for="trending">Availability</label><br>
                                            <input type="checkbox" id="trending" name="trending" <?php echo $data['trending'] == '1' ? 'checked' : ''; ?>>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <label class="mb-0" for="meta_title">Meta Title</label>
                                        <input type="text" id="meta_title" name="meta_title"
                                            value="<?php echo htmlspecialchars($data['meta_title'], ENT_QUOTES); ?>"
                                            placeholder="Enter Meta Title" class="form-control mb-2">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="mb-0" for="meta_description">Meta Description</label>
                                        <textarea id="meta_description" rows="3" name="meta_description"
                                            placeholder="Enter Meta Description"
                                            class="form-control mb-2"><?php echo htmlspecialchars($data['meta_description'], ENT_QUOTES); ?></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="mb-0" for="meta_keywords">Meta Keywords</label>
                                        <textarea id="meta_keywords" rows="3" name="meta_keywords"
                                            placeholder="Enter Meta Keywords"
                                            class="form-control mb-2"><?php echo htmlspecialchars($data['meta_keywords'], ENT_QUOTES); ?></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_product_btn">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                } else {
                    echo "Product not FOUND";
                }
            } else {
                echo "Id missing from url";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>