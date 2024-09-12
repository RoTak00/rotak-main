<?php
// Generate title for current page
// SITE_NAME is used in config.php
$title = $SITE_NAME;

// check if $page_title exists
if (isset($page_title))
    $title = $page_title . " | " . $SITE_NAME;

// check if cookie notif was shown
$show_cookie_notif = true;
if (isset($_COOKIE['cookie_notif_shown'])) {
    $show_cookie_notif = false;
} else {
    setcookie("cookie_notif_shown", true, time() + 60 * 60 * 24 * 30);
}
//$page_href = "www.rotak.ro";
$page_href = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$page_description = "rotak.ro - Robert Takacs";

?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- appears in google and other browsers, should be changed for different pages -->
<meta name="description" content='Robert  Takacs - Web Development and Software Solutions.'>

<!-- page title -->
<title>
    <?= $title ?>
</title>

<!-- bootstrap and css -->
<link href="/<?= ($subfolderName ?? "") ?>inc/bootstrap.min.css" rel="stylesheet">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />-->
<link rel="stylesheet" href="/<?= ($subfolderName ?? "") ?>CSS/styles.css?v=1.5.4">
<link rel="stylesheet" href="/<?= ($subfolderName ?? "") ?>CSS/common/nav.css?v=1.5.1">
<?php
if ($page_alias == "ideas") {
    ?>
            <link rel="stylesheet" href="/<?= ($subfolderName ?? "") ?>CSS/ideas.css?v=1">
        <?php
}
if ($page_alias == "blog") {
    ?>
            <link rel="stylesheet" href="/<?= ($subfolderName ?? "") ?>CSS/blog.css?v=1">
        <?php
}
?>
<script src="/<?= ($subfolderName ?? "") ?>inc/jquery.js"></script>
<script src="/<?= ($subfolderName ?? "") ?>inc/bootstrap.bundle.min.js"></script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-680QC7B6PY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-680QC7B6PY');
</script>