<?php
include 'partials/header.php';

// fech post if id is set 
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id = $id";
    $posts = mysqli_query($connection, $query);
} else {
    header('location:' . ROOT_URL . 'blog.php');
    die();
}
?>

<header class="category__title">
    <h2>
        <?php
        // fetch category
        $categoryId = $id;
        $categoryQuery = "SELECT * FROM categories WHERE id = $id";
        $categoryResult = mysqli_query($connection, $categoryQuery);
        $category = mysqli_fetch_assoc($categoryResult);
        echo $category['title']
        ?>
    </h2>
</header>

<!-- End of Category Title -->

<!-- Section Posts -->
<?php if (mysqli_num_rows($posts) > 0) : ?>
    <section class="posts">
        <div class="container posts__container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="uploads/images/<?= $post['thumbnail'] ?>">
                    </div>
                    <div class="post__info">


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
<?php else : ?>
    <div class="alert__message error lg">
        <p>No post found for this category</p>
    </div>
<?php endif ?>
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
include 'partials/footer.php';
?>