<?php require_once "../includes/header.php"; ?>
<?php require_once "../config/init.php"; ?>
<?php

$products = $db->query("SELECT * FROM cart WHERE userID = '$_SESSION[user_id]'");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);


if(isset($_POST['submit'])){
  $price = $_POST['price'];
  $_SESSION['price'] = $price;

  header("location: checkout.php");

}


?>


    <div class="row d-flex justify-content-center align-items-center h-100 mt-5 mt-5">
      <div class="col-12">
        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
          <div class="card-body p-0">
            <div class="row g-0">
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                  </div>


                  <table class="table" height="190" >
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Update</th>
                        <th scope="col"><button class="delete-all btn btn-danger text-white">Clear</button></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($allProducts) > 0) : ?>
                    <?php foreach ($allProducts as $product) : ?>
                      <tr class="mb-4">
                        <th scope="row"><?php echo $product->prodID; ?></th>
                        <td><img width="100" height="100"
                        src="../images/<?php echo $product->prodImg; ?>"
                        class="img-fluid rounded-3" alt="Cotton T-shirt">
                        </td>
                        <td><?php echo $product->prodName; ?></td>
                        <td class="pro_price"><?php echo $product->prodPrice; ?></td>
                        <td><input id="form1" min="1" name="quantity" value="<?php echo $product->prodAmount; ?>" type="number"
                        class="form-control form-control-sm pro_amount" /></td>
                        <td class="total_price"><?php echo $product->prodPrice * $product->prodAmount; ?></td>
                        <td><button value="<?php echo $product->id; ?>" class="btn-update btn btn-warning text-white"><i class="fas fa-pen"></i> </button></td>

                        <td><button value="<?php echo $product->id; ?>" class="btn-delete btn btn-danger text-white"><i class="fas fa-trash-alt"></i> </button></td>
                      </tr>
                    <?php endforeach;?>
                    <?php else :?>
                      <div class="alert alert-danger bg-danger text-white">
                        there are no products in cart
                      </div>
                    <?php endif;?>
                    </tbody>
                  </table>
                  <a href="<?php echo APPURL; ?>" class="btn btn-success text-white"><i class="fas fa-arrow-left"></i>  Continue Shopping</a>
                </div>
              </div>
              <div class="col-lg-4 bg-grey">
                <div class="p-5">
                  <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                  <hr class="my-4">

                  
                  <form method="post" action="cart.php">
                  <div class="d-flex justify-content-between mb-5">
                    <h5 class="text-uppercase">Total price</h5>
                    <h5 class="full_price"></h5>
                    <input type="text" name="price" class="inp_price" id="inp_price">
                  </div>

                  <button type="submit" name="submit" class="btn btn-dark btn-block btn-lg"
                    data-mdb-ripple-color="dark">Checkout</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
       
      </div>

    </div>
  </div>

<?php require_once "../includes/footer.php"; ?>

<script>
  $(document).ready(function() {

    $(".pro_amount").mouseup(function () {

      const $el = $(this).closest('tr');


      const prodAmount = $el.find(".pro_amount").val();
      const pro_price = $el.find(".pro_price").html();

      const total = prodAmount * pro_price;
      $el.find(".total_price").html("");

      $el.find(".total_price").append(total+'$');

      $(".btn-update").on('click', function(e) {

        const id = $(this).val();


        $.ajax({
          type: "POST",
          url: "update-item.php",
          data: {
            update: "update",
            id: id,
            prodAmount: prodAmount
          },

          success: function() {
            // alert("done");
            reload();
          }
        })
      });



      fetch();
    });


    $(".btn-delete").on('click', function(e) {

      const id = $(this).val();


      $.ajax({
        type: "POST",
        url: "delete-item.php",
        data: {
          delete: "delete",
          id: id
        },

        success: function() {
          alert("product deleted successfully");
          reload();
        }
      })
    });

    $(".delete-all").on('click', function(e) {

      const id = $(this).val();


      $.ajax({
        type: "POST",
        url: "delete-all-item.php",
        data: {
          delete: "delete",
        },

        success: function() {
          alert("all products deleted successfully");
          reload();
        }
      })
    });


    fetch();

    function fetch() {

      setInterval(function () {
        let sum = 0.0;
        $('.total_price').each(function()
        {
          sum += parseFloat($(this).text());
        });
        $(".full_price").html(sum+"$");
        $(".inp_price").val(sum);
      }, 4000);
    }

    function reload() {


      $("body").load("cart.php")

    }

  });
</script>
