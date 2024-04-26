<?php
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

require_once "../includes/header.php";
require_once "../config/init.php";
require_once "../vendor/autoload.php";

if(isset($_POST['email'])) {
    Stripe::setApiKey('$secret_key');

    try {
        $charge = Charge::create([
            'source' => $_POST['stripeToken'],
            'amount' => $_SESSION['price'],
            'currency' => 'usd',
        ]);
    } catch (ApiErrorException $e) {
    }

    if(empty($_POST['password']) OR empty($_POST['email']) OR empty($_POST['fname']) OR empty($_POST['lname'])) {
        echo '<div class="alert alert-danger">Please fill in all fields</div>';
    } else {
        $email = $_POST['email'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $user_id = $_POST['user_id']; // Assuming user_id is stored in session
        $token = $_POST['stripeToken'];
        $username = $_POST['username'];
        $price = $_POST['price'];

        $insert = $db->prepare("INSERT INTO orders (email, username, fname, lname, token, price, userID) 
                        VALUES (:email, :username, :fname, :lname, :token, :price, :user_id)");

        $insert->execute([
            ':email' => $email,
            ':username' => $username,
            ':fname' => $fname,
            ':lname' => $lname,
            ':token' => $token,
            ':price' => $price,
            ':user_id' => $user_id,
        ]);

        header("Location: ". APPURL. "/download.php");
    }
}
require_once "../includes/footer.php";
