<?php
// Include connection
include_once "../login/config.php";

// Fetch data from the database
$sql = "SELECT users.username, obrazky.nazov, obrazky.popis, obrazky.cesta, kategorie.kategoria 
        FROM obrazky 
        JOIN users ON obrazky.user_id = users.id
        JOIN kategorie ON obrazky.kategoria_id = kategorie.id 
        ORDER BY obrazky.datum DESC";
$stmt = mysqli_stmt_init($link);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Error: " . mysqli_stmt_error($stmt);
} else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-Shot</title>
    <link rel="stylesheet" href="../login/css/upload_index.css">
</head>
<body>
<header>
    <h1><a href="index.php">X-Shot</a></h1>
    <nav>
        <a href="profil.php">Profil</a>
        <a href="image_upload.html">Nahrat Obrazok</a>
        <a href="../login/logout.php">Odhlasit sa</a>
    </nav>
    <form class="search-form">
        <input type="text" name="vyhladat" id="vyhladat" formaction="vyhladat.php" placeholder="Vyhladat obrazok">
        <input type="submit" name="submit" id="submit" value="Search">
    </form>
</header>
<main>
    <div class="gallery">
        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="image-card">
                            <div class="user-info">
                                <img src="https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png" class="profile-pic" alt="Profile Picture">
                                <h2>'.$row["username"].'</h2>
                            </div>
                            <img src="'.$row["cesta"].'" class="user-image" alt="User Image">
                            <div class="image-info">
                                <h3>Nazov: '.$row["nazov"].'</h3>
                                <p>Popis: '.$row["popis"].'</p>
                                <p>Kategoria: '.$row["kategoria"].'</p>
                            </div>
                        </div>';
            }
        }
        ?>
    </div>
</main>
</body>
</html>
