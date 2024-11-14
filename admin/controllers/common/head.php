<?php

class CommonHeadController extends BaseController
{

        public function index($setting = [])
        {
                $this->request->addStyle("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css", [], 1);
                $this->request->addStyle("/admin/resources/inc/bootstrap.min.css", [], 1);
                $this->request->addScript("/admin/resources/inc/bootstrap.bundle.min.js", [], 1);
                $this->request->addScript("/admin/resources/inc/jquery.js", [], 1);



                $data = [];

                $data['styles'] = $this->request->getStyles();
                $data['scripts'] = $this->request->getScripts();


                $data['title'] = $setting['page_title'] ?? 'Admin';


                return $this->loadView('common/head.php', $data);
        }
}