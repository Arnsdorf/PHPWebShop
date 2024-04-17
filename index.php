<?php require "includes/header.php";?>
<?php require "config/init.php";?>
<?php

$rows = $db->query("SELECT * FROM products WHERE prodStatus = 1");
$rows->execute();

$allRows = $rows->fetchAll(PDO::FETCH_OBJ);

// Tjek om brugeren er logget ind
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Hvis brugeren ikke er logget ind, kan du sætte en standardværdi
    $username = "Gæst";
}

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="welcome-section">
                <h2 class="text-center mb-4">Velkommen <?php echo $username; ?></h2>
                <p class="text-center">Opdag ny viden hver dag med vores daglige kodningskurser! Uanset om du er en nybegynder eller en erfaren udvikler, tilbyder vi en bred vifte af kurser, der dækker alt fra grundlæggende koncepter til avancerede teknologier.</p>
                <p class="text-center">Tilmeld dig i dag og begynd din rejse mod kodningsmesterskab! Ny viden venter på dig hver dag.</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <?php foreach($allRows as $product) : ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img class="card-img-top" src="images/<?php echo $product->prodImg; ?>" alt="product">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product->prodName; ?></h5>
                        <p class="card-text"><?php echo substr($product->prodDescription, 0, 120). '...';?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">$<?php echo $product->prodPrice; ?>/item</div>
                            <a href="<?php echo APPURL;?>/shopping/single.php?id=<?php echo $product->prodID; ?>" class="btn btn-primary">More <i class="fas fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once "includes/footer.php";?>
