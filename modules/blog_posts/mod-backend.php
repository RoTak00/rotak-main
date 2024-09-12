<?php
// get the last query parameter from the query string 

print_r($_GET);
if (isset($_GET['alias'])) {
    $alias = $_GET['alias'];
    $blog_post = getBlogPostByAlias($alias);
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $blog_post = getBlogPostById($id);
} else {
    if (!$blog_post)
        header("Location: /");
}

$blog_post = checkBlogPost($blog_post);

if (!$blog_post) {
    header("Location: /");
}




function getBlogPostById($id)
{
    $query = "SELECT bp.id, bp.title, bp.alias, bp.header, bp.date, bp.status, bp.content,
GROUP_CONCAT(bt.tag_name SEPARATOR ';') as tags
FROM blog_posts bp
INNER JOIN blog_tags bt ON bp.id = bt.blog_post_id WHERE bp.id = " . (int) $id . " GROUP BY bp.id";

    $blog_post = query_unsafe($query);
    return $blog_post ? $blog_post[0] : null;
}

function getBlogPostByAlias($alias)
{
    $query = "SELECT bp.id, bp.title, bp.alias, bp.header, bp.date, bp.status,bp.content,
GROUP_CONCAT(bt.tag_name SEPARATOR ';') as tags
FROM blog_posts bp
INNER JOIN blog_tags bt ON bp.id = bt.blog_post_id WHERE bp.alias = '" . htmlspecialchars($alias) . "' GROUP BY bp.id";
    $blog_post = query_unsafe($query);
    return $blog_post ? $blog_post[0] : null;
}



function checkBlogPost($elem)
{


    /*if ($elem['status'] !== 'active')
        return null;*/

    $elem['tags'] = explode(';', $elem['tags']);
    return $elem;
}




?>