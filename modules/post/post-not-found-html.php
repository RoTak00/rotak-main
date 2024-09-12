<?php


$stmt = $conn->prepare("SELECT p.title, p.alias, c.title as category, c.alias as category_alias FROM posts p LEFT JOIN post_categories c ON p.category = c.category_id WHERE p.active = 1 ORDER BY c.category_id DESC, p.ordering ASC LIMIT 20");
$stmt->execute();
$postsResult = $stmt->get_result();

?>
<p>God damnit. That post couldn't be found! Try something else?</p>

<?php
while ($post = $postsResult->fetch_assoc()) {
    echo "<a href='{$post['category_alias']}/{$post['alias']}'>{$post['category']} - {$post['title']}</a><br>";
}
?>