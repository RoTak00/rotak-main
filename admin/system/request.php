<?php
class Request
{

    public function __construct($registry)
    {
        $this->registry = $registry->registry;
        $this->get = $_GET;
        $this->post = $_POST;
    }


}