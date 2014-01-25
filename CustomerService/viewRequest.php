<?php
/*
 * PHP Pre-Process Information
 */
global $request, $schoolNames, $id, $userNames;

//variables for request
$schoolID = (int)$request[ServiceRequest::$schoolid];
$rid = (int)$request[ServiceRequest::$rid];
$status = $request[ServiceRequest::$status];
$cname = $request[ServiceRequest::$cname];
$cemail = $request[ServiceRequest::$cemail];
$cphone = $request[ServiceRequest::$cphone];
$clientname = $request[ServiceRequest::$clientname];
$itype = $request[ServiceRequest::$itype];
$ctype = $request[ServiceRequest::$ctype];
$issue = $request[ServiceRequest::$issue];
$aid = (int)$request[ServiceRequest::$aid];
$percent = $request[ServiceRequest::$percent];
$notes = $request[ServiceRequest::$notes];
$creationdate = $request[ServiceRequest::$creationdate];
$completeddate = $request[ServiceRequest::$completeddate];
$howresolved = $request[ServiceRequest::$howresolved];

//possibilities for Status
$statusOpts = ServiceRequest::$STATUSOPTIONS;

//possibilities for IssueType
$issueTypeOpts = ServiceRequest::$ISSUETYPEOPTIONS;

//possibilities for ContactType
$contactTypeOpts = ServiceRequest::$CONTACTTYPEOPTIONS;

?>
<script type="text/javascript">
    //empty for the current version
</script>

<div id="title">
    View Request
</div>
<div id="content">
        <div class="table" id="viewRequest">
            <div class="row">
                <h4>The current <b>status</b> of this request is: </h4>
                <h4><?php echo $status; ?></h4>
            </div>
            
            <div class='row'>
                <h4>The name of the individual who contacted us is: </h4>
                <h4><?php echo $cname; ?></h4>
            </div>
            
            <div class='row'>
                <h4>Their phone number is: </h4>
                <h4><?php echo $cphone; ?></h4>
            </div>
            
            <div class='row'>
                <h4>Their email address is: </h4>
                <h4><?php echo $cemail; ?></h4>
            </div>
            
            <div class='row'>
                <h4>They were calling in regards to: </h4>
                <h4><?php echo $clientname; ?></h4>
            </div>
            
            <div class='row'>
                <h4>The school of interest is: </h4>
                <h4><?php echo $schoolNames[$schoolID]; ?></h4>
            </div>
            
            <div class='row'>
                <h4>This issue lies within the following category: </h4>
                <h4><?php echo $itype; ?></h4>
            </div>
            
            <div class='row'>
                <h4>This individual contacted us in the following way: </h4>
                <h4><?php echo $ctype; ?> </h4>
            </div>
            
            <div class='row'>
                <h4>The issue they described was: </h4>
                <h4><?php echo $issue; ?></h4>
            </div>
            
            <div class='row'>
                <h4>This issue is to be handled by the following employee: </h4>
                <h4><?php $userNames[$aid]; ?></h4>
            </div>
            
            <div class='row' style="max-width: 60px;">
                <h4>These are the updates and notes on the request:</h4>
                <p><?php echo $notes; ?></p>
            </div>
            
            <div class='row'>
                <h4>This issue was resolved in the following way: </h4>
                <h4><?php echo $howresolved; ?></h4>
            </div>
            
            <div class="row">
                <h4>The completion level for this request is at the following percent: </h4>
                <h4><?php echo $percent; ?></h4>
            </div>
            <div class="row">
                <h4>The ID for this request is: </h4>
                <h4><?php echo $id; ?></h4>
            </div>
            <div class="row">
                <h4>The <b>Employee</b> who recorded this request is: </h4>
                <h4><?php echo $userNames[$rid]['FirstName']; ?></h4>
            </div>
            <div class="row">
                <h4>This request was created on: </h4>
                <h4><?php echo $creationdate; ?></h4>
            </div>
            <div class="row">
                <h4>This issue was completed on: </h4>
                <h4><?php echo $completeddate; ?></h4>
            </div>
</div>