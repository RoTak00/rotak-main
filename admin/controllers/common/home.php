<?php

class CommonHomeController extends BaseController
{


    public function index()
    {
        $data = [];
        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');



        $data['head'] = $this->loadController('common/head');
        return $this->loadView('common/home.php', $data);
    }
}