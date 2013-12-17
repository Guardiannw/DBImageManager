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
    //script for the slider and the phone-numbers
    //onload function
    $(function()
    {
       //get the previous value of the percentComplete
       var percentInput = $("input#PercentComplete");
       var percentComplete = percentInput.attr("value");
       $("#slider").slider(
               {
                   value:percentComplete,
                   min: 0,
                   max: 100,
                   step: 1,
                   range: 'min',
                   slide: function(event, ui)
                   {
                       $(percentInput).attr("value", ui.value);
                   }
                   
               });
    });
</script>

<div id="title">
    Edit Request
</div>
<div id="content">
    <form id='editRequest' class="dataForm" method="post" action='?action=updateRequest'>
        <div class="table">
            <div class="row">
                <label for='Status'>What is the current <b>status</b> of this request?</label>
                <select id='Status' name='Status'>
                <?php foreach ($statusOpts as $name): ?>
                    <option value="<?php echo $name; ?>" <?php echo $status == $name ? 'selected' : ''; ?> >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='ContactName'>What was the <b>Name</b> of the individual who contacted you?</label>
                <input type='text' id='ContactName' name='ContactName' value="<?php echo $cname; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ContactPhone'>What is the <b>Phone Number</b> of the individual who contacted you?</label>
                <input type='tel' id='ContactPhone' name='ContactPhone' value="<?php echo $cphone; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ContactEmail'>What is the <b>Email Address</b> of the individual who contacted you?</label>
                <input type='text' id='ContactEmail' name='ContactEmail' value="<?php echo $cemail; ?>"/>
            </div>
            
            <div class='row'>
                <label for='ClientName'>What is the <b>Name</b> of the individual they were contacting you about?</label>
                <input type="text" id="ClientName" name="ClientName" value="<?php echo $clientname; ?>"> 
            </div>
            
            <div class='row'>
                <label for='SchoolName'>What <b>School</b> , if any, does this issue pertain to?</label>
                <select id='SchoolID' name='SchoolID'>
                <?php foreach ($schoolNames as $sid => $name): ?>
                    <option value="<?php echo $sid; ?>" <?php echo $sid == $schoolID ? 'selected' : ''; ?> >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='IssueType'>What type of <b>category</b> does the issue pertain to?</label>
                <select id='IssueType' name='IssueType'>
                <?php foreach ($issueTypeOpts as $name): ?>
                    <option value="<?php echo $name; ?>" <?php echo $itype == $name ? 'selected' : ''; ?> >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='ContactType'>What <b>method of contact</b> did this individual use to contact you?e</label>
                <select id='ContactType' name='ContactType'>
                <?php foreach ($contactTypeOpts as $name): ?>
                    <option value="<?php echo $name; ?>" <?php echo $ctype == $name ? 'selected' : ''; ?> >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='Issue'>What was the <b>issue</b> that they described to you?</label>
                <input type='text' id='Issue' name='Issue' value="<?php echo $issue; ?>"/>
            </div>
            
            <div class='row'>
                <label for='Assignee'>What <b>employee</b> would be best suited to handle this issue?</label>
                <select id="Assignee" name ="Assignee">
                <?php foreach($userNames as $uid => $name): ?>
                    <option value="<?php echo $uid; ?>" <?php echo $uid == $aid ? 'selected' : ''; ?> >
                        <?php echo implode(" ",$name); ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class='row'>
                <label for='Notes'>Record any <b>updates or action</b> taken on this issue here:</label>
                <textarea id='Notes' name='Notes' rows="5" cols="30" ><?php echo $notes; ?></textarea>
            </div>
            
            <div class='row'>
                <label for='HowResolved'>How was this <b>issue resolved</b>?</label>
                <input type='text' id='HowResolved' name='HowResolved' value='<?php echo $howresolved; ?>'>
            </div>
            
            <div class="row">
                <label for='PercentComplete'>Record the <b>completion level</b> of this issue:</label>
                <div id="sliderArea">
                    <div id="slider"><!--Where the slider will be drawn --></div>
                    <input type="text" id='PercentComplete' name='PercentComplete' value="<?php echo $percent; ?>" maxlength="3" size="3" readonly>
                </div>
        </div>
        <input type='hidden' id='ID' name='ID' value='<?php echo $id; ?>'>
        <input type="hidden" value="<?php echo $rid; ?>" name="ReceiverID">
        <input type="hidden" value="<?php echo $creationdate; ?>" name="CreationDate">
        <input type="hidden" value="<?php echo $completeddate; ?>" name="CompletedDate">

        <input type='submit' value="Submit">
    </form>
</div>