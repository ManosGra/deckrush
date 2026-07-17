<?php include __DIR__ . '/../config/db.php';
function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    return mysqli_query($conn, $query);
}

function getById($table, $id)
{
    global $conn;
    $query = "SELECT * FROM $table  WHERE id = '$id'";
    return mysqli_query($conn, $query);
}

function redirect($url, $message = null)
{
    if ($message) {
        session_start();
        $_SESSION['message'] = $message;
    }
    header("Location: $url");
    exit(); // Make sure no further code is executed
}

function getAllOrders()
{
    global $conn;
    $query = "SELECT * FROM orders WHERE status ='0'";
    return mysqli_query($conn, $query);
}

function getAvailability()
{
    global $conn;
    $query = "SELECT * FROM products WHERE is_coming_soon ='0'";
    return mysqli_query($conn, $query);
}

function getOrderHistory()
{
    global $conn;
    $query = "SELECT * FROM orders WHERE status !='0'";
    return mysqli_query($conn, $query);
}

function checkTrackingNoValid($trackingNo)
{
    global $conn;

    $query = "SELECT * FROM orders WHERE tracking_no='$trackingNo'";
    return mysqli_query($conn, $query);
}


function sendEmail($to, $subject, $message)
{
    $headers = "From: DeckRush <info@deckrush.gr>\r\n";
    $headers .= "Reply-To: info@deckrush.gr\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($to, $subject, $message, $headers);
}
function getEmailTemplate($file, $data = [])
{
    $message = file_get_contents($file);

    foreach ($data as $key => $value) {
        $message = str_replace(
            "{{".$key."}}",
            $value,
            $message
        );
    }

    return $message;
}