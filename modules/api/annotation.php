<?php

class annotation extends NQ_Auth_User
{
    public function __construct()
    {
        parent::__construct();
        $this->class_title = "";
    }

    public function __default()
    {

    }

    public function load()
    {
        //Verification
        if ( !$_POST['project_id'] || !is_numeric($_POST['project_id']) || $_POST['project_id'] < 0)
            die("not_ok 2");
        /*Ecrire suite donc appel d'une fonction qui récup toutes les infos des fichiers du project
        puis $this-> set de l'array*/

        $this->all_files = $this->get_all_files_in_project($_POST['project_id']);
die(print_r($this->all_files));
        $this->set('filetable', $this->all_files);

        /*if (empty($this->all_files)){
            die("the project is empty");
        }else{
            $this->set('filetable', $this->all_files);
        }*/
    }
    public function __destruct()
    {
        parent::__destruct();
    }

}

?>