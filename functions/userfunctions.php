<?php include 'config/db.php';

function getAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE status='0'";
    return mysqli_query($conn, $query);
}

function getCategoriesActive($table)
{
    global $conn;
   $query = "SELECT * FROM $table 
          WHERE status = '0' 
            AND slug IN ('harry-potter', 'disney', 'star-wars', 'lego') ORDER BY id";
    return mysqli_query($conn, $query);
}

function getCollectorsVaultProducts()
{
    global $conn;

    $query = "SELECT * 
              FROM products 
              WHERE category_id = 'Collectors Vault' 
              AND status='0' 
              ORDER BY id DESC LIMIT 4";

    return mysqli_query($conn, $query);
}

function getCartItems(){
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];
    // Εδώ ζητάμε σωστά και το p.is_preorder από τη βάση
    $query = "SELECT c.id as cid, c.prod_id, c.prod_qty, p.id as pid, p.name, p.item_image, p.selling_price, p.is_preorder FROM carts c, products p WHERE c.prod_id=p.id AND c.user_id='$userId' ORDER BY c.id DESC";
    return mysqli_query($conn, $query);
}

function getSlugActive($table, $slug)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE slug = '$slug' AND status='0' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    // Έλεγχος αν η ερώτηση εκτελείται σωστά
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }
    return $result;
}

function getProdByCategory($category_id)
{
    global $conn;
    // ΔΙΟΡΘΩΣΗ: Προσθήκη ORDER BY id DESC για να εμφανίζονται πρώτα οι νέες προσθήκες
    $query = "SELECT * FROM products WHERE category_id = '$category_id' AND status='0' ORDER BY id DESC";
    return mysqli_query($conn, $query);
}


function getIDActive($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table  WHERE id = '$id' AND status='0'";
    return mysqli_query($conn, $query);
}

function getOrders()
{
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];
    $query = "SELECT * FROM orders  WHERE user_id = '$userId' ORDER BY id DESC";
    return mysqli_query($conn, $query);
}

function redirect($url, $message = null)
{
    if ($message) {
        $_SESSION['message'] = $message;
    }
    header("Location: $url");
    exit(); // Make sure no further code is executed
}

function checkTrackingNoValid($trackingNo)
{
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];

    $query = "SELECT * FROM orders WHERE tracking_no='$trackingNo' AND user_id='$userId'";
    return mysqli_query($conn, $query);
}
