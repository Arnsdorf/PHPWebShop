<?php require_once "../includes/header.php";?>
<?php require_once "../config/init.php";?>

<?php

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $prodAmount = $_POST['prodAmount'];

    $update = $db->prepare("UPDATE cart SET prodAmount = '$prodAmount' WHERE id = '$id'");
    $update->execute();
}

?>

<?php require_once "../includes/footer.php";?>