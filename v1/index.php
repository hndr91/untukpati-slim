<?php

require_once '../include/dbHandler.php';
require_once '../libs/Slim/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/**
* Get service type end point
**/
$app->get('/type', function(){
  $res = array();
  $db = new dbHandler();

  $result = $db->getServiceType();

  while($type = $result->fetch_assoc()) {
    $tmp = array();
    $tmp["type_name"] = $type["type_name"];
    array_push($res,$tmp);
  }

  response(200, $res);

});

/**
* Get district end point
**/
$app->get('/district', function(){
  $res = array();
  $db = new dbHandler();

  $result = $db->getDistricts();

  while($district = $result->fetch_assoc()) {
    $tmp = array();
    $tmp["district_name"] = $district["district_name"];
    array_push($res,$tmp);
  }

  response(200, $res);

});

/**
* Get service list end point
**/
$app->get('/services', function(){
  $res = array();
  $db = new dbHandler();

  $result = $db->getAllServices();

  while($services = $result->fetch_assoc()) {
    $tmp = array();
    $tmp["service_name"] = $services["service_name"];
    $tmp["service_address"] = $services["service_address"];
    $tmp["service_telp"] = $services["service_telp"];
    $tmp["service_email"] = $services["service_email"];
    $tmp["service_info"] = $services["service_info"];
    array_push($res,$tmp);
  }
  response(200, $res);
});

/**
* Get service list based on service type
* @param $type
**/
$app->get('/servicestype/:type', function($type){
  $res = array();
  $db = new dbHandler();

  $result = $db->getSpecificServices($type);

  while($services = $result->fetch_assoc()) {
    $tmp = array();
    $tmp["service_name"] = $services["service_name"];
    $tmp["service_address"] = $services["service_address"];
    $tmp["service_telp"] = $services["service_telp"];
    $tmp["service_email"] = $services["service_email"];
    $tmp["service_info"] = $services["service_info"];
    array_push($res,$tmp);
  }
  response(200, $res);
});

/**
* Get service list based on district
* @param $district
**/
$app->get('/districtservices/:district', function($district){
  $res = array();
  $db = new dbHandler();

  $result = $db->getDistrictAllServices($district);

  while($services = $result->fetch_assoc()) {
    $tmp = array();
    $tmp["service_name"] = $services["service_name"];
    $tmp["service_address"] = $services["service_address"];
    $tmp["service_telp"] = $services["service_telp"];
    $tmp["service_email"] = $services["service_email"];
    $tmp["service_info"] = $services["service_info"];
    array_push($res,$tmp);
  }
  response(200, $res);
});

/**
* Get service list based on district and type
* @param $district $type
**/
$app->get('/districttypeservices/:district/:type', function($district,$type){
  $res = array();
  $db = new dbHandler();

  $result = $db->getDistrictAllServices($district,$type);

  while($services = $result->fetch_assoc()) {
    $tmp = array();
    $tmp["service_name"] = $services["service_name"];
    $tmp["service_address"] = $services["service_address"];
    $tmp["service_telp"] = $services["service_telp"];
    $tmp["service_email"] = $services["service_email"];
    $tmp["service_info"] = $services["service_info"];
    array_push($res,$tmp);
  }
  response(200, $res);
});

/**
* Print JSON result
* @param $status_code $response
*/
function response($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
    // setting response content type to json
    $app->contentType('application/json');
    // print as JSON
    echo json_encode($response);
}

$app->run();

?>
