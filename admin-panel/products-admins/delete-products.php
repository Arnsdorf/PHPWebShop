<?php require "../layouts/header.php"?>
<?php require "../../config/init.php"?>

<?php

if (isset($_GET['id'])) {
    $prodID = $_GET['id'];

    $select = $db->prepare("SELECT * FROM products WHERE prodID = :prodID");
    $select->execute(array(':prodID' => $prodID));

    $product = $select->fetch(PDO::FETCH_OBJ);

    if($product) {
        // Slet billedet, hvis det eksisterer
        $image_path = "../images/" . $product->prodImg;
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Slet produktet fra databasen
        $delete = $db->prepare("DELETE FROM products WHERE prodID = :prodID");
        $delete->execute(array(':prodID' => $prodID));

        header("location: ".ADMINURL."/products-admins/show-products.php");
        exit(); // Stop script execution after redirecting
    } else {
        header("location: ".ADMINURL."/404.php");
        exit(); // Stop script execution after redirecting
    }
} else {
    header("location: ".ADMINURL."/products-admins/show-products.php");
    exit(); // Stop script execution after redirecting
}


?>


