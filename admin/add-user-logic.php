<?php
require 'config/database.php';


// get form data if btn was clicked

if (isset($_POST['submit'])) {

    $firstName = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userName = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createPassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmPassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // Validate Input Values

    if (!$firstName) {
        $_SESSION['add-user'] = "Please enter your First Name";
    } elseif (!$lastName) {
        $_SESSION['add-user'] = "Please enter your Last Name";
    } elseif (!$userName) {
        $_SESSION['add-user'] = "Please enter your Username";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please enter a valid email";
    } elseif (!$is_admin) {
        $_SESSION['add-user'] = "Please select user role";
    } elseif (strlen($createPassword) < 8 || strlen($confirmPassword) < 8) {
        $_SESSION['add-user'] = "Password should be 8+ characters";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please add avatar";
    } else {

        // check if passwords dont match
        if ($createPassword !== $confirmPassword) {

            $_SESSION['add-user'] = "Password do not match";
        } else {
            $hashedPassword = password_hash($createPassword, PASSWORD_BCRYPT);

            // check if username or email exist in database

            $userCheckQuery = "SELECT * FROM users WHERE username = '$userName' or email = '$email'";

            $userCheckResult = mysqli_query($connection, $userCheckQuery);

            if (mysqli_num_rows($userCheckResult) > 0) {
                $_SESSION['add-user'] = "Username or Email already exist";
            } else {
                // Work on avatar
                // rename avatar
                $time = time(); // make each image name unique using current timestamp
                $avatarName = $time . $avatar['name'];
                $avatarTempName = $avatar['tmp_name'];
                $avatarDestinationPath = '../uploads/images/' . $avatarName;

                // make sure file is an image
                $allowedFiles = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatarName);
                $extention = end($extention);

                if (in_array($extention, $allowedFiles)) {
                    // make sure image is not too large (1mb+)

                    if ($avatar['size'] < 1000000) {
                        // Upload Avatar
                        move_uploaded_file($avatarTempName, $avatarDestinationPath);
                    } else {
                        $_SESSION['add-user'] = "File size is too big. Shoud be less than 1 mb";
                    }
                } else {
                    $_SESSION['add-user'] = "File should be png, jpg or jpeg";
                }
            }
        }
    }
    // redirect back to signup page if there was an problem
    if (isset($_SESSION['add-user'])) {
        // pass form data back to sign up
        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        // insert new user into users table

        $insertUserQuery = "INSERT INTO blog.users (firstname, lastname, username, email, password, avatar, is_admin)
        VALUES('$firstName', '$lastName', '$userName', '$email', '$hashedPassword', '$avatarName', '$is_admin')";

        $insertUserResult = mysqli_query($connection, $insertUserQuery);

        if (!mysqli_errno($connection)) {
            // redirect to login Page with success message

            $_SESSION['add-user-success'] = "New user $firstName $lastName added successfully";
            header('location:' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
} else {
    header('location:' . ROOT_URL . 'admin/add-user.php');
    die();
}
