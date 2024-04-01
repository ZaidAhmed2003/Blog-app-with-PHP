<?php
include 'config/database.php';

// Fetch featured post
$featuredPostQuery = "SELECT * FROM posts WHERE is_featured=1";
$featuredPostResult = mysqli_query($connection, $featuredPostQuery);
$featured = mysqli_fetch_assoc($featuredPostResult);

// Fetch latest posts
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$postsResult = mysqli_query($connection, $query);
$posts = mysqli_fetch_all($postsResult, MYSQLI_ASSOC);

// Prepare data to return
$data = [
    'featured' => $featured,
    'posts' => $posts
];

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
