<?php

include('../functions/myfunctions.php');
include('../functions/sendOrderEmail.php');

# =====================================================================
# 1. ΠΡΟΣΘΗΚΗ ΚΑΤΗΓΟΡΙΑΣ (ADD CATEGORY)
# =====================================================================
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
    $svg = $_FILES['svg_file']['name'];

    $path = "../uploads";

    // ----- ΕΠΕΞΕΡΓΑΣΙΑ JPG/PNG -----
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $image_filename = time() . '.' . $image_ext;

    // ----- ΕΠΕΞΕΡΓΑΣΙΑ SVG -----
    $svg_ext = pathinfo($svg, PATHINFO_EXTENSION);
    $svg_filename = time() . '_icon.' . $svg_ext;

    // Εισαγωγή DB
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

    # =====================================================================
# 2. ΕΝΗΜΕΡΩΣΗ ΚΑΤΗΓΟΡΙΑΣ (UPDATE CATEGORY)
# =====================================================================
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

    $path = "../uploads/";

    if (!empty($new_image)) {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;

        if (move_uploaded_file($new_image_temp, $path . $update_filename)) {
            if ($old_image && file_exists($path . $old_image)) {
                unlink($path . $old_image);
            }
        } else {
            echo "Failed to upload new image.";
            exit();
        }
    } else {
        $update_filename = $old_image;
    }

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

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        redirect("edit-category.php?category_id=$category_id", "Category Updated Successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    # =====================================================================
# 3. ΔΙΑΓΡΑΦΗ ΚΑΤΗΓΟΡΙΑΣ (DELETE CATEGORY)
# =====================================================================
} elseif (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $query = "SELECT category_image FROM product_categories WHERE id='$category_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_filename = $row['category_image'];
        $path = "../uploads/" . $image_filename;

        $delete_query = "DELETE FROM product_categories WHERE id='$category_id'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            if (file_exists($path)) {
                unlink($path);
            }
            echo "200";
        } else {
            echo "500";
        }
    }

    # =====================================================================
# 4. ΠΡΟΣΘΗΚΗ ΠΡΟΪΟΝΤΟΣ (ADD PRODUCT)
# =====================================================================
} elseif (isset($_POST['add_product_btn'])) {
    $category_name = $_POST['category_id'];
    $discount = $_POST['discount'];
    $top_sale = $_POST['top_sale'];
    $is_preorder = isset($_POST['is_preorder']) ? mysqli_real_escape_string($conn, $_POST['is_preorder']) : '0';
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

    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if ($name != "" && $slug != "" && $description != "") {
        $product_query = "INSERT INTO products (category_id, name, slug, small_description, description, original_price, selling_price, qty, meta_title, meta_description, meta_keywords, status, trending, item_image, discount, top_sale, is_preorder) 
        VALUES ('$category_name', '$name', '$slug','$small_description','$description','$original_price','$selling_price','$qty','$meta_title','$meta_description','$meta_keywords','$status','$trending','$filename', '$discount', '$top_sale', '$is_preorder')";

        $product_query_run = mysqli_query($conn, $product_query);

        if ($product_query_run) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("add-product.php", "Product Added Successfully");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        redirect("add-product.php", "All fields are mandatory");
    }
    # =====================================================================
# 5. ΕΝΗΜΕΡΩΣΗ ΠΡΟΪΟΝΤΟΣ (UPDATE PRODUCT)
# =====================================================================
} elseif (isset($_POST['update_product_btn'])) {
    $product_id = $_POST['product_id'];
    $category_name = $_POST['category_id'];
    $discount = $_POST['discount'];
    $top_sale = $_POST['top_sale'];
    $is_preorder = isset($_POST['is_preorder']) ? mysqli_real_escape_string($conn, $_POST['is_preorder']) : '0';
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

    $new_image = $_FILES['image']['name'];
    $new_image_temp = $_FILES['image']['tmp_name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads/";

    if (!empty($new_image)) {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;

        if (move_uploaded_file($new_image_temp, $path . $update_filename)) {
            if ($old_image && file_exists($path . $old_image)) {
                unlink($path . $old_image);
            }
        }
    } else {
        $update_filename = $old_image;
    }

    $update_query = "UPDATE products SET 
        category_id = '$category_name',
        name = '$name', 
        slug = '$slug', 
        small_description = '$small_description',
        description = '$description', 
        original_price = '$original_price',
        selling_price = '$selling_price',
        qty = '$qty',
        meta_title = '$meta_title', 
        meta_description = '$meta_description', 
        meta_keywords = '$meta_keywords', 
        status = '$status', 
        trending = '$trending', 
        item_image = '$update_filename',
        discount = '$discount',
        top_sale = '$top_sale',
        is_preorder = '$is_preorder' 
        WHERE id = '$product_id'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        redirect("edit-product.php?id=$product_id", "Product Updated Successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    # =====================================================================
# 6. ΔΙΑΓΡΑΦΗ ΠΡΟΪΟΝΤΟΣ (DELETE PRODUCT)
# =====================================================================
} elseif (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    $query = "SELECT item_image FROM products WHERE id='$product_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_filename = $row['item_image'];
        $path = "../uploads/" . $image_filename;

        $delete_query = "DELETE FROM products WHERE id='$product_id'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            if ($image_filename && file_exists($path)) {
                unlink($path);
            }
            echo "200";
        } else {
            echo "500";
        }
    } else {
        echo "500";
    }

    # =====================================================================
# 7. ΕΝΗΜΕΡΩΣΗ ΚΑΤΑΣΤΑΣΗΣ ΠΑΡΑΓΓΕΛΙΑΣ (UPDATE ORDER STATUS)
# =====================================================================
} elseif (isset($_POST['update_order_btn'])) {

    $tracking_no = mysqli_real_escape_string($conn, $_POST['tracking_no']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);


    // Update status παραγγελίας
    $update_order_query = "
        UPDATE orders 
        SET status = '$order_status' 
        WHERE tracking_no = '$tracking_no'
    ";

    $update_order_query_run = mysqli_query($conn, $update_order_query);


    if ($update_order_query_run) {


        // Παίρνουμε στοιχεία πελάτη
        $order_query = "
            SELECT * 
            FROM orders 
            WHERE tracking_no='$tracking_no' 
            LIMIT 1
        ";

        $order_query_run = mysqli_query($conn, $order_query);


        if (mysqli_num_rows($order_query_run) > 0) {


            $order = mysqli_fetch_array($order_query_run);

            $email = $order['email'];
            $name = $order['name'];

            // Παίρνουμε το προϊόν της παραγγελίας
            $product_query = "
                SELECT p.name, p.item_image
                FROM order_items oi
                INNER JOIN products p 
                ON oi.prod_id = p.id
                WHERE oi.order_id='" . $order['id'] . "'
                LIMIT 1
                ";

            $product_query_run = mysqli_query($conn, $product_query);


            $product_name = "";
            $product_image = "";


            if (mysqli_num_rows($product_query_run) > 0) {
                $product = mysqli_fetch_array($product_query_run);

                $product_name = $product['name'];
                $product_image = "https://deckrush.gr/uploads/" . $product['item_image'];
            }



            // STATUS 0 - Σε προετοιμασία
            if ($order_status == 0) {

                $subject = "Η παραγγελία σας ετοιμάζεται - DeckRush";

                $message = getEmailTemplate(
                    "../emails/order_processing.html",
                    [
                        "customer_name" => $name,
                        "order_id" => $tracking_no
                    ]
                );

                sendEmail($email, $subject, $message);


            } elseif ($order_status == 1) {


                $subject = "Η παραγγελία σας ολοκληρώθηκε - DeckRush";


                $message = getEmailTemplate(
                    "../emails/order_completed.html",
                    [
                        "customer_name" => $name,
                        "order_id" => $tracking_no
                    ]
                );

                sendEmail(
                    $email,
                    $subject,
                    $message
                );



                // STATUS 2 - Ακυρώθηκε
            } elseif ($order_status == 2) {


                $subject = "Η παραγγελία σας ακυρώθηκε - DeckRush";


                $message = "
                <h2>Γεια σας $name</h2>
                <p>Η παραγγελία σας ακυρώθηκε.</p>
                <p>Αριθμός παραγγελίας: <b>$tracking_no</b></p>
                <p>Για οποιαδήποτε απορία επικοινωνήστε μαζί μας.</p>
                <br>
                <b>DeckRush</b>
                ";


                sendEmail(
                    $email,
                    $subject,
                    $message
                );

            }

        }


        redirect(
            "orders-history.php",
            "Order Status Updated Successfully"
        );


    } else {


        echo "Error updating order: " . mysqli_error($conn);
        exit();

    }
}

$conn->close();
?>