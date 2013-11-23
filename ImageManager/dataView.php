<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    global $databaseManager; //should have been created by connect.php

    //get the table names
    $tableNames = $databaseManager->getTables();
    $selectedTable = $_GET['table'];
    
    //if the table is selected then get the fields
    if(isset($selectedTable))
    {
        $fields = $databaseManager->getTableHeaders($selectedTable);//the table headers for the search
        $columns = $_POST['columns']; // the columns that have been selected from a search
        $columnValues = $_POST['columnValues'];
        if(isset($columns))
        {
            //add search specification if added
            if(isset($columnValues))
            {
                //run through column values and remove all of the null values, and the ones not checked.
                foreach($columnValues AS $key=>$value)
                {
                    if(!in_array($key, $columns) || empty($value))
                    {
                        unset($columnValues[$key]);
                    }
                }
                
                //get the rows
                $rows = $databaseManager->getColumnsFromTableWithValues($columnValues, $columns, $selectedTable);
            }
            else
            {
                $rows = $databaseManager->getColumnsFromTable($columns, $selectedTable);
            }
        }
        else
        {
            $rows = $databaseManager->getTableRows($selectedTable);
        }
    }
    
    //return to the current page
    $_POST['window'] = $window;
?>
            <!-- Select the appropriate table for searching -->
            <select id="tableSelect" onchange="location.href=('?table=' + this.options[this.selectedIndex].value);">
                
                <!-- Create a default option for selecting a database -->
                <?php foreach($tableNames as $tableName): ?>
                <option value="<?php echo $tableName ?>" <?php echo $tableName == $selectedTable ? 'selected' : ''; ?>>
                    <?php echo $tableName; ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Create a form for specifying the columns desired for searching -->
            <?php if(isset($selectedTable)): ?>
            <form method="post" id="columnsSearch">
                <!-- This is the section for specifying the desired columns -->
                    <?php foreach($fields as $key=>$field):?>
                    
                        <label for="<?php echo "columns[$key]"; ?>">
                            <?php echo $field; ?>
                        </label>
                        <input type="checkbox" 
                               name="<?php echo "columns[$key]"; ?>" 
                               value="<?php echo $field; ?>" 
                                   <?php echo isset($columns) ? (in_array($field, $columns) ? 'checked' : '') : 'checked'; ?>
                        >
                    <?php endforeach; ?>
                <!-- This is the section for specifying query constraints -->
                    <?php foreach($fields as $key=>$field):?>
                        <label for="<?php echo "columnValues[$field]"; ?>">
                            <?php echo $field; ?>
                        </label>
                        <input type="text" name="<?php echo "columnValues[$field]"; ?>">
                        
                    <?php endforeach; ?>
                <input type="submit" value="Search">
            </form>
            <?php endif; ?>
            
            
            
            <!-- If a table has been selected, then display the specified view. -->
            <?php if(isset($selectedTable)): ?>
            
            <table id="databaseTable" name="<?php echo $selectedTable; ?>">
                <?php foreach($rows as $row): ?>
                <tr>
                    <?php foreach($row as $column): ?>
                    <td>
                        <?php echo $column; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>