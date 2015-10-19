<?php

defined('_DSEXEC') or die;

final class IndexModel {

    private static $id;

    public function __construct() {
        self::$id = "id";
    }

    public function init() {
        $args = func_get_args();
        return array("ID" => self::$id
            , "Metodo" => "GET"
            , "Tipo" => "Seguros"
            , "Index" => array()
            , "Alias" => array()
            , "Params" => $args[0]
            , "Seguros" => $args[1]
        );
    }

}
