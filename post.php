<?php

session_start();
// includes all required files
require_once "./modules/mod-include.php";

/*here goes a require that will check the file we should post and determine values and content based on it */

require_once "./modules/post/mod-backend.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- performs page settings, includes css and other external tags -->
    <?php include "./modules/mod-head.php"; ?>
</head>

<body>
    <?php include "./modules/mod-navbar.php"; ?>
    
    <div class="content">
        <section id="title">
            <h2>Takacs Robert </h2>
        </section>
      
        <section id = "post-body">

        <h1><?= $page_title ?></h1>
            <?= $postContent ?>
        </section>
    
    </div>



</body>

<?php include "./modules/mod-scripts.php"; ?>

</html>