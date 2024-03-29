<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // For Later
    // Ppdate category id of posts that belong to this category to id of Uncategorized category



    // fetch category from database
    $query = "SELECT * FROM categories WHERE id = '$id'";
    $results = mysqli_query($connection, $query);
    $category = mysqli_fetch_assoc($results);

    // Delete category from Database
    $deleteCategoryQuery = "DELETE FROM categories WHERE id = '$id' LIMIT 1";
    $deleteCategoryResult = mysqli_query($connection, $deleteCategoryQuery);

    $_SESSION['delete-category-success'] = "{$category['title']} category deleted successfully";
}

header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
