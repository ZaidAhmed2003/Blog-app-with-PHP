<?php
require 'config/database.php';

// make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previousThumbnailName = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoryId = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $isFeatured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if it was unchecked
    $isFeatured = $is_featured == 1 ?: 0;

    // check & validate input values
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } elseif (!$categoryId) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } else {
        // delete existing thumbnail if new thumnail is available 
        if ($thumbnail['name']) {
            $previousThumbnailPath = '../uploads/images/' . $previousThumbnailName;
            if ($previousThumbnailPath) {
                unlink($previousThumbnailPath);
            }

            // Work on new Thumbail
            // Rename image
            $time = time(); // made each imagename upload unique using current timestamp
            $thumbnailName = $time . $thumbnail['name'];
            $thumbnailTempName = $thumbnail['tmp_name'];
            $thumbnailDestinationPath = '../uploads/images/' . $thumbnailName;

            // make sure file is an image 

            $allowedFiles = ['png', 'jpg', 'jpeg'];
            $extention = explode('.', $thumbnailName);
            $extention = end($extention);

            if (in_array($extention, $allowedFiles)) {
                // make sure image is not too large (2mb+)

                if ($thumbnail['size'] < 2000000) {
                    // Upload Avatar
                    move_uploaded_file($thumbnailTempName, $thumbnailDestinationPath);
                } else {
                    $_SESSION['edit-post'] = "File size is too big. Shoud be less than 1 mb";
                }
            } else {
                $_SESSION['edit-post'] = "File should be png, jpg or jpeg";
            }
        }
    }
    if ($_SESSION['edit-post']) {
        // redirect to manage posts if invalid
        header('location:' . ROOT_URL . 'admin/');
        die();
    } else {
        // set isfeatured of all posts to 0if this is 1 
        if ($isFeatured == 1) {
            $zeroAllIsFeaturedQuery = "UPDATE posts SET is_featured=0";
            $zeroAllIsFeaturedResult = mysqli_query($connection, $zeroAllIsFeaturedQuery);
        }

        // set thumbnail name if a neew one was uploaded esle keep old
        $thumbnailToInsert = $thumbnailName ?? $previousThumbnailName;

        $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnailToInsert', category_id = '$categoryId', is_featured = ' $isFeatured' WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if (!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
}

header('location:' . ROOT_URL . 'admin/');
die();
