<?php
 
/**
 * A class file to connect to database
 */
class DbConnect {
    
    var $con;
    // constructor
    function __construct() {}
 
    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }
 
    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once __DIR__ . '/eugo.php';
 
        // Connecting to mysql database        
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE); 
 
        // returing connection cursor
        return $this->con;
    }
 
    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        if($this->con){
            $this->con->close();
        }
    }
 
}
 
?>

