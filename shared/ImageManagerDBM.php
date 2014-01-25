<?php
require_once('DBM.php');
require_once('Client.php');
require_once('ServiceRequest.php');
require_once('User.php');
require_once('School.php');
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
    //const variables
    
    
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
        //prepare the statement
        $stmt = $this->DBO->prepare("INSERT INTO ServiceRequests "
                . "(Status, ReceiverID, ContactName, ContactEmail, ContactPhone, ClientName, SchoolID, IssueType, ContactType, Issue, AssigneeID, PercentComplete, Notes, CreationDate, CompletedDate, HowResolved)"
                . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        
        if($stmt)
        {
            //bind all the parameters
            $stmt->bind_param("sissssisssiissss",   $serviceRequest->status, 
                                                    $serviceRequest->rid, 
                                                    $serviceRequest->cname, 
                                                    $serviceRequest->cemail, 
                                                    $serviceRequest->cphone, 
                                                    $serviceRequest->clientname, 
                                                    $serviceRequest->schoolid, 
                                                    $serviceRequest->itype, 
                                                    $serviceRequest->ctype, 
                                                    $serviceRequest->issue, 
                                                    $serviceRequest->aid,
                                                    $serviceRequest->percent,
                                                    $serviceRequest->notes,
                                                    $serviceRequest->creationdate,
                                                    $serviceRequest->completeddate,
                                                    $serviceRequest->howresolved);

            //execute the statement
            $stmt->execute();

            //close the statement
            $stmt->close();
        }
    }
    
    /**
     * Updates a serviceRequest object in the database
     * @param {ServiceRequest} $serviceRequest
     */
    public function updateServiceRequest($serviceRequest)
    {
        try
        {
            //prepare the statement
            $stmt = $this->DBO->prepare("UPDATE ServiceRequests "
                    . "SET Status = ?, "
                    . "ReceiverID = ?, "
                    . "ContactName = ?, "
                    . "ContactEmail = ?, "
                    . "ContactPhone = ?, "
                    . "ClientName = ?, "
                    . "SchoolID = ?, "
                    . "IssueType = ?, "
                    . "ContactType = ?, "
                    . "Issue = ?, "
                    . "AssigneeID = ?, "
                    . "PercentComplete = ?, "
                    . "Notes = ?, "
                    . "CreationDate = ?, "
                    . "CompletedDate = ?, "
                    . "HowResolved = ? WHERE ID = ?");
            if($stmt)
            {
                //bind all the parameters
                $stmt->bind_param("sissssisssiissssi",  $serviceRequest->status, 
                                                        $serviceRequest->rid, 
                                                        $serviceRequest->cname, 
                                                        $serviceRequest->cemail, 
                                                        $serviceRequest->cphone, 
                                                        $serviceRequest->clientname, 
                                                        $serviceRequest->schoolid, 
                                                        $serviceRequest->itype, 
                                                        $serviceRequest->ctype, 
                                                        $serviceRequest->issue, 
                                                        $serviceRequest->aid,
                                                        $serviceRequest->percent,
                                                        $serviceRequest->notes,
                                                        $serviceRequest->creationdate,
                                                        $serviceRequest->completeddate,
                                                        $serviceRequest->howresolved,
                                                        $serviceRequest->id);

                //execute the statement
                $stmt->execute();

                //close the statement
                $stmt->close();
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    /**
     * Returns all service requests from the database in the form of 
     * an indexed array of associative array service requests.  Will sort given a
     * specified column string and ascending or descending value.
     * @param string $sortBy DEFAULT null
     * @param boolean $ascending DEFAULT false
     */
    public function getAllServiceRequests($sortBy = null, $ascending = false)
    {
        try
        {
            //prepare the statement
            $stmt = $this->DBO->prepare("SELECT "
                    . "ID, "
                    . "Status, "
                    . "ReceiverID, "
                    . "ContactName, "
                    . "ContactEmail, "
                    . "ContactPhone, "
                    . "ClientName, "
                    . "SchoolID, "
                    . "IssueType, "
                    . "ContactType, "
                    . "Issue, "
                    . "AssigneeID, "
                    . "PercentComplete, "
                    . "Notes, "
                    . "CreationDate, "
                    . "CompletedDate, "
                    . "HowResolved FROM ServiceRequests");
            if($stmt)
            {

                //execute the statement
                $stmt->execute();
                
                //bind the result to a variable
                $results = $stmt->get_result();
                
                //get all of the results in 1 go
                $return = $results->fetch_all(MYSQLI_NUM);

                //close the statement
                $stmt->close();
                
                if(isset($sortBy))
                {
                    //get the headers
                    //EDIT: $headers = array_column($sortBy)
                    //array_multisort($arr)
                }
                
                return $return;
            }
            else
            {
                return null;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return null;
        }
    }
    
    /**
     * Returns all of the rows in the table.  If specified, it will only retrieve the desired columns
     * from each row.
     * @param type $columns the desired Columns to retrieve from the table.
     * @param type $sortBy Column name to sort by
     * @param type $ascending Sort by true = ascending or false = descending
     * @return Associative Array containing the specified columns of every service requests in the table
     */
    public function getAllServiceRequestsWithColumns($columns = self::ALLCOLUMNS, $sortBy = null, $ascending = false)
    {
        try
        {
            //prepare the statement
            $stmt = $this->DBO->prepare("SELECT "
                    . "ID, "
                    . "Status, "
                    . "ReceiverID, "
                    . "ContactName, "
                    . "ContactEmail, "
                    . "ContactPhone, "
                    . "ClientName, "
                    . "SchoolID, "
                    . "IssueType, "
                    . "ContactType, "
                    . "Issue, "
                    . "AssigneeID, "
                    . "PercentComplete, "
                    . "Notes, "
                    . "CreationDate, "
                    . "CompletedDate, "
                    . "HowResolved FROM ServiceRequests" . (empty($sortBy) ? null : (" Order BY $sortBy " . ($ascending ? "ASC" : "DESC"))));
            if($stmt)
            {

                //execute the statement
                $stmt->execute();
                
                //bind the result to a variable
                $results = $stmt->get_result();
                
                //get all of the results in 1 go
                $return = $results->fetch_all(MYSQLI_NUM);

                //close the statement
                $stmt->close();
                
                return $return;
            }
            else
            {
                return null;
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return null;
        }
        
        //if the ID element exists
        //make them into assoc arrays and put them in an ID based array and return the sorted array
        if(array_key_exists(ServiceRequest::$id, $input[0]))
        {
            foreach($input as $value)
            {
                $output[$value[ServiceRequest::$id]] = $value;
            }
            return $output;
        }
        else
        {
            //otherwise return the array as it was
            return $input;
        }
    }
    
    /**
     * Returns all of the rows in the table.  If specified, it will only retrieve the desired columns
     * from each row. It will only return the rows that satisfy the search constraint
     * @param Associative array where the key is the column name and the value is the search constraint
     * @param type $columns the desired Columns to retrieve from the table.
     * @param type $sortBy Column name to sort by
     * @param type $ascending Sort by true = ascending or false = descending
     * @return Associative Array containing the specified columns of every service requests in the table
     */
    public function searchAllServiceRequestsWithColumns($constraints = null, $columns = self::ALLCOLUMNS, $sortBy = null, $ascending = false)
    {
        //read in all the rows
        $input = $this->getColumnsFromTableWithSearchValues($constraints,$columns, ServiceRequest::$table, $sortBy, $ascending);
        $output = array();
        
        //if the ID element exists
        //make them into assoc arrays and put them in an ID based array and return the sorted array
        if(array_key_exists(ServiceRequest::$id, $input[0]))
        {
            foreach($input as $value)
            {
                $output[$value[ServiceRequest::$id]] = $value;
            }
            return $output;
        }
        else
        {
            //otherwise return the array as it was
            return $input;
        }
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
    public function getUserFromLogin($username, $password)
    {
            $constraints = array();
            $constraints[User::$username] = $username;
            $constraints[User::$password] = sha1($password); //use sha1 password conversion
            $user = $this->getColumnsFromTableWithValues($constraints, self::ALLCOLUMNS, User::$table);
            return $user[0];
    }
    
    /**
     * Returns an array of arrays where the 
     * UserID is the key of the first array
     * and the sql headers are the keys to the rest.
     * @param {User Name Constant} $nameType Must either be kGETFNAME, kGETLNAME, or kGETFULLNAME
     * @param {Datatype Constant} $returnType Must be either 
     */
    public function getAllUserNames($nameType)
    {
        //initialize $columns array to get the ID
        $columns = array(User::$id);
        switch($nameType)
        {
            case User::kGETFNAME:
                array_push($columns,User::$fname);
                break;
            case User::kGETLNAME:
                array_push($columns,User::$lname);
                break;
            case User::kGETFULLNAME:
                array_push($columns, User::$fname,  User::$lname);
                break;
            default:
                break;
        }
        
        $userList = $this->getColumnsFromTable($columns, User::$table);

        //set the ID to be the key for all rows
        foreach($userList as &$value)
        {
            $id = $value[User::$id]; //get the id
            unset($value[User::$id]);// remove it from the array
            $return[$id] = $value; //set it as the key of the new array
        }
        
        return $return;
    }
}
