<nav class="main-nav">
    <!--<div class="brand">
        <h1> Takacs Robert </h1>
    </div>-->

    <div class="nav-links">

        <?php
        if ($page_alias == "index") { ?>
            <a data-to="home" class="selected" disabled>Home</a>
            <a class="child" data-to="projects-tech">Projects</a>
            <!--<a class="child" data-to="projects-volunteering">Volunteering</a>-->
            <a class="child" data-to="studies">Studies</a>
            <a class="child" data-to="contact">Contact</a>
            <?php
            foreach ($categories as $c) {
                ?> <a href='/<?= $c['alias'] ?>'><?= $c['title'] ?></a> <?php
                     foreach ($c['children'] as $c2) {
                         ?> <a class="child" href='/<?= $c2['alias'] ?>'><?= $c2['title'] ?></a> <?php
                     }
            }

        } else { ?>
            <a href="/">Home</a>
            <a class="child" href="/#projects-tech">Projects</a>
            <!--<a class="child" href="/#projects-volunteering">Volunteering</a>-->
            <a class="child" href="/#studies">Studies</a>
            <a class="child" href="/#contact">Contact</a>
            <?php
            foreach ($categories as $c) {
                ?> <a href='/<?= $c['alias'] ?>'
                    class="<?= $page_category == $c['alias'] ? 'selected' : '' ?>"><?= $c['title'] ?></a> <?php
                              foreach ($c['children'] as $c2) {
                                  ?> <a class="child <?= $page_category == $c2['alias'] ? 'selected' : '' ?>"
                        href='/<?= $c2['alias'] ?>'><?= $c2['title'] ?></a> <?php
                              }
            }


            ?>
        <?php } ?>

    </div>
</nav>