<?php
/*
 * PHP Pre-Process Information
 */
global $request, $schoolNames, $id;

//variables for request
$schoolID = (int)$request[ServiceRequest::$schoolid];
$rid = $request[ServiceRequest::$rid];
$status = $request[ServiceRequest::$status];
$cname = $request[ServiceRequest::$cname];
$cemail = $request[ServiceRequest::$cemail];
$cphone = $request[ServiceRequest::$cphone];
$clientname = $request[ServiceRequest::$clientname];
$otype = $request[ServiceRequest::$otype];
$ctype = $request[ServiceRequest::$ctype];
$issue = $request[ServiceRequest::$issue];
$aid = $request[ServiceRequest::$aid];
$percent = $request[ServiceRequest::$percent];
$notes = $request[ServiceRequest::$notes];
$creationdate = $request[ServiceRequest::$creationdate];

//possibilities for Status
$statusOpts = array("In Progress","Completed");
?>

<div id="header">
    <h1>Edit Request</h1>
</div>
<div id="content">
    <form id='createRequest' method="post" action='?action=updateRequest'>
        <div class="alignright inline-block">
            <label for='Status'>
                Status
            </label>
            <label for='ContactName'>
                Contact Name
            </label>
            <label for='ContactPhone'>
                Contact Phone
            </label>
            <label for='ContactEmail'>
                Contact Email
            </label>
            <label for='ClientName'>
                Client
            </label>
            <label for='SchoolName'>
                School
            </label>
            <label for='OrderType'>
                Order Type
            </label>
            <label for='ContactType'>
                Contact Type
            </label>
            <label for='Issue'>
                Issue
            </label>
            <label for='Assignee'>
                Assign To
            </label>
            <label for='Notes'>
                Notes
            </label>
            <label for='PercentComplete'>
                Percent Complete
            </label>
        </div>
        <div class='inline-block alignleft'>
            <select id='Status' name='Status'>
            <?php foreach ($statusOpts as $name): ?>
                <option value="<?php echo $name; ?>" <?php echo $status == $name ? 'selected' : ''; ?> >
                    <?php echo $name; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <input type='text' id='ContactName' name='ContactName' value="<?php echo $cname; ?>"/>
            <input type='tel' id='ContactPhone' name='ContactPhone' value="<?php echo $cphone; ?>"/>
            <input type='text' id='ContactEmail' name='ContactEmail' value="<?php echo $cemail; ?>"/>
            
            <input type="text" id="ClientName" name="ClientName" value="<?php echo $clientname; ?>"> 
            
            <select id='SchoolID' name='SchoolID'>
            <?php foreach ($schoolNames as $id => $name): ?>
                <option value="<?php echo $id; ?>" <?php echo $id == $schoolID ? 'selected' : ''; ?> >
                    <?php echo $name; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <input type='text' id='OrderType' name='OrderType' value="<?php echo $otype; ?>"/>
            <input type='text' id='ContactType' name='ContactType' value="<?php echo $ctype; ?>"/>
            <input type='text' id='Issue' name='Issue' value="<?php echo $issue; ?>"/>
            <input type='number' id='Assignee' name='Assignee' value="<?php echo $aid; ?>"/>
            <textarea id='Notes' name='Notes' rows="5" cols="30" ><?php echo $notes; ?></textarea>
            <input type='number' id='PercentComplete' name='PercentComplete'>
            <input type='hidden' id='ID' name='ID' value='<?php echo $id; ?>'>
        </div>

        <input type='submit' value="Submit">
    </form>
</div>