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
            $stmt = $this->DBO->prepare("SELECT 
                                            ServiceRequests.ID AS ID,
                                            Status,
                                            ContactName,
                                            ContactPhone,
                                            ClientName,
                                            Schools.Name AS School,
                                            IssueType,
                                            Issue,
                                            concat(IFNULL(Users.FirstName, ''),' ', IFNULL(Users.LastName, '')) AS Assignee,
                                            DATE_FORMAT(CreationDate, '%M %e, %Y') AS CreationDate
                                        FROM
                                            ServiceRequests
                                                JOIN
                                            Schools ON ServiceRequests.SchoolID = Schools.ID
                                                JOIN
                                            Users ON Users.ID = ServiceRequests.AssigneeID" . (empty($sortBy) ? null : (" Order BY $sortBy " . ($ascending ? "ASC" : "DESC"))));
            if($stmt)
            {

                //execute the statement
                $stmt->execute();
                
                //bind the result to a variable
                $results = $stmt->get_result();
                
                //get all of the results in 1 go
                $return = $results->fetch_all(MYSQLI_ASSOC);

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
    }
    
    /**
     * Returns all of the rows in the table.  If specified, it will only retrieve the desired columns
     * from each row. It will only return the rows that satisfy the search constraint
     * @param Associative array where the key is the column name and the value is the search constraint
     * @param type $sortBy Column name to sort by
     * @param type $ascending Sort by true = ascending or false = descending
     * @return Associative Array containing the specified columns of every service requests in the table
     */
    public function searchAllServiceRequestsWithConstraints($constraints = null, $sortBy = null, $ascending = false)
    {
        try
        {
	    // If the sortBy contains a date, we have to specify that it should sort by the date and not the sorted string.
            if($sortBy === 'CreationDate')
	    {
		$sortBy = 'ServiceRequests.CreationDate';
	    }

            $stmt = $this->DBO->prepare("SELECT 
                                                ServiceRequests.ID AS ID,
                                                Status,
                                                ContactName,
                                                ContactPhone,
                                                ClientName,
                                                Schools.Name AS School,
                                                IssueType,
                                                Issue,
                                                concat(IFNULL(Users.FirstName, ''),' ', IFNULL(Users.LastName, '')) AS Assignee,
                                                DATE_FORMAT(CreationDate, '%M %e, %Y') AS CreationDate
                                        FROM
                                                ServiceRequests
                                                        JOIN
                                                Schools ON ServiceRequests.SchoolID = Schools.ID
                                                        JOIN
                                                Users ON Users.ID = ServiceRequests.AssigneeID
                                        WHERE
                                                ServiceRequests.ID LIKE ?
                                        AND
                                                coalesce(Status, '') LIKE ?
                                        AND
                                                coalesce(ContactName, '') LIKE ?
                                        AND
                                                coalesce(ContactPhone, '') LIKE ?
                                        AND
                                                coalesce(ClientName, '') LIKE ?
                                        AND
                                                coalesce(Schools.Name, '') LIKE ?
                                        AND
                                                coalesce(IssueType, '') LIKE ?
                                        AND
                                                coalesce(Issue, '') LIKE ?
                                        AND
                                                concat(IFNULL(Users.FirstName, ''),' ', IFNULL(Users.LastName, '')) LIKE ?
                                        AND
                                                coalesce(DATE_FORMAT(CreationDate, '%M %e, %Y'), '') LIKE ?" . (empty($sortBy) ? null : (" Order BY $sortBy " . ($ascending ? "ASC" : "DESC"))));
            if($stmt)
            {

                //set all the constraints that are not set to '%'
                $constraints['ID'] = isset($constraints['ID']) ? '%'.$constraints['ID'].'%' : '%';
                $constraints['Status'] = isset($constraints['Status']) ? '%'.$constraints['Status'].'%' : '%';
                $constraints['ContactName'] = isset($constraints['ContactName']) ? '%'.$constraints['ContactName'].'%' : '%';
                $constraints['ContactPhone'] = isset($constraints['ContactPhone']) ? '%'.$constraints['ContactPhone'].'%' : '%';
                $constraints['ClientName'] = isset($constraints['ClientName']) ? '%'.$constraints['ClientName'].'%' : '%';
                $constraints['School'] = isset($constraints['School']) ? '%'.$constraints['School'].'%' : '%';
                $constraints['IssueType'] = isset($constraints['IssueType']) ? '%'.$constraints['IssueType'].'%' : '%';
                $constraints['Issue'] = isset($constraints['Issue']) ? '%'.$constraints['Issue'].'%' : '%';
                $constraints['Assignee'] = isset($constraints['Assignee']) ? '%'.$constraints['Assignee'].'%' : '%';
                $constraints['CreationDate'] = isset($constraints['CreationDate']) ? '%'.$constraints['CreationDate'].'%' : '%';
                        
                //bind all the search values
                $stmt->bind_param("ssssssssss",$constraints['ID'],
                                               $constraints['Status'],
                                               $constraints['ContactName'],
                                               $constraints['ContactPhone'],
                                               $constraints['ClientName'],
                                               $constraints['School'],
                                               $constraints['IssueType'],
                                               $constraints['Issue'],
                                               $constraints['Assignee'],
                                               $constraints['CreationDate']);
                //execute the statement
                $stmt->execute();
                
                //bind the result to a variable
                $results = $stmt->get_result();
                
                //get all of the results in 1 go
                $return = $results->fetch_all(MYSQLI_ASSOC);

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
