<?php
require_once('../shared/DBO.php');
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
    public static $clientid = 'ClientID';
    public static $schoolid = 'SchoolID';
    public static $otype = 'OrderType';
    public static $ctype = 'ContactType';
    public static $issue = 'Issue';
    public static $aid = 'AssigneeID';
    public static $percent = 'PercentComplete';
    public static $notes = 'Notes';
    
    public function __construct($rID, $cName, $cEmail, $cPhone, $clientID, $schoolID, $oType, $cType, $issue, $aID, $notes)
    {
        //call parent constructor first!!!
        parent::__construct();
        
        //initialize all the variables
        $this->rid = $rID;
        $this->status = 'New'; // the default for all new requests
        $this->cname = $cName;
        $this->cemail = $cEmail;
        $this->cphone = $cPhone;
        $this->clientid = $clientID;
        $this->schoolid = $schoolID;
        $this->otype = $oType;
        $this->ctype = $cType;
        $this->issue = $issue;
        $this->aid = $aID;
        $this->percent = 0;
        $this->notes = $notes;
    }
}
