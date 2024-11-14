<?= $head ?>

<div class="content">

    <h2><?= $category['title'] ?></h2>

    <p><?= $category['page'] ?></p>


    <?php if (!empty($children_posts)): ?>
        <h3>Posts:</h3>
        <ul>
            <?php foreach ($children_posts as $post): ?>
                <li><a href="<?= $post['url'] ?>"><?= $post['title'] ?></a> - <?= $post['date_display'] ?>
            <p>
                <?= $post['intro'] ?>
            </p>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($children_categories)): ?>
        <h3>Subcategories:</h3>
        <ul>
            <?php foreach ($children_categories as $child_category): ?>
                <li><?= $child_category['title'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?= $navigation ?>
<?= $footer ?>