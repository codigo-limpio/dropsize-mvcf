<?php

defined('_DSEXEC') or die;

class IndexController extends Controller {

    protected $BO;

    public function __construct($args) {
        parent::__construct($args);
        $this->BO = new IndexBusiness($this->getModelo());
    }

    public function Init() {

        if ($this->HasAccess()) {
            $this->BO->Init();
        } else {
            throw new Exception("No existe modelo que cargar");
        }
    }

}
