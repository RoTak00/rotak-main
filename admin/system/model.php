<?php
class BaseModel
{

    public $get;
    public $post;
    public $components;
    public $registry;

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->onLoad();
    }

    public function onLoad()
    {

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