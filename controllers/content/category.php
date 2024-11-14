<?php

class ContentCategoryController extends BaseController
{


    public function index($params)
    {
        if (!isset($params[0])) {
            $this->request->redirect('common/home');
        }

        $data = [];

        $category_id = $params[0];
        $this->loadModel('content/category');



        $category = $this->model_content_category->getCategory($category_id);
        if (empty($category)) {
            $this->notification->set('warning', 'Category not found');
            $this->request->redirect('content/category');
        }
        $data['category'] = $category;

        $data['children_categories'] = $this->model_content_category->getChildrenCategories($category_id);

        $children_posts = $this->model_content_category->getCategoryPosts($category_id);
        $this->loadModel('content/post');
        foreach ($children_posts as &$post) {
            $post['url'] = $this->model_content_post->getPostLink($post['post_id']);
        }

        $data['children_posts'] = array_map(function ($post) {
            $date_display = DateTime::createFromFormat('Y-m-d H:i:s', $post['date_added']);
            if ($date_display) {
                $post['date_display'] = $date_display->format('F d, Y');
            } else {
                $post['date_display'] = $post['date_added'];
            }

            $post['intro'] = strlen(strip_tags($post['page'])) > 100 ? substr(strip_tags($post['page']), 0, 100) . '...' : strip_tags($post['page']);
            return $post;
        }, $children_posts);

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation', ['page_alias' => 'category']);

        $head_settings = ['page_title' => $category['title']];
        $data['head'] = $this->loadController('common/head', $head_settings);
        return $this->loadView('content/category_info.php', $data);
    }
}