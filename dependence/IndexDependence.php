<?php

defined('_DSEXEC') or die;

final class IndexDependence {

    public static function init() {

        return array(
            "Archivos" => array(
                "Business" => array(),
                "Dao" => array(),
                "Utils" => array()
            )
        );
    }

}
