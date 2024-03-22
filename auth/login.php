<?php require_once "../includes/header.php"?>
<?php require_once "../config/init.php"?>

<?php

if(isset($_SESSION['username']))
{
    header("Location: ".APPURL."");
}

if(isset($_POST['submit']))
{
    if(empty($_POST['password']) || empty($_POST['email']))
    {
        echo '<div class="alert alert-danger">Please fill in all fields</div>';
    } else {

        $password = $_POST['password'];
        $email = $_POST['email'];

        $login = $db->query("SELECT * FROM users WHERE email = '$email'");
        $login->execute();

        $fetch = $login->fetch(PDO::FETCH_ASSOC);

        if($login->rowCount() > 0){
            if(password_verify($password, $fetch['password'])) {
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['user_id'] = $fetch['userID'];
                header("location: ".APPURL."");
            }else {
                echo '<div class="alert alert-danger">Wrong password</div>';
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form class="form-control mt-5" action="login.php" method="POST">
            <h4 class="text-center mt-3">Login</h4>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail">
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword">
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-4" type="submit" name="submit">Login</button>
        </form>
    </div>
</div>

<?php require_once "../includes/footer.php"?>
