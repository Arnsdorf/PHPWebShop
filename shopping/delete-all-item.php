<?php require_once "../includes/header.php";?>
<?php require_once "../config/init.php";?>

<?php

if (isset($_POST['delete'])) {

    $delete = $db->prepare("DELETE FROM cart WHERE userID = '$_SESSION[user_id]'");
    $delete->execute();
}

?>

<?php require_once "../includes/footer.php";?>

