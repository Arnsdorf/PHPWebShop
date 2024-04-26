<?php require "../layouts/header.php"?>
<?php require "../../config/init.php"?>

<?php

$select = $db->query("SELECT * FROM products");
$select->execute();


$products = $select->fetchAll(PDO::FETCH_OBJ);

?>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Products</h5>
                    <a href="<?php echo ADMINURL;?>/products-admins/create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price in $$</th>
                            <th scope="col">Status</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <th scope="row"><?php echo $product->prodID; ?></th>
                                <td><?php echo $product->prodName; ?></td>
                                <td><?php echo $product->prodPrice; ?></td>
                                <td><a href="#" class="btn btn-success  text-center">Verified</a></td>
                                <td><a href="<?php echo ADMINURL;?>/products-admins/delete-products.php?id=<?php echo $product->prodID; ?>" class="btn btn-danger  text-center">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<?php require "../layouts/footer.php"?>