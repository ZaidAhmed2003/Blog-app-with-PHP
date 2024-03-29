<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $authorId = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $isFeatured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is featured to 0 if unchecked
    $isFeatured = $isFeatured == 1 ?: 0;

    // validate form data 
    if (!$title) {
        $_SESSION['add-post'] = "Enter post Title";
    } elseif (!$categoryId) {
        $_SESSION['add-post'] = "Select post Category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose post thumbnail";
    } else {
        //work on thumbnail
        //rename the image
        $time = time();
        $thumbnailName = $time . $thumbnail['name'];
        $thumbnailTempName = $thumbnail['tmp_name'];
        $thumbnailDestinationPath = '../uploads/images/' . $thumbnailName;

        // make sure file is an image
        $allowedFiles = ['png', 'jpg', 'jpeg'];
        $extention = explode('.', $thumbnailName);
        $extention = end($extention);

        if (in_array($extention, $allowedFiles)) {
            // make sure image is not too large (2mb+)

            if ($thumbnail['size'] < 2_000_000) {
                // Upload Avatar
                move_uploaded_file($thumbnailTempName, $thumbnailDestinationPath);
            } else {
                $_SESSION['add-post'] = "File size is too big. Shoud be less than 1 mb";
            }
        } else {
            $_SESSION['add-post'] = "File should be png, jpg or jpeg";
        }
    }
    // redirect back with form data
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        //set is-featured of all post to 0 if this is 1
        if ($isFeatured == 1) {
            $zeroAllIsFeaturedQuery = "UPDATE posts SET is_featured=0";
            $zeroAllIsFeaturedResult = mysqli_query($connection, $zeroAllIsFeaturedQuery);
        }

        //insert into databsae
        $insertQuery  = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnailName', '$categoryId', '$authorId', '$isFeatured')";
        $insertResult = mysqli_query($connection, $insertQuery);

        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-success'] =  "New post added successfully";
            header('location:' . ROOT_URL . 'admin/');
            die();
        }
    }
}

header('location:' . ROOT_URL . 'admin/');
die();
