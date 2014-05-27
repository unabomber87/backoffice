<?php

/**
* The database wrapper class
*/
class Database {
    /**
    * @var string Holds the database name
    */
    var $database_name;
    /**
    * @var string Holds the database username
    */
    var $database_user;
    /**
    * @var string Holds the database user password
    */
    var $database_pass;
    /**
    * @var string Holds the database host name
    */
    var $database_host;
    /**
    * @var string
    */
    var $database_link;

    /**
    * The class constructor
    * @param string $user The username
    * @param string $pass The user password
    * @param string $host The database server host name
    * @param string $db The database name to connect to
    */
    function Database($user, $pass, $host, $db) {
        $this->database_user = $user;
        $this->database_pass = $pass;
        $this->database_host = $host;
        $this->database_name = $db;
    }

    /**
    * The class destructor
    */
    function __destruct() {
        //print "Object [DATABASE] Destroyed.\n";
    }

    /**
    * Mutator to change the connection username on the fly
    * @param string $user The news username to use
    */
    function changeUser($user){
        $this->database_user = $user;
    }
    /**
    * Mutator to change the connection password on the fly
    * @param string $pass The news password to use
    */
    function changePass($pass){
        $this->database_pass = $pass;
    }
    /**
    * Mutator to change the connection host name on the fly
    * @param string $host The news host name to use
    */
    function changeHost($host){
        $this->database_host = $host;
    }
    /**
    * Mutator to change the connection database name on the fly
    * @param string $name The news database name to use
    */
    function changeName($name){
        $this->databse_name = $name;
    }
    /**
    * Mutator to change the database connection on the fly
    * @param string $user The new username
    * @param string $pass The new user password
    * @param string $host The new database server host name
    * @param string $name The new database name to connect to
    */
    function changeAll($user, $pass, $host, $name){
        $this->database_user = $user;
        $this->database_pass = $pass;
        $this->database_host = $host;
        $this->database_name = $name;
    }

    /**
    * Function to establish a connection to the database
    */
    function connect() {
        $this->database_link = mysql_connect($this->database_host, $this->database_user, $this->database_pass) or die("Could not make connection to MySQL");
        mysql_select_db($this->database_name) or die ("Could not open database: ". $this->database_name);        
    }

    /**
    * Function to close an ongoing connection to the database
    */
    function disconnect() {
        if(isset($this->database_link)) mysql_close($this->database_link);
        else mysql_close(); 
        //print "Database connection closed.\n";
    }

    /**
    * A Method to safely prepare passed arguments to an SQL query
    * 
    * This "magic quotes" any passed argument to a query depending on its type.
    * @param string $theValue The passed argument to magic quote
    * @param string $theType The data type of the passed argument
    * @param string $theDefinedValue Mutator for special cases
    * @param string $theNotDefinedValue Mutator for special cases
    * @return mixed The "Magic quoted" version of the received value
    */	
    function cleanUp($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
        $theValue = stripslashes($theValue);
        $theValue = mysql_escape_string($theValue);
        switch ($theType) {
            case "text":
              $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
              break;
            case "long":
            case "int":
              $theValue = ($theValue != "") ? intval($theValue) : "NULL";
              break;
            case "double":
              $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
              break;
            case "date":
              $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
              break;
            case "defined":
              $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
              break;
            case "zeroone":
                $theValue = ( ($theValue == 0) || ($theValue == 1)) ? $theValue : 0;
        }
        return $theValue;
    }

    /**
    * The query executor.
    * 
    * In the case of a SELECT command, the method returns a two dimensional array 
    * holding the dataset
    * 
    * In the case of an INSERT, UPDATE or DELETE command, the method returns a
    * boolean value with respect to its successful/unsuccessful execution.
    * 
    * @param string $qry The query to execute
    * @return mixed 
    */
//	function query($qry) {
//        if(!isset($this->database_link)) $this->connect();
//        $result = mysql_query($qry, $this->database_link) or die("Error: ". mysql_error());
//		
//        $qtype = strtoupper(substr($qry, 0, strpos($qry, ' ')));
//
//        if($qtype == "SELECT"){
//				$number_of_rows = mysql_num_rows($result);
//                $returnArray = array();
//                $i=0;
//				if($number_of_rows > 1){
//					while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
//						if ($row)
//								 $returnArray[$i++]=$row;
//					mysql_free_result($result);
//					$query_result = array();
//					$query_result['records_num']   = $number_of_rows;
//					$query_result['records_data']  = $returnArray;
//					
//					return $query_result;
//				}
//				else{
//					$returnArray = mysql_fetch_array($result, MYSQL_ASSOC);
//					mysql_free_result($result);
//					return $returnArray;
//				}
//        }
//        else{
//                return $result;
//        }
//    }

	function query($qry) {
        if(!isset($this->database_link)) $this->connect();
        mysql_query("SET NAMES 'utf8'");
        $result = mysql_query($qry, $this->database_link) or die("Error: ". mysql_error());

        $qtype = strtoupper(substr($qry, 0, strpos($qry, ' ')));

        if($qtype == "SELECT"){
                $returnArray = array();
                $i=0;
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
                        if ($row)
                                 $returnArray[$i++]=$row;
                mysql_free_result($result);
                return $returnArray;
        }
        else{
                return $result;
        }
    }

    /**
    * A method to return the total number of records of an SQL query.
    * 
    * @param string $qry The query to execute
    * @return int The totalnumber of records yelded by the query 
    */
    function number_of_rows($qry) {
        if(!isset($this->database_link)) $this->connect();
        mysql_query("SET NAMES 'utf8'");
        $result = mysql_query($qry, $this->database_link) or die("Error: ". mysql_error());
        $number_of_rows = mysql_num_rows($result);
        return $number_of_rows;
    }

}// End of class
?>
