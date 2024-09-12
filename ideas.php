<?php

session_start();
// includes all required files
require_once "./modules/mod-include.php";



// modify variable $page_title to modify header title
// unset to leave blank
$page_title = "Ideas";
$page_alias = "ideas";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- performs page settings, includes css and other external tags -->
    <?php include "./modules/mod-head.php"; ?>

    <?php include "./modules/ideas/mod-backend.php"; ?>
</head>

<body>
    <?php include "./modules/mod-navbar.php"; ?>

    <div class="content">
        <section id="ideas">
            <h2 id="ideas"> Project Ideas </h2>
            <p> I often have project ideas coming up. Read through them, and if you like any - why not implement them? I
                hope you can find some inspiration on this page. </p>
            <?php

            foreach ($project_ideas as $project_idea) {
                ?>
                <div class="idea-card">

                    <h3 class="idea-title">

                        <?= $project_idea['title'] ?>
                    </h3>
                    <p class="idea-date">
                        <?= $project_idea['date'] ?>
                    </p>
                    <div class="rating-container">
                        <div class="positive">
                            <img src="/assets/images/heart-full.svg" class="like-button not-liked">
                        </div>
                        <div class="negative">
                            <img src="/assets/images/cross-full.svg" class="dislike-button not-disliked">
                        </div>
                    </div>
                    <div class="tag-container">
                        <?php
                        foreach ($project_idea['tags'] as $tag) {
                            ?>
                            <div class="tag">
                                <?= $tag ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="idea-content">
                        <?= $project_idea['content'] ?>
                    </div>
                </div>

                <?php
            }
            ?>
        </section>
    </div>



</body>

<script src="./modules/scripts/scroll-to.js"></script>

</html>