<?php

class CommonHomeController extends BaseController
{


    public function index()
    {
        $data = [];

        $this->request->addScript('/resources/scripts/scroll-to.js');
        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');



        $data['projects'] = $this->loadController('content/project/projectList');
        $data['about_me'] = $this->loadView('module/home_about_me.php');
        $data['contact'] = $this->loadController('module/contactform');

        $head_settings = ['page_title' => 'Rotak - Home'];
        $data['head'] = $this->loadController('common/head', $head_settings);
        return $this->loadView('common/home.php', $data);
    }
}