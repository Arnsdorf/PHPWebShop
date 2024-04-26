<?php require "../layouts/header.php"?>
<?php require "../../config/init.php"?>

<?php

if(!isset($_SESSION['adminname'])) {
    header("Location: ".ADMINURL."");
}

if(isset($_POST['submit'])) {
    if(empty($_POST['adminname']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo "<script>alert('Please fill in all fields');</script>";
    } else {
        $adminname = $_POST['adminname'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $insert = $db->prepare("INSERT INTO admins (adminname, password, email) VALUES (:adminname, :password, :email)");

        $insert->execute([
            ':adminname' => $adminname,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':email' => $email,
        ]);


        header("Location: ".ADMINURL."/admins/admins.php");
    }
}

?>





       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="create-admins.php">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" />
                 
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="username" />
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" />
                </div>

                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
       </div>
<?php require "../layouts/footer.php"?>
