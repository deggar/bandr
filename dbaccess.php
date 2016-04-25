<?php
/**
 * This file is responsible for creating and initializing the FileMaker object.
 * This object allows you to manipulate data in the database. To do so, simply
 * include this file in the PHP file that needs access to the FileMaker database.
 */

//include the FileMaker PHP API
require_once ('FileMaker.php');

//create the FileMaker Object
$fm = new FileMaker();

//Specify the FileMaker database
$fm->setProperty('database', 'web_storemind');

//Specify the Host
//     $fm->setProperty('hostspec', '50.240.31.157'); //needed when on a different web server

$fm->setProperty('username', 'web');
$fm->setProperty('password', 'web');

?>