<?php

include_once('DBO.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author nrwebb
 */
class User extends DBO {

    //class constants
    const  kGETFNAME = 1;
    const kGETLNAME = 2;
    const kGETFULLNAME = 3;
    
    //the table name
    public static $table = 'Users';
    //The keys for all pairs
    public static $id = 'ID';
    public static $fname = 'FirstName';
    public static $lname = 'LastName';
    public static $password = 'Password';
    public static $email = 'Email';
    public static $username = 'UserName';

    public function __construct($fname, $lname, $password, $email, $username, $id = 0) {
        //call parent constructor first!!!
        parent::__construct();


        //initialize all the variables
        $this->id = $id;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->password = $password;
        $this->email = $email;
	$this->username = $username;
    }

    /**
     * Will create a User from a given associative array.
     * @param Associative Array $array
     * @return \ServiceRequest
     */
    public static function fromArray($array) {
        //create the object, if the array values are null then set them as null
        $temp = new self(
        isset($array[self::$fname]) ? $array[self::$fname] : null,
        isset($array[self::$lname]) ? $array[self::$lname] : null,
        isset($array[self::$password]) ? $array[self::$password] : null,
        isset($array[self::$email]) ? $array[self::$email] : null,
        isset($array[self::$username]) ? $array[self::$username] : null,
        isset($array[self::$id]) ? $array[self::$id] : null
        );
        return $temp;
    }

}
