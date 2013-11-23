<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBO
 *
 * @author nrwebb
 */
abstract class DBO {
    //all static variables
    public static $MYSQLDATE = 'Y-m-d H:i:s';
    /*
     * Place Class Variables at the top of the class.
     * 1 for each variable name where it equals the SQL
     * Name.
     * 
     * e.g.:
     * public static $id = 'ID';
     */
    //variableArray
    protected $variables;
    
    public function __construct()
    {
        //set up the variables array
        $this->variables = array();
    }
    
    /**
     * Sets the associative array value as if it was an object variable.
     * @param {string} $name
     * @param {mixed} $value
     */
    public function __set($name, $value)
    {
       //get variable name
       $key = static::$$name;
       $this->variables[$key] = $value;
    }
    
    /**
     * Returns the variables array.
     * @return {Assoc. Array}
     */
    public function getVariables()
    {
        return $this->variables;
    }
}
