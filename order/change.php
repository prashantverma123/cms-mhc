<?php
include_once('../config.php');
include_once('variable.php');



if(isset($_GET['lead_source_id'])){
$id = $_GET['lead_source_id'];
// echo "<script type='text/javascript'>alert('$id');</script>";
//run a query
$keyValueArray['lead_source'] = '1';
$stmt = $modelObj->getDynamicCityList($id);
echo json_encode($stmt);
}

if(isset($_GET['service_id'])){
$id = $_GET['service_id'];
// echo "<script type='text/javascript'>alert('$id');</script>";
//run a query
$keyValueArray['lead_source'] = '1';
$stmt = $modelObj->getDynamicCityList($id);
echo json_encode($stmt);
}

if(isset($_GET['name'])){
$id = $_GET['name'];
// echo "<script type='text/javascript'>alert('$id');</script>";
//run a query
$keyValueArray['lead_source'] = '1';
$stmt = $modelObj->getFilterData("name",$id);
echo json_encode($stmt);
}

//loop through all returned rows
// foreach ($stmt as $key => $value) {
//   echo $value->name." has the value". $value->name;
//  }
 //($row = $stmt) {
//   //  echo "<option value='$key->id'>$key->name</option>";
//
//     //echo "<script type='text/javascript'>alert('$row->name');</script>";
//
// }
