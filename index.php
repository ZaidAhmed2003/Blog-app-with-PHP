<?php
include 'partials/header.php';

// fetch fetured post from database

$featuredPostQuery = "SELECT * FROM posts WHERE is_featured=1";
$featuredPostResult = mysqli_query($connection, $featuredPostQuery);
$featured = mysqli_fetch_assoc($featuredPostResult);

// fetch posts from database
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $query);
?>

<!-- Section Featured -->

<!-- Show featured Post if there any  -->

<?php if (mysqli_num_rows($featuredPostResult) == 1) : ?>
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="uploads/images/<?= $featured['thumbnail'] ?>">
            </div>
            <div class="post__info">
                <?php
                // fetch category
                $categoryId = $featured['category_id'];
                $categoryQuery = "SELECT * FROM categories WHERE id = $categoryId";
                $categoryResult = mysqli_query($connection, $categoryQuery);
                $category = mysqli_fetch_assoc($categoryResult);

                ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
                <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
                <p class="post_body">
                    <?= substr($featured['body'], 0, 300) ?>...
                </p>
                <div class="post__author">
                    <?php
                    // fetch author
                    $authorId = $featured['author_id'];
                    $authorQuery = "SELECT * FROM users WHERE id = $authorId";
                    $authorResult = mysqli_query($connection, $authorQuery);
                    $author = mysqli_fetch_assoc($authorResult);

                    ?>

                    <div class="post__author-avatar">
                        <img src="uploads/images/<?= $author['avatar'] ?>">
                    </div>
                    <div class="post-author-info">
                        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>

<!-- End of Section Featured -->

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

<!-- Footer -->
<?php
include 'partials/footer.php'
?>