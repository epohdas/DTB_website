<?php
session_start();

# Check if user is already logged in, If yes then redirect him to index page



require_once "config.php";

# Define variables and initialize with empty values
$user_login_err = $user_password_err = $login_err = "";
$user_login = $user_password = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["user_login"]))) {
    $user_login_err = "prosím zadajte používateľské meno alebo email";
  } else {
    $user_login = trim($_POST["user_login"]);
  }

  if (empty(trim($_POST["user_password"]))) {
    $user_password_err = "Prosím zadajte heslo";
  } else {
    $user_password = trim($_POST["user_password"]);
  }

  # Validate credentials 
  if (empty($user_login_err) && empty($user_password_err)) {
    # Prepare a select statement
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      # Bind variables to the statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_user_login, $param_user_login);

      # Set parameters
      $param_user_login = $user_login;

      # Execute the statement
      if (mysqli_stmt_execute($stmt)) {
        # Store result
        mysqli_stmt_store_result($stmt);

        # Check if user exists, If yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          # Bind values in result to variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            # Check if password is correct
            if (password_verify($user_password, $hashed_password)) {

              # Store data in session variables
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["loggedin"] = TRUE;


                $stmt = $link->prepare("SELECT id FROM users WHERE username=?");

                /* bind parameters for markers */
                $stmt->bind_param("s", $username);

                /* execute query */
                $stmt->execute();

                /* bind result variables */
                $stmt->bind_result($user_id);

                /* fetch value */
                $stmt->fetch();

                $_SESSION['user_id'] = $user_id;
              # Redirect user to index page

              header("Location: ../upload/profil.php");
              exit;
            } else {
              # If password is incorrect show an error message
              $login_err = "Zlý e-mail alebo heslo.";
            }
          }
        } else {
          # If user doesn't exists show an error message
          $login_err = "Zlý email alebo heslo.";
        }
      } else {
        echo "<script>" . "alert('Niečo sa pokazilo. Prosím skúste neskôr.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php'" . "</script>";
        exit;
      }

      # Close statement
      mysqli_stmt_close($stmt);
    }
  }

  # Close connection
  mysqli_close($link);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User login system</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
    <script defer src="./js/script.js"></script>
</head>

<body>
<div class="body">
    <div class="main">
        <div class="col-lg-5">
            <?php
            if (!empty($login_err)) {
                echo "<div class='alert alert-danger'>" . $login_err . "</div>";
            }
            ?>
            <div class="">
                <h1 class="login_label">Log In</h1>
                <p class="login_label2">Please login to continue</p>
                <!-- form starts here -->
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                    <div class="mb-3">

                        <input type="text" class="form-control" name="user_login" id="user_login" value="<?= $user_login; ?>" placeholder="Email or username">
                        <small class="text-danger"><?= $user_login_err; ?></small>
                    </div>
                    <div class="mb-2">

                        <input type="password" class="form-control" name="user_password" id="password" placeholder="Password">
                        <small class="text-danger"><?= $user_password_err; ?></small>
                    </div>
                    <div class="sh_pass_butt">
                        <input type="checkbox" class="form-check-input" id="togglePassword">
                        <label for="togglePassword" class="form-check-label">Show Password</label>
                    </div>
                    <div>
                        <input class="button" type="submit" class="btn btn-primary form-control" name="submit" value="Log In">
                    </div>
                    <p class="mb-0">Don't have an account ? <a href="./register.php">Sign Up</a></p>
                </form>
                <!-- form ends here -->
            </div>
        </div>
    </div>
</div>
</body>

</html>