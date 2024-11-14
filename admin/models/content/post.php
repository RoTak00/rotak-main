<?php

class ContentPostModel extends BaseModel
{


    public function getPosts()
    {
        $sql = "SELECT p.*, c.title as category_name FROM posts p 
        LEFT JOIN post_categories c ON p.category = c.category_id ORDER BY post_id DESC";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addPost($data)
    {

        $sql = "INSERT INTO posts 
        SET title = '" . $this->db->escape($data['title']) . "',
        alias = '" . $this->db->escape($data['alias']) . "',
        category = '" . (int) $data['category'] . "',
        active = '" . $this->db->escape($data['active']) . "',
        ordering = '" . $this->db->escape($data['ordering']) . "',
        page = '" . $this->db->escape($data['page']) . "',
        date_added = NOW()";


        $this->db->query($sql);
    }

    public function editPost($data, $post_id)
    {
        $sql = "UPDATE posts
       SET title = '" . $this->db->escape($data['title']) . "',
        alias = '" . $this->db->escape($data['alias']) . "',
        category = '" . (int) $data['category'] . "',
        active = '" . $this->db->escape($data['active']) . "',
        ordering = '" . $this->db->escape($data['ordering']) . "',
        page = '" . $this->db->escape($data['page']) . "'
        WHERE post_id = '" . (int) $post_id . "'";


        $this->db->query($sql);
    }

    public function getPost($post_id)
    {
        $sql = "SELECT * FROM posts WHERE post_id = '" . (int) $post_id . "'";
        $result = $this->db->query($sql);

        return $result->fetch_assoc();
    }


    public function deletePost($post_id)
    {

        $sql = "DELETE FROM posts WHERE post_id = '" . (int) $post_id . "'";
        $this->db->query($sql);
    }

    public function getPostLink($post_id)
    {

        $sql = "SELECT c.alias as category_alias, p.alias as post_alias
         FROM posts p 
         LEFT JOIN post_categories c ON p.category = c.category_id 
         WHERE post_id = '" . (int) $post_id . "'";

        $result = $this->db->query($sql);

        $row = $result->fetch_assoc();

        if ($row['category_alias'] == null) {
            return $row['post_alias'];
        }

        return $row['category_alias'] . '/' . $row['post_alias'];
    }
}