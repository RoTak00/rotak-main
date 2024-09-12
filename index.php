<?php

session_start();
// includes all required files
require_once "./modules/mod-include.php";



// modify variable $page_title to modify header title
// unset to leave blank
$page_title = "Home";
$page_alias = "index";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- performs page settings, includes css and other external tags -->
    <?php include "./modules/mod-head.php"; ?>

    <?php include "./modules/mod-backend.php"; ?>
</head>

<body>
    <?php include "./modules/mod-navbar.php"; ?>

    <div class="content">
        <section id="home">
            <h2>Takacs Robert </h2>
            <h3>All things web - and so much more </h3>
        </section>
        <section id="projects-tech">
            <h2> Projects </h2>


            <p> This is my technical portfolio, a quick showcase of everything that I'm up to, from tech to
                volunteering.</p>
            <div id="project-filter">
                <input type="text" id="project-filter-input" placeholder="Filter projects...">
            </div>
            <div id="projects-error">
                <h3 style="text-align: center;">No projects were found with this search criteria...
                </h3>
            </div>
            <div id="projects-tech-wrapper">
                <?php foreach ($projects as $p) {
                    ?>
                    <div class="project">
                        <div class="image-wrapper">
                            <a href="<?= $p['link'] ?>" target="_blank">
                                <h3>
                                    <?= $p['title'] ?>
                                </h3>
                                <div class="image-container">
                                    <img src='<?= $p['image'] ?>' alt="<?= $p['title'] ?>">
                                </div>
                            </a>
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



        <section id="studies">
            <h2> Studies </h2>
            <p>I have just returned from an Erasmus+ student exchange, where I studied <strong>Software
                    Engineering</strong>
                at <strong>Instituto
                    Superior Miguel Torga</strong> in Coimbra, Portugal. This exchange lasted until the end of
                January, when I
                returned to my home country, where I'm enrolled as a permanent student. <strong>The University of
                    Bucharest </strong> offers a <strong>Computers
                    and Information Technology </strong> specialization, where I'm currently enrolled as a second year
                student. My academic foundation was laid at the
                <strong>Liviu Rebreanu National College </strong> in Bistrița-Năsăud, Romania, where I graduated from a
                demanding
                mathematics-computer science program in 2022.
            </p>
            <div class="d-flex justify-content-center w-100 d-none d-md-block">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th scope="col">Level</th>
                            <th scope="col">Institution</th>
                            <th scope="col">Location</th>
                            <th scope="col">Program</th>
                            <th scope="col">Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>University</td>
                            <td>University of Bucharest</td>
                            <td>Bucharest, Romania</td>
                            <td>Computers and Information Technology</td>
                            <td>2022 - 2026 (Current)</td>
                        </tr>
                        <tr>
                            <td>University</td>
                            <td>Instituto Superior Miguel Torga</td>
                            <td>Coimbra, Portugal</td>
                            <td>Software Engineering</td>
                            <td>2023-2024</td>
                        </tr>

                        <tr>
                            <td>High School</td>
                            <td>National College Liviu Rebreanu</td>
                            <td>Bistrita-Nasaud, Romania</td>
                            <td>Mathematics-Computer Science</td>
                            <td>2018 - 2022</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-block d-md-none">
                <ul>

                    <li>
                        <strong>University:</strong> Computers and Information Technology at University of
                        Bucharest,
                        Bucharest, Romania | 2022 - 2026 (Current)
                    </li>
                    <li>
                        <strong>University:</strong> Software Engineering at Instituto Superior Miguel Torga,
                        Coimbra, Portugal | 2023 - 2024
                    </li>
                    <li>
                        <strong>High School:</strong> Mathematics-Computer Science at National College Liviu
                        Rebreanu,
                        Bistrita-Nasaud, Romania | 2018 - 2022
                    </li>
                </ul>
            </div>

            <h2> About me </h2>
            <p>I'm Takacs Robert, a
                <?= (new DateTime('now'))->diff(new DateTime('2003-05-05'))->y ?>-year-old Software Engineering
                student
                from
                Romania.
            </p>

            <p>While my primary focus is on software engineering, I believe in a balanced life. I actively participate
                in volunteering activities, and am trying to be as involved in the community as possible.</p>

            <h3>Let's Connect</h3>
            <p>I'm always open for suggestions and collaborations. Or, why not, conversations? Shoot me a message and
                let's get in touch!</p>


        </section>
        <section id="contact" class="mt-5">
            <h2>Contact Me </h2>
            <?php include "./modules/mod-contact.php"; ?>
        </section>

    </div>



</body>

<?php include "./modules/mod-scripts.php"; ?>
<script src="./modules/scripts/scroll-to.js"></script>
<script src="./modules/scripts/filter-projects.js"></script>

</html>