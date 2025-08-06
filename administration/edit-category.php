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

            if (isset($_GET['category_id'])) {
                $id = $_GET['category_id'];
                $category = getById("product_categories", $id);
                if (mysqli_num_rows($category) > 0) {
                    $data = mysqli_fetch_array($category)

                        ?>

                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Category
                                <a href="category.php" class="btn btn-primary float-end">Back</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="category_id" value="<?php echo $data['id']; ?>">
                                        <label for="">Name</label>
                                        <input type="text" name="name" value="<?php echo $data['category_name']; ?>"
                                            placeholder="Enter Category Name" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Slug</label>
                                        <input type="text" name="slug" value="<?php echo $data['slug']; ?>"
                                            placeholder="Enter Slug" class="form-control">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea rows="3" name="description" placeholder="Enter Description"
                                            class="form-control"><?php echo $data['category_description']; ?></textarea>
                                    </div>

                                    <div class="col-md-12 my-4">
                                        <label for="">Upload Image</label>
                                        <img src="../uploads/<?php echo $data['category_image']; ?>" height="50px" width="50px">
                                        <input type="hidden" name="old_image" value="<?php echo $data['category_image']; ?>">
                                        <input type="file" name="image">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Meta Title</label>
                                        <input type="text" name="meta_title" value="<?php echo $data['meta_title']; ?>"
                                            placeholder="Enter Meta Title" class="form-control">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Meta Description</label>
                                        <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
                                            class="form-control"><?php echo $data['meta_description']; ?></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Meta Keywords</label>
                                        <textarea rows="3" name="meta_keywords" placeholder="Enter meta keywords"
                                            class="form-control"><?php echo $data['meta_keywords']; ?></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Status</label>
                                        <input type="checkbox" <?php echo $data['status'] ? "checked" : ""; ?>
                                            name="status">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Popular</label>
                                        <input type="checkbox" <?php echo $data['popular'] ? "checked" : ""; ?>
                                            name="popular">
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_category_btn">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php } else {
                    echo "Category Not Found";
                }
                ?>
            <?php } else {
                echo "Something went wrong";
            }
            ?>


        </div>
    </div>
</div>

<?php include 'includes/footer.php' ?>