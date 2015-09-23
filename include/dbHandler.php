<?php

private $conn;

function __construct() {
  require_once dirname(__FILE__) . '/dbConnect.php';
  //Open DB connection
  $db = new dbConnect();
  $this->conn = $db->connect();
}

/**
* Get Service Type Name
**/
public function getServiceType() {
  $query = "SELECT type_name FROM service_type ORDER BY type_name ASC";
  $stmt = $this->conn->prepare($query);
  $stmt->excute();
  $serviceType = $stmt->get_result();
  $stmt->close();
  return $serviceType;
}

/**
* Get Disctrict Name
**/
public function getDistricts() {
  $query = "SELECT district_name FROM service_districts ORDER BY district_name ASC"
  $stmt = $this->conn->prepare($query);
  $stmt->excute();
  $districtName = $stmt->get_result();
  $stmt->close();
  return $districtName;
}

/**
* Get All Services
**/
public function getAllServices() {
  
}


 ?>
