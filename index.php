<?php require "includes/header.php";?>
<?php require "config/init.php";?>
<?php

$rows = $db->query("SELECT * FROM products WHERE prodStatus = 1");
$rows->execute();

$allRows = $rows->fetchAll(PDO::FETCH_OBJ);

// Tjek om brugeren er logget ind
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $welcomeMessage = "Welcome back $username";
} else {
    // Hvis brugeren ikke er logget ind, kan du sætte en standardværdi
    $welcomeMessage = "Welcome to CodeLearner";
}

?>

<style>
    .card-img-top {
        height: 250px;
        object-fit: cover;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="welcome-section">
                <h2 class="text-center mb-4"><?php echo $welcomeMessage; ?></h2>
                <p class="text-center">Discover new knowledge every day with our daily coding courses! Whether you're a beginner or an experienced developer, we offer a wide range of courses covering everything from basic concepts to advanced technologies.</p>
                <p class="text-center">Sign up today and start your journey towards coding mastery! New knowledge awaits you every day.</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <?php foreach($allRows as $product) : ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top img-fluid" src="images/<?php echo $product->prodImg; ?>" alt="product">
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
