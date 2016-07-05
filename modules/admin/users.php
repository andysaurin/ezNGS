<?php

class users extends NQ_Auth_Admin
{
    public function __construct()
    {
        parent::__construct();
        $this->class_title = "Manage User";
    }

    public function __default()
    {

    }

    public function __destruct()
    {
        parent::__destruct();
    }

}

?>