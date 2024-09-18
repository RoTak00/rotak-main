<?php

class HomeController extends BaseController
{

    public function onLoad()
    {
        $this->loadModel('account/auth');
    }

    public function index()
    {

        return $this->loadView('home.php', ['page' => 'ho222me']);
    }
}