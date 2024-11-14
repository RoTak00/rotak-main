<?php

class AccountAccountController extends BaseController
{


    public function index()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
        }

        $data = [];

        $data['username'] = $this->user->name;

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['head'] = $this->loadController('common/head');
        return $this->loadView('account/account_info.php', $data);
    }


}