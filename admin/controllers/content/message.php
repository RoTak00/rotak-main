<?php

class ContentMessageController extends BaseController
{
    public function index()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
        }

        $data = [];
        $data['heading_title'] = 'User Messages';

        $this->loadModel('content/message');
        $message = $this->model_content_message->getMessages();

        $this->model_content_message->setMessagesViewed();

        $data['messages'] = $message;

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['head'] = $this->loadController('common/head');
        return $this->loadView('message/message_list.php', $data);
    }

    
}