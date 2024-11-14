<?php

class CommonHeadController extends BaseController
{

    public function index($setting = [])
    {
        $this->request->addStyle("/resources/inc/bootstrap.min.css", [], 1);
        $this->request->addScript("/resources/inc/bootstrap.bundle.min.js", [], 1);
        $this->request->addScript("/resources/inc/jquery.js", [], 1);

        $this->request->addStyle("/resources/css/common/styles.css");

        $data = [];

        $data['styles'] = $this->request->getStyles();
        $data['scripts'] = $this->request->getScripts();


        $data['title'] = $setting['page_title'] ?? 'Admin';


        return $this->loadView('common/head.php', $data);
    }
}