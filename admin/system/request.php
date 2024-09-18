<?php
class Request
{

    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function __get($name)
    {
        // Fetch from the registry if it exists
        if (isset($this->registry->registry[$name])) {
            return $this->registry->registry[$name];
        }
        return null; // Or throw an error if you want strict behavior
    }


}