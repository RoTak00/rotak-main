<?php

class ContentPostController extends BaseController
{


    public function index($params)
    {
        if (!isset($params[0])) {
            $this->request->redirect('common/home');
        }

        $data = [];

        $post_id = $params[0];
        $this->loadModel('content/post');



        $post = $this->model_content_post->getPost($post_id);

        $post['page'] = $this->image->replaceImages($post['page']);
        if ($post['page'])
            if (empty($post)) {
                $this->notification->set('warning', 'Post not found');
                $this->request->redirect('common/home');
            }
        $data['post'] = $post;



        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation', ['page_alias' => 'post']);

        $head_settings = ['page_title' => $post['title']];
        $data['head'] = $this->loadController('common/head', $head_settings);
        return $this->loadView('content/post_info.php', $data);
    }
}