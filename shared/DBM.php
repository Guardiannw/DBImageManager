<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBM
 *
 * @author nrwebb
 */
class DBM {
    
    //constants
    const ALLCOLUMNS = 1;
    
    //put your code here
    protected $MYSQLIDATABASE;
    private $MYSQLIHOST;
    private $MYSQLIUSERNAME;
    private $MYSQLIPASSWORD;
    protected $DBO;
    protected $DatabaseFileURL;
    
    /**
     * Set up the DatabaseManager
     */
    public function __construct($db, $host, $user, $pass)
    {
       //set up the class variables
       $this->MYSQLIDATABASE = $db;
       $this->MYSQLIHOST = "p:".$host; // makek it a persistent connection
       $this->MYSQLIUSERNAME = $user;
       $this->MYSQLIPASSWORD = $pass;
       
       //try to make the connection to the database and server
       try
       {
            $server = mysqli_connect($this->MYSQLIHOST, $this->MYSQLIUSERNAME, $this->MYSQLIPASSWORD);
            if(!$server)
            {
                throw new Exception('Server');
            }
            /*
             * if(!mysqli_select_db($server, $MYSQLIDATABASE)) //checks to see if database exists, if not, it runs the creation script
             * {
             *    mysqli_multi_query($server, file_get_contents($DatabaseFileURL));
             * }
             */
            $database = mysqli_connect($this->MYSQLIHOST, $this->MYSQLIUSERNAME, $this->MYSQLIPASSWORD, $this->MYSQLIDATABASE);
            if(!$database) // if the database does not exist, print error message
            {
                throw new Exception('Database');
            }
            
            //assign the database object to DBO
            $this->DBO = $database;
       }
       catch(Exception $ex)
       {
            printf("Error: Could not connect to the %s", $ex->getMessage());
       }
    }
    
    /**
     * Name: getDatabaseTables
     * 
     * Returns: An numerical array of the Table names.
     */
    public function getTables()
    {
        $query = mysqli_query($this->DBO, 'SELECT DATABASE()');
        $result = mysqli_fetch_assoc($query);
        $databaseName = $result['DATABASE()'];
        $query = mysqli_query($this->DBO, "SHOW TABLES FROM $databaseName");
        $results = array();
        $resultRow = mysqli_fetch_array($query);
        while(isset($resultRow))
        {
            array_push($results, $resultRow[0]);
            $resultRow = mysqli_fetch_array($query);
        }
        $query->free();
        return $results;
    }

    /**
     * Name: getTableRows
     * Params:
     * $table = string containing the table name
     * @param string $sortBy Column name to sort by
     * @param boolean $ascending True if ascending sort, false otherwise default = false
     * Returns: An numerical/associative array of the Table rows.
     */
    public function getTableRows($table, $sortBy = null, $ascending = false)
    {
        //check for sorting and prep accordingly
        if(isset($sortBy))
        {
            $asc = $ascending ? "ASC" : "DESC";
            $sortBy = $this->DBO->real_escape_string($sortBy); // for security
            $sortString = "ORDER BY $sortBy $asc";
        }
        else
        {
            $sortString = "";
        }
        //escape the table
        $table = $this->DBO->real_escape_string($table);
        $query = $this->DBO->query("SELECT * FROM $table $sortString");
        $results = array();
        $resultRow = mysqli_fetch_array($query, MYSQLI_ASSOC);
        while(isset($resultRow))
        {
            array_push($results, $resultRow);
            $resultRow = mysqli_fetch_array($query, MYSQLI_ASSOC);
        }
        $query->free();
        return $results;
    }
    /**
     * Name: getTableHeaders
     * Params:
     * $table = string containing the table name
     * Returns: An numerical/associative array of the Table rows.
     */
    public function getTableHeaders($table)
    {
        //escape table
        $table = $this->DBO->real_escape_string($table);
        $query = $this->DBO->query("SELECT * FROM $table LIMIT 0,1");//only return 1 row to optomize it
        $fields = mysqli_fetch_fields($query);
        $results = array();
        foreach($fields as $field)
        {
            array_push($results, $field->name);
        }
        $query->free();
        return $results;
    }

    /**
     * Name: getColumnsFromTable
     * Params:
     * $columns = names of columns to retreive from table (ALLCOLUMNS will return all columns)
     * $table = string containing the table name
     * @param string $sortBy Column name to sort by
     * @param boolean $ascending True if ascending sort, false otherwise default = false
     * Returns: An numerical/associative array of the Table rows where the ID is the key.
     */
    public function getColumnsFromTable($columns, $table, $sortBy = null, $ascending = false)
    {
        //check for sorting and prep accordingly
        if(isset($sortBy))
        {
            $asc = $ascending ? "ASC" : "DESC";
            $sortBy = $this->DBO->real_escape_string($sortBy);
            $sortString = "ORDER BY $sortBy $asc";
        }
        else
        {
            $sortString = "";
        }
        //check for constants
        if($columns === self::ALLCOLUMNS)
        {
            $columns = $this->getTableHeaders($table);
        }
        
        //escape all columns
        foreach($columns as $key=>$value)
        {
            $columns[$key] = $this->DBO->real_escape_string($value);
        }
        
        //escape the table
        $table = $this->DBO->real_escape_string($table);
        //execute query
        $query = $this->DBO->query("SELECT ".implode(',',$columns)." FROM $table $sortString");
        $results = $query->fetch_all(MYSQLI_ASSOC);
        $query->free();
        return $results;
    }


    /**
     * Name: getColumnsFromTableWithValues
     * Params:
     * $constraints = associative array where the key is the column name and the value is the constraint
     * $columns = array of desired columns (ALLCOLUMNS will return all columns)
     * $table = string containing the table name
     * @param string $sortBy Column name to sort by
     * @param boolean $ascending True if ascending sort, false otherwise default = false
     * Returns: An numerical array of the associative Table row arrays.
     */
    public function getColumnsFromTableWithValues($constraints, $columns, $table, $sortBy = null, $ascending = false)
    {
        //check for sorting and prep accordingly
        if(isset($sortBy))
        {
            $asc = $ascending ? "ASC" : "DESC";
            $sortBy = $this->DBO->real_escape_string($sortBy);
            $sortString = "ORDER BY $sortBy $asc";
        }
        else
        {
            $sortString = "";
        }
        
        //prep the input for different data types & Create individual statements
        $statements = array();
        foreach($constraints as $key=>$value)
        {
            $key = $this->DBO->real_escape_string($key);
            $value = $this->DBO->real_escape_string($value);
            //if any values are null, then remove them
            if(!isset($value))
            {
                unset($constraints[$key]);
            }
            else
            {
                //escape all values
                $statements[] = "$key = '$value'";
            }
        }
        
        //check for constants
        if($columns === self::ALLCOLUMNS)
        {
            $columns = $this->getTableHeaders($table);
        }
        
        //escape all columns
        foreach($columns as $key=>$value)
        {
            $columns[$key] = $this->DBO->real_escape_string($value);
        }
        
        //escape table
        $table = $this->DBO->real_escape_string($table);
        
        //execute query
        $formulatedQuery = "SELECT ".implode(',',$columns)." FROM $table WHERE ".implode(' AND ', $statements)." $sortString";
        $query = $this->DBO->query($formulatedQuery);
        $results = array();
        $resultRow = mysqli_fetch_array($query, MYSQLI_ASSOC);
        while(isset($resultRow))
        {
            array_push($results, $resultRow);
            $resultRow = mysqli_fetch_array($query, MYSQLI_ASSOC);
        }
        $query->free();
        return $results;
    }
    
    /**
     * Name: getColumnsFromTableWithValues
     * Params:
     * $constraints = associative array where the key is the column name and the value is the search constraint
     * $columns = array of desired columns (ALLCOLUMNS will return all columns)
     * $table = string containing the table name
     * @param string $sortBy Column name to sort by
     * @param boolean $ascending True if ascending sort, false otherwise default = false
     * Returns: An numerical array of the associative Table row arrays.
     */
    public function getColumnsFromTableWithSearchValues($constraints, $columns, $table, $sortBy = null, $ascending = false)
    {
        //if there are no constraints, then call the other function
        if(empty($constraints))
        {
            return $this->getColumnsFromTable($columns, $table, $sortBy, $ascending);
        }
        
        //check for sorting and prep accordingly
        if(isset($sortBy))
        {
            $asc = $ascending ? "ASC" : "DESC";
            $sortBy = $this->DBO->real_escape_string($sortBy);
            $sortString = "ORDER BY $sortBy $asc";
        }
        else
        {
            $sortString = "";
        }
        
        //prep the input for different data types & Create individual statements
        $statements = array();
        foreach($constraints as $key=>$value)
        {
            $key = $this->DBO->real_escape_string($key);
            $value = $this->DBO->real_escape_string($value);
            //if any values are null, then remove them
            if(!isset($value))
            {
                unset($constraints[$key]);
            }
            else
            {
                //escape all values
                $statements[] = "$key LIKE '%$value%'";
            }
        }
        
        //check for constants
        if($columns === self::ALLCOLUMNS)
        {
            $columns = $this->getTableHeaders($table);
        }
        
        //escape all columns
        foreach($columns as $key=>$value)
        {
            $columns[$key] = $this->DBO->real_escape_string($value);
        }
        
        //escape table
        $table = $this->DBO->real_escape_string($table);
        
        //execute query
        $formulatedQuery = "SELECT ".implode(',',$columns)." FROM $table WHERE ".implode(' AND ', $statements)." $sortString";
        $query = $this->DBO->query($formulatedQuery);
        $results = array();
        $resultRow = mysqli_fetch_array($query, MYSQLI_ASSOC);
        while(isset($resultRow))
        {
            array_push($results, $resultRow);
            $resultRow = mysqli_fetch_array($query, MYSQLI_ASSOC);
        }
        $query->free();
        return $results;
    }
    
    /**
     * Inserts a group of objects into specified table where
     * the key of the array is the column name and the value
     * is the value to be passed.
     * 
     * @param {String} $table
     * @param {Assoc. Array} $list
     */
    public function insertIntoTable($table, $list)
    {
        //prep the input for different data types
        foreach($list as $key=>$value)
        {
            $key = $this->DBO->real_escape_string($key);
            $value = $this->DBO->real_escape_string($value);
            
            //if any values are null, the explicity declare them as string 'NULL'
            if(!isset($value))
            {
                $escapedList[$key]= 'NULL';
            }
            else
            {
                $escapedList[$key] = "'$value'";
            }
            
        }
        
        //get the columns
        $columnString = implode(", ", array_keys($escapedList));
        
        //get the values
        $valueString = implode (", ", $escapedList);
        
        //escape the table
        $table = $this->DBO->real_escape_string($table);
        
        //execute query
        $formulatedQuery = "INSERT INTO $table ($columnString) VALUES ($valueString)";
        $query = $this->DBO->query($formulatedQuery);
        if(!$query)
        {
            echo $this->DBO->error;
        }
    }
    
    /**
     * Updates a row in a table given a list of values where the keys are the column names
     * and the values are the desired values.  MUST INCLUDE ID COLUMN
     * @param String $table
     * @param Assoc. Array $list MUST INCLUDE 'ID' Column and an associated value
     */
    public function updateTableRowWithID($table,$list)
    {
        
        //get the id
        $id = $this->DBO->real_escape_string($list["ID"]);
        //take the id out of the list
        unset($list["ID"]);
        
        //create a set array prep the input for different data types
        $setArray = array();
        foreach($list as $key=>$value)
        {
            $key = $this->DBO->real_escape_string($key);
            $value = $this->DBO->real_escape_string($value);
            
            //if any values are null, the explicity declare them as string 'NULL'
            if(!isset($value))
            {
                $escapedList[$key]= 'NULL';
            }
            else
            {
                $escapedList[$key] = "'$value'";
            }
            //add to the set array
            $setArray[] = "$key = $escapedList[$key]";
            
        }
        
        //create set string
        $setString = implode(", ", $setArray);
        //escape table
        $table = $this->DBO->real_escape_string($table);
        //execute query
        $formulatedQuery = "UPDATE $table SET $setString WHERE ID = $id";
        $query = $this->DBO->query($formulatedQuery);
        if(!$query)
        {
            echo $this->DBO->error;
        }
    }
}
