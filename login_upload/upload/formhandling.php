<?php
session_start();
include "../login/config.php";

$kategoria_id = array(
    "zver" => 1,
    "budovy" => 2,
    "priroda" => 3,
    "auta" => 4,
    "psy" => 5,
    "ludia" => 6
);

$target_dir = "obrazky/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);





    if($check !== false) {
        echo "subor je obrazok - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "subor nieje obrazok.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "subor uz existuje.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "joooooj moc velky.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "iba JPG, JPEG, PNG & GIF su povolene.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "subor nebol nahrani.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "subor " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " bol uspesne nahrati.";

        $kategoria = $_POST["kategorie"];
        $nazov = $_POST["nazov"];
        $popis = $_POST["popis"];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO obrazky (user_id ,kategoria_id, nazov, popis, cesta) VALUES (?, ?, ?, ?, ?)";


        if ($stmt = mysqli_prepare($link, $sql)) {
            # Bind varibales to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iisss", $param_user_id, $param_kategoria_id, $param_nazov, $param_popis, $param_cesta);

            $param_user_id = $_SESSION["user_id"];
            $param_kategoria_id = $kategoria_id[$kategoria];
            $param_nazov = $_POST["nazov"];
            $param_popis = $_POST["popis"];
            $param_user_id = $_SESSION["user_id"];
            $param_cesta = "obrazky/" . htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
            mysqli_stmt_execute($stmt);
            header("location: upload_more.html");

        } else {
            echo "pri nahravani vznikla chyba.";
        }
    }
}
