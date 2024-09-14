<?php

class HomeController extends BaseController
{


    public function index()
    {
        return $this->loadView('home.php', ['page' => 'ho222me']);
    }
}