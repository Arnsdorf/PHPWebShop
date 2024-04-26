<?php require_once "includes/header.php"; ?>
<?php require_once "config/init.php"; ?>
<?php

$select = $db->query("SELECT * FROM cart WHERE user_id='$_GET[user_id]'");
$select->execute();
$allProducts = $select->fetchAll(PDO::FETCH_OBJ);

$zipname = 'sigurd.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($allProducts as $product) {
    $zip->addFile("books/" . $product->prodFile);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
readfile($zipname);


$select = $db->query("DELETE FROM cart WHERE user_id='$_GET[user_id]'");
$select->execute();

header('location: index.php');
