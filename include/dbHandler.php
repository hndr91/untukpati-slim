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

  /**
  * Get Spesific type of services
  * @param $type
  **/
  public function getSpecificServices($type) {
    $query = "SELECT service_name, service_address, service_telp, service_email, service_district, service_info, service_img_url,
              service_location_name, service_location_long, service_location_lat
              FROM service_list
              WHERE service_type = ?
              GROUP BY service_type
              ORDER BY service_name";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s",$type);
    $stmt->execute();
    $services = $stmt->get_result();
    $stmt->close();
    return $services;
  }

  /**
  * Get All Services in specific distrct
  * @param $district
  **/
  public function getDistrictAllServices($district) {
    $query = "SELECT service_name, service_address, service_telp, service_email, service_type, service_info, service_img_url,
              service_location_name, service_location_long, service_location_lat
              FROM service_list
              WHERE service_district = ?
              GROUP BY service_type
              ORDER BY service_name";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s",$district);
    $stmt->execute();
    $services = $stmt->get_result();
    $stmt->close();
    return $services;
  }

  /**
  * Get specific service in specific district
  * @param $distrct $type
  **/
  public function getDistrictServiceType($district, $type) {
    $query = "SELECT service_name, service_address, service_telp, service_email, service_info, service_img_url,
              service_location_name, service_location_long, service_location_lat
              FROM service_list
              WHERE service_district = ? AND service_type = ?
              GROUP BY service_type
              ORDER BY service_name";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ss",$district,$type);
    $stmt->execute();
    $services = $stmt->get_result();
    $stmt->close();
    return $services;
  }


}
?>
