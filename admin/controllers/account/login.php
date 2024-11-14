<?php

class AccountLoginController extends BaseController
{

    public function index()
    {
        $data = [];

        // if the user is logged, redirect to home
        if ($this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are already logged in');
            return $this->request->redirect('common/home');
        }

        // if there is a post request, attempt login
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['email'] && $this->request->post['password']) {

            // attempt login
            if ($this->user->login($this->request->post['email'], $this->request->post['password'])) {

                $this->notification->set('success', 'Login successful');
                return $this->request->redirect('common/home');
            }

            // login failed
            $this->notification->set('warning', 'Invalid email or password');
            $data['email'] = $this->request->post['email'];

        }


        $data['email'] = null;
        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        }


        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['head'] = $this->loadController('common/head');
        return $this->loadView('account/login.php', $data);
    }

}