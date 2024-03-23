<?php
require 'config/constants.php';

// get back form data if there was an error

$firstName = $_SESSION['signup-data']['firstname'] ?? null;
$lastName = $_SESSION['signup-data']['lastname'] ?? null;
$userName = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createPassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmPassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

// delete signup data session

unset($_SESSION['signup-data']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <!-- Style Sheets -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- Iconscout CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign Up</h2>

            <?php
            if (isset($_SESSION['signup'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?=
                        $_SESSION['signup'];
                        unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif ?>

            <form method="post" action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data">
                <input type="text" name="firstname" value="<?= $firstName ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastName ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $userName  ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $createPassword ?>" placeholder="Create password">
                <input type="password" name="confirmpassword" value="<?= $confirmPassword ?>" placeholder="Confirm password">
                <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button class="btn" name="submit" type="submit">Sign Up</button>
                <small>Already have account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>


    <script src="<?= ROOT_URL ?>js/main.js"></script>
</body>

</html>