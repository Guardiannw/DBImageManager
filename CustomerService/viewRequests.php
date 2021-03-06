<?php

/*
 * PHP Pre-Process Information
 */
global $requests;

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
    
    // The searching options
    completedVisible = true;


    function getSearchBoxData()
    {
        var data = new Object();

        //get all of the text box values and store them in the data object
        $("input[id^='search']").each(function()
        {
            if($(this).val())
            {
                data[$(this).attr("name")] = $(this).val();
            }
        });

        return data;
    }

    function setCompletedVisibility()
    {
	$("tbody > tr").each(function()
        {
	    // Get the status column
	    var statusText = $(this).children("td[headers='Status']").html();
            // Reset each of the rows to visible
            $(this).show();
	    if(statusText.match("Completed/Resolved") != null || statusText.match("Completed/Unresolved") != null)
	    {
		if(!completedVisible)
                {
                    $(this).hide();
                }
	    }
	});
    }
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
            var senddata = {
            "column": selectedSort,
            "ascending":ascending,
            "constraints":getSearchBoxData()
            };

            //get the new data
            $.getJSON("/api/searchAndSortAllServiceRequests",senddata, function(data)
            {
                //go through each entry in the data
                $(data).each(function()
                {
                    //get all of the rows to be changed
                    var rows = $("tbody > tr");

                    var rowData = $(this)[0]; // get the current row in the data

                    var rowIndex = $(data).index(this); // get the current row index in the data array

                    var currentRow;

                    //check if this row exists otherwise make it
                    if(rows.length > rowIndex){
                        currentRow = rows[rowIndex];
                    }
                    else
                    {
                        //get the body of the table and make a new row
                        $("tbody").append("<tr><?php foreach($headers as $head): ?><td headers='<?php echo $head; ?>'></td><?php endforeach; ?><td headers='Edit'><form method='GET'><input type='hidden' name='action' value='editRequest'><input type='hidden' name='id' value=''><input type='submit' value='Edit'></form></td></tr>");

                        currentRow = $("tbody > tr:last").get(0);
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
                    //create the onclick link to view the request
                    $("tbody > tr:eq(" + rowIndex + ")").click(function()
                    {
                        //on each onclick, link to the request); referenced by the id
                        //get the id of the link to view
                        var id = $(this).children("[headers='ID']").html();

                        //set the location
                        location.href = '?action=viewRequest&id=' + id;
                    });
                });

                //remove all of the other rows from the table
                var dataLength = $(data).length;
                $("tbody > tr:gt(" + dataLength + "),tbody > tr:eq(" + dataLength + ")").remove();
                
                // Set the current visibility again
                setCompletedVisibility();
            });
        });

        //add the search on each key stroke in the search inputs
        $("input[id^='search']").keyup(function()
        {
            var senddata = {
            "column": selectedSort,
            "ascending":ascending,
            "constraints":getSearchBoxData()
            };

            //get the new data
            $.getJSON("/api/searchAndSortAllServiceRequests",senddata, function(data)
            {
                //go through each entry in the data
                $(data).each(function()
                {

                    //get all of the rows to be changed
                    var rows = $("tbody > tr");

                    var rowData = $(this)[0]; // get the current row in the data

                    var rowIndex = $(data).index(this); // get the current row index in the data array

                    var currentRow;

                    //check if this row exists otherwise make it
                    if(rows.length > rowIndex){
                        currentRow = rows[rowIndex];
                    }
                    else
                    {

                        //get the body of the table and make a new row
                        $("tbody").append("<tr><?php foreach($headers as $head): ?><td headers='<?php echo $head; ?>'></td><?php endforeach; ?><td headers='Edit'><form method='GET'><input type='hidden' name='action' value='editRequest'><input type='hidden' name='id' value=''><input type='submit' value='Edit'></form></td></tr>");

                        currentRow = $("tbody > tr:last").get(0);
                    }

                    //fill the row in with the appropriate data
                    $(currentRow.cells).each(function()
                    {
                        var column = $(this)[0]; // get the current column

                        //get the column header
                        var header = $(column).attr("headers");

                        //do something different if the column is the edit column
                        if(header === "Edit")
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
                    //create the onclick link to view the request
                    $("tbody > tr:eq(" + rowIndex + ")").click(function()
                    {
                        //on each onclick, link to the request); referenced by the id
                        //get the id of the link to view
                        var id = $(this).children("[headers='ID']").html();

                        //set the location
                        location.href = '?action=viewRequest&id=' + id;
                    });

                });

                //remove all of the other rows from the table
                var dataLength = $(data).length;
                $("tbody > tr:gt(" + dataLength + "),tbody > tr:eq(" + dataLength + ")").remove();
                
                // Set the current visibility again
                setCompletedVisibility();
            });
        });

        //set up the size of all of the search inputs
        $("th[id!='Edit']").each(function()
        {
            //get the id of the th
            var id = $(this).attr("id");
            //unhide the search box
            var searchBox = $("input.columnSearch[name='" + id + "']");

            //set the maxwidth for the column
            $(this).css("max-width", $(this).outerWidth());
            $(this).css("width", $(this).outerWidth());

        });

        //set up all onclicks for all the rows at default
        $("tbody > tr").click(function()
        {
            //on each onclick, link to the request); referenced by the id
            //get the id of the link to view
            var id = $(this).children("[headers='ID']").html();

            //set the location
            location.href = '?action=viewRequest&id=' + id;
        });

    });
</script>

<!-- Options -->
<form id="viewOptions">
    <input type="checkBox" onclick="completedVisible = !completedVisible; setCompletedVisibility();" id="completedRequestToggle">
    <label for="completedRequestToggle">Hide Completed Requests</label>
</form>
<form id="columnSearchForm">
    <table id="viewRequests">
        <thead id="head">
            <tr>
                <!-- Service Request Headers -->
                <?php foreach($headers as $col): ?>
                <th id="<?php echo $col; ?>">
                    <?php echo $col; ?>
                    <img src="/shared/images/square.png" id="img<?php echo $col; ?>">
                    <input type="text" id="search<?php echo $col; ?>" name="<?php echo $col; ?>" class="columnSearch">
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
                        <input type='hidden' name='action' value='editRequest'>
                        <input type='hidden' name='id' value='<?php echo $row[ServiceRequest::$id]; ?>'>
                        <input type="submit" value="Edit">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
