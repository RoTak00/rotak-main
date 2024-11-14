<?php

class ModuleContactformController extends BaseController
{

    public function index()
    {
        $this->request->addScript('/resources/scripts/contact-form.js');
        return $this->loadView('module/contact_form.php');
    }

    public function send()
    {
        if (!$_SERVER['REQUEST_METHOD'] == 'POST') {
            http_response_code(400);
            die();
        }

        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
            http_response_code(400);
            die();
        }

        if (!empty($_POST['phone'])) // honeypot
        {
            http_response_code(418);
            // bots
            die();
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // save to db

        $this->loadModel('tool/contact');

        $this->model_tool_contact->saveMessage($name, $email, $message);

        /*$this->loadModel('tool/mail');

        if (!$this->model_tool_mail->sendMail($name, $email, $message)) {
            http_response_code(500);
            die();
        }*/

    }
}