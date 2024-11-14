<?php

class ContentProjectModel extends BaseModel
{
    public function getProjects()
    {
        $sql = "SELECT p.title, p.description, p.link, p.image,
        GROUP_CONCAT(pt.tag_name SEPARATOR ';') as tags
            FROM projects p
            INNER JOIN project_tags pt ON p.id = pt.project_id
        
            WHERE p.status = 'active' AND p.id IN (
            SELECT project_id
            FROM project_tags
            ) GROUP BY p.id ORDER BY p.ordering DESC";

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);

    }
}