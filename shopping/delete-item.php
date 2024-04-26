<?php require_once "../includes/header.php";?>
<?php require_once "../config/init.php";?>

<?php

/* at the top of 'check.php' */
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /*
       Up to you which header to send, some prefer 404 even if
       the files does exist for security
    */
    die(header( 'location: '.APPURL.'' ));

}


if(isset($_SESSION['username']))
{
    header("Location: ".APPURL."");
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $delete = $db->prepare("DELETE FROM cart WHERE id = '$id'");
    $delete->execute();
}

?>

<?php require_once "../includes/footer.php";?><?php
