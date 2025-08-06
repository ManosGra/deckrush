
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
            AND slug IN ('pokemon', 'sports', 'funko-pop', 'onepiece') ORDER BY id";
    return mysqli_query($conn, $query);
}

function getCartItems(){
    global $conn;
    $userId = $_SESSION['auth_user']['user_id'];
    $query = "SELECT c.id as cid, c.prod_id, c.prod_qty, p.id as pid, p.name, p.item_image, p.selling_price FROM carts c, products p WHERE c.prod_id=p.id AND c.user_id='$userId' ORDER BY c.id DESC";
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
    $query = "SELECT * FROM products  WHERE category_id = '$category_id' AND status='0'";
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