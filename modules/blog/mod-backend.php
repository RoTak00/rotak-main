<?php
function GetProjectsBlogPosts()
{
    $sql = "SELECT bp.id, bp.title, bp.alias, bp.header, bp.date, 
GROUP_CONCAT(bt.tag_name SEPARATOR ';') as tags
FROM blog_posts bp
INNER JOIN blog_tags bt ON bp.id = bt.blog_post_id GROUP BY bp.id ORDER BY bp.ordering DESC";

    $blog_posts = query_unsafe($sql);
    $blog_posts = array_map(function ($p) {
        return [
            'id' => $p['id'],
            'title' => $p['title'],
            'alias' => $p['alias'],
            'header' => $p['header'],
            'date' => $p['date'],
            'tags' => explode(';', $p['tags']),
        ];
    }, $blog_posts);
    return $blog_posts;
}

$blog_posts = GetProjectsBlogPosts();

?>