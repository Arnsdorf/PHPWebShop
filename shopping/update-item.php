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

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $prodAmount = $_POST['prodAmount'];

    $update = $db->prepare("UPDATE cart SET prodAmount = '$prodAmount' WHERE id = '$id'");
    $update->execute();
}

?>

<?php require_once "../includes/footer.php";?>