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
 * FDropSize extension of the Slimframework.
 * main handlers and booters.
 * 
 * @package com.dropsizemvcf.utils.legacy.aplicacion
 * @author  Isaac Trenado
 * @since   1.0.0
 */

defined('_DSEXEC') or die;

class FDropSize extends Slim {

    /**
     * Instancia Slim
     */
    static $instancia = null;

    /*
     * Set/Get Instancia Slim
     * @return object Instancia de la clase, metodo Singleton
     */

    public static function Instance($name) {

        if (!self::$instancia) {

            $logWriter = new Slim_LogWriter(fopen($name, 'a+'));

            self::$instancia = new Slim(array(
                'mode' => 'development',
                'debug' => 1,
                'log.enabled' => true,
                'cookies.secure' => 0,
                'cookies.encrypt' => true,
                'cookies.secret_key' => 'llave_secreta',
                'cookies.cipher' => MCRYPT_RIJNDAEL_256,
                'cookies.cipher_mode' => MCRYPT_MODE_CBC,
                'log.level' => Slim_Log::DEBUG,
                'log.writer' => $logWriter
            ));

            self::handlerError();
            self::setup();
        }

        return self::$instancia;
    }

    /*
     * Configurar Instancia Slim
     * 
     * @return void 
     */

    private static function setup() {
        self::$instancia->get('/(:controller)(/)(/:action)(/)(/:params+)', "FDropSize::mainFunction");
        self::$instancia->post('/(:controller)(/)(/:action)(/)(/:params+)', "FDropSize::mainFunction");
    }

    /*
     * Configurar Instancia Slim
     * 
     * @head string Nombre de Log
     * @body string Cuerpo almacenado
     * @glu array Separador, para otros parametros
     * @return void 
     */

    public static function writelog($head, $body, $glu = "|", $others = array()) {

        $app = Slim::getInstance();

        $log = $app->getLog();

        $log->debug(
                $head . "\n"
                . (!is_string($body) ? serialize($body) : $body) . "\n" . (!empty($others) ? implode($glu, $others) : false)
                . "\n");
    }

    /*
     * Configurar manejador de errores
     * 
     * @return void
     */

    private static function handlerError() {
        self::$instancia->error('FDropSize::custom_error_handler');
    }

    /*
     * Manejador de Error Manda a llamar template /error
     * 
     * @return void
     */

    public static function custom_error_handler(Exception $e) {
        $app = Slim::getInstance();
        $app->render('error', array("e" => $e));
    }

    /*
     * Metodo Main llamado por Router, este metodo es invocado
     * 
     * @param string Inicializado en false, Cadena que inicializa el Business 
     * a traves del Controler
     * 
     * @param string Inicializado en false, Ejecuta la peticion del Business 
     * y dirige el flujo hacia el metodo solicitado
     */

    public static function mainFunction($controller = false, $action = false, $params = false) {

        $args = func_get_args();
        $app = Slim::getInstance();

        $controller = isset($args[0]) ? ucfirst($args[0]) : "Index";
        $action = isset($args[1]) ? strtolower($args[1]) : "Init";
        $params = isset($args[2]) ? $args[2] : array();

        try {

            if (!file_exists("controller/" . $controller . "Controller.php")) {
                throw new Exception("El controlador no existe : " . $controller);
            } else if (!file_exists("business/" . $controller . "Business.php")) {
                throw new Exception("El negocio no existe : " . $controller);
            } else if (!file_exists("dependence/" . $controller . "Dependence.php")) {
                throw new Exception("La dependencia no existe : " . $controller);
            } else {

                PhpClass::import("controller/" . $controller . "Controller");
                PhpClass::import("business/" . $controller . "Business");
                PhpClass::import("dependence/" . $controller . "Dependence");

                if (class_exists($controller . "Controller")) {

                    $lstClaseController = $controller . "Controller";
                    $lobClassController = new $lstClaseController($args);

                    try {

                        if (!method_exists($lobClassController, $action))
                            throw new Exception("Acci&oacute;n no definida 4, ");
                        else
                            call_user_func_array(array($lobClassController, $action), $args);
                    } catch (Exception $e) {
                        throw new Exception("Acci&oacute;n no definida 2, " . $e->getMessage());
                    }
                } else {
                    throw new Exception("Modulo no identificado 1" . $e->getMessage());
                }
            } // fin else
        } catch (Exception $e) {
            $app->error($e);
        }
    }

    public static function out($param, $br = true) {
        echo "<pre>";
        print_r($param);
        echo ($br) ? "<br />" : "";
        echo "</pre>";
    }

    public static function fnAutoLoad($controller, $action) {

        if (class_exists($controller . "Dependence")) {

            self::fnAutoLoad($controller, $action);

            $lstClaseDependence = $controller . "Dependence";
            $lobClassDependece = new $lstClaseDependence();

            if (!method_exists($lobClassDependece, $action))
                throw new Exception("Acci&oacute;n no definida 8");
            else
                $larDependencias = call_user_func_array(
                        array($lobClassDependece, $action), array());
        } else {
            throw new Exception("Dependencia no identificada 6");
        }

        // Buscamos en cada ruta los archivos
        while (list($k, $v) = each($larDependencias['Archivos'])) {

            foreach ($v as $path) {
                PhpClass::import($path);
            }
        }
    }

}
