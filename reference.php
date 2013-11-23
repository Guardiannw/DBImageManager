<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


        <form method="post">
            <input type="text" name="query">
            <br>
            <table id="output">
                <tr id="headerRow">
                <?php
                //output the header row
                for($i = 0; $i < count($column_header_array); $i++)
                {
                    echo '<td>' . $column_header_array[$i]->name . '</td>';
                }
                ?>
                </tr>
                <?php
                    //get an initial fetch
                    $results = mysqli_fetch_array($query, MYSQLI_NUM);
                    while($results != NULL)
                    {
                        //print the row initializer
                        echo '<tr>';
                        for($i = 0; $i < count($results); $i++)
                        {
                        echo '<td>' . $results[$i] . '</td>';
                        }
                        $results = mysqli_fetch_array($query, MYSQLI_NUM);
                        
                        //print the row finalizer
                        echo '</tr>';
                    }
                ?>
                </tr>
            </table>
            </fieldset>
            <button type="submit" value="Submit">
        </form>
        
        
        <?php
        // This bit of code appropriatly displays images to the screen dynamically!
                    $path = '/home/nrwebb/Pictures/scrnsht.png';
                    $image = imagecreatefrompng($path);
                    ob_start(); //start the output buffer
                    imagepng($image); //output image to the buffer
                    $output = ob_get_contents(); //store the contents of the buffer in $output
                    ob_end_clean(); //stop the buffer
                    echo '<img src="data:image/png; base64,'. base64_encode($output).'" />';
                    
                    $path = '/home/nrwebb/Pictures/file10198.jpg';
                    $info = exif_read_data($path, 'FILE', TRUE);
        ?>          
