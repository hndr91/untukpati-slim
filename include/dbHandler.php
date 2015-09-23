<?php

class dbHandler {
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
    $stmt->execute();
    $serviceType = $stmt->get_result();
    $stmt->close();
    return $serviceType;
  }

  /**
  * Get Disctrict Name
  **/
  public function getDistricts() {
    $query = "SELECT district_name FROM service_districts ORDER BY district_name ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $districtName = $stmt->get_result();
    $stmt->close();
    return $districtName;
  }

  /**
  * Get All Services
  **/
  public function getAllServices() {
    $query = "SELECT service_name, service_address, service_telp, service_email, service_type,
              service_district, service_info, service_img_url, service_location_name, service_location_long, service_location_lat
              FROM service_list
              GROUP BY service_type
              ORDER BY service_name ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $districtName = $stmt->get_result();
    $stmt->close();
    return $districtName;
  }
}
?>
