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
 * This clas help to define the route to BO. 
 * Import the model and set basics features of slimframework
 * Too determine if has access or not. Help to find if the method access
 * is GET, POST. depending on the model definition
 * 
 * @package com.dropsizemvcf.utils.controller
 * @author  Isaac Trenado
 * @since   1.0.0
 */

defined('_DSEXEC') or die;

abstract class Controller extends Model {

    private $app;
    private $metodo;
    
    public function __construct($args) {

        $app = Slim::getInstance();
        
        $this->setApp($app);
        $modulo = isset($args[0]) ? $args[0] : "Index";
        $action = isset($args[1]) ? $args[1] : "Init";
        $args = isset($args[2]) ? $args[2] : array();
        $seguros = $app->request()->params();

        parent::__construct($app, $modulo, $action, $args, $seguros);
    }

    private function setApp($app) {
        $this->app = $app;
    }

    public function getApp() {
        return $this->app;
    }

    public function getMetodo() {
        return $this->app->request()->getMethod();
    }

    public function HasAccess() {
        if ($this->lboHasModel && ($this->getMetodo() === $this->getAcceso())) {
            return true;
        } else {
            return false;
        }
    }

}
