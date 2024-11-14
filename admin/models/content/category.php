<?php

class ContentCategoryModel extends BaseModel
{


    public function getCategories()
    {
        $sql = "SELECT * FROM post_categories ORDER BY category_id DESC";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addCategory($data)
    {


        $sql = "INSERT INTO post_categories 
        SET title = '" . $this->db->escape($data['title']) . "',
        alias = '" . $this->db->escape($data['alias']) . "',
        parent = '" . (int) $data['parent'] . "',
        active = '" . $this->db->escape($data['active']) . "',
        ordering = '" . $this->db->escape($data['ordering']) . "',
        show_list = '" . (int) $data['show_list'] . "',
        page = '" . $this->db->escape($data['page']) . "'";


        $this->db->query($sql);
    }

    public function editCategory($data, $category_id)
    {
        $sql = "UPDATE post_categories 
        SET title = '" . $this->db->escape($data['title']) . "',
        alias = '" . $this->db->escape($data['alias']) . "',
        parent = '" . (int) $data['parent'] . "',
        active = '" . $this->db->escape($data['active']) . "',
        ordering = '" . $this->db->escape($data['ordering']) . "',
        show_list = '" . (int) $data['show_list'] . "',
        page = '" . $this->db->escape($data['page']) . "'
        WHERE category_id = '" . (int) $category_id . "'";


        $this->db->query($sql);
    }

    public function getCategory($category_id)
    {
        $sql = "SELECT * FROM post_categories WHERE category_id = '" . (int) $category_id . "'";
        $result = $this->db->query($sql);

        return $result->fetch_assoc();
    }


    public function deleteCategory($category_id)
    {

        $sql = "DELETE FROM post_categories WHERE category_id = '" . (int) $category_id . "'";
        $this->db->query($sql);
    }
}