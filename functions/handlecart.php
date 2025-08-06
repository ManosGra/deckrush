<?php

session_start();
include '../config/db.php';

if (isset($_SESSION['auth'])) {
    if (isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        switch ($scope) {
            case "add":
                if (!isset($_POST['prod_qty'])) {
                    echo "Quantity not set";
                    exit;
                }
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];
                $user_id = $_SESSION['auth_user']['user_id'];

                $check_existing_cart = "SELECT * FROM carts WHERE prod_id='$prod_id' AND user_id='$user_id'";
                $check_existing_cart_run = mysqli_query($conn, $check_existing_cart);

                if (mysqli_num_rows($check_existing_cart_run) > 0) {
                    echo "existing"; 
                } else {
                    $insert_query = "INSERT INTO carts (user_id, prod_id, prod_qty) VALUES ('$user_id', '$prod_id', '$prod_qty')";
                    $insert_query_run = mysqli_query($conn, $insert_query);

                    echo $insert_query_run ? 200 : 500;
                }
                break;

            case "update":
                if (!isset($_POST['prod_qty'])) {
                    echo "Quantity not set";
                    exit;
                }
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];
                $user_id = $_SESSION['auth_user']['user_id'];

                $check_existing_cart = "SELECT * FROM carts WHERE prod_id='$prod_id' AND user_id='$user_id'";
                $check_existing_cart_run = mysqli_query($conn, $check_existing_cart);

                if (mysqli_num_rows($check_existing_cart_run) > 0) {
                    $update_query = "UPDATE carts SET prod_qty='$prod_qty' WHERE prod_id='$prod_id' AND user_id='$user_id'";
                    $update_query_run = mysqli_query($conn, $update_query);
                    echo $update_query_run ? 200 : 500;
                } else {
                    echo "Product not found in cart";
                }
                break;

            case "delete":
                if (!isset($_POST['cart_id'])) {
                    echo "Cart ID not set";
                    exit;
                }
                $cart_id = $_POST['cart_id'];
                $user_id = $_SESSION['auth_user']['user_id'];

                $check_existing_cart = "SELECT * FROM carts WHERE id='$cart_id' AND user_id='$user_id'";
                $check_existing_cart_run = mysqli_query($conn, $check_existing_cart);

                if (mysqli_num_rows($check_existing_cart_run) > 0) {
                    $delete_query = "DELETE FROM carts WHERE id='$cart_id'";
                    $delete_query_run = mysqli_query($conn, $delete_query);
                    echo $delete_query_run ? 200 : "Error deleting item";
                } else {
                    echo "Cart item not found";
                }
                break;

                case "getCount":
                    $user_id = $_SESSION['auth_user']['user_id'];
                    $count_query = "SELECT SUM(prod_qty) AS total FROM carts WHERE user_id='$user_id'";
                    $count_query_run = mysqli_query($conn, $count_query);
                    
                    if ($row = mysqli_fetch_assoc($count_query_run)) {
                        echo $row['total'] ?: 0; // Επιστρέφει 0 αν δεν υπάρχουν προϊόντα
                    } else {
                        echo 401;
                    }
                    break;

            default:
                echo 500;
        }
    }
} else {
    echo 0;
}
