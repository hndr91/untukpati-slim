
<?php
/**
 *Class for Database connection
**/
class dbConnection {
  private $conn;

  function __construct() {}

  function connect() {
    include_once dirname(__FILE__) . '/config.php';
    //Connect to Database
    $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    //Check DB if connection error
    if(mysqli_connect_errno()) {
      echo "Failed connect to database : ". mysli_connect_error();
    }
    return $this->conn;
  }
}
?>
