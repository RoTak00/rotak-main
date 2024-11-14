<?php

class ContentCategoryController extends BaseController
{
    public function index()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
        }

        $data = [];
        $data['heading_title'] = 'Categories';

        $this->loadModel('content/category');
        $categories = $this->model_content_category->getCategories();


        $data['categories'] = array_map(
            function ($c) {
                return [
                    'category_id' => $c['category_id'],
                    'title' => $c['title'],
                    'alias' => $c['alias'],
                    'active' => $c['active'],
                    'edit' => '/admin/content/category/edit/' . $c['category_id'],
                    'delete' => '/admin/content/category/delete/' . $c['category_id'],
                ];
            }
            ,
            $categories
        );

        $data['add'] = '/admin/content/category/add';

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['head'] = $this->loadController('common/head');
        return $this->loadView('category/category_list.php', $data);
    }

    public function add()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;
        }

        $this->loadModel('content/category');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {

                $this->model_content_category->addCategory($this->request->post);
                $category_id = $this->db->insert_id();
                $this->url->createAlias($this->request->post['alias'], 'content/category/index/' . $category_id);
                $this->notification->set('success', 'Category added');

                if ($this->request->post['save'] == 'save-stay') {
                    $this->request->redirect('content/category/add');
                    return;
                }

                $this->request->redirect('content/category');
                return;
            }
        }

        $data = [];

        $data['title'] = "";
        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        }

        $data['alias'] = "";
        if (isset($this->request->post['alias'])) {
            $data['alias'] = $this->request->post['alias'];
        }

        $data['parent'] = 0;
        if (isset($this->request->post['parent'])) {
            $data['parent'] = $this->request->post['parent'];
        }

        $data['ordering'] = 0;
        if (isset($this->request->post['ordering'])) {
            $data['ordering'] = $this->request->post['ordering'];
        }

        $data['page'] = "";
        if (isset($this->request->post['page'])) {
            $data['page'] = $this->request->post['page'];
        }

        $data['show_list'] = 1;
        if (isset($this->request->post['show_list'])) {
            $data['show_list'] = $this->request->post['show_list'];
        }

        $data['active'] = 1;
        if (isset($this->request->post['active'])) {
            $data['active'] = $this->request->post['active'];
        }

        $data['heading_title'] = 'Add Category';

        $data = $this->loadForm($data);

        return $this->loadView('category/category_form.php', $data);
    }


    public function edit($params)
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;

        }

        if (!isset($params[0])) {
            $this->request->redirect('content/category');
            return;
        }

        $category_id = $params[0];

        $this->loadModel('content/category');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {

                $this->model_content_category->editCategory($this->request->post, $category_id);
                $this->url->editAlias($this->request->post['alias'], 'content/category/index/' . $category_id);
                $this->notification->set('success', 'Category edited');

                if ($this->request->post['save'] == 'save-stay') {
                    $this->request->redirect('content/category/edit/' . $category_id);
                    return;
                }

                $this->request->redirect('content/category');
                return;
            }
        }

        $category = $this->model_content_category->getCategory($category_id);
        if (!$category) {
            $this->request->redirect('content/category');
            return;
        }

        $data = [];

        $data['title'] = "";
        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } else if (isset($category['title'])) {
            $data['title'] = $category['title'];
        }


        $data['alias'] = "";
        if (isset($this->request->post['alias'])) {
            $data['alias'] = $this->request->post['alias'];
        } else if (isset($category['alias'])) {
            $data['alias'] = $category['alias'];
        }

        $data['parent'] = 0;
        if (isset($this->request->post['parent'])) {
            $data['parent'] = $this->request->post['parent'];
        } else if (isset($category['parent'])) {
            $data['parent'] = $category['parent'];
        }

        $data['ordering'] = 0;
        if (isset($this->request->post['ordering'])) {
            $data['ordering'] = $this->request->post['ordering'];
        } else if (isset($category['ordering'])) {
            $data['ordering'] = $category['ordering'];
        }

        $data['page'] = "";
        if (isset($this->request->post['page'])) {
            $data['page'] = $this->request->post['page'];
        } else if (isset($category['page'])) {
            $data['page'] = $category['page'];
        }

        $data['show_list'] = 1;
        if (isset($this->request->post['show_list'])) {
            $data['show_list'] = $this->request->post['show_list'];
        } else if (isset($category['show_list'])) {
            $data['show_list'] = $category['show_list'];
        }

        $data['active'] = 1;
        if (isset($this->request->post['active'])) {
            $data['active'] = $this->request->post['active'];
        } else if (isset($category['active'])) {
            $data['active'] = $category['active'];
        }

        $data['heading_title'] = 'Edit Category';

        $data = $this->loadForm($data);

        return $this->loadView('category/category_form.php', $data);
    }

    public function delete($params)
    {

        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;
        }

        if (!isset($params[0])) {
            $this->request->redirect('content/category');
            return;
        }

        $category_id = $params[0];


        $this->loadModel('content/category');

        $category = $this->model_content_category->getCategory($category_id);
        $this->url->removeAlias($category['alias']);
        $this->model_content_category->deleteCategory($category_id);

        $this->notification->set('success', 'Category deleted');
        $this->request->redirect('content/category');
        return;
    }


    private function loadForm($data)
    {
        $this->request->addScript('/admin/resources/scripts/content/render_html.js');
        $data['cancel'] = '/admin/content/category';
        $parent_categories = $this->model_content_category->getCategories();

        $data['parent_categories'] = array_map(
            function ($c) {
                return [
                    'category_id' => $c['category_id'],
                    'title' => $c['title'],
                ];
            }
            ,
            $parent_categories
        );

        $data['image_manager'] = $this->loadController('module/filemanager', [
            'no_input' => true
        ]);

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');


        $data['head'] = $this->loadController('common/head');

        return $data;
    }

    public function validateForm()
    {
        return true;
    }
}