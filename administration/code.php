<?php

include('../functions/myfunctions.php');

if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $image = $_FILES['image']['name'];
    $svg    = $_FILES['svg_file']['name'];

    $path = "../uploads";

    // ----- ΕΠΕΞΕΡΓΑΣΙΑ JPG/PNG -----
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $image_filename = time() . '.' . $image_ext;

    // ----- ΕΠΕΞΕΡΓΑΣΙΑ SVG -----
    $svg_ext = pathinfo($svg, PATHINFO_EXTENSION);
    $svg_filename = time() . '_icon.' . $svg_ext;

    // Εισαγωγή DB — πρόσθεσε και το svg όνομα (αν χρειάζεται)
    $cate_query = "INSERT INTO product_categories 
    (category_name, slug, category_description, meta_title, meta_description, meta_keywords, status, popular, category_image, category_svg)
    VALUES ('$name', '$slug','$description','$meta_title','$meta_description','$meta_keywords','$status','$popular','$image_filename', '$svg_filename')";

    $cate_query_run = mysqli_query($conn, $cate_query);

    if ($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $image_filename);
        move_uploaded_file($_FILES['svg_file']['tmp_name'], $path . '/' . $svg_filename);
        redirect("add-category.php", "Category Added Successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

} elseif (isset($_POST['update_category_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $new_image = $_FILES['image']['name'];
    $new_image_temp = $_FILES['image']['tmp_name'];
    $old_image = $_POST['old_image'];

    // Define the upload path
    $path = "../uploads/";

    // Determine the filename to be updated
    if (!empty($new_image)) {
        // Generate a new filename with a timestamp
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;

        // Move the new image to the upload directory
        if (move_uploaded_file($new_image_temp, $path . $update_filename)) {
            // Delete the old image if it exists and is different from the new one
            if ($old_image && file_exists($path . $old_image)) {
                unlink($path . $old_image);
            }
        } else {
            echo "Failed to upload new image.";
            exit();
        }
    } else {
        // No new image uploaded, keep the old image
        $update_filename = $old_image;
    }

    // Update query
    $update_query = "UPDATE product_categories SET 
        category_name = '$name', 
        slug = '$slug', 
        category_description = '$description', 
        meta_title = '$meta_title', 
        meta_description = '$meta_description', 
        meta_keywords = '$meta_keywords', 
        status = '$status', 
        popular = '$popular', 
        category_image = '$update_filename' 
        WHERE id = '$category_id'";

    // Execute the query
    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        // Redirect or display a success message
        redirect("edit-category.php?category_id=$category_id", "Category Updated Successfully");
    } else {
        // Display error message
        echo "Error: " . mysqli_error($conn); // For debugging, remove in production
        exit();
    }

} elseif (isset($_POST['delete_category_btn'])) {
    // Sanitize the category ID
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    // Fetch the image filename from the database before deleting
    $query = "SELECT category_image FROM product_categories WHERE id='$category_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_filename = $row['category_image'];

        // Path to the image file
        $path = "../uploads/" . $image_filename;

        // Delete the category record
        $delete_query = "DELETE FROM product_categories WHERE id='$category_id'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            // Check if the file exists and delete it
            if (file_exists($path)) {
                unlink($path);
            }
            echo "200";
            //redirect("category.php", "Category deleted successfully");
        } else {
            echo "500";
            //redirect("category.php", "Something went wrong");
        }
    }
} elseif (isset($_POST['add_product_btn'])) {
    // Retrieve POST data
    $category_name = $_POST['category_id'];
    $discount = $_POST['discount']; // Retrieve discount selection
    $top_sale = $_POST['top_sale']; // Retrieve top_sale selection
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = floatval($_POST['original_price']); // Sanitize the input
    $selling_price = floatval($_POST['selling_price']);   // Sanitize the input
    $qty = isset($_POST['qty']) && $_POST['qty'] !== '' ? intval($_POST['qty']) : 0;
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';


    // Image upload
    $image = $_FILES['image']['name'];
    $path = "../uploads"; // Ensure this directory exists and is writable
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if ($name != "" && $slug != "" && $description != "") {

        $product_query = "INSERT INTO products (category_id, name, slug, small_description, description, original_price, selling_price, qty, meta_title, meta_description, meta_keywords, status, trending, item_image, discount, top_sale) 
        VALUES ('$category_name', '$name', '$slug','$small_description','$description','$original_price','$selling_price','$qty','$meta_title','$meta_description','$meta_keywords','$status','$trending','$filename', '$discount', '$top_sale')";

        // Run query
        $product_query_run = mysqli_query($conn, $product_query);

        if ($product_query_run) {
            // Move the uploaded file to the specified directory
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);

            // Temporary success message
            redirect("add-product.php", "Product Added Successfully");
        } else {
            // Display error for debugging
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        redirect("add-product.php", "All fields are mandatory");
    }
} elseif (isset($_POST['update_product_btn'])) {
    // Retrieve POST data
    $product_id = $_POST['product_id'];
    $category_name = $_POST['category_id'];
    $discount = $_POST['discount']; // Retrieve discount selection
    $top_sale = $_POST['top_sale']; // Retrieve top_sale selection
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = floatval($_POST['original_price']);
    $selling_price = floatval($_POST['selling_price']);
    $qty = isset($_POST['qty']) && $_POST['qty'] !== '' ? intval($_POST['qty']) : 0;
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    // Handle image upload
    $new_image = $_FILES['image']['name'];
    $old_image = isset($_POST['old_image']) ? $_POST['old_image'] : '';
    $path = "../uploads"; // Ensure this directory exists and is writable

    // Determine the filename to use for the image
    if (!empty($new_image)) {
        // New image is uploaded
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;

        // Move the new image to the uploads directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename)) {
            // Delete the old image if it exists and is not empty
            if (!empty($old_image) && file_exists($path . '/' . $old_image)) {
                unlink($path . '/' . $old_image);
            }
        } else {
            // Handle upload failure
            $update_filename = $old_image; // Use old image if new upload fails
        }
    } else {
        // No new image is uploaded, keep the old image
        $update_filename = $old_image;
    }

    // Update product query
    $update_product_query = "UPDATE products SET 
        category_id='$category_name', 
        name='$name', 
        slug='$slug', 
        small_description='$small_description', 
        description='$description', 
        original_price='$original_price', 
        selling_price='$selling_price', 
        qty='$qty', 
        meta_title='$meta_title', 
        meta_description='$meta_description', 
        meta_keywords='$meta_keywords', 
        status='$status', 
        trending='$trending', 
        item_image='$update_filename', 
        discount='$discount', 
        top_sale='$top_sale' 
        WHERE id='$product_id'";

    // Execute the query
    $update_product_query_run = mysqli_query($conn, $update_product_query);

    if ($update_product_query_run) {
        redirect("edit-product.php?id=$product_id", "Product Updated Successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
        redirect("edit-product.php?id=$product_id", "Something Went Wrong");
    }

} elseif (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Fetch the image filename from the database before deleting
    $product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($conn, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['item_image'];

    $delete_query = "DELETE FROM products WHERE id='$product_id'";
    $delete_query_run = mysqli_query($conn, $delete_query);


    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        //redirect("products.php", "Product deleted successfully");
        echo "200";
    } else {
        //redirect("products.php", "Something went wrong");
        echo "500";
    }
} elseif (isset($_POST['update_order_btn'])) {

    $track_no = $_POST['tracking_no'];
    $order_status = $_POST['order_status'];

    $updateOrder_query = "UPDATE orders SET status='$order_status' WHERE tracking_no='$track_no'";
    $updateOrder_query_run = mysqli_query($conn, $updateOrder_query);

    redirect("view-order.php?t=$track_no", "Order Updated Successfully");
} else {
    header('Location: ../index.php');
}
