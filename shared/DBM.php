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
       $this->MYSQLIHOST = $host;
       $this->MYSQLIUSERNAME = $user;
       $this->MYSQLIPASSWORD = $pass;
       
       //try to make the connection to the database and server
       try
       {
            $server = mysqli_connect($host, $user, $pass);
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
            $database = mysqli_connect($host, $user, $pass, $db);
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
     * Returns: An numerical/associative array of the Table rows.
     */
    public function getTableRows($table)
    {
        $query = $this->DBO->query("SELECT * FROM $table");
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
     * Returns: An numerical/associative array of the Table rows where the ID is the key.
     */
    public function getColumnsFromTable($columns, $table)
    {
        //check for constants
        if($columns === self::ALLCOLUMNS)
        {
            $columns = $this->getTableHeaders($table);
        }
        $query = $this->DBO->query("SELECT ".implode(',',$columns)." FROM $table");
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
     * $constraints = associative array where the key is the column name and the value is the constraint
     * $columns = array of desired columns (ALLCOLUMNS will return all columns)
     * $table = string containing the table name
     * Returns: An numerical array of the associative Table row arrays.
     */
    public function getColumnsFromTableWithValues($constraints, $columns, $table)
    {
        $statements = array();
        foreach($constraints as $key=>$value)
        {
            array_push($statements, "$key = $value");
        }
        //check for constants
        if($columns === self::ALLCOLUMNS)
        {
            $columns = $this->getTableHeaders($table);
        }
        $query = $this->DBO->query("SELECT ".implode(',',$columns)." FROM $table WHERE ".implode(' AND ', $statements));
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
        //get the columns
        $columnString = implode(", ", array_keys($list));
        
        //prep the input for different data types
        foreach($list as &$value)
        {
            
            //if any values are null, the explicity declare them as string 'NULL'
            if(!isset($value))
            {
                $value = 'NULL';
            }
            
            //prep all strings with single quotes
            if(is_string($value))
            {
                $value = "'$value'";
            }
            
        }
        
        //get the values
        $valueString = implode (", ", $list);
        
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
        $id = $list["ID"];
        //take the id out of the list
        unset($list["ID"]);
        //prep the input for different data types
        foreach($list as $key=>$value)
        {
            
            //if any values are null, the explicity declare them as string 'NULL'
            if(!isset($value))
            {
                $list[$key]= 'NULL';
            }
            
            //prep all strings with single quotes
            if(is_string($value))
            {
                $list[$key] = "'$value'";
            }
            
        }
        
        //create a set array
        $setArray = array();
        foreach($list as $key=>$value)
        {
            $setArray[] = "$key = $value";
        }
        
        //create set string
        $setString = implode(", ", $setArray);
        
        //execute query
        $formulatedQuery = "UPDATE $table SET $setString WHERE ID = $id";
        $query = $this->DBO->query($formulatedQuery);
        if(!$query)
        {
            echo $this->DBO->error;
        }
    }
}
