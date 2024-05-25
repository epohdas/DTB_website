<?php
session_start();
include_once "../login/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $imageId = $_POST["id"];

    // Najprv zistíme, či obrázok patrí aktuálnemu používateľovi
    $sql = "SELECT cesta FROM obrazky WHERE id = ? AND user_id = ?";
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $imageId, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $filePath);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($filePath) {
            // Potom odstránime záznam z databázy
            $sql = "DELETE FROM obrazky WHERE id = ? AND user_id = ?";
            $stmt = mysqli_stmt_init($link);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ii", $imageId, $user_id);
                if (mysqli_stmt_execute($stmt)) {
                    // Ak sa záznam úspešne odstránil, odstránime aj súbor
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    echo "success";
                } else {
                    echo "error";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
