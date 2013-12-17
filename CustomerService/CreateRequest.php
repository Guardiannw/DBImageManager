<?php
/*
 * PHP Pre-Process Information
 */
global $schoolNames, $userID, $userNames; //passed in from index

//possibilities for IssueType
$issueTypeOpts = ServiceRequest::$ISSUETYPEOPTIONS;

//possibilities for ContactType
$contactTypeOpts = ServiceRequest::$CONTACTTYPEOPTIONS;

?>

<div id="title">
    New Request
</div>
<div id="content">
    <form id='createRequest' class="dataForm" method="post" action='?action=submitRequest'>
        <div class="table">
            <div class="row">
                <label for='ContactName'>What was the <b>Name</b> of the individual who contacted you?</label>
                <input type='text' id='ContactName' name='ContactName'/>
            </div>
            
            <div class="row">
                <label for='ContactPhone'>What is the <b>Phone Number</b> of the individual who contacted you?</label>
                <input type='tel' id='ContactPhone' name='ContactPhone'/>
            </div>
            
            <div class="row">
                <label for='ContactEmail'>What is the <b>Email Address</b> of the individual who contacted you?</label>
                <input type='text' id='ContactEmail' name='ContactEmail'/>
            </div>
            
            <div class="row">
                <label for='ClientName'>What is the <b>Name</b> of the individual they were contacting you about?</label>
                <input type="text" id="ClientName" name="ClientName">
            </div>
            
            <div class="row">
                <label for='SchoolName'>What <b>School</b> , if any, does this issue pertain to?</label>
                <select id='SchoolID' name='SchoolID'>
                <?php foreach($schoolNames as $id => $name): ?>
                    <option value="<?php echo $id; ?>">
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class="row">
                <label for='IssueType'>What type of <b>category</b> does the issue pertain to?</label>
                <select id='IssueType' name='IssueType'>
                <?php foreach ($issueTypeOpts as $name): ?>
                    <option value="<?php echo $name; ?>" >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class="row">
                <label for='ContactType'>What <b>method of contact</b> did this individual use to contact you?</label>
                <select id='ContactType' name='ContactType'>
                <?php foreach ($contactTypeOpts as $name): ?>
                    <option value="<?php echo $name; ?>" >
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class="row">
                <label for='Issue'>What was the <b>issue</b> that they described to you?</label>
                <input type='text' id='Issue' name='Issue'/>
            </div>
            
            <div class="row">
                <label for='Assignee'>What <b>employee</b> would be best suited to handle this issue?</label>
                <select id="Assignee" name ="Assignee">
                <?php foreach($userNames as $uid => $name): ?>
                    <option value="<?php echo $uid; ?>">
                        <?php echo implode(" ",$name); ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class="row">
                <label for='Notes'>Record any updates or action taken on this issue here:</label>
                <textarea id='Notes' name='Notes' rows="5" cols="30" ></textarea>
            </div>
        </div>
        <input type="hidden" value="<?php echo $userID; ?>" name="ReceiverID">
        <input type='submit' value="Submit">
    </form>
</div>


