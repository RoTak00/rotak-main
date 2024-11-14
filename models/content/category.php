<?php

class ContentCategoryModel extends BaseModel
{
    public function getMenuCategoryList()
    {
        $sql_parent_categories = "SELECT category_id, title, alias FROM post_categories WHERE parent = 0 AND active = 1 ORDER BY ordering ASC";
        $result = $this->db->query($sql_parent_categories);


        $categories = [];

        while ($category = $result->fetch_assoc()) {

            // For each main category, fetch its active children
            $sql_children = "SELECT category_id, title, alias FROM post_categories WHERE parent = " . $category['category_id'] . " AND active = 1 ORDER BY ordering ASC";
            $result_children = $this->db->query($sql_children);
            $result_children = $result_children->fetch_all();

            $children = array_map(function ($child) {
                return ['title' => $child[1], 'alias' => $child[2]];
            }, $result_children);

            // Add the main category and its children to the categories array
            $categories[] = [
                'title' => $category['title'],
                'alias' => $category['alias'],
                'children' => $children
            ];
        }

        return $categories;
    }

    public function getCategory($category_id)
    {

        $sql = "SELECT category_id, title, alias, page FROM post_categories WHERE active = 1 AND category_id = " . (int) $category_id;

        $result = $this->db->query($sql);

        return $result->fetch_assoc();
    }

    public function getChildrenCategories($category_id)
    {

        $sql = "SELECT category_id, title, alias FROM post_categories WHERE parent = " . (int) $category_id . " AND active = 1 ORDER BY ordering ASC";

        $result = $this->db->query($sql);

        $categories = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($categories as &$category) {
            $category['url'] = '/' . $category['alias'];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryPosts($category_id)
    {
        $sql = "SELECT post_id, title, alias, page, date_added FROM posts p WHERE category = " . (int) $category_id . " AND active = 1 ORDER BY ordering ASC";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}