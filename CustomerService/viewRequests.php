<?php

/*
 * PHP Pre-Process Information
 */
global $requests, $schoolNames, $userNames;

//format the time for the requests
formatTimeArray($requests, array(ServiceRequest::$creationdate), ServiceRequest::DEFAULTTIMEFORMAT);

//format the SchoolID's with the school names
foreach($requests as $key=>$request)
{
    //re-assign the schoolid field
    //create a simple link to the schoolid
    $sid = $request[ServiceRequest::$schoolid];
    
    //assign the school name to the schoolid field
    $requests[$key][ServiceRequest::$schoolid] = $schoolNames[(int)$sid];
    unset($sid);
    
    //re-assign the receiverID field
    //create a simple link to the schoolid
    $sid = $request[ServiceRequest::$rid];
    
    //assign the user name to the receiverid field
    $requests[$key][ServiceRequest::$rid] = implode(" ",$userNames[(int)$sid]);
    unset($sid);
    
    //re-assign the assigneeID field
    ////create a simple link to the schoolid
    $sid = $request[ServiceRequest::$aid];
    
    //assign the user name to the asigneeid field
    $requests[$key][ServiceRequest::$aid] = implode(" ",$userNames[(int)$sid]);
    unset($sid);
    
    //take out the Notes section
    unset($requests[$key][ServiceRequest::$notes]);
}

//get the headers from first element of array.
$headers = array_keys(current($requests));
?>

<!-- Initiate the JQuery for this file -->
<script type="text/javascript">
    
    //set the document defaults
    defaultImg = "/square.png";
    selectedSort = "<?php echo ServiceRequest::$id; ?>";
    ascending = true;
    selectedImage = null;
        
    //only execute this when the document has been loaded
    $(document).ready(function()
    {
        //set the first selected image
        selectedImage = $("#img<?php echo ServiceRequest::$id; ?>");
        
        //change the image to follow the defaults
        newimg = ascending ? "/downarrow.png" : "/uparrow.png";
        selectedImage.attr("src", selectedImage.attr("src").replace(/\/[a-zA-Z0-9]+[.][a-zA-Z]+/,newimg));
        
        delete newimg;
        
        //add the onclick functions to each to change the selectedSort and ascending
        $("img[id^='img']").click(function()
        {
            
            //reset old image if it is not this one (use the get(0) to compare the DOM Objects)
            if(!(selectedImage.get(0) === $(this).get(0)))
            selectedImage.attr("src", selectedImage.attr("src").replace(/\/[a-zA-Z0-9]+[.][a-zA-Z]+/,defaultImg));
            
            //automatically make this object the selectedImage & set selectedSort
            selectedImage = $(this);
            selectedSort = $(this).parent().attr("id");
            
            //check to see if this image has been selected before, if so then switch arrow
            //otherwise just make a down arrow
            if($(this).attr("src").match(/square.png$/))
            {
                $(this).attr("src", $(this).attr("src").replace(/\/[a-zA-Z0-9]+[.][a-zA-Z]+/,"/downarrow.png"));
                
                //set ascending
                ascending = true;
                
            }
            else
            {
                //switch ascending 
                ascending = !ascending;
                //figure out desired image
                assign = ascending ? "/downarrow.png": "/uparrow.png";
                
                $(this).attr("src", $(this).attr("src").replace(/\/[a-zA-Z0-9]+[.][a-zA-Z]+/,assign));
            }
            
            //set send parameters
            var senddata = {};
            senddata["column"] = selectedSort;
            senddata["ascending"] = ascending;

            //get the new data
            $.getJSON("/MooreStudioProject/api/sortAllServiceRequests",senddata, function(data)
            {
                //get all of the rows to be changed
                var rows = $("tbody > tr");
                
                //go through each entry in the data
                $(data).each(function()
                {
                    var rowData = $(this)[0]; // get the current row in the data
                    
                    var rowIndex = $(data).index(this); // get the current row index in the data array
                    
                    var currentRow;
                    
                    //check if this row exists otherwise make it
                    if(rows.length > rowIndex){
                        currentRow = rows[rowIndex];
                    }
                    else
                    {
                        //clone the last row
                        currentRow = $(rows).last().clone(true).get(0);
                        
                        //insert it after the last row
                        $(currentRow).insertAfter(rows.last());
                    }
                    
                    //fill the row in with the appropriate data
                    $(currentRow.cells).each(function()
                    {
                        var column = $(this)[0]; // get the current column
                        
                        //get the column header
                        var header = $(column).attr("headers");
                        
                        //do something different if the column is the edit column
                        if(header == "Edit")
                        {
                            //get the input for the id
                            var input = $(column).find("input[name='id']");
                            
                            //put the id in the value
                            $(input).attr("value",rowData["ID"]);
                        }
                        else
                        {
                            //get the same column value from the rowData
                            var insertValue = rowData[header];

                            //insert the value into the column
                            $(column).html(insertValue);
                        }
                    });
                });
                
                //remove all of the other rows from the table
                var dataLength = $(data).length;
                $("tbody > tr:gt(" + dataLength + "),tbody > tr:eq(" + dataLength + ")").remove();
                
            });
        });
        
    });
</script>
<table id="viewRequests">
    <thead id="head">
        <tr>
            <!-- Service Request Headers -->
            <?php foreach($headers as $col): ?>
            <th id="<?php echo $col; ?>">
                <?php echo $col; ?>
                <img src="/MooreStudioProject/shared/images/square.png" id="img<?php echo $col; ?>">
            </th>
            <?php endforeach;?>
            
            <!-- Edit Header -->
            <th id="Edit">
                Edit
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($requests as $row): ?>
        <tr>
            <!-- Input normal row information -->
            <?php foreach($row as $head=>$cols): ?>
            <td headers="<?php echo $head; ?>">
                <?php echo $cols; ?>
            </td>
            <?php endforeach; ?>
            
            <!-- Input the edit button -->
            <td headers="Edit">
                <form method="GET">
                    <input type='hidden' name='id' value='<?php echo $row[ServiceRequest::$id]; ?>'>
                    <input type='hidden' name='action' value='editRequest'>
                    <input type="submit" value="Edit">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>