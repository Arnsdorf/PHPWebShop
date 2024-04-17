<?php


require_once "../includes/header.php";
require_once "../config/init.php";

if (isset($_POST['submit'])) {
    $prodID = $_POST['prodID'];
    $prodName = $_POST['prodName'];
    $prodPrice = $_POST['prodPrice'];
    $prodImg = $_POST['prodImg'];
    $prodFile = $_POST['prodFile'];
    $prodAmount = $_POST['prodAmount'];
    $userID = $_POST['userID'];

    $insert = $db->prepare("INSERT INTO cart (prodID, prodName, prodPrice, prodImg, prodFile, prodAmount, userID)
                                    VALUES(:prodID, :prodName, :prodPrice, :prodImg, :prodFile, :prodAmount, :userID)");

    $insert->execute([
        ':prodID' => $prodID,
        ':prodName' => $prodName,
        ':prodPrice' => $prodPrice,
        ':prodImg' => $prodImg,
        ':prodFile' => $prodFile,
        ':prodAmount' => $prodAmount,
        ':userID' => $userID
        ]);

    header("Location: ". APPURL. "register.php");
}

if(isset($_GET['id'])){
    $prodID = $_GET['id'];

    if (isset($_SESSION['user_id'])){
        $select = $db->query("SELECT * FROM cart WHERE prodID = '$prodID' AND userID = '$_SESSION[user_id]'");
        $select->execute();
    }


    $row = $db->query("SELECT * FROM products WHERE prodStatus = 1 AND prodID='$prodID'");
    $product = $row->fetch(PDO::FETCH_OBJ);
    if(!$product){
        echo "404"; // Produktet blev ikke fundet
    }
} else {
    echo "404"; // Ingen produkt-id blev angivet i URL'en
}
?>

<div class="row mt-5 d-flex justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div class="images p-3">
                        <div class="text-center p-4"> <img id="main-image" alt="prod image" src="../images/<?php echo $product->prodImg; ?>" width="250" /> </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center"> <a href="<?php echo APPURL; ?>" class="ml-1 btn btn-primary"><i class="fa fa-long-arrow-left"></i> Back</a> </div> <i class="fa fa-shopping-cart text-muted"></i>
                        </div>
                        <div class="mt-4 mb-3">
                            <h5 class="text-uppercase"><?php echo $product->prodName; ?></h5>
                            <div class="price d-flex flex-row align-items-center"> <span class="act-price">$<?php echo $product->prodPrice; ?></span>
                            </div>
                        </div>
                        <p class="about"><?php echo $product->prodDescription; ?></p>
                        <form method="post" id="form-data">
                            <div class="">
                                <input type="hidden" name="prodID" value="<?php echo $product->prodID; ?>" class="form-control">
                            </div>
                            <div class="">
                                <input type="hidden" name="prodName" value="<?php echo $product->prodName; ?>" class="form-control">
                            </div>
                            <div class="">
                                <input type="hidden" name="prodImg" value="<?php echo $product->prodImg; ?>" class="form-control">
                            </div>
                            <div class="">
                                <input type="hidden" name="prodPrice" value="<?php echo $product->prodPrice; ?>" class="form-control">
                            </div>
                            <div class="">
                                <input type="hidden" name="prodAmount" value="1" class="form-control">
                            </div>
                            <div class="">
                                <input type="hidden" name="prodFile" value="<?php echo $product->prodFile; ?>" class="form-control">
                            </div>
                            <?php if(isset($_SESSION['user_id'])) : ?>
                            <div class="">
                                <input type="hidden" name="userID" value="<?php echo $_SESSION['user_id']; ?>" class="form-control">
                            </div>
                            <?php endif;?>
                            <div class="cart mt-4 align-items-center">
                                <?php if (isset($_SESSION['user_id'])) : ?>
                                    <?php if ($select->rowCount() > 0) : ?>
                                        <button id="submit" name="submit" type="submit" disabled class="btn btn-primary text-uppercase mr-2 px-4"><i class="fas fa-shopping-cart"></i> Added to cart</button>
                                    <?php else :?>
                                    <button id="submit" name="submit" type="submit" class="btn btn-primary text-uppercase mr-2 px-4"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php";?>

<script>

    $(document).ready(function(){
        $("#form-data").on("submit", function (e) {
            e.preventDefault(); // Prevent the default form submission
            const formdata = $('#form-data').serialize() + '&submit=submit';  // Serialize the form data
            $.ajax({
                type: "POST",
                url: "single.php?=<?php echo $prodID;?>",
                data: formdata,
                success: function () {
                    alert("Added to cart");
                    $("#submit").html("<i class='fas fa-shopping-cart'></i> Added to cart").prop("disabled", true);
                    ref();
                },
            });

                function ref() {


                    $("body").load("single.php?id=<?php echo $prodID;?>");

                }
        });
    });


</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("form-data").addEventListener("submit", function(event) {
            event.preventDefault(); // Forhindrer standardformularafsendelse
            const formData = new FormData(this); // Serializer formdata
            const url = "single.php?id=<?php echo $prodID;?>"; // Konstruer URL'en til AJAX-anmodningen

            const xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Anmodningen var vellykket
                    alert("Tilføjet til indkøbskurv");
                    document.getElementById("submit").innerHTML = "<i class='fas fa-shopping-cart'></i> Added to cart";
                    document.getElementById("submit").disabled = true;
                    // Kald ref funktionen for at genindlæse siden
                    ref();
                }
            };
            xhr.send(formData);
        });
    });

    function ref() {
        // Opret en XMLHttpRequest-objekt
        var xhr = new XMLHttpRequest();

        // Angiv URL'en, du vil indlæse
        var url = "single.php?id=<?php echo $prodID;?>";

        // Åbn en GET-anmodning til den specificerede URL
        xhr.open("GET", url, true);

        // Lyt efter ændringer i anmodningens status
        xhr.onreadystatechange = function() {
            // Hvis anmodningen er afsluttet og svaret er OK
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Erstat indholdet af body-elementet med svaret fra serveren
                document.body.innerHTML = xhr.responseText;
            }
        };

        // Send anmodningen
        xhr.send();
    }
</script>

