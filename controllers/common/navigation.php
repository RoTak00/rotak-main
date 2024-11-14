<?php

class CommonNavigationController extends BaseController
{

    public function index($settings = [])
    {

        $this->request->addStyle('/resources/css/common/navigation.css');
        $data = [];

        $data['page_alias'] = $settings['page_alias'] ?? 'index';
        $this->loadModel('content/category');
        $data['categories'] = $this->model_content_category->getMenuCategoryList();

        $data['notifications'] = $this->loadController('common/notification');

        return $this->loadView('common/navigation.php', $data);
    }
}