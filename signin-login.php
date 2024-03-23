<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // get form data
    $usernameEmail = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$usernameEmail) {
        $_SESSION['signin'] = "Username or Email required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Passsword required";
    } else {

        $fetchUserQuery = "SELECT * FROM users WHERE username = '$usernameEmail' OR email = '$usernameEmail'";

        $fetchUserResult = mysqli_query($connection, $fetchUserQuery);

        if (mysqli_num_rows($fetchUserResult) == 1) {
            // convert the record into assoc array

            $userRecord = mysqli_fetch_assoc($fetchUserResult);
            $databasePassword = $userRecord['password'];

            // compare form password with database pasword

            if (password_verify($password, $databasePassword)) {
                // set session for access control 
                $_SESSION['user-id'] = $userRecord['id'];
                // set session if user is an admin

                if ($userRecord['is_admin'] ==  1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // log user in
                header('location:' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Invalid email or password";
            }
        } else {
            $_SESSION['signin'] = "User not found";
        }
    }
    // if any problem, redirect to signin page with login data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location:' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}
