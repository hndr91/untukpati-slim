<?php

require_once '../include/dbHandler.php';
require_once '../libs/Slim/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new Slim\Slim();

/**
=========== POST METHOD ==============
**/

/**
* Add service type end point
**/
$app->post('/addtype', function() use($app){
  $res = array();
  $typeName = $app->request()->post('typeName');
  $typeName = strtolower($typeName); // post everything in lowecase

  $db = new dbHandler();
  $result = $db->postNewServiceType($typeName);

  if($result == SERVICE_TYPE_ADDED_SUCCESSFULLY) {
		$res["error"] = false;
		$res["message"] = "Service type successfully added";
    $res["value"] = $typeName;
    response(201, $res);
	}
	else if($result == SERVICE_TYPE_ADD_FAILED) {
		$res["error"] = true;
		$res["message"] = "Ooops ! Failed to add service type!";
    $res["value"] = $typeName;
    response(200, $res);
	}
	else if($result == SERVICE_TYPE_ALREADY_EXISTED) {
		$res["error"] = true;
		$res["message"] = "Service type already existed";
    $res["value"] = $typeName;
    response(200, $res);
	}
});

/**
* Add service district end point
**/
$app->post('/adddistrict', function() use($app){
  $res = array();
  $districtName = $app->request()->post('districtName');
  $districtName = strtolower($districtName); // post everything in lowecase

  $db = new dbHandler();
  $result = $db->postNewDistrict($districtName);

  if($result == SERVICE_DISTRICT_ADDED_SUCCESSFULLY) {
		$res["error"] = false;
		$res["message"] = "Service district successfully added";
    $res["value"] = $districtName;
    response(201, $res);
	}
	else if($result == SERVICE_DISTRICT_ADD_FAILED) {
		$res["error"] = true;
		$res["message"] = "Ooops ! Failed to add service district!";
    $res["value"] = $districtName;
    response(200, $res);
	}
	else if($result == SERVICE_DISTRICT_ALREADY_EXISTED) {
		$res["error"] = true;
		$res["message"] = "Service district already existed";
    $res["value"] = $districtName;
    response(200, $res);
	}
});

$app->post('/addservice', function() use($app){
  $res = array();
  $serviceName = $app->request()->post('serviceName');
  $serviceAddress = $app->request()->post('serviceAddress');
  $serviceTelp = $app->request()->post('serviceTelp');
  $serviceEmail = $app->request()->post('serviceEmail');
  $serviceType = $app->request()->post('serviceType'); //post using type id
  $serviceDistrict = $app->request()->post('serviceDistrict'); //post using district id
  $serviceInfo = $app->request()->post('serviceInfo');
  $serviceImageUrl = $app->request()->post('serviceImageUrl');
  $serviceLocationName = $app->request()->post('serviceLocationName');
  $serviceLocationLong = $app->request()->post('serviceLocationLong');
  $serviceLocationLat = $app->request()->post('serviceLocationLat');

  //Post all paramater to lowercase except type, district, long, lat
  $serviceName = strtolower($serviceName);
  $serviceAddress = strtolower($serviceAddress);
  $serviceTelp = strtolower($serviceTelp);
  $serviceEmail = strtolower($serviceEmail);
  $serviceInfo = strtolower($serviceInfo);
  $serviceImageUrl = strtolower($serviceImageUrl);
  $serviceLocationName = strtolower($serviceLocationName);

  $db = new dbHandler();
  $result = $db->postNewServiceList($serviceName, $serviceAddress, $serviceTelp, $serviceEmail, $serviceType, $serviceDistrict,
  $serviceInfo, $serviceImageUrl, $serviceLocationName, $serviceLocationLong, $serviceLocationLat);

  if($result == SERVICE_ADDED_SUCCESSFULLY) {
		$res["error"] = false;
		$res["message"] = "Service district successfully added";
    response(201, $res);
	}
	else if($result == SERVICE_ADD_FAILED) {
		$res["error"] = true;
		$res["message"] = "Ooops ! Failed to add service district!";
    response(200, $res);
	}
	else if($result == SERVICE_ALREADY_EXISTED) {
		$res["error"] = true;
		$res["message"] = "Service district already existed";
    response(200, $res);
	}


});

/**
===============PUT METHOD REGION=================
**/

/**
* Update service type name
* @param $oldTypeName
**/
$app->put('/updatetype', function() use($app){
  $res = array();

  $oldTypeName = $app->request()->put('oldTypeName');
  $newTypeName = $app->request()->put('newTypeName');
  $oldTypeName = strtolower($oldTypeName);
  $newTypeName = strtolower($newTypeName);

  $db = new dbHandler();
  $result = $db->updateType($oldTypeName, $newTypeName);

  if($result == SERVICE_TYPE_UPDATED) {
    $res["error"] = false;
		$res["message"] = "Service type updated";
    response(201, $res);
  } else if ($result == SERVICE_TYPE_UPDATE_FAILED) {
    $res["error"] = true;
    $res["message"] = "Service type update failed";
    response(200, $res);
  } else if ($result == SERVICE_TYPE_NOT_EXIST) {
    $res["error"] = true;
    $res["error"] = "Service type not exist";
    response(200, $res);
  }
});

/**
* Update disctict name
* @param $oldDistrictName
**/
$app->put('/updatedistrict', function() use($app){
  $res = array();

  $oldDistrictName = $app->request()->put('oldDistrictName');
  $newDistrictName = $app->request()->put('newDistrictName');
  $oldDistrictName = strtolower($oldDistrictName);
  $newDistrictName = strtolower($newDistrictName);

  $db = new dbHandler();
  $result = $db->updateDistrict($oldDistrictName, $newDistrictName);

  if($result == SERVICE_DISTRICT_UPDATED) {
    $res["error"] = false;
    $res["message"] = "Service district updated";
    response(201, $res);
  } else if ($result == SERVICE_DISTRICT_UPDATE_FAILED) {
    $res["error"] = true;
    $res["message"] = "Service district update failed";
    response(200, $res);
  } else if($result == SERVICE_DISTRICT_NOT_EXIST) {
    $res["error"] = true;
    $res["message"] = "Service district not exist";
    response(200, $res);
  }
});

/**
* Update service list
* @param $oldServiceName
**/
$app->put('/updateservice/:servicename', function($oldServiceName) use($app){
  $res = array();

  $newServiceName = $app->request()->put('serviceName');
  $newServiceAddress = $app->request()->put('serviceAddress');
  $newServiceTelp = $app->request()->put('serviceTelp');
  $newServiceEmail = $app->request()->put('serviceEmail');
  $newServiceType = $app->request()->put('serviceType');
  $newServiceDistrict = $app->request()->put('serviceDistrict');
  $newServiceInfo = $app->request()->put('serviceInfo');
  $newServiceImgUrl = $app->request()->put('serviceImgUrl');
  $newServiceLocationName = $app->request()->put('serviceLocationName');
  $newServiceLocationLong = $app->request()->put('serviceLocationLong');
  $newServiceLocationLat = $app->request()->put('serviceLocationLat');

  $oldServiceName = strtolower($oldServiceName);
  $newServiceName = strtolower($newServiceName);
  $newServiceAddress = strtolower($newServiceAddress);
  $newServiceTelp = strtolower($newServiceTelp);
  $newServiceEmail = strtolower($newServiceEmail);
  $newServiceInfo = strtolower($newServiceInfo);
  $newServiceImgUrl = strtolower($newServiceImgUrl);
  $newServiceLocationName = strtolower($newServiceLocationName);

  $db = new dbHandler();
  $result = $db->updateService($oldServiceName,
                  $newServiceName,
                  $newServiceAddress,
                  $newServiceType,
                  $newServiceEmail,
                  $newServiceType,
                  $newServiceDistrict,
                  $newServiceInfo,
                  $newServiceImgUrl,
                  $newServiceLocationName,
                  $newServiceLocationLong,
                  $newServiceLocationLat);

  if($result == SERVICE_UPDATED) {
    $res["error"] = false;
    $res["message"] = "Service updated";
    response(201, $res);
  } else if ($result == SERVICE_UPDATE_FAILED) {
    $res["error"] = true;
    $res["message"] = "Service update failed";
    response(200, $res);
  } else if ($result == SERVICE_NOT_EXIST) {
    $res["error"] = true;
    $res["message"] = "Service not exist";
    response(200, $res);
  }
});


/**
=============DELETE METHOD REGION===============
**/

$app->put('/deletetype', function() use($app){
  $res = array();

  $typeName = $app->request()->put('typeName');
  $typeName = strtolower($typeName);

  $db = new dbHandler();
  $result = $db->deleteType($typeName);

  if($result == SERVICE_TYPE_DELETED) {
    $res["error"] = false;
    $res["message"] = "Service type deleted";
    response(201, $res);
  } else if ($result == SERVICE_TYPE_DELETE_FAILED) {
    $res["error"] = true;
    $res["message"] = "Service delete failed";
    response(200, $res);
  } else if ($result == SERVICE_TYPE_NOT_EXIST) {
    $res["error"] = true;
    $res["message"] = "Service type not exist";
    response(200, $res);
  }
});

$app->put('/deletedistrict', function() use($app){
  $res = array();

  $disctrictName = $app->request()->put('districtName');
  $disctrictName = strtolower($disctrictName);

  $db = new dbHandler();
  $result = $db->deleteDistrict($disctrictName);

  if($result == SERVICE_DISTRICT_DELETED) {
    $res["error"] = false;
    $res["message"] = "Service disctrict deleted";
    response(201, $res);
  } else if ($result == SERVICE_DISTRICT_DELETE_FAILED) {
    $res["error"] = true;
    $res["message"] = "Service district delete failed";
    response(200, $res);
  } else if ($result == SERVICE_DISTRICT_NOT_EXIST) {
    $res["error"] = true;
    $res["message"] = "Service district not exist";
    response(200, $res);
  }
});

$app->put('/deleteservice', function($serviceName) use($app){
  $res = array();

  $serviceName = $app->request()->put('serviceName');
  $serviceName = strtolower($serviceName);

  $db = new dbHandler();
  $result = $db->deleteService($serviceName);

  if($result == SERVICE_DELETED) {
    $res["error"] = false;
    $res["message"] = "Service deleted";
    response(201, $res);
  } else if ($result == SERVICE_DELETE_FAILED) {
    $res["error"] = true;
    $res["message"] = "Service delete failed";
    response(200, $res);
  } else if($result == SERVICE_NOT_EXIST) {
    $res["error"] = true;
    $res["message"] = "Service not exist";
    response(200, $res);
  }
});

/**
=========== GET METHOD REGION ===========
**/

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
===============HELPER===================
**/

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
