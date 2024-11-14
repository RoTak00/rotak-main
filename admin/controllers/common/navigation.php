<?php

class CommonNavigationController extends BaseController
{

    public function index()
    {

        $this->request->addStyle('/admin/resources/css/common/navigation.css');
        $data = [];

        $data['logged'] = $this->user->LoggedIn();
        if ($data['logged']) {
            $data['username'] = $this->user->name;
        }

        $data['notifications'] = $this->loadController('common/notification');

        return $this->loadView('common/navigation.php', $data);
    }
}