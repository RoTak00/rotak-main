<?php

class ContentProjectController extends BaseController
{
    public function projectList($params)
    {
        $this->request->addStyle('/resources/css/content/project.css');
        $this->request->addScript('/resources/scripts/filter-projects.js');
        $this->loadModel('content/project');
        $projects = $this->model_content_project->getProjects();

        $projects = array_map(function ($p) {
            $p['image'] = $this->image->image($p['image'], 600);
            $p['tags'] = explode(';', $p['tags']);
            $p['link'] = !empty(trim($p['link'])) ? $p['link'] : null;
            return $p;
        }, $projects);

        $data['projects'] = $projects;

        return $this->loadView('content/project_list.php', $data);

    }
}