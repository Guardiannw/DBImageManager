<?php
/*
 * PHP Pre-Process Information
 */
global $schoolNames, $userID, $userNames; //passed in from index
?>

<div id="title">
    New Request
</div>
<div id="content">
    <form id='createRequest' class="dataForm" method="post" action='?action=submitRequest'>
        <div class="table">
            <div class="row">
                <label for='ContactName'>Contact Name:</label>
                <input type='text' id='ContactName' name='ContactName'/>
            </div>
            
            <div class="row">
                <label for='ContactPhone'>Contact Phone:</label>
                <input type='tel' id='ContactPhone' name='ContactPhone'/>
            </div>
            
            <div class="row">
                <label for='ContactEmail'>Contact Email:</label>
                <input type='text' id='ContactEmail' name='ContactEmail'/>
            </div>
            
            <div class="row">
                <label for='ClientName'>Client Name:</label>
                <input type="text" id="ClientName" name="ClientName">
            </div>
            
            <div class="row">
                <label for='SchoolName'>School:</label>
                <select id='SchoolID' name='SchoolID'>
                <?php foreach($schoolNames as $id => $name): ?>
                    <option value="<?php echo $id; ?>">
                        <?php echo $name; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class="row">
                <label for='OrderType'>Order Type:</label>
                <input type='text' id='OrderType' name='OrderType'/>
            </div>
            
            <div class="row">
                <label for='ContactType'>Contact Type:</label>
                <input type='text' id='ContactType' name='ContactType'/>
            </div>
            
            <div class="row">
                <label for='Issue'>Issue:</label>
                <input type='text' id='Issue' name='Issue'/>
            </div>
            
            <div class="row">
                <label for='Assignee'>Assign To:</label>
                <select id="Assignee" name ="Assignee">
                <?php foreach($userNames as $uid => $name): ?>
                    <option value="<?php echo $uid; ?>">
                        <?php echo implode(" ",$name); ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            
            <div class="row">
                <label for='Notes'>Notes:</label>
                <textarea id='Notes' name='Notes' rows="5" cols="30" ></textarea>
            </div>
        </div>
        <input type="hidden" value="<?php echo $userID; ?>" name="ReceiverID">
        <input type='submit' value="Submit">
    </form>
</div>


