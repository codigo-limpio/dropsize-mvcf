<?php

defined('_DSEXEC') or die;

class IndexBusiness {

    protected $modelo;
    public $con;

    public function __construct($modelo) {

        $this->setModelo($modelo);
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function Init() {

        echo "Hola Mundo";
    }

}
