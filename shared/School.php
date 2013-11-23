<?php
include_once('DBO.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of School
 *
 * @author nrwebb
 */
class School extends DBO
{
    //class constants
    
    
    //the table name
    public static $table = 'Schools';
    
    //The keys for all pairs
    public static $id = 'ID';
    public static $name = 'Name';
    public static $pfname = 'PrincipalFirstName';
    public static $plname = 'PrincipalLastName';
    public static $phoneno = 'PhoneNo';
    public static $faxno = 'FaxNo';
    
    
    
    public function __construct($name, $pfname, $plname, $phoneno, $faxno)
    {
        //call parent constructor first!!!
        parent::__construct();
        
        
        //initialize all the variables
        $this->name = $name;
        $this->pfname = $pfname;
        $this->plname = $plname;
        $this->phoneno = $phoneno;
        $this->faxno = $faxno;
    }
}
