<?php
require_once('DBO.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author nrwebb
 */
class Client extends DBO{
    //class constants
    public static $kGETFNAME = 1;
    public static $kGETLNAME = 2;
    public static $kGETFULLNAME = 3;
    
    
    //the table name
    public static $table = 'Clients';
    
    //The keys for all pairs
    public static $id = 'ID';
    public static $idnumber = 'IDNumber';
    public static $fname = 'FirstName';
    public static $lname = 'LastName';
    public static $schoolid = 'SchoolID';
    
    
    
    public function __construct($idnumber, $fname, $lname, $schoolid)
    {
        //call parent constructor first!!!
        parent::__construct();
        
        
        //initialize all the variables
        $this->idnumber = $idnumber;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->schoolid = $schoolid;
    }
}
