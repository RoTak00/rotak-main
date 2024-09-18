<?php

class Registry
{

    public $registry = [];
    public function __construct()
    {
    }

    public function add($reg_item, $reg_value)
    {
        $this->registry[$reg_item] = $reg_value;
    }
}