<section id="projects">
    <h2> What I've been up to</h2>

    <p> This is my portfolio, a quick showcase of everything that I'm up to, from tech to
        volunteering.</p>

    <div class="form-group" id="project-filter">
        <input type="text" class="form-control" id="project-filter-input" placeholder="Filter projects...">
    </div>

    <div id="projects-error">
        <h3 style="text-align: center;">No projects were found with this search criteria...
        </h3>
    </div>

    <div id="projects-wrapper">
        <?php foreach ($projects as $p) {
            ?>
            <div class="project">
                <div class="image-wrapper">
                    <?php if (!empty($p['link']) && $p['link'] !== '#') { ?>
                        <a href="<?= $p['link'] ?>" target="_blank">
                        <?php } ?>
                        <h3>
                            <?= $p['title'] ?>
                        </h3>
                        <div class="image-container">
                            <img src='<?= $p['image'] ?>' alt="<?= $p['title'] ?>">
                        </div>
                        <?php if (!empty($p['link']) && $p['link'] !== '#') { ?>
                        </a>
                    <?php } ?>
                </div>

                <div class="info-wrapper">
                    <div class="tags">
                        <?php foreach ($p['tags'] as $t)
                            echo '<span>' . $t . '</span>'; ?>
                    </div>
                    <p>
                        <?= $p['description'] ?>
                    </p>

                </div>
                <hr>
            </div>


            <?php
        }

        ?>
    </div>
</section>