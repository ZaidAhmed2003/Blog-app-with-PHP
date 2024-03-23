<?php
require 'config/constants.php';

$usernameEmail = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);

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
            <h2>Sign In</h2>

            <?php
            if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert__message success">
                    <p>
                        <?=
                        $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['signin'])) : ?>

                <div class="alert__message error">
                    <p>
                        <?=
                        $_SESSION['signin'];
                        unset($_SESSION['signin']);
                        ?>
                    </p>
                </div>
            <?php endif ?>

            <form action="<?= ROOT_URL ?>signin-login.php" method="post">
                <input type="text" name="username_email" value="<?= $usernameEmail ?>" placeholder="Username or Email">
                <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
                <button type="submit" name="submit" class="btn">Sign In</button>
                <small>Dont have account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>


    <script src="<?= ROOT_URL ?>js/main.js"></script>
</body>

</html>