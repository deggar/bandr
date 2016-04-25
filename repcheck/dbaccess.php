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
    $fm->setProperty('database', 'Flair_App');
    //Specify the Host
//     $fm->setProperty('hostspec', 'http://50.240.31.157'); //temporarily hosted on local server
    
    /**
     * To gain access to the questionnaire database, use the default administrator account,
     * which has no password. To change the authentication settings, open the database in 
     * FileMaker Pro and select "Manage > Accounts & Privileges" from the "File" menu. 
    */
    
    $fm->setProperty('username', 'php');
    $fm->setProperty('password', 'php');

?>
