<?php
session_start();
include '../config/db.php';

if (isset($_SESSION['auth'])) {
    if (isset($_POST['placeOrderBtn'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
        $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
        $payment_id = isset($_POST['payment_id']) ? mysqli_real_escape_string($conn, $_POST['payment_id']) : "";
        $final_total = isset($_POST['final_total']) ? floatval($_POST['final_total']) : 0;

        if ($name == "" || $email == "" || $address == "" || $phone == "" || $pincode == "") {
            $_SESSION['message'] = "Όλα τα πεδία είναι υποχρεωτικά";
            header('Location: ../checkout.php');
            exit(0);
        }

        $userId = $_SESSION['auth_user']['user_id'];
        $query = "SELECT c.id as cid, c.prod_id, c.prod_qty, p.id as pid, p.name, p.item_image, p.selling_price 
                  FROM carts c, products p 
                  WHERE c.prod_id=p.id AND c.user_id='$userId' ORDER BY c.id DESC";
        $query_run = mysqli_query($conn, $query);

        // Υπολογισμός συνολικού από το καλάθι (για έλεγχο / πληροφορία)
        $totalPrice = 0;
        foreach ($query_run as $citem) {
            $totalPrice += $citem['selling_price'] * $citem['prod_qty'];
        }

        // Δεν ξαναυπολογίζουμε final_total εδώ, παίρνουμε αυτό που στέλνει η φόρμα
        // $final_total = $totalPrice;
        // if ($payment_mode == "COD" && $totalPrice < 50) {
        //     $final_total += 2.50;
        // }

        $tracking_no = "DH" . strtoupper(substr(md5(uniqid()), 0, 5));
        $insert_query = "INSERT INTO orders (tracking_no, user_id, name, lastname, email, phone, address, pincode, total_price, payment_mode, payment_id) 
                         VALUES ('$tracking_no', '$userId', '$name', '$lastname', '$email', '$phone', '$address', '$pincode', '$final_total', '$payment_mode', '$payment_id')";
        $insert_query_run = mysqli_query($conn, $insert_query);

        if ($insert_query_run) {
            $order_id = mysqli_insert_id($conn);
            foreach ($query_run as $citem) {
                $prod_id = $citem['prod_id'];
                $prod_qty = $citem['prod_qty'];
                $price = $citem['selling_price'];

                $insert_items_query = "INSERT INTO order_items (order_id, prod_id, qty, price) VALUES ('$order_id', '$prod_id', '$prod_qty', '$price')";
                $insert_items_query_run = mysqli_query($conn, $insert_items_query);

                $product_query = "SELECT * FROM products WHERE id='$prod_id' LIMIT 1";
                $product_query_run = mysqli_query($conn, $product_query);

                $productData = mysqli_fetch_array($product_query_run);
                $current_qty = $productData['qty'];

                $new_qty = $current_qty - $prod_qty;

                $updateQty_query = "UPDATE products SET qty='$new_qty' WHERE id ='$prod_id'";
                $updateQty_query_run = mysqli_query($conn, $updateQty_query);
            }

            $deleteCartQuery = "DELETE FROM carts WHERE user_id='$userId'";
            $deleteCartQuery_run = mysqli_query($conn, $deleteCartQuery);

            if ($payment_mode == "COD") {
                $_SESSION['message'] = "Η παραγγελία τοποθετήθηκε επιτυχώς!";
                header('Location: ../my-account?source=orders');
                die();
            } else {
                echo 201;
            }
        }
    }
} else {
    header('Location: ../index.php');
    exit();
}
?>
