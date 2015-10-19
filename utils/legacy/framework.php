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
 * Import and Run APP invoke all BO CO MO DE.
 * here goes all library for default too can use path_library PHP
 * 
 * @package com.dropsizemvcf.utils.legacy.framework
 * @author  Isaac Trenado
 * @since   1.0.0
 */

defined('_DSEXEC') or die;

PhpClass::import(FPATH_LIBRARIES . DIRECTORY_SEPARATOR . "Slim" . DIRECTORY_SEPARATOR . "Slim");
PhpClass::import(FPATH_LIBRARIES . DIRECTORY_SEPARATOR . "Slim" . DIRECTORY_SEPARATOR . "LogWriter");
PhpClass::import(FPATH_LIBRARIES . DIRECTORY_SEPARATOR . "Slim" . DIRECTORY_SEPARATOR . "Log");
PhpClass::import(FPATH_LIBRARIES . DIRECTORY_SEPARATOR . "Model");
PhpClass::import(FPATH_LIBRARIES . DIRECTORY_SEPARATOR . "Controller");
PhpClass::import(FPATH_LIBRARIES . DIRECTORY_SEPARATOR . "legacy" . DIRECTORY_SEPARATOR . "aplicacion");

$hostname = "log";
$app = FDropSize::Instance($hostname);
$app->run();
