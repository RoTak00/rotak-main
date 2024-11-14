<?php

class ContentProjectModel extends BaseModel
{


    public function getProjects()
    {
        $sql = "SELECT p.id, p.title, p.status, p.ordering FROM projects p WHERE p.status != 'deleted' ORDER BY id DESC";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function getProject($project_id)
    {
        $sql = "SELECT * FROM projects WHERE id = '" . (int) $project_id . "'";
        $result = $this->db->query($sql);

        $project = $result->fetch_assoc();

        $sql = "SELECT id, tag_name FROM project_tags WHERE project_id = '" . (int) $project_id . "' ORDER BY tag_name ASC";
        $result = $this->db->query($sql);

        $tags = $result->fetch_all(MYSQLI_ASSOC);

        $project['tags'] = $tags;

        return $project;
    }

    public function addProject($data)
    {
        $sql = "INSERT INTO projects 
        SET title = '" . $this->db->escape($data['title']) . "',
        description = '" . $this->db->escape($data['description']) . "',
        image = '" . $this->db->escape($data['image']) . "',
        link = '" . $this->db->escape($data['link']) . "',
        status = '" . $this->db->escape($data['status']) . "',
        ordering = '" . $this->db->escape($data['ordering']) . "', 
        project_date = '" . $this->db->escape($data['project_date']) . "'";

        $this->db->query($sql);

        $project_id = $this->db->insert_id();

        if (!empty($data['tags'])) {
            $tags_array = explode(',', $data['tags']);
            $this->addTags($project_id, $tags_array);
        }

        return $project_id;

    }

    public function editProject($data, $project_id)
    {
        $sql = "UPDATE projects SET 
        title = '" . $this->db->escape($data['title']) . "',
        description = '" . $this->db->escape($data['description']) . "',
        image = '" . $this->db->escape($data['image']) . "',
        link = '" . $this->db->escape($data['link']) . "',
        status = '" . $this->db->escape($data['status']) . "',
        ordering = '" . $this->db->escape($data['ordering']) . "', 
        project_date = '" . $this->db->escape($data['project_date']) . "' WHERE id = '" . (int) $project_id . "'";
        $this->db->query($sql);

        $this->deleteTags($project_id);


        if (!empty($data['tags'])) {
            $tags_array = explode(',', $data['tags']);
            $this->addTags($project_id, $tags_array);
        }

        return $project_id;

    }

    public function addTags($project_id, $tags)
    {
        $sql_insert = "INSERT INTO project_tags (project_id, tag_name) VALUES {project_tags}";


        $tags = array_filter($tags, function ($tag) {
            if (empty(trim($tag)) || $tag == '')
                return false;

            return true;
        });

        $to_insert = implode(',', array_map(function ($tag) use ($project_id) {

            return "('" . $this->db->escape($project_id) . "', '" . $this->db->escape($tag) . "')";
        }, $tags));

        $sql_insert = str_replace('{project_tags}', $to_insert, $sql_insert);

        //file_put_contents("log-sql.log", $sql_insert, FILE_APPEND);

        $this->db->query($sql_insert);
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Deletes all tags associated with a specific project.
     *
     * @param int $project_id The ID of the project whose tags are to be deleted.
     */
    /******  7bd1bb36-093a-41a5-93bc-52b8c7a90c64  *******/
    public function deleteTags($project_id)
    {

        $sql = "DELETE FROM project_tags WHERE project_id = '" . (int) $project_id . "'";
        $this->db->query($sql);
    }

    public function deleteProject($project_id)
    {
        $sql = "DELETE FROM projects WHERE id = '" . (int) $project_id . "'";
        $this->db->query($sql);
    }

    public function softDeleteProject($project_id)
    {
        $sql = "UPDATE projects SET status = 'deleted' WHERE id = '" . (int) $project_id . "'";
        $this->db->query($sql);
    }



}