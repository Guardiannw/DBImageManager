//NATHAN~!!!!!~!!!~ 
//Make sure to switch it so taht the timestamp is only added when an item is scanned,
//not at the beginning automatically.





/**
 * addNewTableRowWithTextInputs
 * 
 * Adds a new row to the end of the table that contains two cells
 * both of which have a text input.
 * 
 * @param {type} tableid The id of the table to add a new row to.
 * @returns {undefined} Sets up the two input fields with the names
 * id[index] and ts[index] respectively for form access.  Also, automatically
 * fills the ts[index] with the current timestamp when the id[index] is filled and enter is pressed.
 * Then a new row is automatically created.
 */
function addNewTableRowWithTextInputs(tableid)
{
    var table = document.getElementById(tableid);
    var tableBody = table.tBodies[0];
    var row = tableBody.insertRow(-1); // inserts the new row at the end of the table
    var index = row.rowIndex;//current row index
    
    //if the row is not the first row in the table, then add the timestamp to the previous row
    if(index > 1)
    {
        var prevTimeStamp = document.getElementById("ts[" + String(index - 1) + "]");
        prevTimeStamp.value = String(Math.round(new Date().getTime()/1000));
    }
    var countCell = row.insertCell(0); // the cell to keep track of the current image number
    var idCell = row.insertCell(1); //the cell for the id text input
    var tsCell = row.insertCell(2); //the cell for the timestamp text input
    
    //fill up the countCell with an integer value that represents its count (index)
    countCell.innerHTML = index;
    
    //create the id input and make it so that when enter is pressed, then it automatically adds a new row
    idCell.innerHTML = '<input type="text" name="id[' + String(index) + ']" id="id[' + String(index) + ']" onkeypress="addRowsWithInputsOnEnter(\'' + String(tableid) + '\', event);">';
    
    //create the timestamp input and make it readonly, also set it to the current date and time
    tsCell.innerHTML = '<input type="text" name="ts[' + String(index) + ']" id="ts[' + String(index) + ']" value="" readonly>';
    
    
    //get the text box to give it focus
    var idInput = document.getElementById("id[" + String(index) + "]");
    
    idInput.focus(); //call the focus method to smoothly move from one to another.
}

/**
 * onEnter
 * 
 * Returns a boolean whether or not the event was triggered by the pressing of the enter key.
 * @param {type} event
 * @returns {Boolean}
 */
function onEnter(event)
{
    if(event.keyCode === 13)
    {
        event.preventDefault(); //otherwise the form would submit
        return true;
    }
    return false;
}


/**
 * addRowsWithInputsOnEnter
 * 
 * Executes the addNewTableRowWithTextInputs method only when the event was 
 * called by an event that involved pressing the enter key.
 * 
 * @param {type} tableid
 * @param {type} event
 * @returns {undefined}
 */
function addRowsWithInputsOnEnter(tableid, event)
{
    if(onEnter(event))
    {
        addNewTableRowWithTextInputs(tableid);
    }
}

/**
 * When the checker object is checked, then it makes the hiders visibility = visible,
 * otherwise it makes it the opposite of visible.
 * 
 * @param {radio} checker
 * @param {any} hider
 * @param {boolean} visible
 * @returns {None}
 */
function changeVisibilityOnCheck(checker, hider, visible)
{
    hider = document.getElementById(hider);
    visibility = visible ? 'visible' : 'hidden';
    if(checker.checked)
    {
        hider.style.visibility = visibility;
    }
    else
        hider.style.visibility = visibility;
}
