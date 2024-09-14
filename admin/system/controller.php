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
}