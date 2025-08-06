<?php 

if(!isset($_SESSION['auth'])){
    redirect("login-register.php", "Login to continue");
}
