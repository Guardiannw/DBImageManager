<?php
/*
 * PHP Pre-Process Information
 */
global $schoolNames; //passed in from index
?>

<div id="header">
    <h1>New Request</h1>
</div>
<div id="content">
    <form id='createRequest' method="post" action='?action=submitRequest'>
        <div class="alignright inline-block">
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
        </div>
        <div class='inline-block alignleft'>
            <input type='text' id='ContactName' name='ContactName'/>
            <input type='tel' id='ContactPhone' name='ContactPhone'/>
            <input type='text' id='Conte[School::$name]actEmail' name='ContactEmail'/>
            
            <input type="text" id="ClientName" name="ClientName"> 
            
            <select id='SchoolID' name='SchoolID'>
            <?php foreach($schoolNames as $id => $name): ?>
                <option value="<?php echo $id; ?>">
                    <?php echo $name; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <input type='text' id='OrderType' name='OrderType'/>
            <input type='text' id='ContactType' name='ContactType'/>
            <input type='text' id='Issue' name='Issue'/>
            <input type='number' id='Assignee' name='Assignee'/>
            <textarea id='Notes' name='Notes' rows="5" cols="30" ></textarea>
        </div>

        <input type='submit' value="Submit">
    </form>
</div>


