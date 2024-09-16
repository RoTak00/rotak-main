<?php

class HomeController extends BaseController
{

    public function onLoad()
    {
        $this->loadModel('account/auth');
    }

    public function index()
    {

        if (!$this->model_account_auth->isAuth()) {
            return $this->loadController('account/login');
        }

        return $this->loadView('home.php', ['page' => 'ho222me']);
    }
}