<?php

class AccountLogoutController extends BaseController
{

    public function index()
    {
        $this->user->logout();
        $this->notification->set('success', 'Logout successful');
        if (isset($this->request->post['continue'])) {
            return $this->request->redirect($this->request->post['continue']);
        }
        return $this->request->redirect('common/home');
    }
}