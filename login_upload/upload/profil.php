<?php
session_start();

// If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    header("location: ../login/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Include connection
include_once "../login/config.php";

// Fetch user profile information
$sql = "SELECT username, profile_picture FROM users WHERE id = ?";
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
}

// Fetch user's images
$sql = "SELECT obrazky.id, obrazky.nazov, obrazky.popis, obrazky.cesta, kategorie.kategoria 
        FROM obrazky 
        JOIN kategorie ON obrazky.kategoria_id = kategorie.id 
        WHERE obrazky.user_id = ? 
        ORDER BY obrazky.datum DESC";
$stmt = mysqli_stmt_init($link);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Count user's images
$image_count = count($images);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="../login/css/profil.css">

    <script>
        function deleteImage(imageId) {
            if (confirm("Naozaj chcete odstrániť tento obrázok?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_image.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText == "success") {
                            document.getElementById("image-card-" + imageId).remove();
                        } else {
                            alert("Nepodarilo sa odstrániť obrázok.");
                        }
                    }
                };
                xhr.send("id=" + imageId);
            }
        }
    </script>
</head>
<body>
<header>
    <h1><a href="index.php">X-Shot</a></h1>
</header>
<div class="container">
    <div class="profile-card">
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="profile-pic">
        <?php else: ?>
            <img src="https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png" alt="Default Profile Picture" class="profile-pic">
        <?php endif; ?>
        <h1 class="profile-info"><?php echo $user['username']; ?></h1>
        <p class="image-count">Počet obrázkov: <?php echo $image_count; ?></p>
        <div class="profile-actions">
            <a href="image_upload.html" class="btn">Nahrať obrázok</a>
            <a href="../login/logout.php" class="btn">Odhlásiť sa</a>
            <a href="index.php" class="btn">Hlavná stránka</a>
        </div>
    </div>

    <div class="profile-pic-upload">
        <form action="profile_picture.php" method="post" enctype="multipart/form-data">
            <input type="file" name="profile_picture" accept="image/*" required>
            <button type="submit" class="btn">Nastaviť profilový obrázok</button>
        </form>
    </div>
</div>

<h1>Vaše obrázky</h1>
<div class="gallery">
    <?php
    if ($images) {
        foreach ($images as $image) {
            echo '<div class="image-card" id="image-card-' . $image["id"] . '">
                    <img src="'.$image["cesta"].'" class="user-image" alt="User Image">
                    <div class="image-info">
                        <h3>'.$image["nazov"].'</h3>
                        <p>'.$image["popis"].'</p>
                        <p>Kategória: '.$image["kategoria"].'</p>
                        <button onclick="deleteImage('.$image["id"].')" class="delete-btn">Odstrániť</button>
                    </div>
                  </div>';
        }
    } else {
        echo '<p>Žiadne obrázky.</p>';
    }
    ?>
</div>
</body>
</html>
