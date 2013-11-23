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
    public static $otype = 'OrderType';
    public static $ctype = 'ContactType';
    public static $issue = 'Issue';
    public static $aid = 'AssigneeID';
    public static $percent = 'PercentComplete';
    public static $notes = 'Notes';
    public static $creationdate = 'CreationDate';
    
    public function __construct($rID, $cName, $cEmail, $cPhone, $clientname, $schoolID, $oType, $cType, $issue, $aID, $notes)
    {
        //call parent constructor first!!!
        parent::__construct();
        
        //initialize all the variables
        $this->rid = $rID;
        $this->status = 'New'; // the default for all new requests
        $this->cname = $cName;
        $this->cemail = $cEmail;
        $this->cphone = $cPhone;
        $this->clientname = $clientname;
        $this->schoolid = $schoolID;
        $this->otype = $oType;
        $this->ctype = $cType;
        $this->issue = $issue;
        $this->aid = $aID;
        $this->percent = 0;
        $this->notes = $notes;
        //define a simple time variable
        $time = new DateTime();
        //assign the time
        $this->creationdate = $time->getTimestamp();
        //remove the variable
        unset($time);
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
                                   $array[self::$otype],
                                   $array[self::$ctype],
                                   $array[self::$issue],
                                   $array[self::$aid],
                                   $array[self::$notes]);
        
        //set up the non-constructor variables
        $temp->id = $array[self::$id];
        $temp->percent = $array[self::$percent];
        $temp->status = $array[self::$status];
        $temp->creationdate = $array[self::$creationdate];
        
        return $temp;
    }
}
