<?php
function GetProjectsIdeas()
{
    $sql = "SELECT pi.title, pi.content, pi.date,
GROUP_CONCAT(pit.tag_name SEPARATOR ';') as tags
FROM project_ideas pi
INNER JOIN project_idea_tags pit ON pi.id = pit.project_idea_id

WHERE pi.status = 'active' GROUP BY pi.id ORDER BY pi.ordering DESC";

    $project_ideas = query_unsafe($sql);
    $project_ideas = array_map(function ($p) {
        return [
            'title' => $p['title'],
            'content' => $p['content'],
            'tags' => explode(';', $p['tags']),
            'date' => $p['date'],
        ];
    }, $project_ideas);
    return $project_ideas;
}

$project_ideas = GetProjectsIdeas();

?>