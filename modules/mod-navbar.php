<?php
ShowAlert();
?>
<!-- shows cookie notification for new users -->
<?php /*include "./modules/other/mod-other-cookie-notif.php"; */ ?>
<?php
// Fetch all main categories
$mainCategoriesStmt = $conn->prepare("SELECT category_id, title, alias FROM post_categories WHERE parent = 0 AND active = 1 ORDER BY ordering ASC");
$mainCategoriesStmt->execute();
$mainCategoriesResult = $mainCategoriesStmt->get_result();

$categories = [];

while ($mainCategory = $mainCategoriesResult->fetch_assoc()) {
    // For each main category, fetch its active children
    $childrenStmt = $conn->prepare("SELECT category_id, title, alias FROM post_categories WHERE parent = ? AND active = 1 ORDER BY ordering ASC");
    $childrenStmt->bind_param("i", $mainCategory['category_id']);
    $childrenStmt->execute();
    $childrenResult = $childrenStmt->get_result();

    $children = [];
    while ($child = $childrenResult->fetch_assoc()) {
        // Add each child to the children array
        $children[] = [
            'title' => $child['title'],
            'alias' => $child['alias']
        ];
    }

    // Add the main category and its children to the categories array
    $categories[$mainCategory['title']] = [
        'title' => $mainCategory['title'],
        'alias' => $mainCategory['alias'],
        'children' => $children
    ];
}
?>
<nav class="main-nav">
    <!--<div class="brand">
        <h1> Takacs Robert </h1>
    </div>-->

    <div class="nav-links">

        <?php
        if ($page_alias == "index") { ?>
                    <a data-to="home" class="selected" disabled>Home</a>
                    <a class="child" data-to="projects-tech">Projects</a>
                    <a class="child" data-to="projects-volunteering">Volunteering</a>
                    <a class="child" data-to="studies">Studies</a>
                    <a class="child" data-to="contact">Contact</a>
                    <?php
                    foreach ($categories as $c) {
                        ?> <a href = '/<?= $c['alias'] ?>' ><?= $c['title'] ?></a> <?php
                             foreach ($c['children'] as $c2) {
                                 ?> <a class="child" href = '/<?= $c['alias'] . "/" . $c2['alias'] ?>'><?= $c2['title'] ?></a> <?php
                             }
                    }

        } else { ?>
                    <a href="/">Home</a>
                    <a class="child" href="/#projects-tech">Projects</a>
                    <a class="child" href="/#projects-volunteering">Volunteering</a>
                    <a class="child" href="/#studies">Studies</a>
                    <a class="child" href="/#contact">Contact</a>
                    <?php
                    foreach ($categories as $c) {
                        ?> <a href = '/<?= $c['alias'] ?>' class = "<?= $page_category == $c['alias'] ? 'selected' : '' ?>"><?= $c['title'] ?></a> <?php
                                     foreach ($c['children'] as $c2) {
                                         ?> <a class="child <?= $page_category == $c2['alias'] ? 'selected' : '' ?>" href = '/<?= $c['alias'] . "/" . $c2['alias'] ?>'><?= $c2['title'] ?></a> <?php
                                     }
                    }


                    ?>
     <?php } ?>
      
    </div>
</nav>