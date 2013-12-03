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
$otype = $request[ServiceRequest::$otype];
$ctype = $request[ServiceRequest::$ctype];
$issue = $request[ServiceRequest::$issue];
$aid = (int)$request[ServiceRequest::$aid];
$percent = $request[ServiceRequest::$percent];
$notes = $request[ServiceRequest::$notes];
$creationdate = $request[ServiceRequest::$creationdate];

//possibilities for Status
$statusOpts = array("In Progress","Completed");
?>

<div id="title">
    Edit Request
</div>
<div id="content">
    <form id='editRequest' class="dataForm" method="post" action='?action=updateRequest'>
        <div class="table">
            <div class="row">
                <label for='Status'>Status</label>
                <select id='Status' name='Status'>
                <?php foreach ($statusOpts as $name): ?>
                    <option value="<?php echo $name; ?>" <?php echo $status == $name ? 'selected' : ''; ?> >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='ContactName'>Contact Name</label>
                <input type='text' id='ContactName' name='ContactName' value="<?php echo $cname; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ContactPhone'>Contact Phone</label>
                <input type='tel' id='ContactPhone' name='ContactPhone' value="<?php echo $cphone; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ContactEmail'>Contact Email</label>
                <input type='text' id='ContactEmail' name='ContactEmail' value="<?php echo $cemail; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ClientName'>Client</label>
                <input type="text" id="ClientName" name="ClientName" value="<?php echo $clientname; ?>"> 
            </div>
            
            <div class='row'>
                <label for='SchoolName'>School</label>
                <select id='SchoolID' name='SchoolID'>
                <?php foreach ($schoolNames as $sid => $name): ?>
                    <option value="<?php echo $sid; ?>" <?php echo $sid == $schoolID ? 'selected' : ''; ?> >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='OrderType'>Order Type</label>
                <input type='text' id='OrderType' name='OrderType' value="<?php echo $otype; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ContactType'>Contact Type</label>
                <input type='text' id='ContactType' name='ContactType' value="<?php echo $ctype; ?>"/>
            </div>
            
            <div class='row'>
                <label for='Issue'>Issue</label>
                <input type='text' id='Issue' name='Issue' value="<?php echo $issue; ?>"/>
            </div>
            
            <div class='row'>
                <label for='Assignee'>Assign To</label>
                <select id="Assignee" name ="Assignee">
                <?php foreach($userNames as $uid => $name): ?>
                    <option value="<?php echo $uid; ?>" <?php echo $uid == $aid ? 'selected' : ''; ?> >
                        <?php echo implode(" ",$name); ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='Notes'>Notes</label>
                <textarea id='Notes' name='Notes' rows="5" cols="30" ><?php echo $notes; ?></textarea>
            </div>
            
            <div class="row">
                <label for='PercentComplete'>Percent Complete</label>
                <input type='number' id='PercentComplete' name='PercentComplete' value="<?php echo $percent; ?>">
            </div>
        </div>
        <input type='hidden' id='ID' name='ID' value='<?php echo $id; ?>'>
        <input type="hidden" value="<?php echo $rid; ?>" name="ReceiverID">

        <input type='submit' value="Submit">
    </form>
</div>