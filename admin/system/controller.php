<?php
class BaseController
{
    public $get;
    public $post;
    public $components;

    public function __construct($get, $post, $components)
    {
        $this->get = $get;
        $this->post = $post;
        $this->components = $components;

        $this->onLoad();
    }

    public function onLoad()
    {

    }

    public function loadView($path, $data)
    {
        if (file_exists(__DIR__ . '/../views/' . $path)) {
            extract($data);

            ob_start();
            include __DIR__ . '/../views/' . $path;
            $output = ob_get_clean();

            return $output;
        } else {
            // TODO: Handle error better
            throw new Exception("View file not found: " . $path);
        }

    }

    public function loadController($path, $data = [])
    {
        $path = !empty($path) ? trim($path, '/') : 'home';

        $components = explode('/', $path);

        // construct the variables for the controller
        $class = $components[0];
        $function = $components[1] ?? 'index';
        $extra_components = array_slice($components, 2);
        $params = ['components' => array_merge($extra_components, $this->components), 'get' => $this->get, 'post' => $this->post];

        $file = __DIR__ . '/../controllers/' . $class . '.php';

        if (file_exists($file)) {
            include $file;

            $className = ucfirst($class) . 'Controller'; // test becomes TestController

            if (class_exists($className)) {
                $controller = new $className($this->get, $this->post, $extra_components);
                $output = $controller->$function($params);

                return $output;
            } else {
                throw new Exception("Class not found: " . $className);
            }
        } else {
            throw new Exception("File not found: " . $file);
        }
    }



    // Method to dynamically load a model based on a path (e.g., folder/file)
    public function loadModel($path)
    {
        $modelFile = __DIR__ . '/../models/' . $path . '.php'; // Construct the path for the model file

        // Replace slashes in the path for the property name
        $modelName = 'model_' . str_replace('/', '_', $path);

        if (file_exists($modelFile)) {
            include_once $modelFile;


            // Convert the path to a model class name (e.g., folder_file becomes FolderFileModel)
            $className = implode('', array_map('ucfirst', explode('/', $path))) . 'Model'; // explode

            if (class_exists($className)) {
                // Store the instantiated model in the models array and make it accessible as a property

                $this->$modelName = new $className();
            } else {
                return "Model class $className not found!";
            }
        } else {
            return "Model file $modelFile not found!";
        }
    }

}