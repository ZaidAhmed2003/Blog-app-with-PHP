<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from database to delete the thumbnail from folder
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($connection, $query);

    // make sure only 1 record/post was fetch
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnailName = $post['thumbnail'];
        $thumbnailPath = '../uploads/images/' . $thumbnailName;

        if ($thumbnailPath) {
            unlink($thumbnailPath);

            // deletepost query
            $deletePostQuery = "DELETE FROM posts WHERE id = $id LIMIT 1";
            $deletePostResult = mysqli_query($connection, $deletePostQuery);

            if (!mysqli_errno($connection)) {
                $_SESSION['delete-post-success'] = "Post deleted successfully";
            }
        }
    }
}

header('location:' . ROOT_URL . 'admin/');
die();
