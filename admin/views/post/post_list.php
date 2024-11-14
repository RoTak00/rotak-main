<?= $head ?>

<?= $navigation ?>

<div class="container">
    <h1><?= $heading_title ?></h1>

    <hr>

    <div class="row">
        <div class="col">
            <a href="<?= $add ?>" class="btn btn-primary">Add Post</a>
        </div>
    </div>
    <hr>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Parent</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td scope="row"><?= $post['post_id'] ?></td>
                    <td scope="row"><?= $post['title'] ?> (<?= $post['alias'] ?>)</td>
                    <td scope="row"><?= $post['category_name'] ?></td>
                    <td scope="row">
                        <?php if ($post['active']): ?>
                            <span class="badge text-bg-success">Enabled</span>
                        <?php else: ?>
                            <span class="badge text-bg-danger">Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td scope="row">
                        <a href="<?= $post['edit'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= $post['delete'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $footer ?>