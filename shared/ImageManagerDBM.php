<?php
require_once('DBM.php');
require_once('Client.php');
require_once('ServiceRequest.php');
require_once('User.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageManagerDBM
 *
 * @author nrwebb
 */
class ImageManagerDBM extends DBM
{
    /**
     * Set up the DatabaseManager
     */
    public function __construct($db, $host, $user, $pass)
    {
       parent::__construct($db, $host, $user, $pass);
    }
    
    /**
     * Returns an associative array of all of the jobs in the database.
     * @return {assoc array}
     */
    public function getJobs()
    {
        return $this->getTableRows('Jobs');
    }
    
    /**
     * Adds a service request object to the database.
     * @param {ServiceRequest} $serviceRequest
     */
    public function addServiceRequest($serviceRequest)
    {
        $this->insertIntoTable(ServiceRequest::$table, $serviceRequest->getVariables());
    }
    
    /**
     * Adds a service request object to the database.
     * @param {ServiceRequest} $serviceRequest
     */
    public function updateServiceRequest($serviceRequest)
    {
        $this->updateTableRowWithID(ServiceRequest::$table, $serviceRequest->getVariables());
    }
    
    /**
     * Returns all service requests from the database in the form of 
     * an indexed array of associative array service requests.
     */
    public function getAllServiceRequests()
    {
        //read in all the rows
        $input = $this->getTableRows(ServiceRequest::$table);
        $output = array();
        
        //make them into objects and put them in an ID based array
        foreach($input as $value)
        {
            $output[$value[ServiceRequest::$id]] = $value;
        }
        
        return $output;
    }
    
    /**
     * Returns an associative array of a service request 
     * given a specific id.
     * @param int $id
     */
    public function getServiceRequestWithID($id)
    {
        $constraints = array();
        $constraints[ServiceRequest::$id] = $id;
        $return = $this->getColumnsFromTableWithValues($constraints, self::ALLCOLUMNS, ServiceRequest::$table);
        //only returning 1 so just return the first element in the array of size 1
        return $return[0];
    }
    
    /**
     * Returns an array of arrays where the 
     * clientID is the key of the first array
     * and the sql headers are the keys to the rest.
     * @param {Client Name Constant} $nameType
     * Must either be $kGETFNAME, $kGETLNAME, or $kGETFULLNAME
     */
    public function getAllClientNames($nameType)
    {
        //initialize $columns array to get the ID
        $columns = array(Client::$id);
        switch($nameType)
        {
            case Client::$kGETFNAME:
                array_push($columns,Client::$fname);
                break;
            case Client::$kGETLNAME:
                array_push($columns,Client::$lname);
                break;
            case Client::$kGETFULLNAME:
                array_push($columns, Client::$fname,  Client::$lname);
                break;
            default:
                break;
        }
        
        $clientList = $this->getColumnsFromTable($columns, Client::$table);

        //set the ID to be the key for all rows
        foreach($clientList as &$value)
        {
            $id = $value[Client::$id]; //get the id
            unset($value[Client::$id]);// remove it from the array
            $return[$id] = $value; //set it as the key of the new array
        }
        
        return $return;
    }
    
    /**
     * Returns an array of arrays where the 
     * SchoolID is the key of the first array
     * and the value is the name.
     */
    public function getAllSchoolNames()
    {
        //initialize $columns array to get the ID and Name columns
        $columns = array(School::$id, School::$name);
        
        $list = $this->getColumnsFromTable($columns, School::$table);

        //set the ID to be the key for all rows
        foreach($list as &$value)
        {
            $id = $value[School::$id]; //get the id
            unset($value[School::$id]);// remove it from the array
            $return[$id] = $value[School::$name]; //set it as the key of the new array
        }
        
        return $return;
    }
    
    /**
     * Returns an associative array of a School
     * given a specific id.
     * @param int $id
     */
    public function getSchoolWithID($id)
    {
        $constraints = array();
        $constraints[School::$id] = $id;
        $return = $this->getColumnsFromTableWithValues($constraints, self::ALLCOLUMNS, School::$table);
        //only returning 1 so just return the first element in the array of size 1
        return $return[0];
    }
    
    /**
     * Returns an associative User array given a specified email address
     * and password.  Throws an exception if incorrect email and password combination.
     * @param String $email
     * @param String $password
     * @return Assoc Array User
     */
    public function getUserFromLogin($email, $password)
    {
            $constraints = array();
            $constraints[User::$email] = $email;
            $constraints[User::$password] = sha1($password); //use sha1 password conversion
            $user = $this->getColumnsFromTableWithValues($constraints, self::ALLCOLUMNS, User::$table);
            return $user[0];
    }
}
