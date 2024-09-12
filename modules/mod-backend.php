<?php

// from table projects select title description link if active order by ordering desc
function GetProjectsTech()
{


    $sql = "SELECT p.title, p.description, p.link, p.image,
    GROUP_CONCAT(pt.tag_name SEPARATOR ';') as tags
    FROM projects p
        INNER JOIN project_tags pt ON p.id = pt.project_id
        
     WHERE p.status = 'active' AND p.id IN (
    SELECT project_id
    FROM project_tags
    WHERE tag_name = 'tech'
  ) GROUP BY p.id ORDER BY p.ordering DESC";

    $projects = query_unsafe($sql);
    $projects = array_map(function ($p) {
        global $imageFolderName;
        return [
            'title' => $p['title'],
            'description' => $p['description'],
            'link' => $p['link'],
            'image' => $imageFolderName . "projects/" . $p['image'],
            'tags' => explode(';', $p['tags']),
        ];
    }, $projects);
    return $projects;
}



function GetProjectsVolunteering()
{
    $sql = "SELECT p.title, p.description, p.link, p.image,
    GROUP_CONCAT(pt.tag_name SEPARATOR ';') as tags
    FROM projects p
        INNER JOIN project_tags pt ON p.id = pt.project_id
        
     WHERE p.status = 'active' AND p.id IN (
    SELECT project_id
    FROM project_tags
    WHERE tag_name = 'volunteering'
  ) AND p.id NOT IN (
    SELECT project_id
    FROM project_tags
    WHERE tag_name = 'tech'
  ) GROUP BY p.id ORDER BY p.ordering DESC";

    $projects = query_unsafe($sql);
    $projects = array_map(function ($p) {
        global $imageFolderName;
        return [
            'title' => $p['title'],
            'description' => $p['description'],
            'link' => $p['link'],
            'image' => $imageFolderName . "projects/" . $p['image'],
            'tags' => explode(';', $p['tags']),
        ];
    }, $projects);
    return $projects;
}

$projects_tech = GetProjectsTech();
$projects_volunteering = GetProjectsVolunteering();
?>