<?php
include 'partials/header.php';

// fetch posts from database
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);


?>
<!-- Search Bar -->

<section class="search__bar">
    <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container" method="get">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Search">
        </div>
        <button type="submit" name="submit" class=" btn">Go</button>
    </form>
</section>

<!-- End of Search Bar -->

<!-- Section Posts -->

<section class="posts <?= $featured ? '' : 'section__extra-margin' ?> ">
    <div class="container posts__container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="uploads/images/<?= $post['thumbnail'] ?>">
                </div>
                <div class="post__info">
                    <?php
                    // fetch category
                    $categoryId = $post['category_id'];
                    $categoryQuery = "SELECT * FROM categories WHERE id = $categoryId";
                    $categoryResult = mysqli_query($connection, $categoryQuery);
                    $category = mysqli_fetch_assoc($categoryResult);

                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
                    <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                    <p class="post__body"><?= substr($post['body'], 0, 150) ?>...
                    </p>
                    <div class="post__author">
                        <?php
                        // fetch author
                        $authorId = $post['author_id'];
                        $authorQuery = "SELECT * FROM users WHERE id = $authorId";
                        $authorResult = mysqli_query($connection, $authorQuery);
                        $author = mysqli_fetch_assoc($authorResult);

                        ?>
                        <div class="post__author-avatar">
                            <img src="uploads/images/<?= $author['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>

<!-- End of Section Posts -->

<!--  Category Buttons-->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $allCategoriesQuery = "SELECT * FROM categories";
        $allCategoriesResult = mysqli_query($connection, $allCategoriesQuery);
        ?>
        <?php while ($category = mysqli_fetch_assoc($allCategoriesResult)) : ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>

<!-- End of Category Buttons-->

<?php
include 'partials/footer.php'
?>