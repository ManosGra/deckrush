<?php
session_start();

include '../config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';


function redirectWithMessage($message, $location = '../login-register')
{
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}


/* =========================================================
   REGISTER
========================================================= */

if (isset($_POST['register_btn'])) {

    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $default_role = '0';

    // Secure activation token
    $activation_token = bin2hex(random_bytes(32));


    // Check email
    $stmt = $conn->prepare(
        "SELECT user_email FROM user WHERE user_email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {

        $_SESSION['message'] = "Αυτό το email χρησιμοποιείται ήδη.";
        header('Location: ../login-register');
        exit();
    }


    if ($password !== $cpassword) {

        $_SESSION['message'] = "Οι κωδικοί δεν ταιριάζουν.";
        header('Location: ../login-register');
        exit();
    }


    // Hash password
    $hashed_password = password_hash(
        $password,
        PASSWORD_BCRYPT
    );


    // Insert user
    $stmt = $conn->prepare(
        "INSERT INTO user
        (username, user_email, user_password, user_role, activation_token)
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssss",
        $name,
        $email,
        $hashed_password,
        $default_role,
        $activation_token
    );


    if ($stmt->execute()) {


        /* =====================================================
           ACTIVATION LINK
        ===================================================== */

        $protocol = (
            isset($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] === 'on'
        ) ? "https" : "http";


        $base_url =
            $protocol . "://" . $_SERVER['HTTP_HOST'];


        $activation_link =
            $base_url . "/activate?token=" .
            $activation_token;


        /* =====================================================
           PAPERCUT / PHPMailer
        ===================================================== */

        $mail = new PHPMailer(true);


        try {

            $mail->isSMTP();

            $mail->Host = 'localhost';
            $mail->SMTPAuth = false;
            $mail->Port = 25;


            $mail->setFrom(
                'noreply@deckrush.local',
                'DeckRush Local'
            );


            $mail->addAddress(
                $email,
                $name
            );


            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';


            $mail->Subject =
                'Ενεργοποίηση Λογαριασμού';


            /* =================================================
               HTML EMAIL TEMPLATE
            ================================================= */

            $mail->Body = <<<EOD
<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeckRush.gr Activation</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f5f5f5;
    font-family:Arial,Helvetica,sans-serif;
">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="background:#f5f5f5;padding:40px 15px;"
>

    <tr>
        <td align="center">

            <table
                width="600"
                cellpadding="0"
                cellspacing="0"
                style="
                    max-width:600px;
                    background:#ffffff;
                    border-radius:12px;
                    overflow:hidden;
                    box-shadow:0 5px 20px rgba(0,0,0,.08);
                "
            >

                <!-- HEADER -->

                <tr>
                    <td
                        align="center"
                        style="
                            background:#0b1e3d;
                            padding:15px;
                        "
                    >

                        <img
                            src="https://deckrush.gr/assets/logo2.png"
                            alt="DeckRush"
                            style="
                                max-width:180px;
                                display:block;
                            "
                        >

                    </td>
                </tr>


                <!-- CONTENT -->

                <tr>
                    <td
                        style="
                            padding:40px;
                            color:#333;
                        "
                    >

                        <h2
                            style="
                                margin-top:0;
                                color:#0d6efd;
                                text-align:center;
                            "
                        >
                            Καλώς ορίσατε στο DeckRush!
                        </h2>


                        <p
                            style="
                                font-size:16px;
                                line-height:1.7;
                            "
                        >
                            Παρακαλώ κάντε κλικ στο παρακάτω σύνδεσμο
                            για να ενεργοποιήσετε το λογαριασμό σας:
                        </p>


                        <!-- ACTIVATION BUTTON -->

                        <table
                            width="100%"
                            cellpadding="15"
                            cellspacing="0"
                            style="
                                background:#f8f9fa;
                                border-radius:8px;
                                margin:25px 0;
                                text-align:center;
                            "
                        >

                            <tr>
                                <td align="center">

                                    <a
                                        href="{$activation_link}"
                                        style="
                                            background:#0d6efd;
                                            color:#ffffff;
                                            padding:12px 25px;
                                            text-decoration:none;
                                            border-radius:5px;
                                            display:inline-block;
                                            font-size:16px;
                                            font-weight:bold;
                                        "
                                    >
                                        Ενεργοποίηση Λογαριασμού
                                    </a>

                                </td>
                            </tr>

                        </table>


                        <p
                            style="
                                font-size:16px;
                                line-height:1.7;
                            "
                        >
                            Αν το κουμπί δεν λειτουργεί,
                            αντιγράψτε αυτό το link στον browser σας:
                            <br><br>

                            <span
                                style="
                                    color:#0d6efd;
                                    word-break:break-all;
                                "
                            >
                                {$activation_link}
                            </span>

                        </p>


                        <p
                            style="
                                font-size:16px;
                                line-height:1.7;
                                margin-bottom:0;
                            "
                        >
                            Με εκτίμηση,<br>

                            <strong>
                                Η ομάδα του DeckRush.gr
                            </strong>
                        </p>

                    </td>
                </tr>


                <!-- FOOTER -->

                <tr>
                    <td
                        align="center"
                        style="
                            background:#f1f3f5;
                            padding:20px;
                            font-size:13px;
                            color:#777;
                        "
                    >
                        © DeckRush.gr
                    </td>
                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>
EOD;


            $mail->send();


            $_SESSION['message'] =
                "Επιτυχής εγγραφή! (Τοπικό Email)";


        } catch (Exception $e) {

            $_SESSION['message'] =
                "Σφάλμα τοπικού SMTP: {$mail->ErrorInfo}";
        }


        header('Location: ../login-register');
        exit();


    } else {

        $_SESSION['message'] =
            "Κάτι πήγε στραβά: " . $stmt->error;

        header('Location: ../login-register');
        exit();
    }
}


/* =========================================================
   LOGIN
========================================================= */

if (isset($_POST['login_btn'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $stmt = $conn->prepare(
        "SELECT * FROM user WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        $userdata = $result->fetch_assoc();


        if (password_verify(
            $password,
            $userdata['user_password']
        )) {


            if ($userdata['user_status'] == 0) {

                redirectWithMessage(
                    "Ο λογαριασμός σας δεν έχει ενεργοποιηθεί ακόμα. Παρακαλώ ελέγξτε το email σας για τον σύνδεσμο ενεργοποίησης."
                );
            }


            $_SESSION['auth'] = true;


            $_SESSION['auth_user'] = [
                'user_id' => $userdata['user_id'],
                'username' => $userdata['username'],
                'email' => $userdata['user_email']
            ];


            $_SESSION['user_role'] =
                $userdata['user_role'];


            if ($userdata['user_role'] == '1') {

                redirectWithMessage(
                    "Καλώς ήρθατε στον Πίνακα Ελέγχου",
                    '../administration/index.php'
                );

            } else {

                redirectWithMessage(
                    "Σύνδεση με επιτυχία",
                    '../my-account'
                );
            }


        } else {

            redirectWithMessage(
                "Μη έγκυρες διαπιστεύσεις"
            );
        }


    } else {

        redirectWithMessage(
            "Μη έγκυρο όνομα χρήστη"
        );
    }


    $stmt->close();
}


$conn->close();

?> 