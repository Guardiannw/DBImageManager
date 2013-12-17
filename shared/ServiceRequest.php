<?php
require_once('DBO.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServiceRequest
 *
 * @author nrwebb
 */
class ServiceRequest extends DBO{
    
    //class constants
    const DEFAULTTIMEFORMAT = "F d, Y";
    
    //the table name
    public static $table = 'ServiceRequests';
    
    //The keys for all pairs
    public static $id = 'ID';
    public static $status = 'Status';
    public static $rid = 'ReceiverID';
    public static $cname = 'ContactName';
    public static $cemail = 'ContactEmail';
    public static $cphone = 'ContactPhone';
    public static $clientname = 'ClientName';
    public static $schoolid = 'SchoolID';
    public static $itype = 'IssueType';
    public static $ctype = 'ContactType';
    public static $issue = 'Issue';
    public static $aid = 'AssigneeID';
    public static $percent = 'PercentComplete';
    public static $notes = 'Notes';
    public static $creationdate = 'CreationDate';
    public static $completeddate = 'CompletedDate';
    public static $howresolved = "HowResolved";
    
    //possibilities for Status
    public static $STATUSOPTIONS = array("In Progress","Completed/Unresolved", "Completed/Resolved");

    //possibilities for IssueType
    public static $ISSUETYPEOPTIONS = array("School Day", "Senior Portraits", "Sports/Teams", "Homecoming", "Prom", "Event", "Studio Portraits", "Yearbook", "Administration");

    //possibilites for ContactType
    public static $CONTACTTYPEOPTIONS = array("Phone", "Email", "In Studio", "Mail", "At School", "Other");
    
    
    public function __construct($rID, $cName, $cEmail, $cPhone, $clientname, $schoolID, $oType, $cType, $issue, $aID, $notes, $status = 'New', $percent = 0)
    {
        //call parent constructor first!!!
        parent::__construct();
        
        //initialize all the variables
        $this->rid = $rID;
        $this->status = $status; // the default 'New' for all new requests
        $this->cname = $cName;
        $this->cemail = $cEmail;
        $this->cphone = $cPhone;
        $this->clientname = $clientname;
        $this->schoolid = $schoolID;
        $this->itype = $oType;
        $this->ctype = $cType;
        $this->issue = $issue;
        $this->aid = $aID;
        $this->percent = $percent; //default 0 for all new requests
        $this->notes = $notes;
        $this->creationdate = date(parent::$MYSQLDATE);
    }
    
    /**
     * Takes the database array and returns a service request object from it.
     * @param {Assoc Array} $array
     */
    public static function fromArray($array)
    {
        $temp = new ServiceRequest($array[self::$aid], 
                                   $array[self::$cname],
                                   $array[self::$cemail],
                                   $array[self::$cphone],
                                   $array[self::$clientname],
                                   $array[self::$schoolid],
                                   $array[self::$itype],
                                   $array[self::$ctype],
                                   $array[self::$issue],
                                   $array[self::$aid],
                                   $array[self::$notes]);
        
        //set up the non-constructor variables
        $temp->id = $array[self::$id];
        $temp->percent = $array[self::$percent];
        $temp->status = $array[self::$status];
        $temp->creationdate = $array[self::$creationdate];
        $temp->completeddate = $array[self::$completeddate];
        $temp->howresolved = $array[self::$howresolved];
        
        return $temp;
    }
    
    /**
     * Returns an array of column names that should be used when viewing ServiceRequests in large
     * quantity.
     * @return Array of column names to return for the view
     */
    public static function getViewColumns()
    {
        //columnsForView
        return    array(self::$id,          self::$status,
                        self::$cname,       self::$cphone,
                        self::$clientname,  self::$schoolid,
                        self::$itype,       self::$aid,
                        self::$creationdate,self::$completeddate);
    }
}
