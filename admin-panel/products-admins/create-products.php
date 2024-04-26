<?php
require "../layouts/header.php";
require "../../config/init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tjek om alle nødvendige felter er udfyldt
    if (isset($_POST['prodName'], $_POST['prodPrice'], $_POST['prodDescription'], $_FILES['prodImg']['name'], $_FILES['prodFile']['name'])) {
        // Få formdata
        $prodName = $_POST['prodName'];
        $prodPrice = $_POST['prodPrice'];
        $prodDescription = $_POST['prodDescription'];

        // Håndter billedeupload
        $image = $_FILES['prodImg']['name'];
        $image_tmp = $_FILES['prodImg']['tmp_name'];

        // Håndter filupload
        $file = $_FILES['prodFile']['name'];
        $file_tmp = $_FILES['prodFile']['tmp_name'];

        // Flyt billede til destinationsmappe
        move_uploaded_file($image_tmp, "../../images/$image");

        // Flyt fil til destinationsmappe
        move_uploaded_file($file_tmp, "../../books/$file");

        // Indsæt produkt i databasen
        $insert = $db->prepare("INSERT INTO products (prodName, prodPrice, prodDescription, prodImg, prodFile) VALUES (:prodName, :prodPrice, :prodDescription, :prodImg, :prodFile)");
        $insert->execute(array(
            ':prodName' => $prodName,
            ':prodPrice' => $prodPrice,
            ':prodDescription' => $prodDescription,
            ':prodImg' => $image,
            ':prodFile' => $file
        ));

        // Omdiriger tilbage til oversigten over produkter
        header("Location: ".ADMINURL."/products-admins/show-products.php");
        exit;
    } else {
        // Hvis der mangler nogle felter, kan du vise en fejlmeddelelse
        $error_message = "Alle felter skal udfyldes, og der skal uploades både et billede og en fil.";
    }
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Create Products</h5>
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-outline mb-4 mt-4">
                        <label>Name</label>
                        <input type="text" name="prodName" class="form-control" placeholder="Name" required>
                    </div>

                    <div class="form-outline mb-4 mt-4">
                        <label>Price</label>
                        <input type="text" name="prodPrice" class="form-control" placeholder="Price" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea name="prodDescription" class="form-control" placeholder="Description" rows="3" required></textarea>
                    </div>

                    <div class="form-outline mb-4 mt-4">
                        <label>Image</label>
                        <input type="file" name="prodImg" class="form-control" required>
                    </div>

                    <div class="form-outline mb-4 mt-4">
                        <label>File</label>
                        <input type="file" name="prodFile" class="form-control" required>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"?>
