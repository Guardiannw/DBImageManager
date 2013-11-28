<?php

/*
 * PHP Pre-Process Information
 */
global $requests, $schoolNames;

//format the time for the requests
formatTimeArray($requests, array(ServiceRequest::$creationdate), "F d, Y");

//format the SchoolID's with the school names
foreach($requests as $key=>$request)
{
    //create a simple link to the schoolid
    $sid = $request[ServiceRequest::$schoolid];
    
    //assign the school name to the schoolid field
    $requests[$key][ServiceRequest::$schoolid] = $schoolNames[(int)$sid];
    
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
                
                //go through all of the rows
                $(rows).each(function()
                {
                    var row = $(this)[0]; // get the current row
                    //get current row index
                    var rowIndex = $(rows).index(this);
                    //get the current row object from the imported data
                    var rowData = data[rowIndex];
                    
                    //go through all of the columns in the row
                    $(row.cells).each(function()
                    {
                        var column = $(this)[0]; // get the current column
                        
                        //get the column header
                        var header = $(column).attr("headers");
                        
                        //get the same column value from the rowData
                        var insertValue = rowData[header];
                        
                        //insert the value into the column
                        $(column).html(insertValue);
                    });
                    
                });
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
            <th>
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
            <td>
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