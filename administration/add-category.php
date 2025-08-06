<?php
include 'includes/header.php';


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
                    <h4>Add Category</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Name</label>
                                <input type="text" name="name" placeholder="Enter Category Name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="">Slug</label>
                                <input type="text" name="slug" placeholder="Enter Slug" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description"
                                    class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 my-4">
                                <label for="">Upload Image</label>
                                <input type="file" name="image" accept="image/*">
                            </div>

                            <div class="col-md-12 my-4">
                                <label for="">Upload SVG Icon</label>
                                <input type="file" name="svg_file" accept=".svg">
                            </div>

                            <div class="col-md-12">
                                <label for="">Meta Title</label>
                                <input type="text" name="meta_title" placeholder="Enter Meta Title"
                                    class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label for="">Meta Description</label>
                                <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
                                    class="form-control"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="">Meta Keywords</label>
                                <textarea rows="3" name="meta_keywords" placeholder="Enter meta keywords"
                                    class="form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="">Status</label>
                                <input type="checkbox" name="status">
                            </div>

                            <div class="col-md-6">
                                <label for="">Popular</label>
                                <input type="checkbox" name="popular">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_category_btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php' ?>