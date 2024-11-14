<?php

class ModuleFilemanagerController extends BaseController
{

    const THUMB_SIZE = 300;

    public function index($settings = [])
    {
        if (!$this->user->LoggedIn()) {
            return;
        }

        $this->request->addScript('/admin/resources/scripts/module/filemanager.js');
        $this->request->addStyle('/admin/resources/css/module/filemanager.css');

        $data = [];

        $data['file_name'] = $settings['name'] ?? 'image';
        $data['file_path'] = $settings['path'] ?? '';
        $data['no_input'] = !empty($settings['no_input']);

        if (!empty($data['file_path']))
            $data['thumbnail'] = $this->image->image($data['file_path'], self::THUMB_SIZE);
        else
            $data['thumbnail'] = '';

        return $this->loadView('module/filemanager_formitem.php', $data);
    }

    public function load()
    {
        if (!$this->user->LoggedIn()) {
            http_response_code(403);
            return;
        }

        $selected_path = $_POST['path'] ?? null;
        if (!$selected_path) {
            if (isset($_COOKIE['filemanager_path'])) {
                $selected_path = $_COOKIE['filemanager_path'];
            }
        }
        $path = false;

        $file_names = [];
        $dir_names = [];

        if ($selected_path) {

            if ($selected_path[0] != '/')
                $path = BASE_DIR . 'resources/images/' . $selected_path;
            else
                $path = $selected_path;

            if (!is_dir($path)) {
                $path_image_folder = explode('/', $selected_path);
                if (count($path_image_folder) > 1) {
                    $path_image_folder = array_slice($path_image_folder, 0, count($path_image_folder) - 1);
                    $path_image_folder = implode('/', $path_image_folder);
                } else {
                    $path_image_folder = null;
                }
                $path = $path_image_folder;

            }
            $path = realpath($path);
        }


        if ($path == false) {
            $path = realpath(BASE_DIR . 'resources/images');
        }

        $is_root = false;
        if ($path == realpath(BASE_DIR . 'resources/images')) {
            $is_root = true;
        }



        if (is_dir($path)) {
            $files = scandir($path);

            foreach ($files as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file)) {
                    $dir_names[] = $path . '/' . $file;
                } else {
                    // Check if file is an image
                    $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        // Use the image function to create a 30x30 thumbnail and add to file names
                        $thumbnail_path = $this->image->image($path . '/' . $file, 30, 30);
                        $file_names[] = ['path' => $path . '/' . $file, 'thumbnail' => $thumbnail_path];
                    } else {
                        $file_names[] = ['path' => $path . '/' . $file];
                    }
                }
            }
        }

        setcookie('filemanager_path', $path, time() + 60 * 60 * 24 * 30, "/");
        $data['is_root'] = $is_root;
        $data['file_names'] = $file_names;
        $data['dir_names'] = $dir_names;
        $data['current_path'] = $path;
        $data['display_path'] = str_replace(BASE_DIR . '/resources/images', '/', $path);
        $data['parent'] = $is_root ? '/' : ($path . '/../');


        return $this->loadView('module/filemanager.php', $data);

    }

    public function create_folder()
    {
        if (!$this->user->LoggedIn()) {
            http_response_code(403);
            return;
        }

        if (!isset($_POST['path'])) {
            http_response_code(400);
            return;
        }

        if (!isset($_POST['folder_name'])) {
            http_response_code(400);
            return;
        }

        $path = $_POST['path'];
        $folder = $_POST['folder_name'];

        $response = [];
        if ($path && $folder) {
            $new_path = $path . '/' . $folder;

            if (!file_exists($new_path) && mkdir($new_path, 0777, true)) {
                http_response_code(200);
                $response['success'] = true;
            } else {
                http_response_code(500);
                $response['success'] = false;
            }
        }

        return json_encode($response);
    }

    public function upload()
    {
        if (!$this->user->LoggedIn()) {
            http_response_code(403);
            return;
        }

        if (!isset($_POST['path'])) {
            http_response_code(400);
            return;
        }

        $path = $_POST['path'];
        if (!$path) {
            http_response_code(400);
            return;
        }

        $upload_dir = rtrim($path, '/') . '/';

        if (empty($_FILES['file'])) {
            http_response_code(400);
            return;
        }

        if (!is_dir($upload_dir)) {
            http_response_code(400);
            return;
        }

        $response = [];
        $target_dir = $path . '/';
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            http_response_code(200);
            $response['success'] = true;
        } else {
            http_response_code(500);
            $response['success'] = false;
        }

        return json_encode($response);



    }

    public function downloadImage()
    {
        if (!$this->user->LoggedIn()) {
            http_response_code(403);
            return;
        }

        if (!isset($_POST['path'])) {
            http_response_code(400);
            return;
        }

        $path = $_POST['path'];
        if (!$path) {
            http_response_code(400);
            return;
        }


        if (!file_exists($path)) {
            http_response_code(400);
            return;
        }


        $thumbnail = $this->image->image($path, self::THUMB_SIZE);
        if ($thumbnail) {
            http_response_code(200);
            echo $thumbnail;
        } else {
            echo "";
        }
    }

    public function delete()
    {
        if (!$this->user->LoggedIn()) {
            http_response_code(403);
            return;
        }

        if (!isset($_POST['path'])) {
            http_response_code(400);
            return;
        }

        $path = $_POST['path'];
        if (!$path) {
            http_response_code(400);
            return;
        }


        if (!file_exists($path)) {
            http_response_code(400);
            return;
        }


        if (unlink($path)) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    }




}