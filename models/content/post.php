<?php

class ContentPostModel extends BaseModel
{
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

    public function getPost($post_id)
    {

        $sql = "SELECT p.*, c.title as category_name
         FROM posts p 
         LEFT JOIN post_categories c ON p.category = c.category_id 
         WHERE post_id = '" . (int) $post_id . "'";

        $result = $this->db->query($sql);

        return $result->fetch_assoc();
    }
}