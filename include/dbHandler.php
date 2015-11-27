<?php

class dbHandler {
  private $conn;

  /**
  * constructor
  **/
  function __construct() {
    require_once dirname(__FILE__) . '/dbConnect.php';
    //Open DB connection
    $db = new dbConnect();
    $this->conn = $db->connect();
  }

  /**
  =============GET==============
  **/

  /**
  * Get Service Type Name
  **/
  public function getServiceType() {
    $query = "SELECT type_name FROM service_type WHERE flag = 0 ORDER BY type_name ASC";
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
    $query = "SELECT district_name FROM service_districts WHERE flag = 0 ORDER BY district_name ASC";
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
              WHERE flag = 0
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

  /**
  =================POST===================
  **/

  /**
  * Insert new service type
  * @param $typeName
  **/
  public function postNewServiceType($typeName) {
    $res = array();

    if(!$this->isTypeExists($typeName)) {
      $id = ''; // set empty, because id is autoincrement
      $query = "INSERT INTO service_type(id_type, type_name) VALUES (?,?)";

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ss',$id,$typeName);
      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_TYPE_ADDED_SUCCESSFULLY;
      } else {
        return SERVICE_TYPE_ADD_FAILED;
      }
    } else {
      return SERVICE_TYPE_ALREADY_EXISTED;
    }

    return $res;
  }

  public function postNewDistrict($districtName) {
    $res = array();

    if(!$this->isDistrictExists($districtName)) {
      $id = '';
      $query = "INSERT INTO service_districts(id_district, district_name) VALUES (?,?)";

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ss', $id,$districtName);
      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_DISTRICT_ADDED_SUCCESSFULLY;
      } else {
        return SERVICE_DISTRICT_ADD_FAILED;
      }
    } else {
      return SERVICE_DISTRICT_ALREADY_EXISTED;
    }

    return $res;
  }

  /**
  * Insert new service
  * @param $id, $serviceName, $serviceAddress, $serviceTelp, $serviceEmail, $serviceType, $serviceDistrict,
  * @param $serviceInfo, $serviceImgUrl, $serviceLocationName, $serviceLocationLong, $serviceLocationLat
  **/
  public function postNewServiceList($serviceName, $serviceAddress, $serviceTelp, $serviceEmail, $serviceType, $serviceDistrict,
  $serviceInfo, $serviceImgUrl, $serviceLocationName, $serviceLocationLong, $serviceLocationLat) {
    $res = array();

    if(!$this->isServiceExists($serviceName)) {
      $id = '';
      $query = "INSERT INTO service_list(id_service, service_name, service_address, service_telp, service_email,
        service_type, service_district, service_info, service_img_url,
        service_location_name, service_location_long, service_location_lat)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ssssssssssss', $id,$serviceName,$serviceAddress,$serviceTelp,$serviceEmail,$serviceType,$serviceDistrict,
      $serviceInfo,$serviceImgUrl,$serviceLocationName,$serviceLocationLong,$serviceLocationLat);

      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_ADDED_SUCCESSFULLY;
      } else {
        return SERVICE_ADD_FAILED;
      }

    } else {
      return SERVICE_ALREADY_EXISTED;
    }

    return $res;
  }

  /**
  ================PUT=================
  **/

  /**
  * Update Service Type
  * @param $oldTypeName, $newTypeName
  **/
  public function updateType($oldTypeName, $newTypeName) {
    $res = array();

    if($this->isTypeExists($oldTypeName)){
      $query = "UPDATE service_type SET type_name = ? WHERE type_name = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ss', $newTypeName, $oldTypeName);
      $result = $stmt->execute();
      $stmt->close();

      if($result){
        return SERVICE_TYPE_UPDATED;
      } else {
        return SERVICE_TYPE_UPDATE_FAILED;
      }
    } else {
      return SERVICE_TYPE_NOT_EXIST;
    }
    return $res;
  }

  /**
  * Update Service district
  * @param $oldDistrictName, $newDistrictName
  **/
  public function updateDistrict($oldDistrictName, $newDistrictName) {
    $res = array();

    if($this->isDistrictExists($oldDistrictName)){
      $query = "UPDATE service_districts SET district_name = ? WHERE district_name = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ss', $newDistrictName, $oldDistrictName);
      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_DISTRICT_UPDATED;
      } else {
        return SERVICE_DISTRICT_UPDATE_FAILED;
      }
    } else {
      return SERVICE_DISTRICT_NOT_EXIST;
    }
    return $res;
  }

  /**
  * Update Service
  * @param $oldServiceName
  * @param $newServiceName, $newServiceAddress, $newServiceTelp, $newSeviceEmail,
  * @param $newServiceType, $newServiceDistrict, $newServiceInfo, $newServiceImgUrl, $newServiceLocationName,
  * @param $newServiceLocationLong, $newServiceLocationLat
  **/
  public function updateService($oldServiceName, $newServiceName, $newServiceAddress, $newServiceTelp, $newServiceEmail,
  $newServiceType, $newServiceDistrict, $newServiceInfo, $newServiceImgUrl, $newServiceLocationName,
  $newServiceLocationLong, $newServiceLocationLat) {
    $res = array();

    if($this->isServiceExists($serviceName)) {
      $query = "UPDATE service_list
                SET service_name = ?
                service_address = ?
                service_telp = ?
                service_email = ?
                service_type = ?
                service_district = ?
                service_info = ?
                service_img_url = ?
                service_location_name = ?
                service_location_long = ?
                service_location_lat = ?
                WHERE service_name = ?";

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('ssssssssssss',$newServiceName, $newServiceAddress, $newServiceTelp, $newServiceEmail,
      $newServiceType, $newServiceDistrict, $newServiceInfo, $newServiceImgUrl, $newServiceLocationName,
      $newServiceLocationLong, $newServiceLocationLat, $oldServiceName);

      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_UPDATED;
      } else {
        return SERVICE_UPDATE_FAILED;
      }
    } else {
      return SERVICE_NOT_EXIST;
    }
    return $res;
  }

  /**
  ============DELETE==============
  * SOFT DELETE
  **/

  public function deleteType($typeName) {
    $res = array();

    if($this->isTypeExists($typeName)){
      $query = "UPDATE service_type SET flag = 1 WHERE type_name = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('s', $typeName);
      $result = $stmt->execute();
      $stmt->close();

      if($result){
        return SERVICE_TYPE_DELETED;
      } else {
        return SERVICE_TYPE_DELETE_FAILED;
      }
    } else {
      return SERVICE_TYPE_NOT_EXIST;
    }
    return $res;
  }

  public function deleteDistrict($districtName) {
    $res = array();

    if($this->isDistrictExists($districtName)){
      $query = "UPDATE service_districts SET flag = 1 WHERE district_name = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('s', $districtName);
      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_DISTRICT_DELETED;
      } else {
        return SERVICE_DISTRICT_DELETE_FAILED;
      }
    } else {
      return SERVICE_DISTRICT_NOT_EXIST;
    }
    return $res;
  }

  public function deleteService($serviceName) {
    $res = array();

    if($this->isServiceExists($serviceName)) {
      $query = "UPDATE service_list SET flag = 1 WHERE service_name = ?";

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('s', $serviceName);
      $result = $stmt->execute();
      $stmt->close();

      if($result) {
        return SERVICE_DELETED;
      } else {
        return SERVICE_DELETE_FAILED;
      }
    } else {
      return SERVICE_NOT_EXIST;
    }
    return $res;
  }



  /**
  ============== HELPER METHOD =====================
  **/

  /**
  * Check existing type
  * @param $typeName
  **/
  public function isTypeExists($typeName) {
    $query = "SELECT type_name FROM service_type WHERE type_name = ? AND flag = 0";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('s',$typeName);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
  }

  /**
  * Check existing district
  * @param $districtName
  **/
  public function isDistrictExists($districtName) {
    $query = "SELECT district_name FROM service_districts WHERE district_name = ? AND flag = 0";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('s', $districtName);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
  }

  /**
  * Check existing service
  * @param $serviceName
  **/
  public function isServiceExists($serviceName) {
    $query = "SELECT service_name FROM service_list WHERE service_name = ? AND flag = 0";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('s', $serviceName);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    $stmt->close();
    return $rows > 0;
  }

}
?>
