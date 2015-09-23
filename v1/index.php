<?php

require_once '../include/dbHandler.php';
require_once '../libs/Slim/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


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

function response($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();

?>
