<?php
require_once "includes/header.php";
require_once "config/init.php";

// Sikre adgang til profilsiden
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit; // Stop udførelse for at forhindre videre kørsel af koden
}

$user_id = $_SESSION['user_id']; // Brug den gemte bruger-ID fra sessionen

// Hent brugeroplysninger baseret på brugerens id
$profile_query = $db->prepare("SELECT * FROM users WHERE userID = ?");
$profile_query->execute([$user_id]);
$profile_data = $profile_query->fetch(PDO::FETCH_ASSOC);

if(!$profile_data || !is_array($profile_data)) {
    echo "Brugeren blev ikke fundet.";
    exit; // Stop udførelse
}

?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Profiloplysninger</h4>
                <?php if(!empty($profile_data['profile_image'])): ?>
                    <img class="card-img-top" src="uploads/<?php echo $profile_data['profile_image']; ?>" alt="profile" style="width: 200px; height: auto;">
                <?php else: ?>
                    <p class="text-center">Billede ikke tilgængeligt</p>
                <?php endif; ?>
                <div class="mt-4">
                    <p class="card-text"><strong>Brugernavn:</strong> <?php echo $profile_data['username']; ?></p>
                    <p class="card-text"><strong>Email:</strong> <?php echo $profile_data['email']; ?></p>
                    <!-- Tilføj andre brugeroplysninger, som du ønsker at vise -->
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once "includes/footer.php"; ?>
