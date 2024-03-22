<?php
include 'partials/header.php';
?>

<section class="dashboard">
    <div class="container dashboard__container">
        <aside>
            <ul>
                <li><a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>
                    </a></li>
                <li><a href="dashboard.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a></li>
                <li><a href="add-user.php"><i class="uil uil-plus"></i>
                        <h5>Add User</h5>
                    </a></li>
                <li><a href="manage-users.php"><i class="uil uil-users-alt"></i>
                        <h5>Manage User</h5>
                    </a></li>
                <li><a href="add-category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5>
                    </a></li>
                <li><a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                        <h5>Manage Category</h5>
                    </a></li>
            </ul>
        </aside>
    </div>
</section>

<main>
    <h2>Manage Categories</h2>
</main>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Travel</td>
            <td><a href="edit-category.php" class="btn sm">Edit</a></td>
            <td><a href="delete-category.php" class="btn sm">Delete</a></td>
        </tr>
        <tr>
            <td>Music</td>
            <td><a href="edit-category.php" class="btn sm">Edit</a></td>
            <td><a href="delete-category.php" class="btn sm">Delete</a></td>
        </tr>
        <tr>
            <td>Art</td>
            <td><a href="edit-category.php" class="btn sm">Edit</a></td>
            <td><a href="delete-category.php" class="btn sm">Delete</a></td>
        </tr>
    </tbody>
</table>

<?php
include 'partials/footer.php';
?>