<?php

class ContentPostController extends BaseController
{
    public function index()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
        }

        $data = [];
        $data['heading_title'] = 'Posts';

        $this->loadModel('content/post');
        $posts = $this->model_content_post->getPosts();


        $data['posts'] = array_map(
            function ($p) {
                return [
                    'post_id' => $p['post_id'],
                    'title' => $p['title'],
                    'alias' => $p['alias'],
                    'category_name' => $p['category_name'],
                    'active' => $p['active'],
                    'edit' => '/admin/content/post/edit/' . $p['post_id'],
                    'delete' => '/admin/content/post/delete/' . $p['post_id'],
                ];
            }
            ,
            $posts
        );

        $data['add'] = '/admin/content/post/add';

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['head'] = $this->loadController('common/head');
        return $this->loadView('post/post_list.php', $data);
    }

    public function add()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;
        }

        $this->loadModel('content/post');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {

                $this->model_content_post->addPost($this->request->post);

                $post_id = $this->db->insert_id();
                $alias = $this->model_content_post->getPostLink($post_id);
                $this->url->createAlias($alias, 'content/post/index/' . $post_id);
                $this->notification->set('success', 'Post added');

                if ($this->request->post['save'] == 'save-stay') {
                    $this->request->redirect('content/post/add');
                    return;
                }

                $this->request->redirect('content/post');
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

        $data['category'] = 0;
        if (isset($this->request->post['category'])) {
            $data['category'] = $this->request->post['category'];
        }

        $data['ordering'] = 0;
        if (isset($this->request->post['ordering'])) {
            $data['ordering'] = $this->request->post['ordering'];
        }

        $data['page'] = "";
        if (isset($this->request->post['page'])) {
            $data['page'] = $this->request->post['page'];
        }

        $data['active'] = 1;
        if (isset($this->request->post['active'])) {
            $data['active'] = $this->request->post['active'];
        }

        $data['heading_title'] = 'Add Post';

        $data = $this->loadForm($data);

        return $this->loadView('post/post_form.php', $data);
    }


    public function edit($params)
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;

        }

        if (!isset($params[0])) {
            $this->request->redirect('content/post');
            return;
        }

        $post_id = $params[0];

        $this->loadModel('content/post');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {

                $this->model_content_post->editPost($this->request->post, $post_id);
                $alias = $this->model_content_post->getPostLink($post_id);
                $this->url->editAlias($alias, 'content/post/index/' . $post_id);
                $this->notification->set('success', 'Category edited');

                if ($this->request->post['save'] == 'save-stay') {
                    $this->request->redirect('content/post/edit/' . $post_id);
                    return;
                }

                $this->request->redirect('content/post');
                return;
            }
        }

        $post = $this->model_content_post->getPost($post_id);
        if (!$post) {
            $this->request->redirect('content/post');
            return;
        }

        $data = [];

        $data['title'] = "";
        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } else if (isset($post['title'])) {
            $data['title'] = $post['title'];
        }


        $data['alias'] = "";
        if (isset($this->request->post['alias'])) {
            $data['alias'] = $this->request->post['alias'];
        } else if (isset($post['alias'])) {
            $data['alias'] = $post['alias'];
        }

        $data['category'] = 0;
        if (isset($this->request->post['category'])) {
            $data['category'] = $this->request->post['category'];
        } else if (isset($post['category'])) {
            $data['category'] = $post['category'];
        }

        $data['ordering'] = 0;
        if (isset($this->request->post['ordering'])) {
            $data['ordering'] = $this->request->post['ordering'];
        } else if (isset($post['ordering'])) {
            $data['ordering'] = $post['ordering'];
        }

        $data['page'] = "";
        if (isset($this->request->post['page'])) {
            $data['page'] = $this->request->post['page'];
        } else if (isset($post['page'])) {
            $data['page'] = $post['page'];
        }



        $data['active'] = 1;
        if (isset($this->request->post['active'])) {
            $data['active'] = $this->request->post['active'];
        } else if (isset($post['active'])) {
            $data['active'] = $post['active'];
        }

        $data['heading_title'] = 'Edit Post';

        $data = $this->loadForm($data);

        return $this->loadView('post/post_form.php', $data);
    }

    public function delete($params)
    {

        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;
        }

        if (!isset($params[0])) {
            $this->request->redirect('content/post');
            return;
        }

        $post_id = $params[0];


        $this->loadModel('content/post');

        $alias = $this->model_content_post->getPostLink($post_id);
        $this->url->removeAlias($alias);
        $this->model_content_post->deletePost($post_id);

        $this->notification->set('success', 'Post deleted');
        $this->request->redirect('content/post');
        return;
    }


    private function loadForm($data)
    {
        $this->request->addScript('/admin/resources/scripts/content/render_html.js');
        $data['cancel'] = '/admin/content/post';
        $this->loadModel('content/category');

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

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['image_manager'] = $this->loadController('module/filemanager', [
            'no_input' => true
        ]);


        $data['head'] = $this->loadController('common/head');

        return $data;
    }

    public function validateForm()
    {
        return true;
    }
}