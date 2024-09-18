<?php

class AccountController extends BaseController
{


    public function index()
    {
        return $this->loadView('home.php', ['data' => $this->registry['request']->get]);
    }

    public function login()
    {
        return "Login";
    }
}