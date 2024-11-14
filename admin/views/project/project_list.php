<?= $head ?>

<?= $navigation ?>


<div class="container">
    <h1><?= $heading_title ?></h1>

    <hr>

    <div class="row">
        <div class="col">
            <a href="<?= $add ?>" class="btn btn-primary">Add Project</a>
        </div>
    </div>
    <hr>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Ordering</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td scope="row"><?= $project['project_id'] ?></td>
                    <td scope="row"><?= $project['title'] ?> </td>
                    <td scope="row"><?= $project['ordering'] ?></td>
                    <td scope="row">
                        <?php if ($project['status'] == 'active'): ?>
                            <span class="badge text-bg-success">Enabled</span>
                        <?php else: ?>
                            <span class="badge text-bg-danger">Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td scope="row">
                        <a href="<?= $project['edit'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= $project['delete'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $footer ?>