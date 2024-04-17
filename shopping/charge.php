<?php use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

require_once "../includes/header.php"; ?>
<?php require_once "../config/init.php"; ?>
<?php require_once "../vendor/autoload.php"; ?>

<?php



Stripe::setApiKey('$secret_key');


try {
    $charge = Charge::create([

        'source' => $_POST['stripeToken'],

        'amount' => $_SESSION['price'] * 100,
        'currency' => 'usd',

    ]);
} catch (ApiErrorException $e) {
}

echo "paid";