<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch user from database

    $query = "SELECT * FROM users WHERE id = '$id'";
    $results = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($results);

    // make sure we got back onlt one user
    if (mysqli_num_rows($results) == 1) {
        $avatarName = $user['avatar'];
        $avatarPath = '../uploads/images/' . $avatarName;
        // Delete image if available 
        if ($avatarPath) {
            unlink($avatarPath);
        }
    }

    // FOR LATER
    // fetch all thumbnails of users posts and delete them



    // Delete user from Database
    $deleteUserQuery = "DELETE FROM users WHERE id = '$id'";
    $deleteUserResult = mysqli_query($connection, $deleteUserQuery);
    if (mysqli_errno($connection)) {
        $_SESSION['delete-user-success'] = "'{$user['firstname']}  '{$user['lastname']} ' deleted successfully";
    }
}

header('location:' . ROOT_URL . 'admin/manage-users.php');
die();
