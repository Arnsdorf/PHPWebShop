<?php require_once "../includes/header.php";?>
<?php require_once "../config/init.php";?>

<?php

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $delete = $db->prepare("DELETE FROM cart WHERE id = '$id'");
    $delete->execute();
}

?>

<?php require_once "../includes/footer.php";?><?php
