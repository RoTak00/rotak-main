<?php

class ContentProjectController extends BaseController
{
    public function index()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
        }

        $data = [];
        $data['heading_title'] = "Projects";

        $this->loadModel('content/project');
        $projects = $this->model_content_project->getProjects();

        $data['projects'] = array_map(
            function ($p) {
                return [
                    'project_id' => $p['id'],
                    'title' => $p['title'],
                    'status' => $p['status'],
                    'ordering' => $p['ordering'],
                    'edit' => '/admin/content/project/edit/' . $p['id'],
                    'delete' => '/admin/content/project/delete/' . $p['id'],
                ];
            }
            ,
            $projects
        );

        $data['add'] = '/admin/content/project/add';

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');

        $data['head'] = $this->loadController('common/head');
        return $this->loadView('project/project_list.php', $data);
    }

    public function add()
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;
        }

        $this->loadModel('content/project');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {

                $this->model_content_project->addProject($this->request->post);

                $this->notification->set('success', 'Project added');

                if ($this->request->post['save'] == 'save-stay') {
                    $this->request->redirect('content/project/add');
                    return;
                }

                $this->request->redirect('content/project');
                return;
            }
        }

        $data = [];

        $data['title'] = "";
        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        }

        $data['description'] = "";
        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        }

        $data['image'] = "";
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        }

        $data['link'] = "";
        if (isset($this->request->post['link'])) {
            $data['link'] = $this->request->post['link'];
        }

        $data['status'] = 'inactive';
        if (
            isset($this->request->post['status'])
            && in_array($this->request->post['status'], ['active', 'inactive', 'deleted'])
        ) {
            $data['status'] = $this->request->post['status'];
        }

        $data['project_date'] = '';
        if (isset($this->request->post['project_date'])) {
            $data['project_date'] = $this->request->post['project_date'];
        }

        $data['ordering'] = 0;
        if (isset($this->request->post['ordering'])) {
            $data['ordering'] = $this->request->post['ordering'];
        }

        $data['tags'] = array();
        $data['tags_string'] = '';
        if (isset($this->request->post['tags'])) {
            $data['tags'] = explode(',', $this->request->post['tags']);
            $data['tags_string'] = $this->request->post['tags'];
        }

        $data['heading_title'] = 'Add Project';

        $data = $this->loadForm($data);

        return $this->loadView('project/project_form.php', $data);
    }

    public function edit($params)
    {
        if (!$this->user->LoggedIn()) {
            $this->notification->set('warning', 'You are not logged in');
            $this->request->redirect('account/login');
            return;

        }

        if (!isset($params[0])) {
            $this->request->redirect('content/project');
            return;
        }

        $project_id = $params[0];

        $this->loadModel('content/project');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {

                $this->model_content_project->editProject($this->request->post, $project_id);
                $this->notification->set('success', 'Category edited');

                if ($this->request->post['save'] == 'save-stay') {
                    $this->request->redirect('content/project/edit/' . $project_id);
                    return;
                }

                $this->request->redirect('content/project');
                return;
            }
        }

        $project = $this->model_content_project->getProject($project_id);
        if (!$project) {
            $this->request->redirect('content/post');
            return;
        }

        $data = [];

        $data['title'] = "";
        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } else if (isset($project['title'])) {
            $data['title'] = $project['title'];
        }

        $data['description'] = "";
        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } else if (isset($project['description'])) {
            $data['description'] = $project['description'];
        }

        $data['image'] = "";
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } else if (isset($project['image'])) {
            $data['image'] = $project['image'];
        }

        $data['link'] = "";
        if (isset($this->request->post['link'])) {
            $data['link'] = $this->request->post['link'];
        } else if (isset($project['link'])) {
            $data['link'] = $project['link'];
        }

        $data['status'] = "";
        if (
            isset($this->request->post['status']) &&
            in_array($this->request->post['status'], ['active', 'inactive', 'deleted'])
        ) {
            $data['status'] = $this->request->post['status'];
        } else if (isset($project['status'])) {
            $data['status'] = $project['status'];
        }

        $data['project_date'] = "";
        if (isset($this->request->post['project_date'])) {
            $data['project_date'] = $this->request->post['project_date'];
        } else if (isset($project['project_date'])) {
            $data['project_date'] = $project['project_date'];
        }

        $data['ordering'] = "";
        if (isset($this->request->post['ordering'])) {
            $data['ordering'] = $this->request->post['ordering'];
        } else if (isset($project['ordering'])) {
            $data['ordering'] = $project['ordering'];
        }

        $data['tags'] = array();
        $data['tags_string'] = '';
        if (isset($this->request->post['tags'])) {
            $data['tags'] = explode(',', $this->request->post['tags']);
            $data['tags_string'] = $this->request->post['tags'];
        } else {
            $data['tags'] = $project['tags'];
            $data['tags_string'] = implode(",", array_column($project['tags'], 'tag_name'));
        }



        $data['page'] = "";
        if (isset($this->request->post['page'])) {
            $data['page'] = $this->request->post['page'];
        } else if (isset($project['page'])) {
            $data['page'] = $project['page'];
        }

        $data['heading_title'] = 'Edit Project';

        $data = $this->loadForm($data);

        return $this->loadView('project/project_form.php', $data);
    }

    private function loadForm($data)
    {
        $this->request->addScript('/admin/resources/scripts/content/render_html.js');
        $this->request->addScript('/admin/resources/scripts/content/project_tags.js');
        $data['cancel'] = '/admin/content/project';
        $this->loadModel('content/project');

        $data['image_manager'] = $this->loadController('module/filemanager', [
            'path' => $data['image']
        ]);

        $data['footer'] = $this->loadController('common/footer');
        $data['navigation'] = $this->loadController('common/navigation');


        $data['head'] = $this->loadController('common/head');

        return $data;
    }

    public function validateForm()
    {
        return true;
    }

    public function delete($params)
    {
        if (!$this->user->LoggedIn()) {
            http_response_code(403);
            return;
        }

        if (!isset($params[0])) {
            $this->request->redirect('content/project');
            return;
        }

        $this->loadModel('content/project');

        $this->model_content_project->deleteTags((int) $params[0]);


        $this->model_content_project->softDeleteProject((int) $params[0]);
        $this->notification->set('success', 'Project deleted');
        $this->request->redirect('content/project');
    }
}