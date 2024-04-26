<?php
require_once "../includes/header.php";
require_once "../config/init.php";

// Funktion til at validere og gemme uploadede billeder
function uploadImage($file) {
    $upload_dir = "../uploads/"; // Stien til mappen, hvor billedet skal gemmes

    // Håndter profilbillede, hvis det blev uploadet
    if (!empty($file["tmp_name"])) {
        $profile_image = basename($file["name"]); // Kun filnavn
        $upload_file = $upload_dir . $profile_image; // Fuld sti til det uploadede billede

        // Kontroller om filen allerede eksisterer
        if (file_exists($upload_file)) {
            echo '<div class="alert alert-danger">Filen eksisterer allerede.</div>';
            return false;
        }

        // Forsøg at flytte den uploadede fil til det angivne upload-dir
        if (!move_uploaded_file($file["tmp_name"], $upload_file)) {
            echo '<div class="alert alert-danger">Der opstod en fejl under upload af filen.</div>';
            return false;
        }
    }

    return $profile_image; // Returnér kun filnavnet
}

if(isset($_SESSION['username'])) {
    header("Location: ".APPURL."");
}

if(isset($_POST['submit'])) {
    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo "<script>alert('Please fill in all fields');</script>";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Håndter profilbillede, hvis det blev uploadet
        $profile_image = uploadImage($_FILES['profile_image']);
        if(!$profile_image) {
            // Fejl ved upload af billede
            exit;
        }

        $insert = $db->prepare("INSERT INTO users (username, password, email, profile_image) VALUES (:username, :password, :email, :profile_image)");

        $insert->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':email' => $email,
            ':profile_image' => (!empty($_FILES["profile_image"]["tmp_name"])) ? $_FILES["profile_image"]["name"] : NULL
        ]);


        header("Location: login.php");
    }
}

?>
<!-- Din eksisterende HTML-formular med tilføjelsen af input-feltet til profilbillede -->
<div class="row justify-content-center">
    <div class="col-md-6">
        <form class="form-control mt-5" method="post" action="register.php" enctype="multipart/form-data">
            <h4 class="text-center mt-3"> Register </h4>
            <div class="">
                <label for="" class="col-sm-2 col-form-label">Username</label>
                <div class="">
                    <input type="text" name="username" class="form-control" id="" value="">
                    <?php if(isset($errors['username'])) { echo "<div class='text-danger'>".$errors['username']."</div>"; } ?>
                </div>
            </div>
            <div class="">
                <label for="staticEmail"  class="col-sm-2 col-form-label">Email</label>
                <div class="">
                    <input type="email" name="email" class="form-control" id="" value="">
                    <?php if(isset($errors['email'])) { echo "<div class='text-danger'>".$errors['email']."</div>"; } ?>
                </div>
            </div>
            <div class="">
                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                <div class="">
                    <input type="password" name="password" class="form-control" id="inputPassword">
                    <?php if(isset($errors['password'])) { echo "<div class='text-danger'>".$errors['password']."</div>"; } ?>
                </div>
            </div>
            <!-- Input-felt til at uploade et profilbillede -->
            <div class="form-group">
                <label for="profile_image">Vælg profilbillede:</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>
            <button name="submit" class="w-100 btn btn-lg btn-primary mt-4 mb-4" type="submit">register</button>
        </form>
    </div>
</div>

<?php require_once "../includes/footer.php"?>
