<?php

/**
 * DropsizeMVCf - extension of the SlimFramework and others tools
 *
 * @author      Isaac Trenado <isaac.trenado@codigolimpio.com>
 * @copyright   2013 Isaac Trenado
 * @link        http://dropsize.codigolimpio.com
 * @license     http://dropsize.codigolimpio.com/license.txt
 * @version     3.0.1
 * @package     DropsizeMVCf
 *
 * DropsizeMVCf - Web publishing software
 * Copyright 2015 by the contributors
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 * This program incorporates work covered by the following copyright and
 * permission notices:
 * 
 * DropsizeMVCf is (c) 2013, 2015 
 * Isaac Trenado - isaac.trenado@codigolimpio.com -
 * http://www.codigolimpio.com
 * 
 * Wherever third party code has been used, credit has been given in the code's comments.
 *
 * DropsizeMVCf is released under the GPL
 * 
 */

/**
 * This class help to find the correct way to get throught path of your app
 * params index, alias, method safe params or unsafe params
 * 
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
 * 
 * @package com.dropsizemvcf.utils.model
 * @author  Isaac Trenado
 * @since   1.0.0
 */
abstract class Model {

    private $app;
    private $modulo;
    private $accion;
    private $acceso;
    public $lboHasModel;
    private $modelo;
    private $params;
    private $seguros;
    private $tempModelo;

    public function __construct($app, $pstModulo, $pstAccion, $parParams, $parSeguros) {

        $this->app = $app;
        $this->setModulo($pstModulo);
        $this->setAccion($pstAccion);
        $this->setParams($parParams);
        $this->setSeguros($parSeguros);

        $this->tempModelo = $this->setModelo($this->loadModulo());
        $this->tempModelo = $this->getModelo($this->tempModelo);

        $this->setAcceso($this->tempModelo['Metodo']);
    }

    public function setSeguros($parSeguros) {
        $this->seguros = $parSeguros;
    }

    public function getSeguros() {
        return $this->seguros;
    }

    public function setParams($parParmas) {
        $this->params = $parParmas;
    }

    public function getParams() {
        return $this->params;
    }

    public function setAcceso($pstAcceso) {
        $this->acceso = $pstAcceso;
    }

    public function getAcceso() {
        return $this->acceso;
    }

    public function setModelo($pstModelo) {
        $this->modelo = $pstModelo;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModulo($pstModulo) {
        $this->modulo = $pstModulo;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function setAccion($pstAccion) {
        $this->accion = $pstAccion;
    }

    public function getAccion() {
        return $this->accion;
    }

    public static function callModel($lobClassModel, $actionClass) {
        return call_user_func_array(array(
            $lobClassModel, $actionClass), array(array(), array()));
    }

    private function loadModulo() {

        $moduloClass = ucfirst(strtolower($this->getModulo()));
        $actionClass = $this->getAccion();

        if (!file_exists("model/" . $moduloClass . "Model.php")) {
            throw new Exception("No existe un modelo que defina el controlador");
        } else {

            include "model/" . $moduloClass . "Model.php";

            if (class_exists($moduloClass . "Model")) {

                $lstClaseModel = $moduloClass . "Model";
                $lobClassModel = new $lstClaseModel();

                if (method_exists($lobClassModel, $actionClass)) {
                    $this->lboHasModel = true;
                    return call_user_func_array(array(
                        $lobClassModel, $actionClass), array($this->getParams(), $this->getSeguros())
                    );
                } else {
                    throw new Exception("Acci&oacute;n no identificada : 5");
                }
            } else {
                throw new Exception("No existe un modelo que defina la acci&oacute;n : 6");
                $this->lboHasModel = false;
            }
        }
    }

}
