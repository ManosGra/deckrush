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
            AND slug IN ('magic-the-gathering', 'disney', 'riftbound', 'lego') ORDER BY id";
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

function getCartItems()
{
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

function getProdByCategory($category_id, $limit = null, $offset = null)
{
    global $conn;

    $category_id = mysqli_real_escape_string($conn, $category_id);

    $query = "SELECT * FROM products 
              WHERE category_id = '$category_id'
              AND status='0'
              ORDER BY id DESC";

    if ($limit !== null && $offset !== null) {
        $query .= " LIMIT $limit OFFSET $offset";
    }

    return mysqli_query($conn, $query);
}


function getProdCountByCategory($category_id)
{
    global $conn;

    $category_id = mysqli_real_escape_string($conn, $category_id);

    $query = "SELECT COUNT(*) AS total
              FROM products
              WHERE category_id='$category_id'
              AND status='0'";

    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_assoc($result);

    return $data['total'];
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

function getRelatedProducts($category_id, $product_id)
{
    global $conn;
    $product_id = (int)$product_id;
    
    $q = mysqli_query($conn, "SELECT name, category_id FROM products WHERE id = $product_id LIMIT 1");
    $curr = mysqli_fetch_assoc($q);
    if(!$curr) return [];
    
    $curr_name = $curr['name'];
    $curr_cat = $curr['category_id'];
    $low = strtolower(trim($curr_cat));

    $is_singles = (strpos($low, 'single') !== false || $curr_cat == 105);
    $is_vault = (strpos($low, 'vault') !== false || $curr_cat == 113);
    $is_onepiece = (strpos($low, 'one piece') !== false || strpos($low, 'one-piece') !== false || stripos($curr_name, 'one piece') !== false);
    $is_pokemon = (stripos($curr_name, 'pokemon') !== false);

    $products = [];
    $exclude = [$product_id];

    // 1. SINGLES / VAULT / ONE PIECE -> ΜΟΝΟ ΙΔΙΑ ΚΑΤΗΓΟΡΙΑ / ΙΔΙΟ FRANCHISE
    if ($is_singles || $is_vault) {
        $cat_esc = mysqli_real_escape_string($conn, $curr_cat);
        $ex = implode(',', $exclude);
        $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND category_id='$cat_esc' ORDER BY id DESC LIMIT 4");
        while($r=mysqli_fetch_assoc($res)) $products[]=$r;
        return $products;
    }

    if ($is_onepiece) {
        // 1 από ίδια κατηγορία One Piece
        $ex = implode(',', $exclude);
        $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND LOWER(category_id) LIKE '%one piece%' ORDER BY id DESC LIMIT 1");
        while($r=mysqli_fetch_assoc($res)){ $products[$r['id']]=$r; $exclude[]=$r['id']; }

        // 3 Pre-Orders ΜΟΝΟ One Piece
        $ex = implode(',', array_map('intval', $exclude));
        $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND (category_id=108 OR LOWER(category_id) LIKE '%pre-order%') AND LOWER(name) LIKE '%one piece%' ORDER BY id DESC LIMIT 3");
        while($r=mysqli_fetch_assoc($res)){ $products[$r['id']]=$r; $exclude[]=$r['id']; }

        // Αν δεν έχει άλλα, συμπλήρωσε ΜΟΝΟ από One Piece κατηγορία, ΟΧΙ Pokemon
        if(count($products) < 4){
            $ex = implode(',', array_map('intval', $exclude));
            $needed = 4 - count($products);
            $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND LOWER(category_id) LIKE '%one piece%' ORDER BY id DESC LIMIT $needed");
            while($r=mysqli_fetch_assoc($res)) $products[$r['id']]=$r;
        }
        return array_values($products);
    }

    // 2. POKEMON -> 3 PRE-ORDERS POKEMON + 1 POKEMON TCG
    if ($is_pokemon) {
        $ex = implode(',', $exclude);
        $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND (category_id=108 OR LOWER(category_id) LIKE '%pre-order%') AND LOWER(name) LIKE '%pokemon%' ORDER BY id DESC LIMIT 3");
        while($r=mysqli_fetch_assoc($res)){ $products[$r['id']]=$r; $exclude[]=$r['id']; }

        $ex = implode(',', array_map('intval', $exclude));
        $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND LOWER(category_id) LIKE '%pokemon%' AND LOWER(category_id) NOT LIKE '%pre-order%' AND LOWER(name) NOT LIKE '%booster pack%' ORDER BY id DESC LIMIT 1");
        while($r=mysqli_fetch_assoc($res)){ $products[$r['id']]=$r; $exclude[]=$r['id']; }

        return array_values($products);
    }

    // 3. OLES OI ALLES
    $cat_esc = mysqli_real_escape_string($conn, $curr_cat);
    $ex = implode(',', $exclude);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE status='0' AND id NOT IN ($ex) AND category_id='$cat_esc' ORDER BY id DESC LIMIT 4");
    while($r=mysqli_fetch_assoc($res)) $products[]=$r;

    return array_values($products);
}